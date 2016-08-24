<?php if(!is_user_logged_in()){ ?>
	<div class="ss-btn-group">
		<a href="<?php echo get_site_url();?>/login" class="ss-head-btn-login">Login</a>
	<?php 
date_default_timezone_set("Asia/Bangkok");
global $ss_theme_opt;
// is close date or not
$today    = date('Y-m-d');
$closed = date('Y-m-d', strtotime($ss_theme_opt['date_close']));
if ($today !== $closed ){
	 ?>
		<a href="<?php echo get_site_url();?>/register" class="ss-head-btn-register">Register</a>
<?php } ?>
	</div>
<?php } else { ?>
	<div class="ss-btn-group">
		<a href="<?php echo get_site_url();?>/login/user_dashboard" class="dashboard">User Dashboard</a>
		<a href="<?php echo wp_logout_url( get_site_url().'/login' ); ?> " class="logout">Logout</a>
	</div>
<div class="welcome-user">
	Welcome&nbsp;
<?php 
	global $current_user;
	wp_get_current_user(); 
	echo $current_user->display_name;	
?>
</div>
<?php }?>