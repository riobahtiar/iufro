<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "ss_theme_opt";

    $theme = wp_get_theme(); // For use with some settings. Not necessary.
    
    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->name,
        // Name that appears at the top of your panel
        'allow_sub_menu'       => false,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        'page_title'           => __( 'Theme Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 41,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => 'dashicons-layout',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    


    /*
     *
     * ---> START SECTIONS
     *
     */

    Redux::setSection( $opt_name, array(
        'title'            => 'Home',
        'id'               => 'home',
        'desc'             => 'Options for homepage content',
        'icon'             => 'el el-home'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => 'General Options',
        'id'         => 'general',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-align-justify',
        'fields'     => array(
            
            array(
                'id'       => 'logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Logo',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
                //'hint'      => array(
                //    'title'     => 'Hint Title',
                //    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
                //)
            ),
            array(
                'id'       => 'favicon',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Favicon',
                'compiler' => 'true',
                'desc'     => 'use image with maximum resolution 64px x 64px',
                'subtitle' => '',
                'default'  => '',
                //'hint'      => array(
                //    'title'     => 'Hint Title',
                //    'content'   => 'This is a <b>hint</b> for the media field with a Title.',
                //)
            ),
            array(
                'id'       => 'search-image',
                'type'     => 'button_set',
                'title'    => 'Image',
                'subtitle' => '',
                'options'  => array(
                    'no' => 'No image',
                    'thumbnail' => 'Thumbnail',
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'full' => 'Full'
                ),
                'default'  => 'thumbnail'
            ),
            array(
                'id'       => 'page-not-found-title',
                'type'     => 'text',
                'title'    => 'Page Not Found Title',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => 'Oops! That page can’t be found.',
            ),
            array(
                'id'       => 'page-not-found-image',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Page Not Found Image',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),
            array(
                'id'      => 'page-not-found-text',
                'type'    => 'editor',
                'title'   => 'Page Not Found Text',
                'default' => 'It looks like nothing was found at this location. ',
                'full_width' => true,
                'args'    => array(
                    'wpautop'       => true,
                    'media_buttons' => false,
                    'textarea_rows' => 5,
                    //'tabindex' => 1,
                    //'editor_css' => '',
                    'teeny'         => false,
                    //'tinymce' => array(),
                    'quicktags'     => true,
                )
            ),
        )
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => 'Social Media',
        'id'         => 'social-media',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-quote-alt',
        'fields'     => array(
            
            array(
                'id'       => 'facebook',
                'type'     => 'text',
                'title'    => 'Facebook URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            array(
                'id'       => 'twitter',
                'type'     => 'text',
                'title'    => 'Twitter URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            array(
                'id'       => 'googleplus',
                'type'     => 'text',
                'title'    => 'Google+ URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            array(
                'id'       => 'linkedin',
                'type'     => 'text',
                'title'    => 'Linkedin URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            array(
                'id'       => 'instagram',
                'type'     => 'text',
                'title'    => 'Instagram URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            array(
                'id'       => 'pinterest',
                'type'     => 'text',
                'title'    => 'Pinterest URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            array(
                'id'       => 'youtube',
                'type'     => 'text',
                'title'    => 'Youtube URL',
                'subtitle' => '',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
        )
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'            => 'Widget Area',
        'id'               => 'widget-area',
        'desc'             => 'Options for homepage content',
        'icon'             => 'el el-th-large'
    ) );

    Redux::setSection( $opt_name, array(
        'title'      => 'Header',
        'id'         => 'widget-area-header',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-chevron-up',
        'fields'     => array(
            //-------------------Header Top-----------------------
            array(
                'id'       => 'section-start-1',
                'type'     => 'section',
                'title'    => 'Header Top',
                'subtitle' => 'Options for header top widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'header-top-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            
            array(
                'id'       => 'header-top-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'header-top-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'header-top-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'header-top-show-on-page',
                'type'     => 'switch',
                'title'    => 'Show on Page',
                'subtitle' => 'show widget area on page',
                'default'  => true,
            ),

            array(
                'id'       => 'header-top-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'header-top-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'header-top-sticky',
                'type'     => 'switch',
                'title'    => 'Enable Sticky',
                'subtitle' => '',
                'default'  => false,
            ),


            array(
                'id'     => 'section-end-1',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Header Top----------------------


            //-------------------Header Middle-----------------------
            array(
                'id'       => 'section-start-2',
                'type'     => 'section',
                'title'    => 'Header Middle',
                'subtitle' => 'Options for header middle widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'header-middle-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'header-middle-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'header-middle-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'header-middle-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'header-middle-show-on-page',
                'type'     => 'switch',
                'title'    => 'Show on Page',
                'subtitle' => 'show widget area on page',
                'default'  => true,
            ),

            array(
                'id'       => 'header-middle-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'header-middle-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-2',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Header Middle----------------------


            //-------------------Header Bottom-----------------------
            array(
                'id'       => 'section-start-3',
                'type'     => 'section',
                'title'    => 'Header Bottom',
                'subtitle' => 'Options for header bottom widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'header-bottom-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'header-bottom-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'header-bottom-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'header-bottom-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'header-bottom-show-on-page',
                'type'     => 'switch',
                'title'    => 'Show on Page',
                'subtitle' => 'show widget area on page',
                'default'  => true,
            ),

            array(
                'id'       => 'header-bottom-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'header-bottom-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-3',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Header Bottom----------------------

        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => 'Home',
        'id'         => 'widget-area-home',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-graph-alt ',
        'fields'     => array(

            //-------------------Home Top-----------------------
            array(
                'id'       => 'section-start-4',
                'type'     => 'section',
                'title'    => 'Home Top',
                'subtitle' => 'Options for home top widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'home-top-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'home-top-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'home-top-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'home-top-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'home-top-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'home-top-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => 'not applied when using sidebar',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-4',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Home Top----------------------


            //-------------------Home Middle-----------------------
            array(
                'id'       => 'section-start-5',
                'type'     => 'section',
                'title'    => 'Home Middle',
                'subtitle' => 'Options for home middle widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'home-middle-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'home-middle-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'home-middle-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'home-middle-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'home-middle-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'home-middle-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => 'not applied when using sidebar',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-5',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Home Middle----------------------


            //-------------------Home Bottom-----------------------
            array(
                'id'       => 'section-start-6',
                'type'     => 'section',
                'title'    => 'Home Bottom',
                'subtitle' => 'Options for home bottom widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'home-bottom-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'home-bottom-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'home-bottom-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'home-bottom-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'home-bottom-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'home-bottom-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => 'not applied when using sidebar',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-6',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Home Bottom----------------------

            //-------------------Home Sidebar-----------------------
            array(
                'id'       => 'section-start-6-5',
                'type'     => 'section',
                'title'    => 'Home Sidebar',
                'subtitle' => 'Options for home sidebar widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'home-sidebar-custom-class',
                'type'     => 'text',
                'title'    => 'Sidebar custom class',
                'subtitle' => 'add custom class to page sidebar container',
                'desc'     => '',
                'validate' => '',
                'default'  => 'col-md-3',
            ),

            array(
                'id'       => 'home-sidebar-position',
                'type'     => 'button_set',
                'title'    => 'Sidebar Position',
                'subtitle' => '',
                'options'  => array(
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'default'  => 'right'
            ),

            array(
                'id'       => 'home-content-custom-class',
                'type'     => 'text',
                'title'    => 'Content custom class',
                'subtitle' => 'wrapper for home top, home middle, and home bottom section. Use only when sidebar shown',
                'desc'     => '',
                'validate' => '',
                'default'  => 'col-md-9',
            ),

            array(
                'id'     => 'section-end-6-5',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Home Sidebar----------------------
            
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => 'Footer',
        'id'         => 'widget-area-footer',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-chevron-down',
        'fields'     => array(
            //-------------------Footer Top-----------------------
            array(
                'id'       => 'section-start-7',
                'type'     => 'section',
                'title'    => 'Footer Top',
                'subtitle' => 'Options for footer top widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'footer-top-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'footer-top-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'footer-top-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'footer-top-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'footer-top-show-on-page',
                'type'     => 'switch',
                'title'    => 'Show on Page',
                'subtitle' => 'show widget area on page',
                'default'  => true,
            ),

            array(
                'id'       => 'footer-top-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'footer-top-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-7',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End footer Top----------------------


            //-------------------footer Middle-----------------------
            array(
                'id'       => 'section-start-8',
                'type'     => 'section',
                'title'    => 'Footer Middle',
                'subtitle' => 'Options for footer middle widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'footer-middle-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'footer-middle-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'footer-middle-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'footer-middle-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'footer-middle-show-on-page',
                'type'     => 'switch',
                'title'    => 'Show on Page',
                'subtitle' => 'show widget area on page',
                'default'  => true,
            ),

            array(
                'id'       => 'footer-middle-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'footer-middle-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-8',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End footer Middle----------------------


            //-------------------Footer Bottom-----------------------
            array(
                'id'       => 'section-start-9',
                'type'     => 'section',
                'title'    => 'Footer Bottom',
                'subtitle' => 'Options for footer bottom widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'footer-bottom-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'footer-bottom-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
			    'id'       => 'footer-bottom-background-color',
			    'type'     => 'color',
			    'title'    => 'Background Color',
			    'subtitle' => '',
			    'default'  => '',
			    'validate' => 'color',
			),

            array(
                'id'       => 'footer-bottom-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'footer-bottom-show-on-page',
                'type'     => 'switch',
                'title'    => 'Show on Page',
                'subtitle' => 'show widget area on page',
                'default'  => true,
            ),

            array(
                'id'       => 'footer-bottom-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'footer-bottom-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-9',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End footer Bottom----------------------
        )
    ) );
    

    Redux::setSection( $opt_name, array(
        'title'      => 'Page',
        'id'         => 'widget-area-page',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-file',
        'fields'     => array(
            
            //-------------------Page Header-----------------------
            array(
                'id'       => 'section-start-9-5',
                'type'     => 'section',
                'title'    => 'Page Header',
                'subtitle' => 'Options for page header widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'page-header-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            
            array(
                'id'       => 'page-header-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'page-header-background-color',
                'type'     => 'color',
                'title'    => 'Background Color',
                'subtitle' => '',
                'default'  => '',
                'validate' => 'color',
            ),

            array(
                'id'       => 'page-header-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'page-header-use-featured-image',
                'type'     => 'switch',
                'title'    => 'Use featured image',
                'subtitle' => 'use featured image if available',
                'default'  => true,
            ),

            array(
                'id'       => 'page-header-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'page-header-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-9-5',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Page Header----------------------

            //-------------------Page Sidebar-----------------------
            array(
                'id'       => 'section-start-10-5',
                'type'     => 'section',
                'title'    => 'Page Sidebar',
                'subtitle' => '',
                'indent'   => true,
            ),

            array(
                'id'       => 'page-sidebar-custom-class',
                'type'     => 'text',
                'title'    => 'Sidebar custom class',
                'subtitle' => 'add custom class to page sidebar container',
                'desc'     => '',
                'validate' => '',
                'default'  => 'col-md-3',
            ),

            array(
                'id'       => 'page-sidebar-position',
                'type'     => 'button_set',
                'title'    => 'Sidebar Position',
                'subtitle' => '',
                'options'  => array(
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'default'  => 'right'
            ),

            array(
                'id'       => 'page-sidebar-page-id',
                'type'     => 'text',
                'title'    => 'Show Sidebar only on',
                'subtitle' => 'list of comma separate page ID or title. Leave blank to show on all pages.',
                'desc'     => 'example: 12, 13, 24, "contact-us", 36',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'page-content-custom-class-sidebar-shown',
                'type'     => 'text',
                'title'    => 'Content custom class when sidebar shown',
                'subtitle' => 'add custom class to page content container when sidebar shown',
                'desc'     => '',
                'validate' => '',
                'default'  => 'col-md-9',
            ),

            array(
                'id'     => 'section-end-10-5',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Page Sidebar-----------------------



            //-------------------Page Content-----------------------
            array(
                'id'       => 'section-start-11',
                'type'     => 'section',
                'title'    => 'Page Content',
                'subtitle' => '',
                'indent'   => true,
            ),

            array(
                'id'       => 'page-top-custom-class',
                'type'     => 'text',
                'title'    => 'Page content top custom class',
                'subtitle' => 'add custom class to page content header container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'page-content-custom-class',
                'type'     => 'text',
                'title'    => 'Content custom class',
                'subtitle' => 'add custom class to page content container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'page-bottom-custom-class',
                'type'     => 'text',
                'title'    => 'Page content bottom custom class',
                'subtitle' => 'add custom class to page content footer container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'page-show-title',
                'type'     => 'switch',
                'title'    => 'Show Title',
                'subtitle' => 'show page title',
                'default'  => true,
            ),

            array(
                'id'       => 'page-image',
                'type'     => 'button_set',
                'title'    => 'Image',
                'subtitle' => '',
                'options'  => array(
                    'no' => 'No image',
                    'thumbnail' => 'Thumbnail',
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'full' => 'Full'
                ),
                'default'  => 'large'
            ),

            array(
                'id'       => 'page-show-author',
                'type'     => 'switch',
                'title'    => 'Show Author',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'page-show-date',
                'type'     => 'switch',
                'title'    => 'Show Date',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'page-show-comments-number',
                'type'     => 'switch',
                'title'    => 'Show Comments Number',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'page-show-content',
                'type'     => 'switch',
                'title'    => 'Show Content',
                'subtitle' => '',
                'default'  => true,
            ),

            array(
                'id'       => 'page-show-comment',
                'type'     => 'switch',
                'title'    => 'Show Comment',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-11',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Page Content-----------------------


            //-------------------Page Footer-----------------------
            array(
                'id'       => 'section-start-11-5',
                'type'     => 'section',
                'title'    => 'Page Footer',
                'subtitle' => 'Options for page footer widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'page-footer-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            
            array(
                'id'       => 'page-footer-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'page-footer-background-color',
                'type'     => 'color',
                'title'    => 'Background Color',
                'subtitle' => '',
                'default'  => '',
                'validate' => 'color',
            ),

            array(
                'id'       => 'page-footer-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'page-footer-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'page-footer-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-11-5',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Page Footer----------------------
            
        )
    ) );


    Redux::setSection( $opt_name, array(
        'title'      => 'Contact Us Template',
        'id'         => 'widget-area-contact',
        'desc'       => '',
        'subsection' => true,
        'icon'       => 'el el-file',
        'fields'     => array(
            
            //-------------------Contact Header-----------------------
            array(
                'id'       => 'section-start-12',
                'type'     => 'section',
                'title'    => 'Contact Us: Header',
                'subtitle' => 'Options for contact us page header widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'contact-header-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            
            array(
                'id'       => 'contact-header-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'contact-header-background-color',
                'type'     => 'color',
                'title'    => 'Background Color',
                'subtitle' => '',
                'default'  => '',
                'validate' => 'color',
            ),

            array(
                'id'       => 'contact-header-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-header-use-featured-image',
                'type'     => 'switch',
                'title'    => 'Use featured image',
                'subtitle' => 'use featured image if available',
                'default'  => true,
            ),

            array(
                'id'       => 'contact-header-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-header-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-12',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Header Top----------------------


            //-------------------Contact Us Page Sidebar-----------------------
            array(
                'id'       => 'section-start-14',
                'type'     => 'section',
                'title'    => 'Contact Us: Sidebar',
                'subtitle' => '',
                'indent'   => true,
            ),

            array(
                'id'       => 'contact-sidebar-custom-class',
                'type'     => 'text',
                'title'    => 'Sidebar custom class',
                'subtitle' => 'add custom class to page sidebar container',
                'desc'     => '',
                'validate' => '',
                'default'  => 'col-md-3',
            ),

            array(
                'id'       => 'contact-sidebar-position',
                'type'     => 'button_set',
                'title'    => 'Sidebar Position',
                'subtitle' => '',
                'options'  => array(
                    'left' => 'Left',
                    'right' => 'Right'
                ),
                'default'  => 'right'
            ),

            array(
                'id'       => 'contact-sidebar-contact-id',
                'type'     => 'text',
                'title'    => 'Show Sidebar only on',
                'subtitle' => 'list of comma separate page ID or title. Leave blank to show on all pages.',
                'desc'     => 'example: 12, 13, 24, "contact-us", 36',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'contact-content-custom-class-sidebar-shown',
                'type'     => 'text',
                'title'    => 'Content custom class when sidebar shown',
                'subtitle' => 'add custom class to page content container when sidebar shown',
                'desc'     => '',
                'validate' => '',
                'default'  => 'col-md-9',
            ),

            array(
                'id'     => 'section-end-14',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Contact Us Page Sidebar-----------------------



            //-------------------Contact Us Page Content-----------------------
            array(
                'id'       => 'section-start-15',
                'type'     => 'section',
                'title'    => 'Contact Us: Content',
                'subtitle' => '',
                'indent'   => true,
            ),

            array(
                'id'       => 'contact-content-custom-class',
                'type'     => 'text',
                'title'    => 'Content custom class',
                'subtitle' => 'add custom class to page content container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'contact-show-title',
                'type'     => 'switch',
                'title'    => 'Show Title',
                'subtitle' => 'show page title',
                'default'  => true,
            ),

            array(
                'id'       => 'contact-image',
                'type'     => 'button_set',
                'title'    => 'Image',
                'subtitle' => '',
                'options'  => array(
                    'no' => 'No image',
                    'thumbnail' => 'Thumbnail',
                    'medium' => 'Medium',
                    'large' => 'Large',
                    'full' => 'Full'
                ),
                'default'  => 'large'
            ),

            array(
                'id'       => 'contact-show-author',
                'type'     => 'switch',
                'title'    => 'Show Author',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-show-date',
                'type'     => 'switch',
                'title'    => 'Show Date',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-show-comments-number',
                'type'     => 'switch',
                'title'    => 'Show Comments Number',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-show-content',
                'type'     => 'switch',
                'title'    => 'Show Content',
                'subtitle' => '',
                'default'  => true,
            ),

            array(
                'id'       => 'contact-show-comment',
                'type'     => 'switch',
                'title'    => 'Show Comment',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-15',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Contact Us Page Content-----------------------
            

            //-------------------Contact Us Page Footer-----------------------
            array(
                'id'       => 'section-start-16',
                'type'     => 'section',
                'title'    => 'Contact Us: Footer',
                'subtitle' => 'Options for page footer widget area',
                'indent'   => true,
            ),

            array(
                'id'       => 'contact-footer-custom-class',
                'type'     => 'text',
                'title'    => 'Custom class',
                'subtitle' => 'add custom class to section container',
                'desc'     => '',
                'validate' => '',
                'default'  => '',
            ),
            
            array(
                'id'       => 'contact-footer-background',
                'type'     => 'media',
                'url'      => true,
                'title'    => 'Background',
                'compiler' => 'true',
                'desc'     => '',
                'subtitle' => '',
                'default'  => '',
            ),

            array(
                'id'       => 'contact-footer-background-color',
                'type'     => 'color',
                'title'    => 'Background Color',
                'subtitle' => '',
                'default'  => '',
                'validate' => 'color',
            ),

            array(
                'id'       => 'contact-footer-overlay',
                'type'     => 'switch',
                'title'    => 'Show Overlay',
                'subtitle' => 'show semi transparent layer on top of background',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-footer-use-row-class',
                'type'     => 'switch',
                'title'    => 'Enable bootstrap column',
                'subtitle' => 'add row class to inner div container',
                'default'  => false,
            ),

            array(
                'id'       => 'contact-footer-full-width',
                'type'     => 'switch',
                'title'    => 'Full width',
                'subtitle' => '',
                'default'  => false,
            ),

            array(
                'id'     => 'section-end-11-5',
                'type'   => 'section',
                'indent' => false,
            ),
            //-------------------End Contact Us Page Footer----------------------
            
        )
    ) );
    
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'redux-framework-demo' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

