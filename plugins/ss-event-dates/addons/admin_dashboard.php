<?php
/**
 * @package User Dashboard
 * @author riobahtiar
 */


// create custom plugin settings menu
add_action('admin_menu', 'init_iufro_dash');

function init_iufro_dash() {

	//create new top-level menu
	add_menu_page('IUFRO U', 'Users', 'administrator', IUFRO_DIR, 'users_page_control' , plugins_url('ss-event-dates/assets/plant1.png', IUFRO_DIR) );
}


function users_page_control() {
	global $wpdb;
	$get_members = $wpdb->get_results( "SELECT * FROM wp_ss_event_user_detail" );
?>
<div class="wrap">
<h2>IUFRO ACACIA CONFERENCE 2017</h2>
<p>Control Dashboard</p>
<table class="etable">
<thead>
<tr>
  <th width="10%">ID</th>
  <th width="14%">Name</th>
  <th width="14%">Files</th>
  <th width="14%">Status</th>
  <th width="17%">Details</th>
  <th width="14%">Payment</th>
  <th width="8%">Last Login</th>
  <th width="8%">Act</th>
</tr>
</thead>
<tbody>
<?php 
foreach ( $get_members as $show_me ) {
?>
<tr id="rio_t-<?php echo $show_me->euser_id; ?>">
  <td><?php echo $show_me->euser_barcode; ?></td>
  <td><?php echo $show_me->euser_fullname; ?></td>
  <td><?php echo $show_me->euser_email; ?></td>
  <td><?php echo $show_me->euser_status; ?></td>
  <td><?php echo $show_me->euser_addon; ?></td>
  <td><?php echo $show_me->euser_payment_status; ?></td>
  <td><?php echo $show_me->updated_at; ?></td>
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
			url: '<?php echo plugins_url('rio-testimonial/rt-delete.php', IUFRO_DIR); ?>',
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

