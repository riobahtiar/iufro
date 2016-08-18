<?php
/*
Plugin Name: SS Event Dates Post
Description: SS plugin that will create a custom post type displaying Important Dates.
Version: 1.0
Author: SoftwareSeni Team

SoftwareSeni Team:
- Rio
- Sidiq
- Gamma
- Bayu
- Ginanjar
 */

define('IUFRO_DIR', plugin_dir_path(__FILE__));

/*
 * Include Dashboard
 */

require_once IUFRO_DIR . 'addons/admin_dashboard.php';
// Email Resend
// require_once IUFRO_DIR . 'templates/resend_email.php';
//require_once IUFRO_DIR . 'rates.php';
function ss_event_install()
{
    global $wpdb;
    $user_table = $wpdb->prefix . 'ss_event_user_detail';

    $charset_collate = $wpdb->get_charset_collate();
    $db_version      = '1.0';

    $sql_euser = "CREATE TABLE IF NOT EXISTS `{$user_table}` (
  `euser_id` bigint(20) NOT NULL,
  `euser_fullname` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_phone` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_zip` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_city` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_state` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_country` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_meta_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `euser_type` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_stdcard_id` int(11) NOT NULL,
  `euser_addon` int(11) NOT NULL,
  `euser_payment` int(11) NOT NULL,
  `euser_abstrak` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_paper` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_poster` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_addon_mid` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_addon_post` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_addon_dinner` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disabled',
  `euser_activationkey` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_payment_status` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `euser_barcode` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
            primary key (euser_id)
        ) ENGINE=InnoDB $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql_euser);

    add_option('ss_books_db_ver', $db_version);
    update_option('ss_books_db_ver', $db_version);
}

register_activation_hook(__FILE__, 'ss_event_install');

add_action('init', 'create_important_dates');

function create_important_dates()
{
    register_post_type('important_dates',
        array(
            'labels'      => array(
                'name'               => 'SS Important Dates',
                'singular_name'      => 'Important Date',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Date',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Date',
                'new_item'           => 'New Date',
                'view'               => 'View',
                'view_item'          => 'View Date',
                'search_items'       => 'Search Date',
                'not_found'          => 'No Date found',
                'not_found_in_trash' => 'No Date found in Trash',
                'parent'             => 'Parent Important Date',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'comments', 'thumbnail'),
            'taxonomies'  => array(''),
            'menu_icon'   => 'dashicons-calendar',
            'has_archive' => true,
        )
    );

}

function html_important_date_code()
{
    wp_reset_query();
    wp_reset_postdata();

    $custom_args = array(
        'post_type'      => 'important_dates',
        'posts_per_page' => 4,
        'cat'            => '-26,-27,-35',
    );

    $custom_query = new WP_Query($custom_args);
    $mypost       = array('post_type' => 'important_dates');
    if ($custom_query->have_posts()):
        while ($custom_query->have_posts()): $custom_query->the_post();
            echo '  <div class="article-' . $post->ID . ' col-md-6">';
            echo '  <div class="row"><div class="col-md-12">
                            <h3>';
            echo the_title();
            echo '    </h3>
                          </div></div>';
            echo '  <div class="row"><div class="col-md-5"> ';
            // ====== FROM NOW ===== // 
                if ( get_post_meta( get_the_ID(), 'rw_date', true ) !== '2017-01-01'){
            echo '  <h2 class="date-day">' . date("d", strtotime(get_post_meta(get_the_ID(), 'rw_date', true))) . '<span>' . date("S", strtotime(get_post_meta(get_the_ID(), 'rw_date', true))) . '</span></h2>';
                }
            // ====== END FROM NOW ===== //
            if ((get_post_meta(get_the_ID(), 'rw_date_end', true))) {
            // ====== FROM NOW ===== // 
                if ( get_post_meta( get_the_ID(), 'rw_date', true ) !== '2017-01-01'){
                echo '  <h4>' . date("F Y", strtotime(get_post_meta(get_the_ID(), 'rw_date', true))) . '</h4>';
                }else{
                    echo "<h4> FROM NOW </h4>";
                }
            // ====== END FROM NOW ===== //
                echo '  <h2> - </h2>';
                echo '  <h2 class="date-day">' . date("d", strtotime(get_post_meta(get_the_ID(), 'rw_date_end', true))) . '<span>' . date("S", strtotime(get_post_meta(get_the_ID(), 'rw_date_end', true))) . '</span></h2>';
                echo '  <h4>' . date("F Y", strtotime(get_post_meta(get_the_ID(), 'rw_date_end', true))) . '</h4>';
            } else {
                echo '  <h4>' . date("F Y", strtotime(get_post_meta(get_the_ID(), 'rw_date', true))) . '</h4>';
            }
            echo '  </div>';
            echo '  <div class="col-md-7" style="height:100%;background: url(' . wp_get_attachment_url(get_post_thumbnail_id($post->ID)) . ') no-repeat center center;
                                background-size: cover;
                                -webkit-background-size: cover;
                                -moz-background-size: cover;
                                -o-background-size: cover;"
                        class="imgf ">';
            //echo "     <a href=".get_permalink($post->ID).">view detail</a>";
            echo '  <a href="http://www.iufroacacia2017.com/dates-venue/dates/">view detail</a>';
            echo '  </div></div>';
            echo '  </div>';
        endwhile;
    endif;

}

