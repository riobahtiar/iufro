<?php
if(isset($_GET['step']) && $_GET['step']=="addon"){
	$post_url=get_permalink()."?step=payment";
}else{
	$post_url="";
}

// get Get User Login
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

//get user data
global $wpdb;
$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
$user_detail = $wpdb->get_row( $query, ARRAY_A );


?>

<link href="<?php echo plugins_url(); ?>/ss-event-dates/assets/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="<?php echo plugins_url(); ?>/ss-event-dates/assets/js/bootstrap-toggle.min.js"></script>
<form id="form-addon" enctype="multipart/form-data" action="<?php echo $post_url; ?>" method="post">
<div class="container">
	<h3>Add On Facilities</h3>
	<div class="field-trip">
		<h4>Field Trip</h4>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-8"> Mid Conference Trip </div>
				<div class="col-md-4"><input class="switch-btn" data-on="Yes" data-off="No" type="checkbox" name="mid-conf" checked data-toggle="toggle"></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="radio" name="mid-conf-child" value="gunung-kidul" checked>
				 	<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Gunungkidul.jpg" alt = "Gunungkidul">
			     	</div>
			      	Gunungkidul<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/gunung-kidul" target="_blank">Learn more</a> 
			    </div>
				<div class="col-md-6">
					<input type="radio" name="mid-conf-child" value="klaten">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Klaten.jpg" alt = "Klaten">
			     	</div>
			    	Klaten<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/klaten/" target="_blank">Learn more</a> 
			    </div>
				<div class="col-md-6">
					<input type="radio" name="mid-conf-child" value="mount-merapi">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/merapi-1.png" alt = "Mount Merapi">
			     	</div>
			    	Mount Merapi<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/mount-merapi/" target="_blank">Learn more</a> 
			    </div>
			</div>
		</div> 
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-8"> Post Conference Trip </div>
				<div class="col-md-4"><input class="switch-btn" data-on="Yes" data-off="No" type="checkbox" name="post-conf" checked data-toggle="toggle"></div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<input type="radio" name="post-conf-child" value="pekanbaru" id="radio-custom-toggle">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Pekanbaru.jpg" alt = "Pekanbaru">
			     	</div>
			      	Pekanbaru<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/pekanbaru" target="_blank">Learn more</a>
			    </div>
				<div class="col-md-6">
					<input type="radio" name="post-conf-child" value="pacitan">
					<div class = "thumbnail">
			         	<img src = "<?php echo site_url(); ?>/wp-content/uploads/2016/07/Pacitan.jpg" alt = "Pacitan">
			     	</div>
			    	Pacitan 
			    	<p class="item-price-x">US$ 250/pax<br>
			    	<a href="<?php echo site_url(); ?>/field-trip/pacitan/" target="_blank">Learn more</a>
			    	</p>
			    </div>
			    <div class="col-md-12 pekanbaru-selected">
<div class="custom-toggle" id="custom-toggle">
<div class="well">
    <input type="radio" name="post-conf-child" id="single-room" value="pekanbaru_single">
    Single room = US$ 510/pax<br>
    <input type="radio" name="post-conf-child" id="shared-room" value="pekanbaru_shared">
    Shared room = US$ 475/pax
</div>
</div>
			    </div>
			</div>
		</div>
	</div>
	<div class="field-trip">
		<div class="col-md-8"> <span>Dinner Conference<span> </div>
		<div class="col-md-4"><input class="switch-btn" data-on="Yes" data-off="No" type="checkbox" name="dinner-conf" checked data-toggle="toggle"></div>
	</div>
<br>


<?php 
if ( $user_detail['euser_meta_type'] == 'author_type' ) {
?>

<div class="well">
<input id="okeread" type="checkbox" name="readme_ok" value="readme">&nbsp;I have read all  <a href="<?php echo get_permalink(); ?>/poster">the guidelines</a>, and ready to upload
</div>
	<div class="field-trip col-md-4">
		<label> <span>Upload Abstract</span> <input id="mydoc1" name="abstrak" type="file" /></label>
	</div>
	<div class="field-trip col-md-4">
		<label>  <span>Upload Paper</span> <input id="mydoc2" name="paper" type="file" /></label>
	</div>
	<div class="field-trip col-md-4">
		<label> <span>Upload Poster</span> <input id="mydoc3" name="poster" type="file" /></label>
	</div>
	<div>
<?php } ?>


		<a href="<?php echo get_permalink(); ?>?step=membership" class="btn btn-default pull-left">Back</a>
	  	<button id="btnval" type="submit" name="submit" class="btn btn-default pull-right" value="addon" <?php if ( $user_detail['euser_meta_type'] == 'author_type' ) {?>disabled<?php } ?>>Next</button>
	</div>
</div>
</form>
<?php if ($user_detail['euser_meta_type'] == 'author_type') {?>
<script type="text/javascript">
//validate all form upload
	jQuery('#form-addon').on('change', function() {
	   if(jQuery('input[name=readme_ok]:checked', '#form-addon').val()=="readme"){
	   		jQuery( "#btnval" ).removeAttr("disabled");
	   } else {
	   	jQuery( "#btnval" ).attr("disabled", "disabled");
	   }
	});

	jQuery("#form-addon").submit(function(e){
	   	if (jQuery('#mydoc1').val()==''){
			alert('please upload your Abstract');
			e.preventDefault(e);
		}
	   	if (jQuery('#mydoc2').val()==''){
			alert('please upload your Paper');
			e.preventDefault(e);
		}	    
	});


// jQuery('input[name=post-conf]').change(function() {
//   if (jQuery(this).is(':checked')) {
//     console.log('Checked');
//   } else {
//     console.log('Unchecked');
//   }
// });





</script>
<?php } ?>