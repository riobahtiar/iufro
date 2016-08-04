<?php
$product=$_GET['trxname'];
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;





// ========= Get Email Data ========= //


//get user data
global $wpdb;
$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
$user_detail = $wpdb->get_row( $query, ARRAY_A );

if(isset($user_detail['euser_addon_mid'] )){

        if ( $user_detail['euser_addon_mid'] == "gunung-kidul" ) {
          $string_mid_conf="Gunung Kidul";
          $price_mid_conf = 0;
        }elseif ( $user_detail['euser_addon_mid'] == "klaten" ) {
          $string_mid_conf="Klaten";
          $price_mid_conf = 0;
        }else{
          $string_mid_conf=" - ";
          $price_mid_conf = 0;
        } 

}else{
  $string_mid_conf=" - ";
  $price_mid_conf == 0;
}

// post conf
if(isset($user_detail['euser_addon_post'])){
    // Pricing Post Conference
        if ( $user_detail['euser_addon_post'] == "pacitan" ) {
          $string_post_conf="Pacitan ( US$ 250 )";
          $price_post_conf = 250;
        }elseif ( $user_detail['euser_addon_post'] == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( US$ 475 )";
          $price_post_conf = 475;
        }elseif ( $user_detail['euser_addon_post'] == "pekanbaru_single" ) {
          $string_post_conf="Pekanbaru | Single Room ( US$ 510 )";
          $price_post_conf = 510;
        }else{
          $string_post_conf=" - ";
          $price_post_conf = 0;
        }
}else{
  $string_post_conf=" - ";
  $price_post_conf = 0;
}

if(isset($user_detail['euser_addon_dinner'])){
  $string_dinner=" Yes ";
}else{
  $string_dinner=" No ";
}

if ($user_detail['euser_type']=="local student") {
  $user_string = "Local | Students ( Rates apply US$ 20 )";
  $total_price=$price_post_conf+20;
}elseif ($user_detail['euser_type']=="local regular") {
  $user_string = "Local | Regular ( Rates apply US$ 30 )";
  $total_price=$price_post_conf+30;
}elseif ($user_detail['euser_type']=="foreigner") {
  $user_string = "Foreign   ( Rates apply US$ 400 )";
  $total_price=$price_post_conf+400;
}else{
  $total_price=0;
}

// ========= end Get Email Data ========= //

 ?>
<div class="alert alert-success">
	<h3>Thank you for completing the payment.<br>Please check your email for the e-ticket. You may print the e-ticket and bring it at the conference.</h3>
	<p>Transaction Code: <?php echo $product; ?></p>
</div>

<?php

