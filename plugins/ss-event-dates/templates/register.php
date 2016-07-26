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
$body .= 'Welcome to your personal IUFRO ACACIA 2017 account.<br>

To activate your IUFRO ACACIA 2017 account please validate your email address. Simply click the button below:<br>';
$body .= '<a href="http://staging.iufroacacia2017.com/redir_xcmil?user_auth='.$randAct.'&fromxmail=true">Activate Account</a><hr>';

$headers[] = 'Content-Type: text/html; charset=UTF-8';
$headers[] = 'From: IUFRO ACACIA TEAM <noreply@iufroacacia2017.com>';
$headers[] = 'Cc: Rio Hotmail <riobahtiar@live.com>'; // note you can just use a simple email address
wp_mail( $to, $subject, $body, $headers );



    }







?>