function ss_important_date()
{
    ob_start();
    html_important_date_code();
    return ob_get_clean();
}

add_shortcode('ss_important_date', 'ss_important_date');

function html_homepage_post_code()
{
    wp_reset_query();
    wp_reset_postdata();

    $custom_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 4,
        'cat'            => '-26,-27,-35',
    );
    $custom_query = new WP_Query($custom_args);
    if ($custom_query->have_posts()):
        while ($custom_query->have_posts()): $custom_query->the_post();
            echo '<div class="col-md-8">';
            echo '<div class="tumbnail">';
            the_post_thumbnail();
            echo '</div>';
            echo '<div class="title">';
            the_title();
            echo '</div>';
            echo '<div class="detail">';
            echo '<div class="col-md-2 detail-news">NEWS</div>';
            echo '<div class="detail-wrap col-md-8">';
            echo '<div class="col-md-4"><i class="fa fa-clock-o" aria-hidden="true"></i>' . get_the_date('M, dS Y', get_the_ID()) . '</div>';
            echo '<div class="col-md-4"><i class="fa fa-heart" aria-hidden="true"></i></div>';
            echo '<div class="col-md-4"><i class="fa fa-comments" aria-hidden="true"></i>';
            echo comments_number();
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="content">';
            the_excerpt();
            echo '</div>';
            echo '<a class="btn" href="' . get_permalink($post->ID) . '">Read More</a>';
            echo '</div>';
            break;
        endwhile;
        echo '<div class="col-md-4">';
        echo '<ul class="nav nav-tabs" role="tablist">';
        echo '  <li role="presentation" class="active"><a href="#news" aria-controls="news" role="tab" data-toggle="tab">News</a></li>
                <li role="presentation"><a href="#popular" aria-controls="popular" role="tab" data-toggle="tab">Popular</a></li>
                  </ul>';
        echo '
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="news">
              ';

        while ($custom_query->have_posts()): $custom_query->the_post();
            echo '<div class="col-md-12">';
            echo '<div class="title"><a href="' . get_permalink($post->ID) . '">';
            the_title();
            echo '</a></div>';
            echo '<div class="content">';
            the_excerpt();
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<i class="fa fa-clock-o" aria-hidden="true"></i>' . get_the_date('M, dS Y', get_the_ID());
            echo '</div>';
            echo '<div class="col-md-6"><i class="fa fa-comments" aria-hidden="true"></i>';
            echo comments_number();
            echo '</div>';
            echo '</div>';
        endwhile;
        echo '</div>';

        echo '<div role="tabpanel" class="tab-pane" id="popular">';
        while ($custom_query->have_posts()): $custom_query->the_post();
            echo '<div class="col-md-12">';
            echo '<div class="title"><a href="' . get_permalink($post->ID) . '">';
            the_title();
            echo '</a></div>';
            echo '<div class="content">';
            the_excerpt();
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<i class="fa fa-clock-o" aria-hidden="true"></i>' . get_the_date('M, dS Y', get_the_ID());
            echo '</div>';
            echo '<div class="col-md-6"><i class="fa fa-comments" aria-hidden="true"></i>';
            echo comments_number();
            echo '</div>';
            echo '</div>';
        endwhile;
        echo '</div>';
        echo '</div>';
    endif;
}

function homepage_post()
{
    ob_start();
    html_homepage_post_code();
    return ob_get_clean();
}

add_shortcode('homepage_post', 'homepage_post');

