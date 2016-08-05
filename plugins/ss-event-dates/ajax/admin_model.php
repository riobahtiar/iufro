<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );
	$euser_barcode=$_GET['brcd'];
	global $wpdb;
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
	echo $user_detail['euser_fullname'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="padding: 10px">
<form action="<?php echo plugins_url('ss-event-dates').'/ajax/admin/member_process.php'; ?>" type="post">
<h4>Change User Type to </h4>
<input type="hidden" name="do_model" value="do_membership">
<input type="hidden" name="barcode" value="<?php echo $euser_barcode; ?>">
<div class="form-group">
  <label for="user_type">User Type</label>
<select name="user_type" class="form-control">
  <option value="free_type">Free</option>
  <option value="participant_type">Participant</option>
  <option value="author_type">Author</option>
</select>
  </div>
  <button type="submit" class="btn btn-default">Change</button>
</form>



<script type="text/javascript">
	function editProfile(){
		console.log('editProfile');
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/edit_profile.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-profile" ).html(html);
		});
	}

	function cancelAjax(){
		console.log('cancelAjax');
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/profile.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-profile" ).html(html);
		});
		jQuery.ajax({ url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/user.php'; ?>",cache: false})
		.done(function( html ){
		    jQuery( "#main-pass" ).html(html);
		});
	}

	// function doMembership(){
	// 	console.log('doMembership');
	// 		jQuery.ajax({ 
	// 			url: "<?php echo  plugins_url('ss-event-dates').'/templates/dashboard/model.php'; ?>",
	// 			type: 'POST',
	// 			data: "do_model=do_membership",				
	// 		}).done(function( html ){
	// 	    	window.location.replace("<?php bloginfo('url');echo "/login/user_dashboard/"; ?>");
	// 		});
				
	// }

	function saveProfile(){
		console.log('saveProfile');
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


  </body>
</html>

