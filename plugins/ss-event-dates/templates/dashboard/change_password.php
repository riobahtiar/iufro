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
<form id="password-form">
<div class="col-md-8">
	<table class="table">
		<tr><td>Old password</td><td>:</td><td><input type="password" class="form-control" id="o_password" name="o_password" ></td></tr>
		<tr><td>New Password</td><td>:</td><td><input type="password"  class="form-control" id="n_password" name="n_password" ></td></tr>	
		<tr><td>Confirm Password</td><td>:</td><td><input type="password"  class="form-control" id="c_password" name="c_password" ></td></tr>	
	</table>
</div>
</form>
<div class="col-md-4">
	<button class="btn" id="save-detail" onclick="savePassword()">Save Changes</button>
	<button class="btn btn-danger" id="cancel-detail" onclick="cancelAjax()">Cancel</button>
</div>
<script type="text/javascript">
	
</script>
