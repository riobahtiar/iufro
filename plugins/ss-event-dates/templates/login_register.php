<?php if(!is_user_logged_in()){ ?>
	<div class="ss-btn-group">
		<a href="<?php echo get_site_url();?>/login" class="ss-head-btn-login">Login</a>
		<a href="<?php echo get_site_url();?>/register" class="ss-head-btn-register">Register</a>
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
  get_currentuserinfo();
  echo $current_user->display_name;	
?>, <a class="edit-my-profile" href="<?php echo get_site_url().'/login/user_dashboard?step=detail_profil' ?>">Edit Profile</a>
</div>
<?php }?>