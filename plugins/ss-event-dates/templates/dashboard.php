<?php
// do database process when theris post data from form register/membership.php
if ( isset($_POST['submit']) ){
	if ($_POST['submit']=="membership") require_once dirname(dirname(__FILE__)) . '/model/membership_process.php';
	if ($_POST['submit']=="addon") require_once dirname(dirname(__FILE__)) . '/model/addon_process.php';
	if ($_POST['submit']=="payment") require_once dirname(dirname(__FILE__)) . '/model/payment_process.php';
}



// get detail user from wordpress user
global $current_user;
    get_currentuserinfo();
  	$euser_email = $current_user->user_email;

//check login user
if(!is_user_logged_in()){

	wp_redirect(get_site_url().'/login');

}else{

	global $wpdb;
	//get detail user from table wp_ss_event_user_detail
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
	
		if ($user_detail['euser_meta_type']=="free_type"){ 
				switch ($_GET['step']) {
					case 'free':
						require_once dirname(__FILE__) . '/register/free.php';
						break;
					case 'detail_profil':
						require_once dirname(__FILE__) . '/dashboard/account.php';
						break;
					
					default:
						require_once dirname(__FILE__) . '/dashboard/account.php';
						break;
				}	
		}elseif ( $user_detail['euser_meta_type']=="author_type" || $user_detail['euser_meta_type']=="participant_type" ){ 
			//author
			//check if user using menu back, if not go to else condition depend on user last step
			if(isset($_GET['step'])){
				switch ($_GET['step']) {
					case 'membership':
						require_once dirname(__FILE__) . '/register/membership.php';
						break;
					case 'detail_profil':
						require_once dirname(__FILE__) . '/dashboard/account.php';
						break;
					case 'addon':
						require_once dirname(__FILE__) . '/register/addon.php';
						break;
					case 'payment':
						require_once dirname(__FILE__) . '/register/payment.php';
						break;
					case 'paynow':
						require_once dirname(__FILE__) . '/register/pay_now.php';
						break;
					
					default:
						require_once dirname(__FILE__) . '/dashboard/account.php';
						break;
				}
			}else{
				if ($user_detail['euser_addon']==0){
					require_once dirname(__FILE__) . '/register/addon.php';
				} else if ($user_detail['euser_payment']==0){
					require_once dirname(__FILE__) . '/register/payment.php';
				} else {
					require_once dirname(__FILE__) . '/dashboard/account.php';
				}
			} 

			//end author
		} else {
			echo "<div class='alert alert-warning' role='alert'>";
					echo "Sorry, only Free, Author and Participant account type. can access this page";
			echo "</div>";
		}

}

?>