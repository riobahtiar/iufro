<?php 

if(is_user_logged_in()){
	wp_redirect(get_site_url().'/login/user_dashboard');
}


add_filter( 'login_errors', function( $error ) {
	global $errors;
	$err_codes = $errors->get_error_codes();

	// Invalid username.
	// Default: '<strong>ERROR</strong>: Invalid username. <a href="%s">Lost your password</a>?'
	if ( in_array( 'invalid_username', $err_codes ) ) {
		$error = '<strong>ERROR</strong>: Invalid username.';
	}

	// Incorrect password.
	// Default: '<strong>ERROR</strong>: The password you entered for the username <strong>%1$s</strong> is incorrect. <a href="%2$s">Lost your password</a>?'
	if ( in_array( 'incorrect_password', $err_codes ) ) {
		$error = '<strong>ERROR</strong>: The password you entered is incorrect.';
	}

	return $error;
} );


if( is_wp_error( $error ) ) {
    echo $error->get_error_message();
}


$args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'/user_dashboard',
	'form_id'        => 'loginform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => __( 'Username' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
);?>
<?php if(isset($_GET['p']) & $_GET['p']=="updated"){ ?>
	<div class="warning">Your Password has ben updated please re-login</div>
<?php }?>
<?php wp_login_form( $args ); ?> 
