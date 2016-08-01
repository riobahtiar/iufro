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
	add_menu_page('IUFRO U', 'IUFRO U', 'administrator', IUFRO_DIR, 'users_page_control' , plugins_url('ss-event-dates/assets/muda.png', IUFRO_DIR) );
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
  <th width="17%">Addon</th>
  <th width="14%">Payment</th>
  <th width="8%">Last Login</th>
  <th width="8%">Act</th>
</tr>
</thead>
<tbody>
<?php 
foreach ( $get_members as $show_me ) {

// mid conf
if(isset($show_me->euser_addon_mid )){

        if ( $show_me->euser_addon_mid == "gunung-kidul" ) {
          $string_mid_conf="Gunung Kidul";
          $price_mid_conf = 0;
        }elseif ( $show_me->euser_addon_mid == "klaten" ) {
          $string_mid_conf="Klaten";
          $price_mid_conf = 0;
        }elseif ( $show_me->euser_addon_mid == "mount-merapi" ) {
          $string_mid_conf="Mount Merapi";
          $price_mid_conf = 0;
        }else{
          $string_mid_conf=" - ";
          $price_mid_conf = 0;
        } 

}else{
  $string_mid_conf=" - ";
  $price_mid_conf == 0;
}

// post conf
if(isset($show_me->euser_addon_post )){
    // Pricing Post Conference
        if ( $show_me->euser_addon_post  == "pacitan" ) {
          $string_post_conf="Pacitan ( USD 250 )";
          $price_post_conf = 250;
        }elseif ( $show_me->euser_addon_post  == "pekanbaru_shared" ) {
          $string_post_conf="Pekanbaru | Shared Room ( USD 475 )";
          $price_post_conf = 475;
        }elseif ( $show_me->euser_addon_post  == "pekanbaru_single" ) {
          $string_post_conf="Pekanbaru | Single Room ( USD 510 )";
          $price_post_conf = 510;
        }else{
          $string_post_conf=" - ";
          $price_post_conf = 0;
        }
}else{
  $string_post_conf=" - ";
  $price_post_conf = 0;
}

if(isset( $show_me->euser_addon_dinner )){
  $string_dinner=" Yes ";
}else{
  $string_dinner=" No ";
}




    // Paymen Dates Earlybird
 $paymentDate = $show_me->euser_payment_date;
 $paymentDate=date('Y-m-d', strtotime($paymentDate));
 $earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
 $earlyBirdEnd = date('Y-m-d', strtotime("04/30/2017"));


if ( $show_me->euser_type =="local student") {
  $user_string = "Local | Students";
  $total_price=$price_post_conf+20;
  $user_price=20;
}elseif ( $show_me->euser_type =="local regular") {
  // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd))
    {
        $user_string = "Local | Regular ( Early Bird Rates )";
        $total_price=$price_post_conf+23;
        $user_price=23;
    } else {
        $user_string = "Local | Regular ( Regular Rates )";
        $total_price=$price_post_conf+39;
        $user_price=39;
    }
}elseif ( $show_me->euser_type =="foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd))
    {
        $user_string = "Foreign ( Early Bird Rates )";
        $total_price=$price_post_conf+350;
        $user_price=350;
    } else {
        $user_string = "Foreign ( Regular Rates )";
        $total_price=$price_post_conf+400;
        $user_price=400;
    }

}else{
  $total_price=0;
}


?>
<tr id="euser-<?php echo $show_me->euser_id; ?>">
  <td><?php echo $show_me->euser_barcode; ?></td>
  <td><?php echo $show_me->euser_fullname.$show_me->euser_abstrak.$show_me->euser_poster.$string_mid_conf; ?></td>
  <td>
<?php   if (isset( $show_me->euser_abstrak )) { ?>
Abstract: <a href="<?php wp_get_attachment_url( $show_me->euser_abstrak ); ?>" target="_blank">Download</a><br>
<?php } if (isset( $show_me->euser_paper )) { ?>
Paper: <a href="<?php wp_get_attachment_url( $show_me->euser_paper ); ?>" target="_blank">Download</a><br>
<?php } if (isset( $show_me->euser_poster )) { ?>
Poster: <a href="<?php wp_get_attachment_url( $show_me->euser_poster ); ?>" target="_blank">Download</a><br>
<?php } if (isset( $show_me->euser_stdcard_id )) { ?>
  Student Card: <a href="<?php wp_get_attachment_url( $show_me->stdcard_id ); ?>" target="_blank">Download</a><br>
<?php } ?>
  </td>
  <td><?php echo $show_me->euser_status; ?></td>
  <td>
  	
<?php   if ($user_string) { ?>
User Type: <?php echo $user_string; ?><br>
<?php } if (isset( $string_mid_conf )) { ?>
Trip Mid Conference : <?php echo $string_mid_conf; ?><br>
<?php } if (isset( $string_post_conf )) { ?>
Trip Post Conference : <?php echo $string_post_conf; ?><br>
<?php } if (isset( $string_dinner )) { ?>
  Dinner : <?php echo $string_dinner; ?><br>
<?php } ?>

  </td>
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

