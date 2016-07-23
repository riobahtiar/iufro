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
    echo "<br>Validate Data 1 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;
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
        echo "<br>Validate Data 2 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;
        return 1;    
}

function save_custom_userdata($fullname, $password, $email, $phone, $address, $zip, $city, $state, $country,$user_reg_type){
    global $wpdb;
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
                    'euser_meta_type' => $user_reg_type
                    
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
                '%s') 
            );
    echo "<br>Validate Data 3 ". $fullname." + ".$password." + ".$email." + ".$phone." + ".$address." + ".$zip." + ".$city." + ".$state." + ".$country." + ".$user_reg_type;
    }




?>