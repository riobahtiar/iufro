<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once $parse_uri[0] . 'wp-load.php';

global $wpdb;
$query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_addon = 1";
$user_detail = $wpdb->get_results($query);
echo "<pre>";
foreach ($user_detail as $vuser) {
 // ==== Remove Temporary Booking === //
    $wpdb->update(
        'wp_ss_event_user_detail',
        array(
            'euser_addon_mid' => '',
            'euser_addon_post' => '',
            'euser_addon_dinner' => ''
        ),
        array('euser_email' => $euser_email),
        array(
            '%s',
            '%s',
            '%s'
        ),
        array('%s')
    );

 // ==== end Remove Temporary Booking === //



    echo "<br>USER RESET :" . $vuser->euser_fullname . " at " . date("Y-m-d H:i:s") . "<hr>";

    // end of forech

}

echo "</pre>";
