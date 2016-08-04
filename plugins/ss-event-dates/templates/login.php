<?php 

if(is_user_logged_in()){
	wp_redirect(get_site_url().'/login/user_dashboard');
}




$args = array(
	'echo'           => true,
	'remember'       => true,
	'redirect'       => site_url().'/user_dashboard',
	'form_id'        => 'loginform',
	'id_username'    => 'user_login',
	'id_password'    => 'user_pass',
	'id_remember'    => 'rememberme',
	'id_submit'      => 'wp-submit',
	'label_username' => __( 'Email' ),
	'label_password' => __( 'Password' ),
	'label_remember' => __( 'Remember Me' ),
	'label_log_in'   => __( 'Log In' ),
	'value_username' => '',
	'value_remember' => false
);?>
<?php if(isset($_GET['p']) & $_GET['p']=="updated"){ ?>
	<div class="alert alert-warning">Your Password has ben updated please <a href="<?php echo get_site_url().'/login'; ?>">re-login</a></div>
<?php } elseif(isset($_GET['p']) & $_GET['p']=="failed"){ ?>
	<div class="alert alert-warning">Password Error, Please try again.</div>
<?php
wp_login_form( $args );
 }  elseif(isset($_GET['p']) & $_GET['p']=="empty"){ ?>
	<div class="alert alert-warning">Password Empty, Please try again.</div>
<?php 
wp_login_form( $args );
} else { 
 wp_login_form( $args ); 
}
 ?>