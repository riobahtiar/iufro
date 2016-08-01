<div class="container">
<?php
	global $current_user;
    wp_get_current_user();
  	$euser_email = $current_user->user_email;
  	global $wpdb;
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
 ?>
	<div class="row">
		<div class="col-md-4"><h3>User Dashboard</h3></div>

<?php if($user_detail['euser_meta_type']!=="free_type"){ ?>
		<div class="col-md-8">
		<ul class="menu-dashboard">
		  <li><a href="<?php echo get_permalink()."?step=membership"; ?>">Membership</a></li>
		  <li><a href="<?php echo get_permalink()."?step=addon"; ?>">Addons</a></li>
		  <li><a href="<?php echo get_permalink()."?step=payment"; ?>">Payment Summary</a></li>
		</ul>
		</div>
<?php } ?>
	</div><!-- end row -->



	<div id="main-profile">
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
	</div>
	<div id="main-pass">
		<div class="col-md-8">
			<table class="table">
				<tr><td>Username</td><td>:</td><td><?php echo $user_detail['euser_email']; ?></td></tr>
				<tr><td>User type</td><td>:</td><td><?php 
				if ($user_detail['euser_meta_type']=="participant_type"){
					echo "Participant";
				}elseif ($user_detail['euser_meta_type']=="author_type"){
					echo "Author";
				}else{
					echo "Free Account";
				}
				 ?> </td></tr>
				<?php if($user_detail['euser_type']=="local student"){ ?>
				<tr><td>Student Card</td><td>:</td><td><img class="student-card" src="<?php echo wp_get_attachment_url($user_detail['euser_stdcard_id']); ?>" ></td></tr>	
				<?php }?>
			</table>
		</div>
		<div class="col-md-4">
			<button class="btn" id="change-password" onclick="changePassword()">Change Password</button>
			<?php if($user_detail['euser_meta_type']=="free_type"){ ?>
				<button class="btn hidden" id="change-type" onclick="resetMembership()">upgrade participant type</button>
			<?php } ?>
		</div>
	</div>		
</div>
<script type="text/javascript">
	function editProfile(){
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/edit_profile.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-profile" ).html(html);
		});
	}

	function cancelAjax(){
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/profile.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-profile" ).html(html);
		});
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/user.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-pass" ).html(html);
		});
	}

	function resetMembership(){
		if (confirm("are you sure want to upgrade?")){
			jQuery.ajax({ 
				url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/model.php'; ?>",
				type: 'POST',
				data: "do_model=reset_member",				
			}).done(function( html ){
		    	window.location.replace("<?php bloginfo('url');echo "/login/user_dashboard/"; ?>");
			});
				
		}
	}

	function saveProfile(){
		if (confirm("Save changes?")){
			var from_form = jQuery( "#profile-form" ).serialize();
			jQuery.ajax({ 
				url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/model.php'; ?>",
				type: 'POST',
				data: "do_model=update_profile&"+from_form,				
			}).done(function( html ){
		    	window.location.replace("<?php bloginfo('url');echo "/login/user_dashboard/"; ?>");
			});
				
		}
	}

	function changePassword(){
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/change_password.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-pass" ).html(html);
		});
	}

	function savePassword(){
		if (confirm("Save changes?")){
			var from_form = jQuery( "#password-form" ).serialize();
			jQuery.ajax({ 
				url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/model.php'; ?>",
				type: 'POST',
				data: "do_model=update_password&"+from_form,				
			}).done(function( html ){
		    	jQuery( "#main-pass" ).html(html);
			});	
		}
	}
	
</script>