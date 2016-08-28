<?php
/**
 * @package User Dashboard
 * @author riobahtiar
 */

// call thickbox
add_thickbox();


// theme option
global $ss_theme_opt; 
function modal_action()
{
    define('IFRAME_REQUEST', true);
    iframe_header();
    iframe_footer();
    exit;
}
add_action('admin_action_foo_modal_box', 'modal_action');

function dash_css(){
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
  ";
}

add_action('admin_head', 'dash_css');

// create custom plugin settings menu
add_action('admin_menu', 'init_iufro_dash');

function init_iufro_dash()
{

    //create new top-level menu
    add_menu_page('IUFRO U', 'IUFRO U', 'administrator','iufro-dashboard','users_page_control', plugins_url('ss-event-dates/assets/muda.png', IUFRO_DIR), 4);
    // Page of Submenu
    add_submenu_page('iufro-dashboard','Reports', 'Reports', 'administrator', 'iufro-reports','reports_page');
}

// Function to get all value for report page //


// gunung kidul
$gkidul_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "gunung-kidul"' );
// Klaten
$klaten_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "klaten"' );
// Mount Merapi
$merapi_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "mount-merapi"' );
// Pekanbaru Single
$pekanbaru_single_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pekanbaru_single"' );
// Pekanbaru Shared
$pekanbaru_shared_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pekanbaru_shared"' );
// Pacitan
$pacitan_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pacitan"' );
// Dinner 
$dinner_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_dinner = "Yes"' );
// all users
$all_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail' );
// attender
$attender = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_onsite_absence = "present"' );
// Paid
$paid = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_payment_status = "Paid-Onsite" OR euser_payment_status = "berhasil-iPaymu" OR euser_payment_status = "Complete-Paypal"' );
// UN-Paid
$unpaid = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_payment_status != "Paid-Onsite" OR euser_payment_status != "berhasil-iPaymu" OR euser_payment_status != "Complete-Paypal"' );
// Participant 
$participant_t = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_meta_type = "   participant_type"' );
// Author
$author_t = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_meta_type = "author_type"' );

