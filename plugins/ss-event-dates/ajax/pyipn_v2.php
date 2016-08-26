<?php

// Include wp-load
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
$upload_dir = wp_upload_dir();

//get user data
global $wpdb;
global $ss_theme_opt; 

// echo '<pre>';
// var_dump($wpdb);
// echo '</pre>';

if (isset($_GET['auth_code'])) {
    $barcodeno = $_GET['auth_code'];

//get user data
    $query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$barcodeno}'";
    $user_detail = $wpdb->get_row($query, ARRAY_A);

// ======== Start Payment Conditional Block ======== //

// mid conf
if (isset($user_detail['euser_addon_mid'])) {

    if ($user_detail['euser_addon_mid'] == "gunung-kidul") {
        $string_mid_conf = "Gunung Kidul";
        $price_mid_conf  = 0;
        $product_mc = "MC1";
    } elseif ($user_detail['euser_addon_mid'] == "klaten") {
        $string_mid_conf = "Klaten";
        $price_mid_conf  = 0;
        $product_mc = "MC2";
    } elseif ($user_detail['euser_addon_mid'] == "mount-merapi") {
        $string_mid_conf = "Mount Merapi";
        $price_mid_conf  = 0;
        $product_mc = "MC3";
    } else {
        $string_mid_conf = " - ";
        $price_mid_conf  = 0;
        $product_mc = "MC0";
    }

} else {
    $string_mid_conf = " - ";
    $price_mid_conf == 0;
    $product_mc = "MC0";
}

// post conf
if (isset($user_detail['euser_addon_post'])) {
    // Pricing Post Conference
    if ($user_detail['euser_addon_post'] == "pacitan") {
        $string_post_conf = "Pacitan ( US$ 250 )";
        $price_post_conf  = 250;
        $product_pc = "PC1";
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_shared") {
        $string_post_conf = "Pekanbaru | Shared Room ( US$ 475 )";
        $price_post_conf  = 475;
        $product_pc = "PC2";
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_single") {
        $string_post_conf = "Pekanbaru | Single Room ( US$ 510 )";
        $price_post_conf  = 510;
        $product_pc = "PC3";
    } else {
        $string_post_conf = " - ";
        $price_post_conf  = 0;
        $product_pc = "PC0";
    }
} else {
    $string_post_conf = " - ";
    $price_post_conf  = 0;
    $product_pc = "PC0";
}

if (isset($user_detail['euser_addon_dinner'])) {
    if ($user_detail['euser_addon_dinner'] == "Yes") {
        $string_dinner = " Yes ";
        $product_d = "D1";
    } elseif ($user_detail['euser_addon_dinner'] == "No") {
        $string_dinner = " No ";
        $product_d = "D2";
    } else {
        $string_dinner = "-";
        $product_d = "D0";
    }
}

// Payment Dates Earlybird
$paymentDate    = date('Y-m-d');
$paymentDate    = date('Y-m-d', strtotime($paymentDate));
$earlyBirdBegin = date('Y-m-d', strtotime($ss_theme_opt['date_earlybird_start']));
$earlyBirdEnd   = date('Y-m-d', strtotime($ss_theme_opt['date_earlybird_end']));

if ($user_detail['euser_type'] == "local student") {
    $user_string = "Local | Students";
    $total_price = $price_post_conf + 20;
    $user_price  = 20;
    $product_usr = "LS";
} elseif ($user_detail['euser_type'] == "local regular") {
    // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Local | Regular ( Early Bird Rates )";
        $total_price = $price_post_conf + 23;
        $user_price  = 23;
        $product_usr = "LR-EBR";
    } else {
        $user_string = "Local | Regular ( Regular Rates )";
        $total_price = $price_post_conf + 39;
        $user_price  = 39;
        $product_usr = "LR-RR";
    }
} elseif ($user_detail['euser_type'] == "foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Foreign ( Early Bird Rates )";
        $total_price = $price_post_conf + 350;
        $user_price  = 350;
        $product_usr = "F-EBR";
    } else {
        $user_string = "Foreign ( Regular Rates )";
        $total_price = $price_post_conf + 400;
        $user_price  = 400;
        $product_usr = "F-RR";
    }

} else {
    $total_price = 0;
}

// Assemble Product Name

$product_name = $product_usr . $product_mc . $product_pc . $product_d . date('md');

// ======== End of Payment Conditional Block ======== //

}
// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
define("DEBUG", 1);

// Set to 0 once you're ready to go live
define("USE_SANDBOX", 1);

define("LOG_FILE", "./ipn.log");

// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
$raw_post_data  = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost         = array();
foreach ($raw_post_array as $keyval) {
    $keyval = explode('=', $keyval);
    if (count($keyval) == 2) {
        $myPost[$keyval[0]] = urldecode($keyval[1]);
    }

}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if (function_exists('get_magic_quotes_gpc')) {
    $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
    if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}

// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data

if (USE_SANDBOX == true) {
    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
} else {
    $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
}

$ch = curl_init($paypal_url);
if ($ch == false) {
    return false;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

if (DEBUG == true) {
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
}

// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.

//$cert = __DIR__ . "./cacert.pem";
$cert = $upload_dir['basedir'] . "/xpathvy/cacert.pem";
curl_setopt($ch, CURLOPT_CAINFO, $cert);

$res = curl_exec($ch);
if (curl_errno($ch) != 0) // cURL error
{
    if (DEBUG == true) {
        error_log(date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
    exit;

} else {
    // Log the entire HTTP response if debug is switched on.
    if (DEBUG == true) {
        error_log(date('[Y-m-d H:i e] ') . "HTTP request of validation request:" . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
        error_log(date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);
    }
    curl_close($ch);
}

// Inspect IPN validation result and act accordingly

// Split response headers and payload, a better way for strcmp
$tokens = explode("\r\n\r\n", trim($res));
$res    = trim(end($tokens));

if (strcmp($res, "VERIFIED") == 0) {
    // check whether the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your PayPal email
    // check that payment_amount/payment_currency are correct
    // process payment and mark item as paid.

    //assign posted variables to local variables
    $item_name        = $_POST['item_name'];
    $item_number      = $_POST['item_number'];
    $payment_status   = $_POST['payment_status'];
    $payment_amount   = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id           = $_POST['txn_id'];
    $receiver_email   = $_POST['receiver_email'];
    $payer_email      = $_POST['payer_email'];

    $packlogs = '<b>Extra Info from PayPal</b><br>item_name:' . $item_name . ' <br> item_number:' . $item_number . ' <br> payment_status:' . $payment_status . ' <br> payment_amount:' . $payment_amount . ' <br> payment_currency:' . $payment_currency . ' <br> txn_id:' . $txn_id . ' <br> receiver_email:' . $receiver_email . ' <br> payer_email:' . $payer_email;

    global $wpdb;
    $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_payment_status' => $payment_status.'-Paypal', // string
            'euser_payment_meta'   => $packlogs, // integer (number)
        ),
        array('euser_barcode' => $barcodeno),
        array(
            '%s',
            '%s',
        ),
        array('%s')
    );

/// ======= FPDF BLOCK ============ ///

    require_once $parse_uri[0] . 'wp-content/plugins/ss-event-dates/addons/fpdf/eticket.php';
    $title = 'IUFRO ACACIA CONFERENCE 2017';
// Setting Page
    $pdf = new PDF_Code128();
    $pdf->AddPage('P', 'A4');
// Barcode
    $pdf->Cell(28, 117, '', 1, 0, 'C');
    $pdf->Rotate(90, 88, 120);
    $pdf->Code128(100, 46, $barcodeno, 90, 15);
    $pdf->Rotate(0);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->RotatedText(36, 80, 'ID ' . $barcodeno, 90);
    $pdf->Cell(160, 30, '', 1, 0, 'C');
    $pdf->Image('http://www.iufroacacia2017.com/wp-content/uploads/2016/06/logo.png', 146, 17, 50);
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetXY(45, 23);
    $pdf->Write(5, $title);
    $pdf->SetXY(39, 11);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(5, 'EVENT');
    $pdf->SetXY(38, 40);
    $pdf->Cell(80, 30, '', 1, 0, 'C');
    $pdf->Cell(80, 30, '', 1, 0, 'C');
    $pdf->SetXY(39, 41);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Write(5, 'DATE');
    $pdf->SetXY(49, 52);
    $pdf->Write(5, 'July 24, 2017 - July 28, 2017');
    $pdf->SetXY(119, 41);
    $pdf->Write(5, 'VENUE');
    $pdf->SetXY(128, 47);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Write(5, 'The Alana Yogyakarta Hotel');
    $pdf->SetXY(133, 52);
    $pdf->Write(5, 'and Convention Center');
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetXY(123, 58);
    $pdf->Write(5, 'Jalan Palagan Tentara Pelajar Km 15,');
    $pdf->SetXY(125, 64);
    $pdf->Write(5, 'Pakem, Sleman, Yogyakarta 55582');
    $pdf->SetXY(38, 70);
    $pdf->Cell(160, 57, '', 1, 0, 'C');

    if ($user_detail['euser_meta_type'] == "participant_type") {
        $user_type = "Participant";
    } elseif ($user_detail['euser_meta_type'] == "author_type") {
        $user_type = "Author";
    } else {
        $user_type = "Free Account";
    }

    $pdf->SetXY(39, 71);
    $pdf->Write(5, 'DETAILS');
    $pdf->SetXY(45, 77);
    $pdf->Write(5, 'Full Name : ' . $user_detail['euser_fullname']);
    $pdf->SetXY(45, 83);
    $pdf->Write(5, 'Address : ' . $user_detail['euser_address']);
    $pdf->SetXY(45, 89);
    $pdf->Write(5, 'Membership Type : ' . $user_string . ' ' . $user_type);
    $pdf->SetXY(45, 95);
    $pdf->Write(5, 'Field Trip :');
    $pdf->SetXY(47, 102);
    $pdf->Write(5, ' ~ Mid Conference : ' . $string_mid_conf);
    $pdf->SetXY(47, 108);
    $pdf->Write(5, ' ~ Post Conference : ' . $string_post_conf);
    $pdf->SetXY(45, 114);
    $pdf->Write(5, ' Conference Dinner : ' . $string_dinner);
    $pdf->SetXY(45, 120);
    $pdf->Write(5, ' Payment : US$' . $payment_amount);

    $pdf->SetXY(50, 200);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Write(5, 'generated by system on ' . date('Y-m-d H:i:s T'));
    $pdf->Image('http://www.iufroacacia2017.com/wp-content/uploads/2016/08/paid.png', 164, 73, 30);

    $filename = $upload_dir['basedir'] . "/dumpticket/iufro2017_ticket_" . $barcodeno . ".pdf";
    $pdf->Output($filename, 'F');

/// ======= END FPDF ============ ///

    // ===== Emails ==== //
    $to      = $user_detail['euser_email'];
    $subject = 'Payment Successful Notification | IUFRO SYSTEM';
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
                Thank you for completing the payment,<br>Transaction Code: ' . $item_name . '
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
                            <td>' . $user_detail['euser_barcode'] . '</td>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td>:</td>
                            <td>' . $user_detail['euser_fullname'] . '</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>' . $user_detail['euser_address'] . '</td>
                        </tr>
                        <tr>
                            <td>Membership Type</td>
                            <td>:</td>
                            <td>' . $user_string . '</td>
                        </tr>
                        <tr>
                            <td>Field Trip</td>
                            <td>:</td>
                        </tr>
                        <tr>
                            <td> - Mid Conference</td>
                            <td>:</td>
                            <td>' . $string_mid_conf . '</td>
                        </tr>
                        <tr>
                            <td> - Post Conference</td>
                            <td>:</td>
                            <td>' . $string_post_conf . '</td>
                        </tr>
                        <tr>
                            <td>Conference Dinner</td>
                            <td>:</td>
                            <td>' . $user_detail['euser_addon_dinner'] . '</td>
                        </tr>
                        <tr>
                            <td>NET TOTAL</td>
                            <td>:</td>
                            <td> US$ ' . $total_price . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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

    $headers[]   = 'Content-Type: text/html; charset=UTF-8';
    $headers[]   = 'From: IUFRO System <payment@iufroacacia2017.com>';
    $headers[]   = 'Cc: Rio Bahtiar <akhibahtiar@gmail.com>';
    $attachments = array(WP_CONTENT_DIR . '/uploads/dumpticket/iufro2017_ticket_' . $barcodeno . '.pdf');
    wp_mail($to, $subject, $body, $headers, $attachments);
// === SEND USER EMAIL === //

    if (DEBUG == true) {
        error_log(date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL, 3, LOG_FILE);
    }
} else if (strcmp($res, "INVALID") == 0) {
    // log for manual investigation
    // Add business logic here which deals with invalid IPN messages
    if (DEBUG == true) {
        error_log(date('[Y-m-d H:i e] ') . "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
    }
    // === SEND USER EMAIL if Invalid //
    $to      = 'akhibahtiar@gmail.com';
    $subject = 'Payment error last invalid';
    $body    = $packlogs;
    $body .= 'Payment error last invalid' . date('l jS \of F Y h:i:s A');
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
    $headers[] = 'Cc: Rio Bahtiar <riob@softwareseni.com>';
    wp_mail($to, $subject, $body, $headers);
// === SEND USER EMAIL === //
}
