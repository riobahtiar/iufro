<?php
/**
 * @package User Dashboard
 * @author riobahtiar
 */


// create custom plugin settings menu
add_action('admin_menu', 'init_rt_menu');

function init_rt_menu() {

	//create new top-level menu
	add_menu_page('Rio Testimonial Page', 'Testimonials', 'administrator', RT_DIR, 'rt_dashboard_settings_page' , plugins_url('rio-testimonial/img/chat.png', RT_DIR) );

	//call register settings function
	add_action( 'admin_init', 'register_rt_plugin_settings' );
}


function register_rt_plugin_settings() {
	//register our settings
	register_setting( 'my-cool-plugin-settings-group', 'new_option_name' );
	register_setting( 'my-cool-plugin-settings-group', 'some_other_option' );
	register_setting( 'my-cool-plugin-settings-group', 'option_etc' );
}

function rt_dashboard_settings_page() {
	global $wpdb;
	$show_testimonials = $wpdb->get_results( "SELECT * FROM wp_testimonial" );
?>
<div class="wrap">
<h2>Testimonial Dashboard</h2>

<table class="etable">
<thead>
<tr>
  <th width="16%">ID</th>
  <th width="16%">Email</th>
  <th width="16%">Phone</th>
  <th width="45%">Testimonials</th>
  <th width="7%">Act</th>
</tr>
</thead>
<tbody>
<?php 
foreach ( $show_testimonials as $show_me ) {
?>
<tr id="rio_t-<?php echo $show_me->ID; ?>">
  <td><?php echo $show_me->name; ?></td>
  <td><?php echo $show_me->email; ?></td>
  <td><?php echo $show_me->phone; ?></td>
  <td><?php echo $show_me->testimonial; ?></td>
  <td>
<a href="?delete=<?php echo $show_me->ID; ?>" class="delete">Delete</a>
  </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<script>
jQuery(document).ready(function() {
	jQuery('a.delete').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent();
		$.ajax({
			type: 'get',
			url: '<?php echo plugins_url('rio-testimonial/rt-delete.php', RT_DIR); ?>',
			data: 'ajax=1&delete=' + parent.attr('id').replace('rio_t-',''),
			beforeSend: function() {
				parent.animate({'backgroundColor':'#fb6c6c'},300);
			},
			success: function() {
				parent.slideUp(300,function() {
					parent.remove();
				});
			}
		});
	});
});
</script>
<?php } 

