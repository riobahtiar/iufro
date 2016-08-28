<?php
global $wpdb;
$get_members = $wpdb->get_results("SELECT * FROM wp_ss_event_user_detail WHERE euser_onsite_absence = 'present'");
    ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/datatables.min.css"/>
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

.button.btn-add-user{
    background: #59524c;
    color: white;
    border-color: #59524c;
}

.iufro-toolbar {
    background-color: #ffffff;
    padding: 7px;
    border-color: #cccccc;
    border-width: 2px;
    border-style: solid;
    margin-bottom: 10px;
}

label.iufro-toolbar-label {
    color: #403d3d;
    padding: 5px;
    vertical-align: middle;
    font-size: 18px;

}
.iufro-toolbar-secondary{
    vertical-align: middle;
}

  </style>
<div class="wrap">
<h2>IUFRO ACACIA CONFERENCE 2017</h2>
<h4>Attender</h4>
<div class="dtbl-btn"></div>
<table class="etable" id="iufro-member" class="display" cellspacing="0" width="100%">
<thead>
<tr>
  <th width="6%">ID</th>
  <th width="13%">Name</th>
  <th width="auto">Address and Contact</th>
  <th width="10%">User Type</th>
  <th width="14%">Abstract Title</th>
  <th width="14%">Mid Trip</th>
  <th width="14%">Post Trip</th>
  <th width="8%">Dinner</th>
</tr>
</thead>
<tbody>
<?php
foreach ($get_members as $show_me) {

// ======== Start Payment Conditional Block ======== //

// mid conf
if (isset($show_me->euser_addon_mid)) {

    if ($show_me->euser_addon_mid == "gunung-kidul") {
        $string_mid_conf = "Gunung Kidul";
        $price_mid_conf  = 0;
        $product_mc = "MC1";
    } elseif ($show_me->euser_addon_mid == "klaten") {
        $string_mid_conf = "Klaten";
        $price_mid_conf  = 0;
        $product_mc = "MC2";
    } elseif ($show_me->euser_addon_mid == "mount-merapi") {
        $string_mid_conf = "Mount Merapi";
        $price_mid_conf  = 0;
        $product_mc = "MC3";
    } else {
        $string_mid_conf = " - ";
        $price_mid_conf  = 0;
        $product_mc = "MC0";
    }

} else {
    $string_mid_conf = " - ";
    $price_mid_conf == 0;
    $product_mc = "MC0";
}

// post conf
if (isset($show_me->euser_addon_post)) {
    // Pricing Post Conference
    if ($show_me->euser_addon_post == "pacitan") {
        $string_post_conf = "Pacitan";
        $price_post_conf  = 250;
        $product_pc = "PC1";
    } elseif ($show_me->euser_addon_post == "pekanbaru_shared") {
        $string_post_conf = "Pekanbaru | Shared Room";
        $price_post_conf  = 475;
        $product_pc = "PC2";
    } elseif ($show_me->euser_addon_post == "pekanbaru_single") {
        $string_post_conf = "Pekanbaru | Single Room";
        $price_post_conf  = 510;
        $product_pc = "PC3";
    } else {
        $string_post_conf = " - ";
        $price_post_conf  = 0;
        $product_pc = "PC0";
    }
} else {
    $string_post_conf = " - ";
    $price_post_conf  = 0;
    $product_pc = "PC0";
}

if (isset($show_me->euser_addon_dinner)) {
    if ($show_me->euser_addon_dinner == "Yes") {
        $string_dinner = " Yes ";
        $product_d = "D1";
    } elseif ($show_me->euser_addon_dinner == "No") {
        $string_dinner = " No ";
        $product_d = "D2";
    } else {
        $string_dinner = "-";
        $product_d = "D0";
    }
}

// Payment Dates Earlybird
$paymentDate    = date('Y-m-d');
$paymentDate    = date('Y-m-d', strtotime($paymentDate));
$earlyBirdBegin = date('Y-m-d', strtotime($ss_theme_opt['date_earlybird_start']));
$earlyBirdEnd   = date('Y-m-d', strtotime($ss_theme_opt['date_earlybird_end']));

if ($show_me->euser_type == "local student") {
    $user_string = "Local | Students";
    $total_price = $price_post_conf + 20;
    $user_price  = 20;
    $product_usr = "LS";
} elseif ($show_me->euser_type == "local regular") {
    // Early Bird Conf
    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Local | Regular ( Early Bird Rates )";
        $total_price = $price_post_conf + 23;
        $user_price  = 23;
        $product_usr = "LR-EBR";
    } else {
        $user_string = "Local | Regular ( Regular Rates )";
        $total_price = $price_post_conf + 39;
        $user_price  = 39;
        $product_usr = "LR-RR";
    }
} elseif ($show_me->euser_type == "foreigner") {

    if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
        $user_string = "Foreign ( Early Bird Rates )";
        $total_price = $price_post_conf + 350;
        $user_price  = 350;
        $product_usr = "F-EBR";
    } else {
        $user_string = "Foreign ( Regular Rates )";
        $total_price = $price_post_conf + 400;
        $user_price  = 400;
        $product_usr = "F-RR";
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
  <td><?php echo $show_me->euser_fullname; ?></td>
  <td>
<?php echo $show_me->euser_address .', &nbsp;' . $show_me->euser_city .' <br> '
   . $show_me->euser_state .', &nbsp;' . $show_me->euser_country .', &nbsp;' . $show_me->euser_zip . ' <br>Phone: '
   . $show_me->euser_phone .', &nbsp;'. $show_me->euser_email
   ;  ?>
  </td>
  <td><?php echo $show_me->user_meta_string; ?>( <?php echo $user_string; ?> )</td>
  <td>
<?php
$abstract_title = $show_me->euser_abstract_title;
if (!empty($abstract_title )) {
            echo $abstract_title ; 
}
        ?>
  </td>
  <td><?php echo $string_mid_conf; ?></td>  
  <td><?php echo $string_post_conf; ?></td>
  <td><?php echo $string_dinner; ?> </td>
</tr>
<?php }?>
</tbody>
</table>
</div>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/datatables.min.js"></script>
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
});

</script>
<?php
// end 
?>