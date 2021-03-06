<?php
global $wpdb;
global $current_user;
wp_get_current_user();
$euser_email = $current_user->user_email;

// Mid Conference

if (isset($_POST['mid-conf']) && $_POST['mid-conf'] == "on") {
    $mid_conf = $_POST['mid-conf-child'];
    //         $wpdb->insert(
    //     'wp_ss_event_package',
    //     array(     'package_user' => $euser_email,
    //             'package_item' => 'Mid Conference',
    //             'package_detail' => $mid_conf
    //         ),
    //     array( '%s','%s','%s')
    // );

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_addon_mid' => $mid_conf),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}else{
    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_addon_mid' => ''),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

// Post Conference

if (isset($_POST['post-conf']) && $_POST['post-conf'] == "on") {
    $post_conf = $_POST['post-conf-child'];

    //         $wpdb->insert(
    //     'wp_ss_event_package',
    //     array(     'package_user' => $euser_email,
    //             'package_item' => 'Post Conference',
    //             'package_detail' => $post_conf
    //         ),
    //     array( '%s','%s','%s')
    // );

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_addon_post' => $post_conf),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}else{
    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_addon_post' => ''),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

if (isset($_POST['dinner-conf']) && $_POST['dinner-conf'] == "on") {

    $wpdb->insert(
        'wp_ss_event_package',
        array('package_user' => $euser_email,
            'package_item'       => 'Conference Dinner',
        ),
        array('%s', '%s')
    );

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_addon_dinner' => 'Yes'),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
} else {
    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_addon_dinner' => 'No'),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

if (isset($_FILES['profile_pict']) && $_FILES['profile_pict'] != "") {

    $get_id = upload_user_file($_FILES['profile_pict']);

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_profile_pict' => $get_id),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}


if (isset($_POST['euser_abstract_title'])) {
    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_abstract_title' => $_POST['euser_abstract_title']),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

if (isset($_FILES['abstrak']) && $_FILES['abstrak'] != "") {

    $get_id = upload_user_file($_FILES['abstrak']);

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_abstrak' => $get_id),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

if (isset($_FILES['paper']) && $_FILES['paper'] != "") {

    $get_id = upload_user_file($_FILES['paper']);

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_paper' => $get_id),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

if (isset($_FILES['poster']) && $_FILES['poster'] != "") {

    $get_id = upload_user_file($_FILES['poster']);

    $wpdb->update(
        'wp_ss_event_user_detail',
        array('euser_poster' => $get_id),
        array('euser_email' => $euser_email),
        array('%s'),
        array('%s')
    );
}

$wpdb->update(
    'wp_ss_event_user_detail',
    array('euser_addon' => 1),
    array('euser_email' => $euser_email),
    array('%s'),
    array('%s')
);

function upload_user_file($file = array())
{

    require_once ABSPATH . 'wp-admin/includes/admin.php';

    $file_return = wp_handle_upload($file, array('test_form' => false));
    if (isset($file_return['error']) || isset($file_return['upload_error_handler'])) {

        return false;

    } else {

        $filename   = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content'   => '',
            'post_status'    => 'inherit',
            'guid'           => $file_return['url'],
        );

        $attachment_id = wp_insert_attachment($attachment, $file_return['url']);
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attachment_data = wp_generate_attachment_metadata($attachment_id, $filename);
        wp_update_attachment_metadata($attachment_id, $attachment_data);
        if (0 < intval($attachment_id)) {
            return $attachment_id;
        }
    }
    return false;
}
