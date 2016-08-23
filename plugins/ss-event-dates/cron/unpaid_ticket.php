<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

global $wpdb;
global $ss_theme_opt; 


$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_paylater_date > NOW() - INTERVAL 7 DAY";
$user_detail = $wpdb->get_results($query);
echo "<pre>";
foreach ($user_detail as $vuser) {

    // === SEND USER EMAIL === //
    $to      = $vuser->euser_email;
    $subject = 'Reminder for Payment | IUFRO ACACIA CONFERENCE 2017';
    $body    = '
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
                Registration Closed | IUFRO ACACIA CONFERENCE 2017
            </div>
            <div>
<p>
The online registration and online payment for IUFRO ACACIA CONFERENCE 2017 is officially closed today.
You will no longer able to register or pay online.
<br>
User that still haven\'t finish the online payment process can continue the payment process onsite, by bringing the e-ticket (attached on this email).
Please be advised that :<br>
  &nsbp;&nsbp;-  &nsbp;The conference fee for onsite payment will be :
<br>
 &nsbp; &nsbp;>  &nsbp;Local author/participant : Rp. 750.000,-
 &nsbp; &nsbp;>  &nsbp;Foreign author/participant : US$ 550
<br>
  &nsbp;&nsbp;-  &nsbp;Onsite payment user will lose the right to join Mid and Post Trip, and also Conference Dinner
</p>

            </div>
            <div>
            <br>
            <div>
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
    wp_mail($to, $subject, $body, $headers);
    // === END SEND USER EMAIL === //

    echo "<br>Email Send to " . $vuser->euser_fullname . " at " . date("Y-m-d H:i:s") . "<hr>";
    // ==== UPDATE DATE PAYMENT ==== //
    $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_payment_status' => 'have not been paid for more than 7 days(cron)',
            'euser_paylater_date'  => date("Y-m-d H:i:s"),
        ),
        array('euser_email' => $euser_email),
        array(
            '%s',
            '%s',
        ),
        array('%s')
    );

    // end of forech

}

echo "</pre>";