function reports_page(){
?>
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
<style>
    * {
    box-sizing: border-box;
}

.container-iuf {
    font-family: 'Lato', sans-serif;
    margin: 0 auto;
    width: 100%;
    position: relative;
    color: #333;
    padding: 15px 0;
    overflow: hidden;
}

h1,
h2,
h3,
h4,
p {
    margin: 15px 0;
}


/*Counter */

.counter-iuf {
    margin: 0 -5px;
    overflow: hidden;
}

.counter-item-iuf {
    width: 16.6667%;
    float: left;
    text-align: center;
    padding: 5px;
    color: #fff;
    margin-bottom: 15px;
}

.counter-item-iuf h1,
.counter-item-iuf p {
    margin: 0;
}

.counter-item-iuf h1 {
    padding: 30px 0 0 !important;
    font-size: 60px;
    color: white;
    display: inline-block;

}

.counter-item-iuf p {
    padding: 15px 0 !important;
    display: block;
}

.registered-iuf> div {
    background-color: #f17d4a;
}

.attended-iuf> div {
    background-color: #ffb500;
}

.paid-iuf> div {
    background-color: #78b732;
}

.participant-iuf> div {
    background-color: #1eadd9;
}

.auth-iuf> div {
    background-color: #dc5a7c;
}

.unpaid-iuf> div {
    background-color: #78808b;
}


/*Add on facilities */

.info-iuf h2 {
    margin-bottom: 0;
}

.mid-trip-iuf,
.post-trip-iuf,
.place-iuf,
.numb-iuf {
    width: 50%;
    float: left;
}

.trip-iuf {
    overflow: hidden;
    margin: 0 -5px;
}

.mid-trip-iuf,
.post-trip-iuf {
    padding: 5px;
}

.trip-item {
    overflow: hidden;
    margin-bottom: 5px;
    color: #fff;
}

.place-iuf {
    padding-left: 15px;
    background-color: #1eadd9;
}

.numb-iuf {
    text-align: center;
    background-color: #1b95bb;
}


/* Dinner */

.dinner-iuf,
.dinner-numb-iuf {
    width: 50%;
    float: left;
    color: #fff;
}

.dinner-wrap-iuf,
.dinner-iuf-item {
    width: 100%;
    float: left;
}

.dinner-wrap-iuf {
    margin-bottom: 15px;
    margin-top: 15px;
}

.dinner-numb-iuf {
    background-color: #649a29;
    text-align: center;
}

.dinner-iuf {
    background-color: #78b732;
    padding-left: 15px;
}


/* Content Iufro */

.content-wrap-iuf {
    width: 100%;
    float: left;
    border: 1px solid #ccc;
    padding: 5px 15px;
    margin-bottom: 10px;
}

.content-wrap-iuf> h3 {
    float: left;
    display: inline-block;
}

.btn-admin-iuf {
    padding: 7px 30px;
    display: inline-block;
    float: right;
    margin: 8px 0;
    text-decoration: none;
    color: #fff;
}

.btn-black-iuf {
    background-color: #4d5361;
}

.btn-grey-iuf {
    background-color: #949fb3;
}


/*Media  Queries  */

@media (max-width: 767px) {
    .counter-item-iuf {
        width: 100%;
        margin-bottom: 5px;
    }
    .mid-trip-iuf,
    .post-trip-iuf {
        width: 100%;
    }
}
</style>
        <!-- Container -->
        <div class="container-iuf">
            <!-- Title -->
            <div class="title-iuf">
                <h2>Dashboard</h2>
            </div>
            <!-- End of Title -->

            <!-- Counter Wrap -->
            <div class="counter-iuf">
                <div class="registered-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $all_rows; ?></h1>
                        <p>Total Registered</p>
                    </div>
                </div>
                <div class="attended-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $attender; ?></h1>
                        <p>Total Attended</p>
                    </div>
                </div>
                <div class="paid-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $paid; ?></h1>
                        <p>Paid Member</p>
                    </div>
                </div>
                <div class="participant-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $participant_t; ?></h1>
                        <p>Participant</p>
                    </div>
                </div> 
                <div class="auth-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $author_t; ?></h1>
                        <p>Author</p>
                    </div>
                </div>
                <div class="unpaid-iuf counter-item-iuf">
                    <div class="counter-wrap-iuf">
                        <h1><?php echo $unpaid; ?></h1>
                        <p>Unpaid Member</p>
                    </div>
                </div>
            </div>
            <!-- End of Counter Wrap -->

            <!-- Add on facilities -->
            <div class="info-iuf">
                <h2>Add-on facilities</h2>
                <div class="trip-iuf">

                    <div class="mid-trip-iuf">
                        <h3>Mid Trip</h3>
                        <!-- Mid Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Gunung Kidul</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $gkidul_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Mid Trip Item -->
                        <!-- Mid Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Klaten</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $klaten_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Mid Trip Item -->
                        <!-- Mid Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Merapi</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $merapi_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Mid Trip Item -->
                    </div>

                    <div class="post-trip-iuf">
                        <h3>Post Trip</h3>
                        <!-- Post Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Pacitan</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $pacitan_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Post Trip Item -->
                        <!-- Post Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Pekanbaru Shared</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $pekanbaru_shared_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Post Trip Item -->
                        <!-- Post Trip Item -->
                        <div class="trip-item">
                            <div class="place-iuf">
                                <p>Pekanbaru Single</p>
                            </div>
                            <div class="numb-iuf">
                                <p><?php echo $pekanbaru_single_rows; ?></p>
                            </div>
                        </div>
                        <!-- End of Post Trip Item -->
                    </div>
                </div>
            </div>
            <!-- End of Add on facilities -->
            <!-- Dinner -->
            <div class="dinner-wrap-iuf">
                <div class="dinner-iuf-item">
                    <div class="dinner-iuf">
                        <p>Dinner</p>
                    </div>
                    <div class="dinner-numb-iuf">
                        <p><?php echo $dinner_rows; ?></p>
                    </div>
                </div>
            </div>
            <!-- End of Dinner -->

            <div class="content-wrap-iuf">
                <h3>Content Wrap</h3>
                <a href="#" class="btn-admin-iuf btn-black-iuf">VIEW</a>
            </div>

            <div class="content-wrap-iuf">
                <h3>Content Wrap</h3>
                <a href="#" class="btn-admin-iuf btn-grey-iuf">VIEW</a>
            </div>

        </div>
        <!-- End of Container -->


<script type="text/javascript" src="<?php echo get_site_url() . '/wp-content/plugins/ss-event-dates/assets/js/popup.js' ?>"></script>
<script>
// Activate All PopUp Windows
jQuery('.iufro-popup').popupWindow(); 

</script>

<?php
}



