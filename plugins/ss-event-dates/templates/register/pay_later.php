<?php


// get Get User Login
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

//get user data
global $wpdb;
$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_email = '{$euser_email}'";
$user_detail = $wpdb->get_row( $query, ARRAY_A );

// Get Event Package Details
$mid_conf_q="SELECT * FROM wp_ss_event_package 
WHERE package_user = '{$euser_email}' 
AND package_item = 'Mid Conference'";

$post_conf_q="SELECT * FROM wp_ss_event_package 
WHERE package_user = '{$euser_email}' 
AND package_item = 'Post Conference'";

$mid_conf_var = $wpdb->get_row( $mid_conf_q, ARRAY_A );
$post_conf_var = $wpdb->get_row( $post_conf_q, ARRAY_A );

// mid conf
if(isset($mid_conf_var['package_detail'])){

        if ( $mid_conf_var['package_detail'] == "gunung-kidul" ) {
          $string_mid_conf="Gunung Kidul";
          $price_mid_conf = 0;
        }elseif ( $mid_conf_var['package_detail'] == "klaten" ) {
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
if(isset($post_conf_var['package_detail'])){
    // Pricing Post Conference
        if ( $post_conf_var['package_detail'] == "pacitan" ) {
          $string_post_conf="Pacitan ( USD 250 )";
          $price_post_conf = 250;
        }elseif ( $post_conf_var['package_detail'] == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( USD 475 )";
          $price_post_conf = 475;
        }elseif ( $post_conf_var['package_detail'] == "pekanbaru_single" ) {
          $string_post_conf="Pekanbaru | Single Room ( USD 510 )";
          $price_post_conf = 510;
        }else{
          $string_post_conf=" - ";
          $price_post_conf = 0;
        }
}else{
  $string_post_conf=" - ";
  $price_post_conf = 0;
}

if ($user_detail['euser_type']=="local student") {
  $user_string = "Local | Students ( Rates apply USD 20 )";
  $total_price=$price_post_conf+20;
}elseif ($user_detail['euser_type']=="local regular") {
  $user_string = "Local | Regular ( Rates apply USD 30 )";
  $total_price=$price_post_conf+30;
}elseif ($user_detail['euser_type']=="foreigner") {
  $user_string = "Foreign   ( Rates apply USD 400 )";
  $total_price=$price_post_conf+400;
}else{
  $total_price=0;
}










$to = $euser_email;
$subject = 'Thank you for participating on IUFRO ACACIA 2017';
$body.= '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>IUFRO</title>
        <style type="text/css">
@media (max-width: 992px) {
    #content {
        max-width: 100% !important;
        padding-left: 30px;
        padding-right: 30px;
    }
    #logo img {
        width: 100% !important;
        max-width: 300px !important;
    }
}

        </style>
    </head>

    <body style="font-family:Lato,Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;color:#525252;margin:0;line-height:1.5;padding: 15px 0;background:#fff;">
        <div id="content" style="max-width:550px;letter-spacing:0.5px; margin: 0 auto">
            <div id="logo" style="background:#fff;overflow:hidden;padding:16px;text-align:center">
                <img src="http://demosite.softwareseni.com/iufro/wp-content/uploads/2016/06/logo.png" alt="IufroLogo" style="min-height:30px;width:200px;max-width:100%;vertical-align:top" class="CToWUd">
            </div>
            <div>
                <h2 style="text-align:center;color:#809062;margin-top: 0;">Dear Sir / Madam</h2>
            </div>
            <div style="background:#809062;color:#fff;font-size:14px;text-align:center;width:100%;padding: 15px 0;">
';
$body.= 'Thank you for participating on IUFRO ACACIA Conference 2017</div>';


$body.=  '<div>

Below are your details :<br>
Registration Number : 1234<br>
Full Name : Mr. / Mrs. xxx<br>
Address : xxx<br>
Membership Type : Local-Regular Participant<br>
Field Trip : <br>
&nbsp;&nbsp;- Mid Conference : Gunungkidul<br>
&nbsp;&nbsp;- Post Conference : Pacitan<br>
Dinner Conference : Yes <br>
FEE INFORMATION<br><br>
Conference Fee :<br>
* Local Participant : <br>
&nbsp;&nbsp;- Early Bird Registration (1 Jan 2017 - 30 Apr 2017) : $23<br>
&nbsp;&nbsp;- Regular Registration (1 May 2017 - 24 Jul 2017) : $39<br>
&nbsp;&nbsp;- Student : $20<br>
* Foreigner<br>
&nbsp;&nbsp;- Early Bird Registration (1 Jan 2017 - 30 Apr 2017) : $350<br>
&nbsp;&nbsp;- Regular Registration (1 May 2017 - 24 Jul 2017) : $400<br>
Post Conference Field Trip Fee :<br>
*Pekanbaru<br>
&nbsp;&nbsp;- Single Room : $510/pax<br>
&nbsp;&nbsp;- Shared Room : $475/pax<br>
*Pacitan : $250/pax<br><br>
PAYMENT METHOD <br>
We accept the payment via Paypal and iPaymu.<br>
Please access to your payment page by <a href="'.get_permalink()."'/login'".'">Login</a> to your account and choose menu payment summary on Dashboard page<br>
*Registration fee will be determined based on the date you do the payment (early bird / regular), or by your type of user (local/foreigner/student).<br>
Should you require any further assistance, please do not hesitate to contact us on address below:<br>
Center of Forest Biotechnology and Tree Improvement<br>
Jl. Palagan Tentara Pelajar KM 15 Purwobinangun, Pakem, Sleman, Yogyakarta 55582<br>
Phone: 0274-895954<br>
Email: secretariat@iufroacacia2017.com<br>
</div>';


$body.= '
            <div>
                <p style="font-size:16px;">We are looking forward to welcoming your guest at IUFRO ACACIA CONFERENCE 2017</p>
                <p style="font-size:16px;">Should you require any further assistance, please do not hesitate to contact us on address below: </p>
                <p style="font-size:12px;margin: 0;color:#809062">Center of Forest Biotechnology and Tree Improvement</p>
                <p style="font-size:12px;margin: 0;color:#809062">Jl. Palagan Tentara Pelajar KM 15 Purwobinangun, Pakem, Sleman, Yogyakarta 55582</p>
                <p style="font-size:12px;margin: 0;color:#809062">Phone: 0274-895954</p>
                <p style="font-size:12px;margin: 0;color:#809062">Email: secretariat@iufroacacia2017.com</p>
            </div>
        </div>
    </body>

</html>
';



$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; // note you can just use a simple email address
wp_mail( $to, $subject, $body, $headers );
echo "Check Your Email";
?>
