<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );
	var_dump($parse_uri[0]);
	// global $current_user;
 //    wp_get_current_user();
 //  	$euser_email = $current_user->user_email;

	// global $wpdb;
	// $query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
	// $user_detail = $wpdb->get_row( $query, ARRAY_A );
?>
<form id="profile-form">
<div class="col-md-8">
	<table class="table">
		<tr><td>Name</td><td>:</td><td><input type="text" class="form-control" name="euser_fullname" value="<?php echo $user_detail['euser_fullname']; ?>"></td></tr>
		<tr><td>Email</td><td>:</td><td><input type="text" disabled class="form-control" name="euser_email" value="<?php echo $user_detail['euser_email']; ?>"></td></tr>	
		<tr><td>Phone</td><td>:</td><td><input type="text" class="form-control" name="euser_phone" value="<?php echo $user_detail['euser_phone']; ?>"></td></tr>
		<tr><td>Address</td><td>:</td><td><input type="text" class="form-control" name="euser_address" value="<?php echo $user_detail['euser_address']; ?>"></td></tr>
	</table>
</div>
</form>
<div class="col-md-4">
	<button class="btn" id="save-detail" onclick="saveProfile()">Save Changes</button>
	<button class="btn btn-danger" id="cancel-detail" onclick="cancelAjax()">Cancel</button>
</div>
<script type="text/javascript">
	
</script>

