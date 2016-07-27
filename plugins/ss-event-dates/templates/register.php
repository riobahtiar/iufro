<?php
$success = 0;

if ( isset($_POST['submit'] ) ) {
    $fullname   =   sanitize_user( $_POST['salutation'].$_POST['title']." ".$_POST['fullname'] );
    $password   =   esc_attr( $_POST['password'] );
    $email      =   sanitize_email( $_POST['email'] );
    $phone      =   sanitize_text_field( $_POST['phone'] );
    $address    =   esc_textarea( $_POST['address'] );
    $zip        =   sanitize_text_field( $_POST['zip'] );
    $city       =   sanitize_text_field( $_POST['city'] );
    $state      =   sanitize_text_field( $_POST['state'] );
    $country    =   sanitize_text_field( $_POST['country'] );
    $user_reg_type   =  $_POST['user_type'];

    //save custom data into table  wp_ss_event_user_detail
    save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type);
    $success = complete_registration($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type);
    //echo "<br>Validate Data 1 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;

}

if ($success == 0){
    require_once dirname(__FILE__) . '/register/personal.php';
}


function complete_registration($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type) {
        $userdata = array(
        'user_login'    =>   $email,
        'user_email'    =>   $email,
		'display_name'  =>   $fullname,
        'user_pass'     =>   $password,
        'phone'     	=>   $phone,
        'address'  		=>   $address,
        'zip'    		=>   $zip,
        'city'     		=>   $city,
        'state'      	=>   $state,
        'country'   	=>   $country,
        );
        $user = wp_insert_user( $userdata );
        echo 'Please login and complete your registeration here <a href="' . get_site_url() . '/login">login page</a>.'; 
        //echo "<br>Validate Data 2 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;
        return 1;    
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type){
    global $wpdb;

$wpdb->get_results( 'SELECT COUNT(*) FROM wp_ss_event_user_detail' );
$num_rows=$wpdb->num_rows;
$barcode=$num_rows.date('Ymd').rand(1000, 9999);
$randAct=generateRandomString(15);
    $wpdb->insert( 
                'wp_ss_event_user_detail', 
                array( 
                    'euser_fullname' => $fullname, 
                    'euser_phone' => $phone, 
                    'euser_email' => $email, 
                    'euser_address' => $address, 
                    'euser_zip' => $zip, 
                    'euser_city' => $city, 
                    'euser_state' => $state, 
                    'euser_country' => $country,
                    'euser_meta_type' => $user_reg_type,
                    'euser_activationkey' => $randAct,
                    'euser_barcode' => $barcode           
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
    //echo "<br>Validate Data 3 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;


// The Email Account
$to = $email;
$subject = 'Welcome to IUFRO ACACIA 2017';
$body .= '
Hello '.$fullname.' 
<hr>';

$body .= '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>IUFRO ACACIA 2017</title>
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
$body .= 'Thank you for participating on IUFRO ACACIA Conference 2017</div><br>';


$body .= 'Welcome to your personal IUFRO ACACIA 2017 account.<br>
<hr>
To activate your IUFRO ACACIA 2017 account please validate your email address. Simply click the button below:<br>';
$body .= '<a href="http://staging.iufroacacia2017.com/redir_xcmil?user_auth='.$randAct.'&fromxmail=true">Activate Account</a><hr>';

$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; // note you can just use a simple email address
wp_mail( $to, $subject, $body, $headers );



    }







?>