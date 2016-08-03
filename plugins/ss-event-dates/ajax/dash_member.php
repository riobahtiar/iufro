	<?php

	$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
	require_once( $parse_uri[0] . 'wp-load.php' );

	global $wpdb;
	$get_members = $wpdb->get_results( "SELECT * FROM wp_ss_event_user_detail" );




if ( htmlspecialchars($_GET('ifr_list_form')) == 'true'){
	echo "<div class='modal-admin'>";
	echo "<div class='modal-admin'>";
	echo "</div>";
}elseif ( $_GET('ifr_model') == 'true' ) {
	
}elseif ( htmlspecialchars($_GET('ifr_')) == 'true' ) {

}else{

}