<?php
/**
 * @package User Dashboard
 * @author riobahtiar
 */


function dash_css() {
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
.etable {
    border: 1px solid #ddd;
    font-size: 13px;
}
.etable {
    width: 100%;
    max-width: 100%;
    margin-bottom: 20px;
}

.etable {
    border-collapse: collapse;
    border-spacing: 0;
    display: table;
    background: white;
}

.etable>tbody>tr>td, .etable>tbody>tr>th, .etable>tfoot>tr>td, .etable>tfoot>tr>th, .etable>thead>tr>td, .etable>thead>tr>th {
    border: 1px solid #ddd;
}
.etable>tbody>tr>td, .etable>tbody>tr>th, .etable>tfoot>tr>td, .etable>tfoot>tr>th, .etable>thead>tr>td, .etable>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #ddd;
}
.etable thead{
	background: green;
	color: white;
	border-color: black;
}
	</style>
	";
}

add_action( 'admin_head', 'dash_css' );


// create custom plugin settings menu
add_action('admin_menu', 'init_iufro_dash');

function init_iufro_dash() {

	//create new top-level menu
	add_menu_page('IUFRO U', 'Users', 'administrator', IUFRO_DIR, 'users_page_control' , plugins_url('ss-event-dates/assets/man.png', IUFRO_DIR) );
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

