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
</style>
    <link rel="stylesheet" href="<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/css/intlTelInput.css'; ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://lab.iamrohit.in/js/location.js"></script>
    <script src="<?php echo get_site_url() .'/wp-content/plugins/ss-event-dates/addons/intl-tel/build/js/intlTelInput.min.js'; ?>"></script>
    </head>
    <body style="padding: 20px">

    <form action="<?php echo plugins_url('ss-event-dates') . '/ajax/admin/member_save_process.php'; ?>" method="post">
        <div class="row">
            <div class="form-group col-md-6">
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
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group form-group col-md-6">
                <label for="c_password">Confirm Password</label>
                <input type="password" class="form-control" name="c_password" id="c_password" placeholder="Confirm Password">
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
        </div>
        <hr>
        <div>
        <br>
            <button type="submit" name="submit" class="btn btn-primary btn-lg pull-right" value="Register">Register</button>
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
});
</script>





    </body>
</html>
