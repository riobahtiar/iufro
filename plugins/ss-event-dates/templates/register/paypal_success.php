<?php
$product=$_GET['trxname'];
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;


// ========= Include PDF Lib & Barcode Lib ========= //
require_once( IUFRO_DIR . 'addons/fpdf/fpdf.php' );
require_once( IUFRO_DIR . 'addons/barcode/src/BarcodeGenerator.php' );
require_once( IUFRO_DIR . 'addons/barcode/src/BarcodeGeneratorPNG.php' );


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
            // ===== Emails ==== //
$to = $euser_email;
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
                Thank you for completing the payment,<br>Transaction Code: '.$product.'
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

// ==== attachments ==== //
$pdf = new FPDF('P', 'pt', array(500,233));
$pdf->AddFont('Georgiai','','georgiai.php');
$pdf->AddPage();
$pdf->Image('lib/fpdf/image.jpg',0,0,500);
$pdf->SetFont('georgiai','',16);
$pdf->Cell(40,10,'Hello World!');
// attachment name
$filename = "test.pdf";
// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));
// a random hash will be necessary to send mixed content
$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;
$attachments = "--".$separator.$eol;
$attachments .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$attachments .= "Content-Transfer-Encoding: base64".$eol;
$attachments .= "Content-Disposition: attachment".$eol.$eol;
$attachments .= $attachment.$eol;
$attachments .= "--".$separator."--";


wp_mail( $to, $subject, $body, $headers, $attachments );