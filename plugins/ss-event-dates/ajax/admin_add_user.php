<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
$euser_barcode = $_GET['brcd'];
global $wpdb;
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_barcode = '{$euser_barcode}'";
$user_detail = $wpdb->
    get_row($query, ARRAY_A);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title></title>
    <link href="<?php echo plugins_url(); ?>/ss-event-dates/assets/bootstrap.min.css" rel="stylesheet">
<script>
document.write("<p id='loading'><img src='http://staging.iufroacacia2017.com/wp-content/uploads/2016/08/ajax-loader.gif'></p>");
</script>
<style type="text/css">
#loading {
    position: absolute;
    left: 50%;
    top: 50%;
    text-align: center;
}
.intl-tel-input{
    width: 100%;
}
</style>
    <link rel="stylesheet" href="<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/css/intlTelInput.css'; ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://lab.iamrohit.in/js/location.js"></script>
    <script src="<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/js/intlTelInput.min.js'; ?>"></script>
    </head>
    <body style="padding: 20px">
<?php 
// ====== Query to check availabel seats on database ======== //
// call redux global Object
global $ss_theme_opt; 
 echo "<div class='alert alert-info'>";
// Gunung Kidul
$gkidul_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "gunung-kidul"' );
$gkidul_av = $ss_theme_opt['text-gunungkidul'] - $gkidul_rows;
echo  $gkidul_av . ' &nbsp; Gunung Kidul (Seats Available)<br>';


// Klaten
$klaten_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "klaten"' );
$klaten_av = $ss_theme_opt['text-klaten'] - $klaten_rows;
echo  $klaten_av . ' &nbsp; Klaten (Seats Available)<br>';

// Mount Merapi
$merapi_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_mid = "mount-merapi"' );
$merapi_av = $ss_theme_opt['text-gunung-merapi'] - $merapi_rows;
echo  $merapi_av . ' &nbsp; Merapi (Seats Available)<br>';

// Pekanbaru Single
$pekanbaru_single_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pekanbaru_single"' );
$pekanbaru_single_av = $ss_theme_opt['text-pb-single'] - $pekanbaru_single_rows;
echo  $pekanbaru_single_av . ' &nbsp; Pekanbaru Single (Seats Available)<br>';


// Pekanbaru Shared
$pekanbaru_shared_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pekanbaru_shared"' );
$pekanbaru_shared_av = $ss_theme_opt['text-pb-shared'] - $pekanbaru_shared_rows;
echo  $pekanbaru_shared_av . ' &nbsp; Pekanbaru Shared (Seats Available)<br>';

// Pacitan
$pacitan_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_post = "pacitan"' );
$pacitan_av = $ss_theme_opt['text-pacitan'] - $pacitan_rows;
echo  $pacitan_av . ' &nbsp; Pacitan (Seats Available)<br>';

// Dinner 
$dinner_rows = $wpdb->get_var( 'SELECT COUNT(*) FROM wp_ss_event_user_detail WHERE euser_addon_dinner = "Yes"' );
$dinner_av = $ss_theme_opt['text-dinner'] - $dinner_rows;
echo  $dinner_av . ' &nbsp; Dinner (Seats Available)<br>';

 echo "</div>";

// ====== end check availabel seats on database ======== //

?>
    <form id="onsite-register" action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_save_process.php'; ?>" method="post">
        <div class="row">
            <div class="form-group col-md-6">
            <div class="form-group">
            <label for="user_type">Register as </label>
            <select class="form-control" name="user_type" id="user_type">
                <option value="participant_type">Participant</option>
                <option value="free_pass">Free Pass</option>
            </select>
            </div>
                <label for="salutation">Salutation</label>
                <select id="salutation" name="salutation" class="form-control">
                    <option value="Mr." <?php isset( $_POST['salutation'] ) ? 'checked' : null?> >Mr.</option>
                    <option value="Mrs." <?php isset( $_POST['salutation'] ) ? 'checked' : null?> >Mrs.</option>
                </select>
            </div>
            <div class="form-group form-group col-md-6">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="<?php if(isset( $_POST['title'] ))  echo $_POST['title']; else echo null; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" value="<?php if(isset( $_POST['fullname'] ))  echo $_POST['fullname']; else echo null;?>">
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php if(isset( $_POST['email'] ))  echo $_POST['email']; else echo null; ?>">
            </div>

            <div class="form-group form-group col-md-6">
                <label for="phone">Phone number</label>
                <input type="text" class="form-control" name="phone" id="phone">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="text" class="form-control" name="password" id="password" placeholder="Auto Generated" disabled>
            </div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" name="address" id="address" placeholder="Address"><?php if(isset( $_POST['address'] ))  echo $_POST['address']; else echo null; ?></textarea>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php if(isset( $_POST['zip'] ))  echo $_POST['zip']; else echo null; ?>">
            </div>
            <div class="form-group form-group col-md-6">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php if(isset( $_POST['city'] ))  echo $_POST['city']; else echo null; ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label for="state">Country</label>
                <select name="country" class="form-control countries" id="countryId">
