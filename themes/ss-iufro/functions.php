<?php
    /* Load theme option */    
    if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/redux-framework/ReduxCore/framework.php' ) ) {
        require_once( dirname( __FILE__ ) . '/redux-framework/ReduxCore/framework.php' );
    }
    if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/redux-framework/redux-config.php' ) ) {
        require_once( dirname( __FILE__ ) . '/redux-framework/redux-config.php' );
    }

    /* Load assets */
    function custom_scripts() {             
        /* stylesheets */

        $style_config = file_get_contents(get_template_directory().'/config/css.json'); 
        $js_config = file_get_contents(get_template_directory().'/config/js.json'); 
 
        $style_assets = json_decode($style_config);
        $js_assets = json_decode($js_config);

        foreach ($style_assets as $value) {
            if(isset($value->url)) {
                wp_enqueue_style($value->name, $value->url);
            } elseif(isset($value->name)) {
                wp_enqueue_style($value->name, get_template_directory_uri().'/'.$value->file);
            }
            
        } 

        wp_enqueue_script('jquery');
        foreach ($js_assets as $value) {
            if(isset($value->url)) {
                wp_enqueue_script($value->name,  $value->url, '1.00', array(), true);
            } elseif(isset($value->name)) {
                wp_enqueue_script($value->name,  get_template_directory_uri().'/'.$value->file, '1.00', array(), true);
            }
            
        }

        // Set global variable to javascript
        $global_vars = array(
                'homeURL' => get_home_url(),
                'themeURL' => get_template_directory_uri(),
                'siteName' => esc_attr( get_bloginfo( 'name', 'display' ) )
            );
        wp_localize_script('app', 'app_vars', $global_vars);
        
    }

    add_action('wp_enqueue_scripts', 'custom_scripts', 100);

    /* Add mobile class */
    function custom_class_names($classes) {

        // Mobile Detects
        if( wp_is_mobile() ) {
            $classes[] = 'is-mobile';
        } else {
            $classes[] = 'not-mobile';
        }
        return $classes;
    }

    add_filter('body_class','custom_class_names');  

    /* Custom theme setup */

    function custom_theme_setup() {

        // Enable post thumbnail support
        add_theme_support( 'post-thumbnails' ); 
        //set_post_thumbnail_size( 600, 400, true ); // Normal post thumbnails
        //add_image_size( 'banner-thumb', 566, 250, true ); // Small thumbnail size
        add_image_size( 'social-preview', 600, 315, true ); // Square thumbnail used by sharethis and facebook

        // Turn on menus
        //add_theme_support('menus');

    }
    add_action( 'after_setup_theme', 'custom_theme_setup' );


    /* Add post type */

    // Our custom post type function
    function create_posttype() {
        register_post_type( 'layout-options',
        // CPT Options
            array(
                'labels' => array(
                    'name' => __( 'Layout Options' ),
                    'singular_name' => __( 'Layout Options' )
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => 'layout-options'),
            )
        );
    }
    // Hooking up our function to theme setup
    // add_action( 'init', 'create_posttype' );

    /* Include layout option page */
    function get_static_layout($part) {
        $content = get_page_by_title($part, OBJECT, 'layout-options')->post_content;
        if(isset($content)) {
            return WR_Pb_Helper_Shortcode::doshortcode_content($content);
        }
    }



    /**
     * Register widget area.
     *
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    function ss_widget_area_init() {
        register_sidebar( array(
            'name'          => 'Header Top',
            'id'            => 'header-top',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Header Middle',
            'id'            => 'header-middle',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Header Bottom',
            'id'            => 'header-bottom',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Home Top',
            'id'            => 'home-top',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Home Middle',
            'id'            => 'home-middle',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Home Bottom',
            'id'            => 'home-bottom',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Home Sidebar',
            'id'            => 'home-sidebar',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Footer Top',
            'id'            => 'footer-top',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Footer Middle',
            'id'            => 'footer-middle',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Footer Bottom',
            'id'            => 'footer-bottom',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Page Header',
            'id'            => 'page-header',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Page Sidebar',
            'id'            => 'page-sidebar',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Page Content Top',
            'id'            => 'page-top',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Page Content Bottom',
            'id'            => 'page-bottom',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Page Footer',
            'id'            => 'page-footer',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Contact Header',
            'id'            => 'contact-header',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Contact Sidebar',
            'id'            => 'contact-sidebar',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Contact Footer',
            'id'            => 'contact-footer',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );

        register_sidebar( array(
            'name'          => 'Blog Bottom',
            'id'            => 'blog-bottom',
            'description'   => '',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ) );        
    }

    add_action( 'widgets_init', 'ss_widget_area_init' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => 'Primary Menu',
        'top' => 'Top Menu',
        'bottom' => 'Bottom Menu',
        'extra' => 'Extra Menu',
    ) );



    if ( ! function_exists( 'twentyfifteen_comment_nav' ) ) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     * @since Twenty Fifteen 1.0
     */
    function twentyfifteen_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
        ?>
        <nav class="navigation comment-navigation" role="navigation">
            <h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'twentyfifteen' ); ?></h2>
            <div class="nav-links">
                <?php
                    if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'twentyfifteen' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'twentyfifteen' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                ?>
            </div><!-- .nav-links -->
        </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
    endif;

    function iufro_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
        ?>

        <div class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div><!-- .post-thumbnail -->

        <?php else : ?>

        <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
            <?php
                the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) );
            ?>
        </a>

        <?php endif; // End is_singular()
    }

    function iufro_index($length) 
    {
        return 70;
    }    

    function iufro_post_readmore($text) {
        ob_start();
    ?>
        <span class="readmore"><a href="<?php the_permalink(); ?>">Read More</a></span> 
    <?php
        return ".... ".ob_get_clean();
    }

    function iufro_excerpt($length_callback = '', $more_callback = '')
    {
        global $post;
        if (function_exists($length_callback)) {
            add_filter('excerpt_length', $length_callback);
        }
        if (function_exists($more_callback)) {
            add_filter('excerpt_more', $more_callback);
        }
        $output = get_the_excerpt(); 
        $output = apply_filters('wptexturize', $output);
        $output = apply_filters('convert_chars', $output);        
        $output = '<p>' . $output . '</p>';
        echo $output;
    } 

    add_action('pre_get_posts','custom_pre_get_posts',9,1);
    function custom_pre_get_posts($query) {
        if ( is_main_query() ) {

        } else { 

        }
    }

    add_action('wp','blog_reload',5,1);
    function blog_reload($wp) {
        global $wp_query;
        //var_dump($wp_query->max_num_pages);
    }         


    /**
     *  Check gravity form phone field.
     * 
     *  If phone field format is international, then check user input. 
     *  Only certain characters are allowed. 
     * 
     *  @author heryno
     *  @return result whether it's valid or error
     */

    add_filter( 'gform_field_validation', 'ss_validate_phone', 10, 4 );
    function ss_validate_phone( $result, $value, $form, $field ) {
        //phone number regex allows digit, space, -, +, (, ),
        $pattern = "/^[\+\s\d\-x()]+$/";
        
        if ( $value != '' && $field->type == 'phone' && $field->phoneFormat != 'standard' && ! preg_match( $pattern, $value ) ) {
            $result['is_valid'] = false;
            $result['message']  = 'Please enter a valid phone number';
        }

        return $result;
    }

    /**
     * declare woocommerce support
     *
     * @author woocommerce
     */
    function woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }
    add_action( 'after_setup_theme', 'woocommerce_support' );
    
    function new_excerpt_more($more) {
        global $post;
        return '...';
    }
    add_filter('excerpt_more', 'new_excerpt_more');
	
	
	function custom_excerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'<span class="custom-readmore"><a href="'.get_permalink(get_the_ID()).'"> read more&nbsp;&raquo;</a></span>';
		} else {
			$excerpt = implode(" ",$excerpt);
		}
		$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
		return $excerpt;
	}

	/**
	 * create post views count
	 *
	 */
	function custom_set_post_views($postID) {
		$count_key = 'wp_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
		}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
		}
	}
	//refresh count
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
?>