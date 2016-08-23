<?php
date_default_timezone_set("Asia/Bangkok");
// is close date or not
$today    = date('Y-m-d');
$closed = '2016-08-24';
if ($today == $closed ){

$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

// Call Wp Global Object
global $wpdb;
// Call Theme Options
global $ss_theme_opt;

// Call Function to fortmat indonesian currency
function formatIDR($nominal = 0)
{
    $jumlah_desimal  = "0";
    $pemisah_desimal = ",";
    $pemisah_ribuan  = ".";
    echo "Rp " . number_format($nominal, $jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) . ",-";
}


// Wp Content directory
$upload_dir = wp_upload_dir();

// Query to select user by date
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE (euser_payment_status = 'Pay Later' OR euser_payment_status IS NULL OR euser_payment_status = '') AND euser_meta_type = 'participant_type' AND euser_status = 'activated' LIMIT 300";

$user_detail = $wpdb->get_results($query);
echo "<pre>";
foreach ($user_detail as $vuser) {
/// ======= FPDF BLOCK ============ ///
$barcodeno = $vuser->euser_barcode;
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
    $pdf->Image('http://staging.iufroacacia2017.com/wp-content/uploads/2016/06/logo.png', 146, 17, 50);
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

    if ($vuser->euser_meta_type == "participant_type") {
        $user_type = "Participant";
    } elseif ($vuser->euser_meta_type == "author_type") {
        $user_type = "Author";
    } else {
        $user_type = "Free Account";
    }

    $pdf->SetXY(39, 71);
    $pdf->Write(5, 'DETAILS');
    $pdf->SetXY(45, 77);
    $pdf->Write(5, 'Full Name : ' . $vuser->euser_fullname);
    $pdf->SetXY(45, 83);
    $pdf->Write(5, 'Address : ' . $vuser->euser_address);
    $pdf->SetXY(45, 89);
    $pdf->Write(5, 'Membership Type : ' . $user_string . ' ' . $user_type);
    $pdf->SetXY(45, 95);

// Conditional Pricing by User Type
    if ($vuser->euser_type == 'local regular') {
        $pdf->Write(5, ' Payment :' . formatIDR(750000));
        $wording_price = '&nbsp; &nbsp;&nbsp;&nbsp;>  &nbsp;Local participant : Rp. 750.000,-<br>';

    } else if ($vuser->euser_type == 'local student') {
        $pdf->Write(5, ' Payment :' . formatIDR(250000));
        $wording_price = '&nbsp; &nbsp;&nbsp;&nbsp;>  &nbsp;Local students : Rp. 250.000,-<br>';
    } else {
        $wording_price = ' &nbsp; &nbsp;&nbsp;&nbsp;>  &nbsp;Foreign participant : US$ 550';
        $pdf->Write(5, ' Payment : US$' . $payment_amount);
    }

    $pdf->SetXY(50, 200);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Write(5, 'generated by system on ' . date('Y-m-d H:i:s T'));
    $pdf->Image('http://staging.iufroacacia2017.com/wp-content/uploads/2016/08/unpaid.png', 164, 73, 30);

    $filename = $upload_dir['basedir'] . "/dumpticket/iufro2017_ticket_" . $barcodeno . ".pdf";
    $pdf->Output($filename, 'F');

/// ======= END FPDF ============ ///

    // === SEND USER EMAIL === //
    $to      = $vuser->euser_email;
    $subject = 'Registration Closed | IUFRO ACACIA CONFERENCE 2017';
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
  &nbsp;&nbsp;-  &nbsp;The conference fee for onsite payment will be :
<br>
'.$wording_price.'
<br>
  &nbsp;&nbsp;-  &nbsp;Onsite payment user will lose the right to join Mid and Post Trip, and also Conference Dinner
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

    $headers[]   = 'Content-Type: text/html; charset=UTF-8';
    $headers[]   = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
    $headers[]   = 'Cc: Rio Bahtiar <riob@softwareseni.com>';
    $attachments = array(WP_CONTENT_DIR . '/uploads/dumpticket/iufro2017_ticket_' . $barcodeno . '.pdf');
    wp_mail($to, $subject, $body, $headers, $attachments);

    echo "<br>Email Send to " . $vuser->euser_fullname . " at " . date("Y-m-d H:i:s") . "<hr>";
    // ==== UPDATE DATE PAYMENT ==== //
    $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_payment_status' => 'onsite-payment',
            'euser_paylater_date'  => '0000-00-00 00:00:00',
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

}else{
    echo "Yoolaa.. is not today";
}

