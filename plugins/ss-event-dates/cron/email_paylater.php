<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );
	
	global $current_user;
    wp_get_current_user();
  	$euser_email = $current_user->user_email;

	global $wpdb;
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
?>