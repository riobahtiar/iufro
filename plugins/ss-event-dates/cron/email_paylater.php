<?php
	$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
	require_once( $parse_uri[0] . 'wp-load.php' );

	global $wpdb;
	$query="SELECT * FROM wp_ss_event_user_detail WHERE euser_paylater_date > NOW() - INTERVAL 7 DAY";
	$user_detail = $wpdb->get_row( $query, ARRAY_A );
	echo "<pre>";	
	foreach ($user_detail as $vuser) {
		// Conditional Logic for user string payment //
if(isset($vuser['euser_addon_mid'] )){

        if ( $vuser['euser_addon_mid'] == "gunung-kidul" ) {
          $string_mid_conf="Gunung Kidul";
          $price_mid_conf = 0;
        }elseif ( $vuser['euser_addon_mid'] == "klaten" ) {
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
if(isset($vuser['euser_addon_post'])){
    // Pricing Post Conference
        if ( $vuser['euser_addon_post'] == "pacitan" ) {
          $string_post_conf="Pacitan ( US$ 250 )";
          $price_post_conf = 250;
        }elseif ( $vuser['euser_addon_post'] == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( US$ 475 )";
          $price_post_conf = 475;
        }elseif ( $vuser['euser_addon_post'] == "pekanbaru_single" ) {
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

if(isset($vuser['euser_addon_dinner'])){
  $string_dinner=" Yes ";
}else{
  $string_dinner=" No ";
}

// === USER DETAIL === //

    // Paymen Dates Earlybird
    $paymentDate = date('Y-m-d');
    $paymentDate=date('Y-m-d', strtotime($paymentDate));
    $earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
    $earlyBirdEnd = date('Y-m-d', strtotime("04/30/2017"));


if ($vuser['euser_type']=="local student") {
  $user_string = "Local | Students";
  $total_price=$price_post_conf+20;
  $user_price=20;
}elseif ($vuser['euser_type']=="local regular") {
  // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd))
    {
        $user_string = "Local | Regular ( Early Bird Rates )";
        $total_price=$price_post_conf+23;
        $user_price=23;
    } else {
        $user_string = "Local | Regular ( Regular Rates )";
        $total_price=$price_post_conf+39;
        $user_price=39;
    }
}elseif ($vuser['euser_type']=="foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd))
    {
        $user_string = "Foreign ( Early Bird Rates )";
        $total_price=$price_post_conf+350;
        $user_price=350;
    } else {
        $user_string = "Foreign ( Regular Rates )";
        $total_price=$price_post_conf+400;
        $user_price=400;
    }

}else{
  $total_price=0;
}


		// === SEND USER EMAIL === //
		$to = $vuser['euser_email'];
$subject = 'Reminder for Payment';
$body = '
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
                Reminder for Payment | IUFRO ACACIA CONFERENCE 2017
            </div>
            <div>
            <p>We notice that you have not finish the payment on IUFRO ACACIA 2017.
Please complete the payment before 24 July 2017.<p>

<p>Also you can get the cheaper fee if you complete the payment before 30 April 2017.</p>
            </div>
            <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                <p>Below is the fee information :</p>
            </div>
            <div>

<div id="registration" style="padding:15px 0;">
                <table>
                    <tbody style="color:#525252;font-size:16px;">
                        <tr>
                            <td>Registration Number</td>
                            <td>:</td>
                            <td>'.$vuser['euser_barcode'].'</td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>:</td>
                            <td>'.$vuser['euser_fullname'].'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>'.$vuser['euser_address'].'</td>
                        </tr>
                        <tr>
                            <td>Membership Type</td>
                            <td>:</td>
                            <td>'.$user_string.'</td>
                        </tr>
                        <tr>
                            <td>Field Trip</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td> - Mid Conference</td>
                            <td>:</td>
                            <td>'.$string_mid_conf.'</td>
                        </tr>
                        <tr>
                            <td> - Post Conference</td>
                            <td>:</td>
                            <td>'.$string_post_conf.'</td>
                        </tr>
                        <tr>
                            <td>Dinner Conference</td>
                            <td>:</td>
                            <td>'.$vuser['euser_addon_dinner'].'</td>
                        </tr>
                        <tr>
                            <td>NET TOTAL</td>
                            <td>:</td>
                            <td> US$ '.$total_price.'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br>
            <div>
                <p>PAYMENT METHOD </p>
                <p>We accept the payment via Paypal and iPaymu. Please access to your payment page by <a href="http://www.iufroacacia2017.com/login">Login</a> to your account and choose menu payment summary on Dashboard page</p>
                <p style="font-style:italic;">*Registration fee will be determined based on the date you do the payment (early bird / regular), or by your type of user (local/foreigner/student).</p>
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
$headers[] = 'Cc: Rio Bahtiar <riob@softwareseni.com>'; 
wp_mail( $to, $subject, $body, $headers );
	// === END SEND USER EMAIL === //
	
var_dump($vuser);
echo "<br>Email Send to ".$vuser['euser_fullname']." at ".date("Y-m-d H:i:s")."<hr>";
 // ==== UPDATE DATE PAYMENT ==== //
$wpdb->update( 
          'wp_ss_event_user_detail', 
          array( 
            'euser_payment_status' => 'have not been paid for more than 7 days(cron)', 
            'euser_paylater_date' => date("Y-m-d H:i:s")  
          ), 
          array( 'euser_email' => $euser_email ), 
          array( 
            '%s', 
            '%s'  
          ), 
          array( '%s' ) 
        );

	// end of forech

	}

echo "</pre>";


?>