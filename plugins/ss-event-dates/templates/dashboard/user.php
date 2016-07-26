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
		<tr><td>Username</td><td>:</td><td><?php echo $user_detail['euser_email']; ?></td></tr>
		<tr><td>User type</td><td>:</td><td><?php echo $user_detail['euser_type']; ?></td></tr>
	</table>
</div>
<div class="col-md-4">
	<button class="btn" id="change-password" onclick="changePassword()">Change Password</button>
	<?php if($user_detail['euser_type']=="free"){ ?>
		<button class="btn" id="change-type" onclick="resetMembership()">upgrade participant type</button>
	<?php } ?>
</div>