add_action('init', 'create_keynote_speakers');
function create_keynote_speakers()
{
    register_post_type('keynote_speakers',
        array(
            'labels'      => array(
                'name'               => 'SS Keynote Speakers',
                'singular_name'      => 'Keynote Speaker',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Speaker',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Speaker',
                'new_item'           => 'New Speaker',
                'view'               => 'View',
                'view_item'          => 'View Speaker',
                'search_items'       => 'Search Speaker',
                'not_found'          => 'No Speaker found',
                'not_found_in_trash' => 'No Speaker found in Trash',
                'parent'             => 'Parent Keynote Speaker',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomies'  => array(''),
            'menu_icon'   => 'dashicons-controls-volumeon',
            'has_archive' => true,
        )
    );
}

add_action('init', 'create_programme');

function create_programme()
{
    register_post_type('programme',
        array(
            'labels'      => array(
                'name'               => 'SS Programme',
                'singular_name'      => 'Programme',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Programme',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Programme',
                'new_item'           => 'New Programme',
                'view'               => 'View',
                'view_item'          => 'View Programme',
                'search_items'       => 'Search Programme',
                'not_found'          => 'No Programme found',
                'not_found_in_trash' => 'No Programme found in Trash',
                'parent'             => 'Parent Keynote Programme',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomies'  => array(''),
            'menu_icon'   => 'dashicons-media-spreadsheet',
            'has_archive' => true,
        )
    );
}

add_action('init', 'create_event_rundown');

function create_event_rundown()
{
    register_post_type('event_rundown',
        array(
            'labels'      => array(
                'name'               => 'SS Event Rundown',
                'singular_name'      => 'Event Rundown',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Event Rundown',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Event Rundown',
                'new_item'           => 'New Event Rundown',
                'view'               => 'View',
                'view_item'          => 'View Event Rundown',
                'search_items'       => 'Search Event Rundown',
                'not_found'          => 'No Event Rundown found',
                'not_found_in_trash' => 'No Event Rundown found in Trash',
                'parent'             => 'Parent Keynote Event Rundown',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomies'  => array(''),
            // 'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'menu_icon'   => 'dashicons-calendar-alt',
            'has_archive' => true,
        )
    );
}

add_action('init', 'ss_event_rundown_taxonomy');

function ss_event_rundown_taxonomy()
{
    register_taxonomy(
        'ss_event_rundown_category',
        'event_rundown',
        array(
            'label'        => __('Event Rundown Categories'),
            'rewrite'      => array('slug' => 'event_rundown_category'),
            'hierarchical' => true,
        )
    );
}

add_action('init', 'create_venue');
function create_venue()
{
    register_post_type('venue',
        array(
            'labels'      => array(
                'name'               => 'SS Venue',
                'singular_name'      => 'Venue',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Venue',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Venue',
                'new_item'           => 'New Venue',
                'view'               => 'View',
                'view_item'          => 'View Venue',
                'search_items'       => 'Search Venue',
                'not_found'          => 'No Venue found',
                'not_found_in_trash' => 'No Venue found in Trash',
                'parent'             => 'Parent Venue',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomies'  => array(''),
            'menu_icon'   => 'dashicons-location',
            'has_archive' => true,
        )
    );
}

add_action('init', 'create_presenter');
function create_presenter()
{
    register_post_type('presenter',
        array(
            'labels'      => array(
                'name'               => 'SS Presenter',
                'singular_name'      => 'Presenter',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Presenter',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Presenter',
                'new_item'           => 'New Presenter',
                'view'               => 'View',
                'view_item'          => 'View Presenter',
                'search_items'       => 'Search Presenter',
                'not_found'          => 'No Presenter found',
                'not_found_in_trash' => 'No Presenter found in Trash',
                'parent'             => 'Parent Presenter',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomies'  => array(''),
            'menu_icon'   => 'dashicons-laptop',
            'has_archive' => true,
        )
    );
}

add_action('init', 'create_paper');
function create_paper()
{
    register_post_type('ss_paper',
        array(
            'labels'      => array(
                'name'               => 'SS Paper',
                'singular_name'      => 'Paper',
                'add_new'            => 'Add New',
                'add_new_item'       => 'Add New Paper',
                'edit'               => 'Edit',
                'edit_item'          => 'Edit Paper',
                'new_item'           => 'New Paper',
                'view'               => 'View',
                'view_item'          => 'View Paper',
                'search_items'       => 'Search Paper',
                'not_found'          => 'No Paper found',
                'not_found_in_trash' => 'No Paper found in Trash',
                'parent'             => 'Parent Paper',
            ),

            'public'      => true,
            'rewrite'     => true,
            // 'menu_position' => 15,
            'supports'    => array('title', 'editor', 'thumbnail'),
            'taxonomies'  => array(''),
            // 'menu_icon' => plugins_url( 'images/image.png', __FILE__ ),
            'menu_icon'   => 'dashicons-media-default',
            'has_archive' => true,
        )
    );
}

/**
 * general shortcode with params
 */

/**
 * @param  array
 * @return string
 */
function ss_event_system($atts)
{
    ob_start();
    $attr = shortcode_atts(array('template' => ''), $atts);
    extract($attr);
    $__required_template = plugin_dir_path(__FILE__) . "templates/{$template}.php";
    if (!empty($template) && file_exists($__required_template)) {
        require_once $__required_template;
    }
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}

add_shortcode('ss_event_system', 'ss_event_system');

/**
 * add metabox on custom post
 *
 * @author Sidiq
 */

add_filter('rwmb_meta_boxes', 'dates_register_meta_boxes');
function dates_register_meta_boxes($meta_boxes)
{
    $prefix = 'rw_';

    $meta_boxes[] = array(
        'title'      => __('Date Detail', 'textdomain'),
        'post_types' => 'important_dates',
        'fields'     => array(
            array(
                'name' => __('date start', 'textdomain'),
                'id'   => $prefix . 'date',
                'type' => 'date',
            ),
            array(
                'name' => __('date end (you can leave it blank)', 'textdomain'),
                'id'   => $prefix . 'date_end',
                'type' => 'date',
            ),
        ),
    );

    $meta_boxes[] = array(
        'title'      => __('Speaker Detail', 'textdomain'),
        'post_types' => 'keynote_speakers',
        'fields'     => array(
            array(
                'name' => __('Company', 'textdomain'),
                'id'   => $prefix . 'company',
                'type' => 'text',
            ),
            array(
                'name' => __('facebook', 'textdomain'),
                'id'   => $prefix . 'facebook',
                'type' => 'text',
            ),
            array(
                'name' => __('twitter', 'textdomain'),
                'id'   => $prefix . 'twitter',
                'type' => 'text',
            ),
            array(
                'name' => __('linkedin', 'textdomain'),
                'id'   => $prefix . 'linkedin',
                'type' => 'text',
            ),
        ),
    );

    $meta_boxes[] = array(
        'title'      => __('Event Detail', 'textdomain'),
        'post_types' => 'event_rundown',
        'fields'     => array(
            array(
                'name' => __('Event Date', 'textdomain'),
                'id'   => $prefix . 'event_date',
                'type' => 'date',
            ),
            array(
                'name' => __('Start Time', 'textdomain'),
                'id'   => $prefix . 'event_start',
                'type' => 'time',
            ),
            array(
                'name' => __('End Time', 'textdomain'),
                'id'   => $prefix . 'event_end',
                'type' => 'time',
            ),
        ),
    );

    $meta_boxes[] = array(
        'title'      => __('Presenter Detail', 'textdomain'),
        'post_types' => 'presenter',
        'fields'     => array(
            array(
                'name' => __('Position', 'textdomain'),
                'id'   => $prefix . 'position',
                'type' => 'text',
            ),
            array(
                'name' => __('facebook', 'textdomain'),
                'id'   => $prefix . 'facebook',
                'type' => 'text',
            ),
            array(
                'name' => __('twitter', 'textdomain'),
                'id'   => $prefix . 'twitter',
                'type' => 'text',
            ),
            array(
                'name' => __('linkedin', 'textdomain'),
                'id'   => $prefix . 'linkedin',
                'type' => 'text',
            ),
        ),
    );

    $meta_boxes[] = array(
        'title'      => __('Paper Detail', 'textdomain'),
        'post_types' => 'ss_paper',
        'fields'     => array(
            array(
                'name' => __('Author', 'textdomain'),
                'id'   => $prefix . 'paper_author',
                'type' => 'text',
            ),
            array(
                'name' => __('Pdf File', 'textdomain'),
                'id'   => $prefix . 'paper_pdf_file',
                'type' => 'file',
            ),
        ),
    );

    return $meta_boxes;
}

/**
 *
 * @param string $name
 * @param string $value
 * @return boolean
 */

function ss_event_set_cookie($name = '', $value = '', $prefix = '')
{
    setcookie($prefix . "ss_event[" . $name . "]", $value, time() + (3600 * 12 * 30 * 365), '/');
    return true;
}

/**
 *
 * @return boolean
 */

function ss_event_unset_all_cookie()
{
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach ($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name  = trim($parts[0]);
            setcookie($name, '', time() - 1000);
            setcookie($name, '', time() - 1000, '/');
        }
    }
    wp_redirect(get_site_url());
    //break;
    return true;
}

/**
 *
 * @param string $name
 * @param string $default_value
 * @return string
 */

function ss_event_get_cookie($name = '', $default_value = '', $prefix = '')
{
    if ($name == '') {
        if (isset($_COOKIE["ss_event"])) {
            $value = $_COOKIE["ss_event"];
        } else {
            $value = $default_value;
        }
    } else {
        if (isset($_COOKIE[$prefix . "ss_event[" . $name . "]"])) {
            $value = $_COOKIE[$prefix . "ss_event[" . $name . "]"];
        } else {
            $value = $default_value;
        }
    }
    return $value;
}

/**
 * Construct SQL to insert new data to a table.
 * The $parameters is an array containing table field name and the value of the field.
 *
 * @param string $table_name
 * @param array $parameters
 * @return string
 */

function sql_new($table_name, $parameters)
{
    $sql      = "INSERT INTO " . $table_name . " (";
    $key_list = '';
    $val_list = '';
    $i        = 0;

    foreach ($parameters as $key => $val) {
        if ($i == 0) {
            $key_list .= $key;
            $val_list .= "'" . $val . "'";
        } else {
            $key_list .= ", " . $key;
            $val_list .= ", '" . $val . "'";
        }
        $i++;
    }

    $sql .= $key_list . ") VALUES (" . $val_list . ")";

    return $sql;
}

/**
 * Construct SQL to update a table.
 * The $parameters is an array containing table field name and the value of the field.
 *
 * @param string $table_name
 * @param string $where
 * @param integer $value
 * @param array $parameters
 * @return string
 */

function sql_update($table_name, $where, $value, $parameters)
{
    $sql = "UPDATE " . $table_name . " SET ";
    $i   = 0;
    foreach ($parameters as $key => $val) {
        if ($i == 0) {
            $sql .= $key . "='" . $val . "'";
        } else {
            $sql .= ", " . $key . "='" . $val . "'";
        }
        $i++;
    }

    $sql .= " WHERE " . $where . "='" . $value . "'";

    return $sql;
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function wpse_lost_password_redirect()
{
    wp_redirect(home_url());
    exit;
}
add_action('password_reset', 'wpse_lost_password_redirect');

//blocking not admin user that access wp-admin
add_action('init', 'blockusers_init');
function blockusers_init()
{
    if (is_admin() && !current_user_can('administrator') &&
        !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url() . "/login");
        exit;
    }
}

// ========== USER ACTIVATION ========== //
function user_activation()
{
    ob_start();
    if (isset($_GET['user_auth'])) {
        $user_auth = sanitize_text_field($_GET['user_auth']);
        //get user data
        global $wpdb;
        $query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_activationkey = '{$user_auth}'";
        $user_detail = $wpdb->get_row($query, ARRAY_A);
        $userchecker = $wpdb->update(
            'wp_ss_event_user_detail',
            array('euser_status' => 'activated'),
            array('euser_activationkey' => $user_auth),
            array('%s'),
            array('%s')
        );
        if ($userchecker === false) {
            echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
        } elseif ($userchecker === 0) {
            echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
        } elseif ($userchecker > 0) {
            echo "<div class='alert alert-danger'>Congratulation " . $user_detail['euser_fullname'] . ", your account has been activated. Please <a href='" . get_permalink() . "/login'>Login</a> to your account to continue event registration.</div>";
        } else {
            echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
        }

    } else {
        echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
    }
    return ob_get_clean();
}

add_shortcode('user_activation', 'user_activation');
// ========== END USER ACTIVATION ========== //


// ========== AUTHOR TO PARTICIPANT LINK ========== //

function participant_converter(){
    ob_start();
    if (isset($_GET['user_auth'])) {
        $user_auth = sanitize_text_field($_GET['user_auth']);
        //get user data
        global $wpdb;
        $query       = "SELECT * FROM wp_ss_event_user_detail WHERE euser_activationkey = '{$user_auth}'";
        $user_detail = $wpdb->get_row($query, ARRAY_A);
        $userchecker = $wpdb->update(
            'wp_ss_event_user_detail',
            array('euser_meta_type' => 'participant_type'),
            array('euser_activationkey' => $user_auth),
            array('%s'),
            array('%s')
        );
        if ($userchecker === false) {
            echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
        } elseif ($userchecker === 0) {
            echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
        } elseif ($userchecker > 0) {
            echo "<div class='alert alert-danger'>Congratulation " . $user_detail['euser_fullname'] . ", your account has been changed to Participant. Please <a href='" . get_permalink() . "/login'>Login</a> to your account to continue payment process.</div>";
        } else {
            echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
        }

    } else {
        echo "<div class='alert alert-danger'>
                    <h1>Oops!</h1><br>
                    <p>We can't seem to find the page you're looking for.</p>
                    <h4>Error code: <strong>404</strong></h4>
                    <br>
                    <br></div>";
    }
    return ob_get_clean();
}

add_shortcode('participant_converter', 'participant_converter');