function users_page_control()
{
    global $wpdb;
    $get_members = $wpdb->get_results("SELECT * FROM wp_ss_event_user_detail");
    ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/r-2.1.0/sc-1.4.2/datatables.min.css"/>
<div class="wrap">
<h2>IUFRO ACACIA CONFERENCE 2017</h2>
<h4>Control Dashboard</h4>
<div class="dtbl-btn"></div>
<p>&nbsp;| &nbsp;Payment Details: <button id="ihide">Hide</button>&nbsp;<button id="ishow">Show</button>
<?php
$url = add_query_arg(array(
            'brcd'      => $show_me->euser_barcode,
            'type'      => 'member',
            'TB_iframe' => 'true',
            'width'     => '800',
            'height'    => '500',
        ), plugins_url('ss-event-dates') . '/ajax/admin_add_user.php');
echo '<a href="' . $url . '" class="button btn-add-user thickbox">' . __('Add User', 'iufro') . '</a>';
?>
 </p>
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

// Assemble Product Name

//$product_name = $product_usr . $product_mc . $product_pc . $product_d . date('md');

// ======== End of Payment Conditional Block ======== //




// // mid conf
//         if (isset($show_me->euser_addon_mid)) {

//             if ($show_me->euser_addon_mid == "gunung-kidul") {
//                 $string_mid_conf = "Gunung Kidul";
//                 $price_mid_conf  = 0;
//             } elseif ($show_me->euser_addon_mid == "klaten") {
//                 $string_mid_conf = "Klaten";
//                 $price_mid_conf  = 0;
//             } elseif ($show_me->euser_addon_mid == "mount-merapi") {
//                 $string_mid_conf = "Mount Merapi";
//                 $price_mid_conf  = 0;
//             } else {
//                 $string_mid_conf = " - ";
//                 $price_mid_conf  = 0;
//             }

//         } else {
//             $string_mid_conf = " - ";
//             $price_mid_conf == 0;
//         }

// // post conf
//         if (isset($show_me->euser_addon_post)) {
//             // Pricing Post Conference
//             if ($show_me->euser_addon_post == "pacitan") {
//                 $string_post_conf = "Pacitan ( US$ 250 )";
//                 $price_post_conf  = 250;
//             } elseif ($show_me->euser_addon_post == "pekanbaru_shared") {
//                 $string_post_conf = "Pekanbaru | Shared Room ( US$ 475 )";
//                 $price_post_conf  = 475;
//             } elseif ($show_me->euser_addon_post == "pekanbaru_single") {
//                 $string_post_conf = "Pekanbaru | Single Room ( US$ 510 )";
//                 $price_post_conf  = 510;
//             } else {
//                 $string_post_conf = " - ";
//                 $price_post_conf  = 0;
//             }
//         } else {
//             $string_post_conf = " - ";
//             $price_post_conf  = 0;
//         }

//         if (isset($show_me->euser_addon_dinner)) {
//             $string_dinner = " Yes ";
//         } else {
//             $string_dinner = " No ";
//         }

//         // Paymen Dates Earlybird
//         $paymentDate    = $show_me->euser_payment_date;
//         $paymentDate    = date('Y-m-d', strtotime($paymentDate));
//         $earlyBirdBegin = date('Y-m-d', strtotime("01/1/2016"));
//         $earlyBirdEnd   = date('Y-m-d', strtotime("04/30/2017"));

//         if ($show_me->euser_type == "local student") {
//             $user_string = "Local | Students";
//             $total_price = $price_post_conf + 20;
//             $user_price  = 20;
//         } elseif ($show_me->euser_type == "local regular") {
//             // Early Bird Conf
//             if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
//                 $user_string = "Local | Regular ( Early Bird Rates )";
//                 $total_price = $price_post_conf + 23;
//                 $user_price  = 23;
//             } else {
//                 $user_string = "Local | Regular ( Regular Rates )";
//                 $total_price = $price_post_conf + 39;
//                 $user_price  = 39;
//             }
//         } elseif ($show_me->euser_type == "foreigner") {

//             if (($paymentDate > $earlyBirdBegin) && ($paymentDate < $earlyBirdEnd)) {
//                 $user_string = "Foreign ( Early Bird Rates )";
//                 $total_price = $price_post_conf + 350;
//                 $user_price  = 350;
//             } else {
//                 $user_string = "Foreign ( Regular Rates )";
//                 $total_price = $price_post_conf + 400;
//                 $user_price  = 400;
//             }

//         } else {
//             $total_price = 0;
//         }

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
        $profile_pict_download      = wp_get_attachment_url($show_me->euser_profile_pict);
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
        if (!empty($profile_pict_download)) {
            ?>
Profile Picture &nbsp;<a href="<?php echo $profile_pict_download; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Download</a><br>


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
        ), plugins_url('ss-event-dates') . '/ajax/admin_edit_user.php');
        echo '<a href="' . $url . '" class="button button-primary thickbox">' . __('options', 'iufro') . '</a>';
        ?>
<a href="<?php echo get_site_url() . '/wp-content/plugins/ss-event-dates/addons/barcode/card.php?brcd='.$show_me->euser_barcode; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Print ID Card</a>
  </td>
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
    jQuery("#ihide").click(function(){
        jQuery(".xdetails").hide();
    });
    jQuery("#ishow").click(function(){
        jQuery(".xdetails").show();
    });
});





</script>
<?php }
