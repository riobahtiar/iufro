<?php
// Response from Paypal
    $parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
    require_once( $parse_uri[0] . 'wp-load.php' );
    $req = 'cmd=_notify-validate';
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&$key=$value";
    }

    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']             = $_POST['custom'];
    $data['invoice']            = $_POST['invoice'];
    $data['paypallog']          = $req;

    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 

    if (!$fp) {
        // HTTP ERROR
    } else {    
        fputs ($fp, $header . $req);
        while (!feof($fp)) {
            $res = fgets ($fp, 1024);
            if (true || strcmp($res, "VERIFIED") == 0) {
            // ==== Blok  Insert DB ==== //
                global $wpdb;
                $wpdb->insert( 
                'wp_ss_trx_paypal', 
                array( 
                    'trx_name'  => $data['item_name'], 
                    'trx_number'   => $data['item_number'], 
                    'trx_status'     => $data['payment_status'], 
                    'trx_amount'   => $data['payment_amount'], 
                    'trx_currency'   => $data['payment_currency'], 
                    'trx_txn_id'  => $data['txn_id'], 
                    'trx_receiver'     => $data['receiver_email'], 
                    'trx_payer'   => $data['payer_email'],
                    'trx_custom'     => $data['custom'],
                    'trx_invoice'     => $data['invoice'],
                    'trx_logs'   => $data['paypallog']           
                ), 
                array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s') 
            );

            // ===== End Insert DB ===== //
            // ===== Emails ==== //
$to = $data['payer_email'];
$subject = 'Payment Complete Notification | IUFRO SYSTEM';
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
                Thank you, your payment was successfully
            </div>
            <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                <p>We will verify your payment</p>
            </div>
            <br>
            <div>
                <p>Payment Success </p>
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
$headers[] = 'From: IUFRO System <payment@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; 
wp_mail( $to, $subject, $body, $headers );
            // ===== End of Email ==== //

            } elseif ($res=='INVALID') {
            // ===== Emails ==== //
$to = $data['payer_email'];
$subject = 'Payment Error | IUFRO SYSTEM';
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
                Payment Error
            </div>
            <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                <p>We will verify your payment</p>
            </div>
            <br>
            <div>
                <p>Payment Success </p>
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
$headers[] = 'From: IUFRO System <payment@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; 
wp_mail( $to, $subject, $body, $headers );
            // ===== End of Email ==== //
            }       
        }       
    fclose ($fp);
    }   

?>