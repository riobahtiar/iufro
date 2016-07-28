<?php


// get Get User Login
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

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
          $string_post_conf="Pacitan ( USD 250 )";
          $price_post_conf = 250;
        }elseif ( $user_detail['euser_addon_post'] == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( USD 475 )";
          $price_post_conf = 475;
        }elseif ( $user_detail['euser_addon_post'] == "pekanbaru_single" ) {
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

if(isset($user_detail['euser_addon_dinner'])){
  $string_dinner=" Yes ";
}else{
  $string_dinner=" No ";
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
$subject = 'Thank you for registering IUFRO ACACIA CONFERENCE 2017';
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
                Thank you for registering IUFRO ACACIA CONFERENCE 2017
            </div>
            <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                <p>Below are your details:</p>
            </div>
            <div id="registration" style="padding:15px 0;">
                <table>
                    <tbody style="color:#525252;font-size:16px;">
                        <tr>
                            <td>Registration Number</td>
                            <td>:</td>
                            <td>'.$user_detail['euser_barcode'].'</td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>:</td>
                            <td>'.$user_detail['euser_fullname'].'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>'.$user_detail['euser_address'].'</td>
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
                            <td>'.$user_detail['euser_addon_dinner'].'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                <p>FEE INFORMATION:</p>
            </div>
            <br>
            <!--  Conference fee -->
            <div>
                <table cellspacing="0" style="font-size:14px;width:100%;text-align:center;">
                    <tbody>
                        <tr>
                            <td style="font-size: 18px;padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062" colspan="4">Conference Fee</td>
                        </tr>
                        <!--  Category -->
                        <tr>
                            <td style="padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062">Membership</td>
                            <td style="padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062">Registration Type</td>
                            <td style="padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062">Date</td>
                            <td style="padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062">Price</td>
                        </tr>
                        <!-- End Category -->
                        <!-- Content 1 -->
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c" rowspan="3">Local</td>
                            <td style="padding:5px;border:1px solid #49503c">Early Bird</td>
                            <td style="padding:5px;border:1px solid #49503c">1 Jan 2017 - 30 Apr 2017</td>
                            <td style="padding:5px;border:1px solid #49503c">$23</td>
                        </tr>
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c">Regular</td>
                            <td style="padding:5px;border:1px solid #49503c">1 May 2017 - 24 Jul 2017</td>
                            <td style="padding:5px;border:1px solid #49503c">$39</td>
                        </tr>
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c">Student</td>
                            <td style="padding:5px;border:1px solid #49503c">1 Jan 2017 - 24 Jul 2017</td>
                            <td style="padding:5px;border:1px solid #49503c">$20</td>
                        </tr>
                        <!-- End Content 1 -->
                        <!-- Content 2 -->
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c" rowspan="2">Foreigner</td>
                            <td style="padding:5px;border:1px solid #49503c">Early Bird</td>
                            <td style="padding:5px;border:1px solid #49503c">1 Jan 2017 - 30 Apr 2017</td>
                            <td style="padding:5px;border:1px solid #49503c">$350</td>
                        </tr>
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c">Regular</td>
                            <td style="padding:5px;border:1px solid #49503c">1 May 2017 - 24 Jul 2017</td>
                            <td style="padding:5px;border:1px solid #49503c">$400</td>
                        </tr>
                        <!-- End Content 2 -->
                    </tbody>
                </table>
            </div>
            <!-- End Conference Fee -->
            <br>
            <!--  Post Conference  -->
            <div>
                <table cellspacing="0" style="font-size:14px;width:100%;text-align:center;">
                    <tbody>
                        <tr>
                            <td style="font-size: 18px;padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062" colspan="2">Conference Fee</td>
                        </tr>
                        <!--  Category -->
                        <tr>
                            <td style="padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062">Destination</td>
                            <td style="padding:5px;text-align:center;border:1px solid #49503c;color:white;background-color:#809062">Price</td>
                        </tr>
                        <!-- End Category -->
                        <!-- Content 1 -->
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c" rowspan="2">Pekanbaru</td>
                            <td style="padding:5px;border:1px solid #49503c">Single Room : $510/pax</td>
                        </tr>
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c">Shared Room : $475/pax</td>
                        </tr>
                        <!--  End Content 1-->
                        <!-- Content 2 -->
                        <tr>
                            <td style="padding:5px;border:1px solid #49503c">Pacitan</td>
                            <td style="padding:5px;border:1px solid #49503c">$250/pax</td>
                        </tr>
                        <!--  End Content 2-->
                    </tbody>
                </table>
            </div>
            <!-- End Post Conference  -->
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
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; // note you can just use a simple email address
wp_mail( $to, $subject, $body, $headers );
echo "<div class='well thanks-notify'><h3>Thank you for registering on IUFRO ACACIA CONFERENCE 2017.</h3>
<p>Please check your email for payment information.</p></div>";
?>
