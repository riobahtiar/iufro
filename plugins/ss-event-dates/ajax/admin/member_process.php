<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );
echo $_POST['do_model'].$_POST['user_type'].$_POST['barcode'].'<hr>';
	 print_r($_POST);
	if (isset($_POST['do_model'])){
		switch ($_POST['do_model']) {

			case 'do_membership':
					$wpdb->update( 
					'wp_ss_event_user_detail', 
					array( 
						'euser_meta_type' => $_POST['user_type'],	
					), 
					array( 'euser_barcode' => $_POST['barcode'] ), 
					array( 
						'%s',	
					), 
					array( '%s' ) 
				);
				echo "Member type changed. Please Refresh your browser";
				break;

			case 'update_profile':
					$wpdb->update( 
					'wp_ss_event_user_detail', 
					array( 
						'euser_fullname' => $_POST['euser_fullname'],	
						'euser_phone' => $_POST['euser_phone'],	
						'euser_address' => $_POST['euser_address']	
					), 
					array( 'euser_email' => $euser_email ), 
					array( 
						'%s',	
						'%s',	
						'%s'	
					), 
					array( '%s' ) 
				);
					$wpdb->update( 
					'wp_users', 
					array( 
						'display_name' => $_POST['euser_fullname']
					), 
					array( 'user_login' => $euser_email ), 
					array( 
						'%s'	
					), 
					array( '%s' ) 
				);
				break;

			case 'update_password':
					$o_password = $_POST['o_password'];
					$n_password = $_POST['n_password'];	
					$c_password = $_POST['c_password'];

					// echo $o_password.$n_password.$c_password;
					// $wp_hasher = new PasswordHash(8, TRUE);
					// echo wp_hash_password( $o_password )."<br>";
					// echo $current_user->user_pass;
					echo $current_user->user_id;
					?>
					<?php if (!wp_check_password( $o_password, $current_user->user_pass, $current_user->user_id )){ ?>
						<div class="col-md-8">
							<div class="warning">Your old password didn't match your current password</div>
							<table class="table">
								<tr><td>Username</td><td>:</td><td><?php echo $user_detail['euser_email']; ?></td></tr>
								<tr><td>User type</td><td>:</td><td><?php echo $user_detail['euser_type']; ?> participant</td></tr>
							</table>
						</div>
						<div class="col-md-4">
							<button class="btn" id="change-password" onclick="changePassword()">Change Password</button>
							<?php if($user_detail['euser_type']=="free"){ ?>
								<button class="btn" id="change-type" onclick="resetMembership()">upgrade participant type</button>
							<?php } ?>
						</div>
					<?php } else { if ($n_password != $c_password) { ?>
						<div class="col-md-8">
							<div class="warning">Your New password didn't match your confirmation password</div>
							<table class="table">
								<tr><td>Username</td><td>:</td><td><?php echo $user_detail['euser_email']; ?></td></tr>
								<tr><td>User type</td><td>:</td><td><?php echo $user_detail['euser_type']; ?> participant</td></tr>
							</table>
						</div>
						<div class="col-md-4">
							<button class="btn" id="change-password" onclick="changePassword()">Change Password</button>
							<?php if($user_detail['euser_type']=="free"){ ?>
								<button class="btn" id="change-type" onclick="resetMembership()">upgrade participant type</button>
							<?php } ?>
						</div>
					<?php } else {
						wp_set_password( $n_password, get_current_user_id() ); 
						// wp_redirect('http://demosite.softwareseni.com/iufro/login/?p=updated');
						?>
						<script type="text/javascript">
							window.location.replace("<?php bloginfo('url');echo "/login/?p=updated"; ?>");
						</script>
						<div class="col-md-8">
							<div class="warning">Your Password has ben updated please re-login</div>
							<table class="table">
								<tr><td>Username</td><td>:</td><td><?php echo $user_detail['euser_email']; ?></td></tr>
								<tr><td>User type</td><td>:</td><td><?php echo $user_detail['euser_type']; ?> participant</td></tr>
							</table>
						</div>
						<div class="col-md-4">
							<button class="btn" id="change-password" onclick="changePassword()">Change Password</button>
							<?php if($user_detail['euser_type']=="free"){ ?>
								<button class="btn" id="change-type" onclick="resetMembership()">upgrade participant type</button>
							<?php } ?>
						</div>
					<?php 	}
						} 
				break;
			default:
				break;
		}

	}else {
		echo "lol";
	}

?>

