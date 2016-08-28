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

// create custom plugin settings menu
add_action('admin_menu', 'init_iufro_dash');

function init_iufro_dash(){

    //create new top-level menu
    add_menu_page('IUFRO 1', 'IUFRO 2', 'administrator','iufro-dashboard','iufro_dashboard_page', plugins_url('ss-event-dates/assets/muda.png', IUFRO_DIR), 4);
    // Page of Submenu
    add_submenu_page('iufro-dashboard','Administration', 'Administration', 'administrator', 'iufro-administration','iufro_adminisitration_page');
    // Page of Submenu
    add_submenu_page('iufro-dashboard','Attender', 'Attender', 'administrator', 'iufro-attender','iufro_attender_page');
}

function iufro_dashboard_page(){
    require_once IUFRO_DIR . 'addons/admin_dashboard/dashboard-style.php';
    require_once IUFRO_DIR . 'addons/admin_dashboard/dashboard.php';
}

function iufro_adminisitration_page(){
    require_once IUFRO_DIR . 'addons/admin_dashboard/control.php';
}


function iufro_attender_page(){
    require_once IUFRO_DIR . 'addons/admin_dashboard/attender.php';
}
