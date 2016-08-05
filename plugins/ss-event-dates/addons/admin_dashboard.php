<?php
/**
 * @package User Dashboard
 * @author riobahtiar
 */
add_thickbox();
function modal_action()
{
    define('IFRAME_REQUEST', true);
    iframe_header();
    iframe_footer();
    exit;
}
add_action('admin_action_foo_modal_box', 'modal_action');

function dash_css()
{
    $x = is_rtl() ? 'left' : 'right';

    echo "
  <style type='text/css'>
.xdetails{
  max-width: 200px;
  padding: 7px;
  background-color: #2c3e50;
  color: #ecf0f1;
  font-size: 8px;
  display: none;
}
.xdetails p{
  margin: 0;
}

#ihide,#ishow{
    position: relative;
    display: inline-block;
    box-sizing: border-box;
    margin-right: 0.333em;
    padding: 0.5em 1em;
    border: 1px solid #999;
    border-radius: 2px;
    cursor: pointer;
    font-size: 0.88em;
    color: black;
    white-space: nowrap;
    overflow: hidden;
    background-color: #e9e9e9;
    background-image: -webkit-linear-gradient(top, #fff 0%, #e9e9e9 100%);
    background-image: -moz-linear-gradient(top, #fff 0%, #e9e9e9 100%);
    background-image: -ms-linear-gradient(top, #fff 0%, #e9e9e9 100%);
    background-image: -o-linear-gradient(top, #fff 0%, #e9e9e9 100%);
    background-image: linear-gradient(to bottom, #fff 0%, #e9e9e9 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='white', EndColorStr='#e9e9e9');
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    text-decoration: none;
    outline: none;
}
#ihide:hover,#ishow:hover{
    border: 1px solid #666;
    background-color: #e0e0e0;
    background-image: -webkit-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
    background-image: -moz-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
    background-image: -ms-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
    background-image: -o-linear-gradient(top, #f9f9f9 0%, #e0e0e0 100%);
    background-image: linear-gradient(to bottom, #f9f9f9 0%, #e0e0e0 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#f9f9f9', EndColorStr='#e0e0e0');
}
.etable {
    border: 1px solid #59524c;
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
    border: 1px solid #59524c;
}
.etable>tbody>tr>td, .etable>tbody>tr>th, .etable>tfoot>tr>td, .etable>tfoot>tr>th, .etable>thead>tr>td, .etable>thead>tr>th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: top;
    border-top: 1px solid #59524c;
}
.etable thead{
  background: #59524c;
  color: white;
  border-color: black;
}

div#iufro-member_filter {
    margin-right: 2px;
    margin-bottom: -2px;
    margin-top: -48px;
    width: 35%;
}


#iufro-member_filter input[type='search'] {
    width: 70%;
    border: #d606da medium solid;
    border-radius: 23px;
    text-align: center;
    font-weight: bold;
    transition: ease-in-out, width .35s ease-in-out;
    color: #d606da;
}

#iufro-member_filter label{
  color:#f1f1f1;
}

#iufro-member_filter input[type='search']:focus {
    width: 85%;
    border: #4f0450 medium solid;
    color: #4f0450;
}


  </style>
  ";
}

add_action('admin_head', 'dash_css');

// create custom plugin settings menu
add_action('admin_menu', 'init_iufro_dash');

function init_iufro_dash()
{

    //create new top-level menu
    add_menu_page('IUFRO U', 'IUFRO U', 'administrator', IUFRO_DIR, 'users_page_control', plugins_url('ss-event-dates/assets/muda.png', IUFRO_DIR));
}

