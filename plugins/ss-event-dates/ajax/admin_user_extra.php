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
    </head>
<body>
<div class="alert alert-warning">
<h4>Data saved successfully</h4>
<br>
Print user ID Card &nbsp;<a href="<?php echo get_site_url() . 'wp-content/plugins/ss-event-dates/addons/barcode/card.php?brcd='.$euser_barcode; ?>" onclick="window.open(this.href); return false;" onkeypress="window.open(this.href); return false;">Print</a>

</div>
</body>
</html>