<option>Select Country</option>
                </select>
            </div>
            <div class="form-group form-group col-md-6">
                <label for="country">State/Province</label>
                <select name="state" class="form-control states" id="stateId">
<option>Select State</option>
            </select>
            </div>
<hr>

    <div class="form-group form-group col-md-6">
        <label for="midc">Mid Conference</label>
        <select name="midc" class="form-control">
        <option>Select Options</option>
<?php if ($gkidul_av >= 1){ ?>
    <option value="gunung-kidul">Gunung Kidul</option>
<?php }  if ($merapi_av >= 1){ ?>
    <option value="mount-merapi">Mount Merapi</option>
<?php }  if ($klaten_av >= 1){ ?>
    <option value="klaten">Klaten</option>
<?php } ?>  
        </select>
    </div>

    <div class="form-group form-group col-md-6">
        <label for="postc">Post Conference</label>
        <select name="postc" class="form-control">
        <option>Select Options</option>
<?php if ($pacitan_av >= 1){ ?>
    <option value="pacitan">Pacitan</option>
<?php }  if ($pekanbaru_single_av >= 1){ ?>
    <option value="pekanbaru_single">Pekanbaru Single</option>
<?php }  if ($pekanbaru_shared_av >= 1){ ?>
    <option value="pekanbaru_shared">Pekanbaru Shared</option>
<?php } ?> 
        </select>
    </div>
    <div class="form-group form-group col-md-6">
        <label for="dinner">Dinner Conference</label>
        <select name="dinner" class="form-control">
        <option>Select Options</option>
<?php if ($dinner_av >= 1){ ?>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
<?php } ?> 
        </select>
    </div>
        </div>
<!--         <div class="alert alert-warning" id="pricing-calculator">
        <p>Registration Fee: <span id="vregister-price"></span></p> 
        <p>Mid Conference: <span id="vmid-price">-</span></p> 
        <p>Post Conference: <span id="vpost-price"></span></p> 
        <h4>Total : <span id="vtotal-price"></span></h4>
        </div> -->
        <hr>
        <div>
        <br>
            <button type="submit" name="submit" class="btn btn-primary btn-lg pull-right" value="Register">Continue</button>
        <br>
        <br>
        </div>
    </form>
  <script>
    jQuery("#phone").intlTelInput({
       allowDropdown: true,
       //autoHideDialCode: true,
      // autoPlaceholder: false,
      // dropdownContainer: "body",
      // excludeCountries: ["us"],
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // initialCountry: "auto",
       nationalMode: false,
      // numberType: "MOBILE",
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
       preferredCountries: ['id'],
      // separateDialCode: true,
      utilsScript: "<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/js/utils.js'; ?>"
    });

jQuery(document).ready(function(){
 jQuery('#loading').remove();

// var userType = jQuery("#user_type");
// var midPrice = jQuery("#mid-price");
// var postPrice = jQuery("#post-price");

// jQuery('#onsite-register').on('change', function() {
//     if(jQuery('input[name=user_type]', '#onsite-register').val()==""){
//             console.log('participant_type');
//             jQuery( "#vregister-price" ).attr("454");
//     } else if (jQuery('input[name=user_type]', '#onsite-register').val()=="free_pass"){
//             console.log('free_type');
//             jQuery( "#vregister-price" ).attr("545");
//     }

//     if(jQuery('input[name=postc]', '#onsite-register').val()=="pacitan"){
//             console.log('pacitan');
//             jQuery( "#vpost-price" ).attr("454");
//     } else if (jQuery('input[name=postc]', '#onsite-register').val()=="pekanbaru_shared"){
//             console.log('pekanbaru_shared');
//             jQuery( "#vpost-price" ).attr("235");
//     } else if (jQuery('input[name=postc]', '#onsite-register').val()=="pekanbaru_single"){
//             console.log('pekanbaru_single');
//             jQuery( "#vpost-price" ).attr("89");
//     }

// });

});
</script>
    </body>
</html>