function users_page_control()
{
    global $wpdb;
    $get_members = $wpdb->get_results("SELECT * FROM wp_ss_event_user_detail");
    ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/datatables.min.js"></script>

<div class="wrap">
<h2>IUFRO ACACIA CONFERENCE 2017</h2>
<h4>Control Dashboard</h4>
<div class="dtbl-btn"></div>
<p>&nbsp;| &nbsp;Payment Details: <button id="ihide">Hide</button>&nbsp;<button id="ishow">Show</button></p>
<table class="etable" id="iufro-member" class="display" cellspacing="0" width="100%">
<thead>
<tr>
  <th width="10%">ID</th>
  <th width="14%">Name</th>
  <th width="14%">Files</th>
  <th width="10%">Status</th>
  <th width="21%">Addon</th>
  <th width="14%">Payment</th>
  <th width="8%">Last Login</th>
  <th width="8%">Act</th>
</tr>
</thead>
<tbody>
<?php
foreach ($get_members as $show_me) {

// mid conf
        if (isset($show_me->euser_addon_mid)) {

            if ($show_me->euser_addon_mid == "gunung-kidul") {
                $string_mid_conf = "Gunung Kidul";
                $price_mid_conf  = 0;
            } elseif ($show_me->euser_addon_mid == "klaten") {
                $string_mid_conf = "Klaten";
                $price_mid_conf  = 0;
            } elseif ($show_me->euser_addon_mid == "mount-merapi") {
                $string_mid_conf = "Mount Merapi";
                $price_mid_conf  = 0;
            } else {
                $string_mid_conf = " - ";
                $price_mid_conf  = 0;
            }

        } else {
            $string_mid_conf = " - ";
            $price_mid_conf == 0;
        }

// post conf
        if (isset($show_me->euser_addon_post)) {
            // Pricing Post Conference
            if ($show_me->euser_addon_post == "pacitan") {
                $string_post_conf = "Pacitan ( USD 250 )";
                $price_post_conf  = 250;
            } elseif ($show_me->euser_addon_post == "pekanbaru_shared") {
                $string_post_conf = "Pekanbaru | Shared Room ( USD 475 )";
                $price_post_conf  = 475;
            } elseif ($show_me->euser_addon_post == "pekanbaru_single") {
                $string_post_conf = "Pekanbaru | Single Room ( USD 510 )";
                $price_post_conf  = 510;
            } else {
                $string_post_conf = " - ";
                $price_post_conf  = 0;
            }
        } else {
            $string_post_conf = " - ";
            $price_post_conf  = 0;
        }

        if (isset($show_me->euser_addon_dinner)) {
            $string_dinner = " Yes ";
        } else {
            $string_dinner = " No ";
        }

        // Paymen Dates Earlybird
        $paymentDate    = $show_me->euser_payment_date;
        $paymentDate    = date('Y-m-d', strtotime($paymentDate));
        $earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
        $earlyBirdEnd   = date('Y-m-d', strtotime("04/30/2017"));

        if ($show_me->euser_type == "local student") {
            $user_string = "Local | Students";
            $total_price = $price_post_conf + 20;
            $user_price  = 20;
        } elseif ($show_me->euser_type == "local regular") {
            // Early Bird Conf
            if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
                $user_string = "Local | Regular ( Early Bird Rates )";
                $total_price = $price_post_conf + 23;
                $user_price  = 23;
            } else {
                $user_string = "Local | Regular ( Regular Rates )";
                $total_price = $price_post_conf + 39;
                $user_price  = 39;
            }
        } elseif ($show_me->euser_type == "foreigner") {

            if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
                $user_string = "Foreign ( Early Bird Rates )";
                $total_price = $price_post_conf + 350;
                $user_price  = 350;
            } else {
                $user_string = "Foreign ( Regular Rates )";
                $total_price = $price_post_conf + 400;
                $user_price  = 400;
            }

        } else {
            $total_price = 0;
        }

        if ($show_me->euser_meta_type == "author_type") {
            $user_meta_string = 'Author Member';
        } elseif ($show_me->euser_meta_type == "participant_type") {
            $user_meta_string = 'Participant Member';
        } else {
            $user_meta_string = 'Free Member';
        }

        ?>
<tr id="euser-<?php echo $show_me->euser_id; ?>">
  <td><?php echo $show_me->euser_barcode; ?></td>
  <td><?php echo $show_me->euser_fullname . ' <br>( as ' . $user_meta_string . ' )'; ?></td>
  <td>
<?php
$abstract_download = wp_get_attachment_url($show_me->euser_abstrak);
        $paper_download    = wp_get_attachment_url($show_me->euser_paper);
        $poster_download   = wp_get_attachment_url($show_me->euser_poster);
        $ktm_download      = wp_get_attachment_url($show_me->euser_stdcard_id);
        if (!empty($abstract_download)) {
            ?>
Abstract &nbsp;<a href="<?php echo $abstract_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Download</a><br>
<?php
}
        if (!empty($paper_download)) {
            ?>
Paper &nbsp;<a href="<?php echo $paper_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Download</a><br>
<?php
}
        if (!empty($poster_download)) {
            ?>
Poster &nbsp;<a href="<?php echo $poster_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Download</a><br>

<?php
}
        if (!empty($ktm_download)) {
            ?>
Student Card &nbsp;<a href="<?php echo $ktm_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Download</a><br>

<?php
}
        ?>

  </td>
  <td><?php echo $show_me->euser_status; ?></td>
  <td>

<?php if (isset($user_string)) {?>
User Type: <?php echo $user_string; ?><br>
<?php }if (isset($string_mid_conf)) {?>
Trip Mid Conference : <?php echo $string_mid_conf; ?><br>
<?php }if (isset($string_post_conf)) {?>
Trip Post Conference : <?php echo $string_post_conf; ?><br>
<?php }if (isset($string_dinner)) {?>
  Dinner : <?php echo $string_dinner; ?><br>
  Billed : US$<?php echo $total_price; ?>
<?php }?>



  </td>
  <td><?php echo $show_me->euser_payment_status; ?><br>
  <?php if (isset($show_me->euser_payment_meta)) {?>
<div class="xdetails" style="display: none;"><p><?php echo $show_me->euser_payment_meta; ?></p></div>
<?php }?>
  </td>
  <td><?php echo $show_me->updated_at; ?></td>
  <td>
<?php
$url = add_query_arg(array(
            'brcd'      => $show_me->euser_barcode,
            'type'      => 'member',
            'TB_iframe' => 'true',
            'width'     => '800',
            'height'    => '500',
        ), plugins_url('ss-event-dates') . '/ajax/admin_model.php');
        echo '<a href="' . $url . '" class="button button-primary thickbox">' . __('options', 'iufro') . '</a>';
        ?>
  </td>
</tr>
<?php }?>
</tbody>
</table>
</div>


<script type="text/javascript">
jQuery(document).ready(function() {
    var table = jQuery('#iufro-member').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );

    table.buttons().container()
        .appendTo( '.dtbl-btn' );
} );

jQuery(document).ready(function(){
  jQuery("#iufro-member_filter input[type='search']").attr("placeholder", " Find Anything ");
  jQuery("#iufro-member_filter input[type='search']").attr("autofocus");
    jQuery("#ihide").click(function(){
        jQuery(".xdetails").hide();
    });
    jQuery("#ishow").click(function(){
        jQuery(".xdetails").show();
    });
});


</script>
<?php }
