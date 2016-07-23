<?php
$success = 0;

if ( isset($_POST['submit'] ) ) {

    registration_validation(
        $_POST['fullname'],
        $_POST['password'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['c_password'],
        $_POST['address'],
        $_POST['zip'],
        $_POST['city'],
        $_POST['state'],
        $_POST['country'],
        $_POST['user_type']
    );
       
    // sanitize user form input
    global $fullname, $password, $email, $phone, $address, $zip, $city, $state, $country, $user_reg_type;
    $fullname   =   sanitize_user( $_POST['salutation'].$_POST['title']." ".$_POST['fullname'] );
    $password   =   esc_attr( $_POST['password'] );
    $email      =   sanitize_email( $_POST['email'] );
    $phone      =   sanitize_text_field( $_POST['phone'] );
    $address    =   esc_textarea( $_POST['address'] );
    $zip        =   sanitize_text_field( $_POST['zip'] );
    $city       =   sanitize_text_field( $_POST['city'] );
    $state      =   sanitize_text_field( $_POST['state'] );
    $country    =   sanitize_text_field( $_POST['country'] );
    $user_reg_type   =  sanitize_text_field( $_POST['user_type'] );
 
       
    
    //save custom data into table  wp_ss_event_user_detail
    save_custom_userdata(
        $fullname, 
        $password, 
        $email, 
        $phone, 
        $address, 
        $zip, 
        $city, 
        $state, 
        $country,
        $user_reg_type
    );

    // call @function complete_registration to create the user
    // only when no WP_error is found
    // echo "here_2";
    $success = complete_registration(
        $fullname, 
        $password, 
        $email, 
        $phone, 
        $address, 
        $zip, 
        $city, 
        $state, 
        $country,
        $user_reg_type
    );
}

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
	        echo '<div>';
	        echo '<strong>ERROR </strong>:';
	        echo $error . '<br/>';
	        echo '</div>';	         
	    }	 
	}
}


function complete_registration() {
    global $reg_errors, $fullname, $password, $email, $phone, $c_password, $address, $zip, $city, $state, $country;
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
        echo 'Please login and complete your registeration here <a href="' . get_site_url() . '/login">login page</a>.'; 

        return 1;
    }
    
}

function save_custom_userdata(){
    global $reg_errors, $fullname, $password, $email, $phone, $c_password, $address, $zip, $city, $state, $country, $user_reg_type;   
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
    }


?>