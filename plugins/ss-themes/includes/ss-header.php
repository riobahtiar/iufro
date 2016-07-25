<?php
	
	/**
	 *	Custom post type - Header
	 * 
	 *  This post type can be use for showing content as part of the page
	 * 
	 *	@author heryno
	 */
	function ss_create_header_post_type() {
	    register_post_type( 'ss_header',
	        array(
	            'labels' => array(
	                'name'                => 'Header',
	                'singular_name'       => 'header',
	                'add_new_item' => 'Add New Content',
					'edit_item' => 'Edit Content',
					'new_item' => 'New Content',
					'view_item' => 'View Content',
					'search_items' => 'Search Contents' 
	            ),
	            'public'        => false,
	            'show_ui'		=> true,
	            'publicly_queryable' => false,
	            'menu_position' => 21, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'page-attributes'),
	            'menu_icon'     => 'dashicons-arrow-up-alt2',
	            'show_in_menu' => 'edit.php?post_type=ss_home'
	        )
	    );

	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_header_post_type' );

	/**
	 * Add submenu for header category taxonomy
	 */
	add_action('admin_menu', 'ss_admin_menu'); 
	function ss_admin_menu() { 
	    
	    //add_menu_page( 'Content', 'Content', 'manage_options', 'ss-content', 'my_plugin_options' );
	    //add_submenu_page('ss-content', 'Header Categories', 'Header Categories', 'manage_options', 'edit-tags.php?taxonomy=ss_header_category&post_type=ss_header'); 
	}

	/**
	 *	Custom category for Parts
	 * 
	 *  Create a custom category for parts post type so we can add/choose category for each part
	 * 
	 *	@author heryno
	 */
	function ss_create_header_taxonomies() {
		register_taxonomy(
			'ss_header_category',
			'ss_header',
			array(
				'label' => 'Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true,
				//'show_in_menu' => 'edit.php?post_type=page'
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_header_category', 'ss_header' ); 
	}
	add_action( 'init', 'ss_create_header_taxonomies' );



	/**
	 *	Custom meta for Parts
	 * 
	 *  Create a custom meta for parts post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_header_metabox($meta_boxes)
	{

	    $meta_boxes[] = array(
	        'id'       => 'ss_header',
	        'title'    => 'Link',
	        'pages'    => 'ss_header',
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Link to',
	                'desc'  => 'url sample : http://www.example.com',
	                'id'    => 'ss_parts_url',
	                'type'  => 'text',
	                'std'   => '',
	                'class' => 'widefat',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Link text',
	                'desc'  => 'use for hover and other animations',
	                'id'    => 'ss_parts_url_text',
	                'type'  => 'text',
	                'std'   => 'See more',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Open in new tab',
	                'desc'  => '',
	                'id'    => 'ss_parts_new_tab',
	                'type'  => 'checkbox',
	                'clone' => false,
	            )
	        )
	    );
	    return $meta_boxes;
	}
	add_filter( 'rwmb_meta_boxes', 'ss_header_metabox' );




	//----------HOME CONTENT---------
	/**
	 *	Custom post type - Home
	 * 
	 *  This post type can be use for showing content as part of the page
	 * 
	 *	@author heryno
	 */
	function ss_create_home_post_type() {
	    register_post_type( 'ss_home',
	        array(
	            'labels' => array(
	                'name'                => 'Content',
	                'singular_name'       => 'home',
	                'all_items'		=> 'Home',
	                'add_new_item' => 'Add New Content',
					'edit_item' => 'Edit Content',
					'new_item' => 'New Content',
					'view_item' => 'View Content',
					'search_items' => 'Search Contents' 
	            ),
	            'public'        => false,
	            'show_ui'		=> true,
	            'publicly_queryable' => false,
	            'menu_position' => 19, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'page-attributes'),
	            'menu_icon'     => 'dashicons-admin-home',
	        )
	    );

	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_home_post_type' );


	/**
	 *	Custom category for Home
	 * 
	 *  Create a custom category for parts post type so we can add/choose category for each part
	 * 
	 *	@author heryno
	 */
	function ss_create_home_taxonomies() {
		register_taxonomy(
			'ss_home_category',
			'ss_home',
			array(
				'label' => 'Home Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_home_category', 'ss_home' ); 
	}
	add_action( 'init', 'ss_create_home_taxonomies' );



	/**
	 *	Custom meta for Home
	 * 
	 *  Create a custom meta for parts post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_home_metabox($meta_boxes)
	{

	    $meta_boxes[] = array(
	        'id'       => 'ss_home',
	        'title'    => 'Link',
	        'pages'    => 'ss_home',
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Link to',
	                'desc'  => 'url sample : http://www.example.com',
	                'id'    => 'ss_parts_url',
	                'type'  => 'text',
	                'std'   => '',
	                'class' => 'widefat',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Link text',
	                'desc'  => 'use for hover and other animations',
	                'id'    => 'ss_parts_url_text',
	                'type'  => 'text',
	                'std'   => 'See more',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Open in new tab',
	                'desc'  => '',
	                'id'    => 'ss_parts_new_tab',
	                'type'  => 'checkbox',
	                'clone' => false,
	            )
	        )
	    );
	    return $meta_boxes;
	}
	add_filter( 'rwmb_meta_boxes', 'ss_home_metabox' );


	//------------SIDEBAR----------
	/**
	 *	Custom post type - Sidebar
	 * 
	 *  This post type can be use for showing content as part of the page
	 * 
	 *	@author heryno
	 */
	function ss_create_sidebar_post_type() {
	    register_post_type( 'ss_sidebar',
	        array(
	            'labels' => array(
	                'name'                => 'Sidebar',
	                'singular_name'       => 'sidebar',
	                'add_new_item' => 'Add New Content',
					'edit_item' => 'Edit Content',
					'new_item' => 'New Content',
					'view_item' => 'View Content',
					'search_items' => 'Search Contents' 
	            ),
	            'public'        => false,
	            'show_ui'		=> true,
	            'publicly_queryable' => false,
	            'menu_position' => 22, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'page-attributes'),
	            'menu_icon'     => 'dashicons-arrow-right-alt2',
	            'show_in_menu' => 'edit.php?post_type=ss_home'
	        )
	    );

	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_sidebar_post_type' );


	/**
	 *	Custom category for Sidebar
	 * 
	 *  Create a custom category for parts post type so we can add/choose category for each part
	 * 
	 *	@author heryno
	 */
	function ss_create_sidebar_taxonomies() {
		register_taxonomy(
			'ss_sidebar_category',
			'ss_sidebar',
			array(
				'label' => 'Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_sidebar_category', 'ss_sidebar' ); 
	}
	add_action( 'init', 'ss_create_sidebar_taxonomies' );



	/**
	 *	Custom meta for Sidebar
	 * 
	 *  Create a custom meta for parts post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_sidebar_metabox($meta_boxes)
	{

	    $meta_boxes[] = array(
	        'id'       => 'ss_sidebar',
	        'title'    => 'Link',
	        'pages'    => 'ss_sidebar',
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Link to',
	                'desc'  => 'url sample : http://www.example.com',
	                'id'    => 'ss_parts_url',
	                'type'  => 'text',
	                'std'   => '',
	                'class' => 'widefat',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Link text',
	                'desc'  => 'use for hover and other animations',
	                'id'    => 'ss_parts_url_text',
	                'type'  => 'text',
	                'std'   => 'See more',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Open in new tab',
	                'desc'  => '',
	                'id'    => 'ss_parts_new_tab',
	                'type'  => 'checkbox',
	                'clone' => false,
	            )
	        )
	    );
	    return $meta_boxes;
	}
	add_filter( 'rwmb_meta_boxes', 'ss_sidebar_metabox' );


	/**
	 *	Custom post type - Parts
	 * 
	 *  This post type can be use for showing content as part of the page
	 * 
	 *	@author heryno
	 */
	function ss_create_footer_post_type() {
	    register_post_type( 'ss_footer',
	        array(
	            'labels' => array(
	                'name'                => 'Footer',
	                'singular_name'       => 'footer',
	                'add_new_item' => 'Add New Content',
					'edit_item' => 'Edit Content',
					'new_item' => 'New Content',
					'view_item' => 'View Content',
					'search_items' => 'Search Contents' 
	            ),
	            'public'        => false,
	            'show_ui'		=> true,
	            'publicly_queryable' => false,
	            'menu_position' => 23, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'page-attributes'),
	            'menu_icon'     => 'dashicons-arrow-down-alt2',
	            'show_in_menu' => 'edit.php?post_type=ss_home'
	        )
	    );

	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_footer_post_type' );


	/**
	 *	Custom category for Parts
	 * 
	 *  Create a custom category for parts post type so we can add/choose category for each part
	 * 
	 *	@author heryno
	 */
	function ss_create_footer_taxonomies() {
		register_taxonomy(
			'ss_footer_category',
			'ss_footer',
			array(
				'label' => 'Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_footer_category', 'ss_footer' ); 
	}
	add_action( 'init', 'ss_create_footer_taxonomies' );



	/**
	 *	Custom meta for Parts
	 * 
	 *  Create a custom meta for parts post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_footer_metabox($meta_boxes)
	{

	    $meta_boxes[] = array(
	        'id'       => 'ss_footer',
	        'title'    => 'Link',
	        'pages'    => 'ss_footer',
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Link to',
	                'desc'  => 'url sample : http://www.example.com',
	                'id'    => 'ss_parts_url',
	                'type'  => 'text',
	                'std'   => '',
	                'class' => 'widefat',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Link text',
	                'desc'  => 'use for hover and other animations',
	                'id'    => 'ss_parts_url_text',
	                'type'  => 'text',
	                'std'   => 'See more',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Open in new tab',
	                'desc'  => '',
	                'id'    => 'ss_parts_new_tab',
	                'type'  => 'checkbox',
	                'clone' => false,
	            )
	        )
	    );
	    return $meta_boxes;
	}
	add_filter( 'rwmb_meta_boxes', 'ss_footer_metabox' );

?>