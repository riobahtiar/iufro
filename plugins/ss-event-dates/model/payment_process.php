<?php


global $current_user;
wp_get_current_user();
	$euser_email = $current_user->user_email;

global $wpdb;
$wpdb->update( 
	'wp_ss_event_user_detail', 
	array( 'euser_payment' => '2'), 
	array( 'euser_email' => $euser_email ), 
	array( '%s'), 
	array( '%s' ) 
);


?>