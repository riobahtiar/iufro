<?php
$success = 0;

if ( isset($_POST['submit'] ) ) {
    $fullname   =   sanitize_user( $_POST['salutation'].$_POST['title']." ".$_POST['fullname'] );
    $c_password   =   esc_attr( $_POST['c_password'] );
    $password   =   esc_attr( $_POST['password'] );
    $email      =   sanitize_email( $_POST['email'] );
    $phone      =   sanitize_text_field( $_POST['phone'] );
    $address    =   esc_textarea( $_POST['address'] );
    $zip        =   sanitize_text_field( $_POST['zip'] );
    $city       =   sanitize_text_field( $_POST['city'] );
    $state      =   sanitize_text_field( $_POST['state'] );
    $country    =   sanitize_text_field( $_POST['country'] );
    $user_reg_type   =  $_POST['user_type'];

    registration_validation( $fullname, $password, $email, $phone, $c_password, $address, $zip, $city, $state, $country, $user_reg_type);
    save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type);
    $success = complete_registration($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type);


}

if ($success == 0){
    require_once dirname(__FILE__) . '/register/personal.php';
}



//
if ($success == 0){
    require_once dirname(__FILE__) . '/register/personal.php';
}

function registration_validation( $fullname, $password, $email, $phone, $c_password, $address, $zip, $city, $state, $country, $user_reg_type) {
    global $reg_errors;
    $reg_errors = new WP_Error;
    if ( empty( $fullname ) || empty( $password ) || empty( $email ) || empty( $phone ) || empty( $c_password ) || empty( $zip ) || empty( $city ) || empty( $state ) || empty( $country ) || empty( $user_reg_type ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }
    if ($password != $c_password ) {
        $reg_errors->add( 'password', 'Password and confirmation password must be same' );
    }

    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }

    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }

    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div class="alert alert-warning">';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';           
        }    
    }
}




function complete_registration($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type) {
    global $reg_errors;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
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
        echo '<div class="well register-thankyou">Thank you for registering on IUFRO ACACIA CONFERENCE 2017.<br>
Please check your email to activate your account.</div>'; 
        //echo "<br>Validate Data 2 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;
        return 1;
    }    
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

function save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country, $user_reg_type){
    global $reg_errors;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
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

    $to = $email;
    $subject = 'Email Activation | IUFRO ACACIA CONFERENCE 2017';

    $body .= '
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
                    Welcome to your personal IUFRO ACACIA CONFERENCE 2017 account.
                </div>
                <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                    <p>Below are your login details:</p>
                </div>';
    $body .= '<div id="registration" style="padding:15px 0;">
                    <table>
                        <tbody style="color:#525252;font-size:16px;">
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td>'.$email.'</td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>:</td>
                                <td>'.$password.'</td>
                            </tr>

                        </tbody>
                    </table>
    </div>
                <div style="width:100%;text-align: left;border-bottom:1px solid #809062;">
                    <p>To activate your IUFRO ACACIA 2017 account please validate your email address. Simply click the button below:</p>
                    <a href="http://staging.iufroacacia2017.com/redir_xcmil?user_auth='.$randAct.'&fromxmail=true" style="background-color: #809062;color: #fff;width: 100px;text-decoration: none;display: block;margin: 0 auto;text-align: center;padding: 10px;margin-bottom: 20px;">ACTIVATE</a>
                </div>';


    $body .= '
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
    $headers[] = 'Reply-To: IUFRO ACACIA TEAM <secretariat@iufroacacia2017.com>';
    $headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; 
    wp_mail( $to, $subject, $body, $headers );
    }
}