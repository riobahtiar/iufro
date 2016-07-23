<?php 

if(is_user_logged_in()){
	wp_redirect(get_site_url().'/login/user_dashboard');
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
