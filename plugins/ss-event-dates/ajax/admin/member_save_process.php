<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
global $wpdb;

if ( isset($_POST['submit'] ) ) {
    $fullname   =   sanitize_user( $_POST['salutation']." ".$_POST['title']." ".$_POST['fullname'] );
    $password           =   'iufroacacia2017_Gen-PWD';
    $email              =   sanitize_email( $_POST['email'] );
    $phone              =   sanitize_text_field( $_POST['phone'] );
    $address            =   esc_textarea( $_POST['address'] );
    $zip                =   sanitize_text_field( $_POST['zip'] );
    $city               =   sanitize_text_field( $_POST['city'] );
    $state              =   sanitize_text_field( $_POST['state'] );
    $country            =   sanitize_text_field( $_POST['country'] );
    $user_reg_type      =   $_POST['user_type'];
    $midc               =   sanitize_text_field( $_POST['midc'] );
    $postc              =   sanitize_text_field( $_POST['postc'] );
    $dinner             =   sanitize_text_field( $_POST['dinner'] );
    complete_registration($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type);
    $ubarcode = save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type,$midc,$postc,$dinner);
    
    wp_redirect( get_site_url().'/wp-content/plugins/ss-event-dates/ajax/admin_user_extra.php?brcd='.$ubarcode );
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

function save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country, $user_reg_type, $midc, $postc, $dinner){
    global $wpdb;
    $barcode='17'.date('md').rand(1000, 9999);
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
                    'euser_addon_mid' => $midc,
                    'euser_addon_post' => $postc,
                    'euser_addon_dinner' => $dinner,
                    'euser_status' => 'activated',
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
                '%s',
                '%s',
                '%s',
                '%s',
                '%s') 
            );
    return $barcode;

}