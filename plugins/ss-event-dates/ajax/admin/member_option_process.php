<?php 
// Action File
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title></title>
    </head>
<body style="background: #f7f7f7; padding: 20px; font-size: 15px; text-align: center;">
<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
global $wpdb;
global $ss_theme_opt; 
$euser_barcode = $_GET['barcode'];
$query         = "SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
$user_detail   = $wpdb->get_row($query, ARRAY_A);

// ======== Start Payment Conditional Block ======== //

// mid conf
if (isset($user_detail['euser_addon_mid'])) {

    if ($user_detail['euser_addon_mid'] == "gunung-kidul") {
        $string_mid_conf = "Gunung Kidul";
        $price_mid_conf  = 0;
        $product_mc      = "MC1";
    } elseif ($user_detail['euser_addon_mid'] == "klaten") {
        $string_mid_conf = "Klaten";
        $price_mid_conf  = 0;
        $product_mc      = "MC2";
    } elseif ($user_detail['euser_addon_mid'] == "mount-merapi") {
        $string_mid_conf = "Mount Merapi";
        $price_mid_conf  = 0;
        $product_mc      = "MC3";
    } else {
        $string_mid_conf = " - ";
        $price_mid_conf  = 0;
        $product_mc      = "MC0";
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
        $product_pc       = "PC1";
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_shared") {
        $string_post_conf = "Pekanbaru | Shared Room ( US$ 475 )";
        $price_post_conf  = 475;
        $product_pc       = "PC2";
    } elseif ($user_detail['euser_addon_post'] == "pekanbaru_single") {
        $string_post_conf = "Pekanbaru | Single Room ( US$ 510 )";
        $price_post_conf  = 510;
        $product_pc       = "PC3";
    } else {
        $string_post_conf = " - ";
        $price_post_conf  = 0;
        $product_pc       = "PC0";
    }
} else {
    $string_post_conf = " - ";
    $price_post_conf  = 0;
    $product_pc       = "PC0";
}

if (isset($user_detail['euser_addon_dinner'])) {
    if ($user_detail['euser_addon_dinner'] == "Yes") {
        $string_dinner = " Yes ";
        $product_d     = "D1";
    } elseif ($user_detail['euser_addon_dinner'] == "No") {
        $string_dinner = " No ";
        $product_d     = "D2";
    } else {
        $string_dinner = "-";
        $product_d     = "D0";
    }
}

// Payment Dates Earlybird
$paymentDate    = date('Y-m-d');
$paymentDate    = date('Y-m-d', strtotime($paymentDate));
$earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
$earlyBirdEnd   = date('Y-m-d', strtotime("04/30/2017"));

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


if ($_GET['do_model'] == 'do_membership') {

    $getx_result = $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_meta_type' => $_GET['user_type'],
        ),
        array('euser_barcode' => $_GET['barcode']),
        array(
            '%s',
        ),
        array('%s')
    );
    echo "Member type changed Successfully. Please Refresh your browser <kbd>[F5]</kbd>";

// ========= Email Block =========//
    $to      = $user_detail['euser_email'];
    $subject = 'Member type changed Successfully | IUFRO ACACIA 2017';
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
                Membership changed successfully | IUFRO ACACIA 2017
            </div>
            <div>
<p>Thank you, you membership type changed Successfully.</p>

            </div>
            <div>
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
    $headers[] = 'Cc: IUFRO Keeper <keep@iufroacacia2017.com>';
    wp_mail($to, $subject, $body, $headers);

// ========= END Email =========//
} elseif ($_GET['do_model'] == 'do_abstract_revision') {

    if((isset($_FILES['abstract']) && $_FILES['abstract']!="") || (isset($_POST['abstract']) && $_POST['abstract']!="" ) ){
        
        $get_id = upload_user_file($_FILES['abstract']);

        $wpdb->update( 
            'wp_ss_event_user_detail', 
            array( 'euser_abstrak' => $get_id), 
            array( 'euser_barcode' => $_GET['barcode']), 
            array( '%s'), 
            array( '%s' ) 
        );
        // Function to save file and generate to document ID
        function upload_user_file( $file = array() ) {
            require_once( ABSPATH . 'wp-admin/includes/admin.php' );
            $file_return = wp_handle_upload( $file, array('test_form' => false ) );
            if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
                return false;
            } else {
                $filename = $file_return['file'];
                $attachment = array(
                    'post_mime_type' => $file_return['type'],
                    'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'guid' => $file_return['url']
                );
                $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
                wp_update_attachment_metadata( $attachment_id, $attachment_data );
                if( 0 < intval( $attachment_id ) ) {
                    return $attachment_id;
                }
            }
            return false;
        }

    }else{
        echo "Document Empty<pre>";
        var_dump($_GET['abstract']);
        echo "Barcode".$_GET['barcode'];
    }
        echo "</pre>Document uploaded Successfully <kbd>[F5]</kbd>";


} elseif ($_GET['do_model'] == 'do_doc_publish') {
    $getx_result = $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_doc_status' => 'published',
        ),
        array('euser_barcode' => $_GET['barcode']),
        array(
            '%s',
        ),
        array('%s')
    );
    echo "Document Publised Successfully. Please Refresh your browser <kbd>[F5]</kbd>";

