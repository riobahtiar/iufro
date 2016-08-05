<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';
echo $_GET['do_model'] . $_GET['user_type'] . $_GET['barcode'] . '<hr>';
print_r($_GET);
global $wpdb;
$getx_result=$wpdb->update(
    'wp_ss_event_user_detail',
    array(
        'euser_meta_type' => $_GET['user_type'],
    ),
    array('euser_barcode' => $_GET['barcode']),
    array(
        '%s',
    ),
    array('%s')
);
echo "Member type changed. Please Refresh your browser<br>";
echo "<pre>";
var_dump($getx_result);
echo "</pre><hr>Lagi";
echo "<pre>";
var_dump($wpdb);
echo "</pre><hr>Lagi";