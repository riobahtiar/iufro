<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

global $wpdb;
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_paylater_date > NOW() - INTERVAL 7 DAY";
$user_detail = $wpdb->get_results($query);
	// jQuery("#registration").submit(function(e){
	//    		if (jQuery('#fullname').val()==''){
	// 			alert('Full Name needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	//    		if (jQuery('#email').val()==''){
	// 			alert('Email needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#password').val()==''){
	// 			alert('Password needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#c_password').val()==''){
	// 			alert('Password Validation needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#phone').val()==''){
	// 			alert('Phone needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#zip').val()==''){
	// 			alert('Portal Code needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#city').val()==''){
	// 			alert('City needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#countryId').val()==''){
	// 			alert('Country needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// 		if (jQuery('#stateId').val()==''){
	// 			alert('State needs to be filled');
	// 			e.preventDefault(e);
	// 		}

	// });