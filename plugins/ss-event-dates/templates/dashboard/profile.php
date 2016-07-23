<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );
	
	global $current_user;
    get_currentuserinfo();
  	$euser_email = $current_user->user_email;

	global $wpdb;
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
?>
<div class="col-md-8">
	<table class="table">
		<tr><td>Name</td><td>:</td><td><?php echo $user_detail['euser_fullname']; ?></td></tr>
		<tr><td>Email</td><td>:</td><td><?php echo $user_detail['euser_email']; ?></td></tr>	
		<tr><td>Phone</td><td>:</td><td><?php echo $user_detail['euser_phone']; ?></td></tr>
		<tr><td>Address</td><td>:</td><td><?php echo $user_detail['euser_address']; ?></td></tr>
	</table>
</div>
<div class="col-md-4">
	<button class="btn" id="edit-detail" onclick="editProfile()">Edit</button>
</div>