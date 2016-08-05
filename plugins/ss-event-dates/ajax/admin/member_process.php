<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
global $wpdb;
$euser_barcode = $_GET['barcode'];
$query         = "SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
$user_detail   = $wpdb->get_row($query, ARRAY_A);

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
    echo "Member type changed Successfully. Please Refresh your browser <kbd>[CTRL+F5]</kbd>";

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
                Your Member type changed Successfully
            </div>

        </div>
    </body>

</html>
';

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
    $headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>';
    wp_mail($to, $subject, $body, $headers);

// ========= END Email =========//

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
    echo "Document Publised Successfully. Please Refresh your browser <kbd>[CTRL+F5]</kbd>";

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
    </body>

</html>
';

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
    $headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>';
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
    echo "Document Unpublised Successfully. Please Refresh your browser <kbd>[CTRL+F5]</kbd>";
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
    echo "Document Rejected Successfully. Please Refresh your browser <kbd>[CTRL+F5]</kbd>";


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

        </div>
    </body>

</html>
';

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
    $headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>';
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
    echo "Document Approved Successfully. Please Refresh your browser <kbd>[CTRL+F5]</kbd>";


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
                Your Document was Approved to IUFRO ACACIA CONFERENCE 2017 Website
            </div>

        </div>
    </body>

</html>
';

    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
    $headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>';
    wp_mail($to, $subject, $body, $headers);

// ========= END Email =========//




} else {
    echo "ERR21. Please Refresh your browser <kbd>[CTRL+F5]</kbd>";
}

// echo "<pre>";
// var_dump($getx_result);
// echo "</pre><hr>Lagi";
// echo "<pre>";
// var_dump($wpdb);
// echo "</pre><hr>Lagi";