// ========= Email Block =========//
    $to      = $user_detail['euser_email'];
    $subject = 'Document Published Notification | IUFRO ACACIA 2017';
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
                Your Document was published to IUFRO ACACIA CONFERENCE 2017 Website
            </div>

        </div>
        <div>
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
    $headers[] = 'Cc: IUFRO Keeper <keep@iufroacacia2017.com>';
    wp_mail($to, $subject, $body, $headers);

// ========= END Email =========//

} elseif ($_GET['do_model'] == 'do_doc_unpublish') {
    $getx_result = $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_doc_status' => 'unpublished',
        ),
        array('euser_barcode' => $_GET['barcode']),
        array(
            '%s',
        ),
        array('%s')
    );
    echo "Document Unpublised Successfully. Please Refresh your browser <kbd>[F5]</kbd>";
} elseif ($_GET['do_model'] == 'do_doc_rejected') {
    $getx_result = $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_doc_status' => 'rejected',
        ),
        array('euser_barcode' => $_GET['barcode']),
        array(
            '%s',
        ),
        array('%s')
    );
    echo "Document Rejected Successfully. Please Refresh your browser <kbd>[F5]</kbd>";
    $authkey = $user_detail['euser_activationkey'];
    $rejection_wording = $_GET['reason'];
// ========= Email Block =========//
    $to      = $user_detail['euser_email'];
    $subject = 'Document Rejected Notification | IUFRO ACACIA 2017';
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
                Your Document was Rejected to IUFRO ACACIA CONFERENCE 2017 Website
            </div>
            <div>
            <p>With regret, we want to inform you that your document still does not meet our requirements.
Therefore, you can not continue to participate on this conference as an Author.</p>
<div>
<p>'.$rejection_wording.'</p>
</div>
<p>But you still can continue to participate as a "Participant" type user, instead of author.
To continue the registration as a participant, simply click the button below.</p>
</div>

                <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                    <a href="http://staging.iufroacacia2017.com/changer?user_auth='.$authkey.'&fromxmail=true" style="background-color: #809062;color: #fff;width: 100px;text-decoration: none;display: block;margin: 0 auto;text-align: center;padding: 10px;margin-bottom: 20px;">CHANGE TO PARTICIPANT</a>
                </div>

<div>
<p>You still need to proceed with the payment. Your payment details can be seen on the summaries page after you click the button above.</p>
            </div>

        </div>
        <div>
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
    $headers[] = 'Cc: IUFRO Keeper <keep@iufroacacia2017.com>';
    wp_mail($to, $subject, $body, $headers);

// ========= END Email =========//

} elseif ($_GET['do_model'] == 'do_doc_approved') {
    $getx_result = $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_doc_status' => 'approved',
        ),
        array('euser_barcode' => $_GET['barcode']),
        array(
            '%s',
        ),
        array('%s')
    );
    echo "Document Approved Successfully. Please Refresh your browser <kbd>[F5]</kbd>";
    $approve_wording = sanitize_text_field( $_GET['reason'] );
// ========= Email Block =========//
    $to      = $user_detail['euser_email'];
    $subject = 'Document Approved Notification | IUFRO ACACIA 2017';
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
                Document Approved Notification | IUFRO ACACIA 2017
            </div>
            <div>
<p>This is to inform you that your document has been approved by us. <br> '.$approve_wording.' </br> In order to continue the registration process, you have to complete the payment.</p>

<p>Below is your payment detail :</p>

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
            <div>
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
    $headers[] = 'Cc: IUFRO Keeper <keep@iufroacacia2017.com>';
    wp_mail($to, $subject, $body, $headers);

// ========= END Email =========//




} else {
    echo "ERR21. Please Refresh your browser <kbd>[F5]</kbd>";
}

// echo "<pre>";
// var_dump($getx_result);
// echo "</pre><hr>Lagi";
// echo "<pre>";
// var_dump($wpdb);
// echo "</pre><hr>Lagi";

?>
    </body>
</html>