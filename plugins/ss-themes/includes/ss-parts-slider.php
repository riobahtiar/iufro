<?php
	/**
	 *	Custom post type - Parts
	 * 
	 *  This post type can be use for showing content as part of the page
	 * 
	 *	@author heryno
	 */
	function ss_create_slides_post_type() {
	    register_post_type( 'ss_slides',
	        array(
	            'labels' => array(
	                'name'                => 'Slides',
	                'singular_name'       => 'slide',
	            ),
	            'public'        => false,
	            'show_ui'		=> true,
	            'publicly_queryable' => false,
	            'menu_position' => 18, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'page-attributes'),
	            'menu_icon'     => 'dashicons-format-gallery'
	        )
	    );

	    //wp_register_style( 'ss-parts-style', plugins_url('../style/ss-parts.css', __FILE__) );
	    //wp_enqueue_style( 'ss-parts-style' );

	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_slides_post_type' );


	/**
	 *	Custom category for Slides
	 * 
	 *  Create a custom category for slide post type so we can add/choose category for each part
	 * 
	 *	@author heryno
	 */
	function ss_create_slides_taxonomies() {
		register_taxonomy(
			'ss_slides_category',
			'ss_slides',
			array(
				'label' => 'Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_slides_category', 'ss_slides' ); 
	}
	add_action( 'init', 'ss_create_slides_taxonomies' );



	/**
	 *	Custom meta for Slides
	 * 
	 *  Create a custom meta for slide post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_slides_metabox($meta_boxes)
	{

	    $meta_boxes[] = array(
	        'id'       => 'ss_slides',
	        'title'    => 'Link',
	        'pages'    => 'ss_slides',
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Link to',
	                'desc'  => 'url sample : http://www.example.com',
	                'id'    => 'ss_slides_url',
	                'type'  => 'text',
	                'std'   => '',
	                'class' => 'widefat',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Link text',
	                'desc'  => 'use for hover and other animations',
	                'id'    => 'ss_slides_url_text',
	                'type'  => 'text',
	                'std'   => 'See more',
	                'class' => '',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Open in new tab',
	                'desc'  => '',
	                'id'    => 'ss_slides_new_tab',
	                'type'  => 'checkbox',
	                'clone' => false,
	            )
	        )
	    );
	    return $meta_boxes;
	}
	add_filter( 'rwmb_meta_boxes', 'ss_slides_metabox' );

	/**
	 *	Register script
	 *   
	 *	@author heryno
	 */
	function ss_register_parts_slider_scripts() {
	    wp_register_script( 'cycle2', plugins_url('../js/jquery.cycle2.min.js', __FILE__) );
	    wp_register_script( 'cycle2-carousel', plugins_url('../js/jquery.cycle2.carousel.min.js', __FILE__) );

	    wp_register_style( 'ss-parts-slider-style', plugins_url('../style/ss-parts-slider.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_parts_slider_scripts' );

	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show parts content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_parts_slider_generate_html($instance){
		wp_enqueue_script( 'cycle2' );
		wp_enqueue_style( 'ss-parts-slider-style' );

		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];

        $category = $instance['category'];
        $number = $instance['number'];
        if($number == 0){ //when user input number 0, that mean show all posts
        	$number = -1; //set number for posts per page to -1 to show all posts
        }
        $order_by = $instance['order_by'];
        $order = $instance['order'];
        
        //individual link setting
        $image_as_link = ($instance['image_as_link'] && $instance['image_as_link'] != 'false') ? true : false;
        $title_as_link = ($instance['title_as_link'] && $instance['title_as_link'] != 'false') ? true : false;
        $hide_image = ($instance['hide_image'] && $instance['hide_image'] != 'false') ? true : false;
        $hide_title = ($instance['hide_title'] && $instance['hide_title'] != 'false') ? true : false;
        $hide_description = ($instance['hide_description'] && $instance['hide_description'] != 'false') ? true : false;
        $hide_link = ($instance['hide_link'] && $instance['hide_link'] != 'false') ? true : false;
        $image_size = $instance['image_size'];

        //layout and styling
        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        $style = $instance['style'];
        $button_style = $instance['button_style'];
        $navigation_style = $instance['navigation_style'];
        $arrow_icon = $instance['arrow_icon'];


        //slider options
        $timeout = $instance['timeout'];
	    $fx = $instance['fx'];
	    $disable_wrap = ($instance['disable_wrap'] && $instance['disable_wrap'] != 'false') ? true : false;
	    $carousel = ($instance['carousel'] && $instance['carousel'] != 'false') ? true : false;
	    $carousel_visible = $instance['carousel_visible'];
	    $carousel_visible_tablet = $instance['carousel_visible_tablet'];
	    $carousel_visible_mobile = $instance['carousel_visible_mobile'];

	    $arr_slider_option = array();
	    $arr_slider_option[] = "data-cycle-timeout=".$timeout;
	    
	    if($disable_wrap){
	    	$arr_slider_option[] = "data-cycle-allow-wrap=false";
	    }

	    if($carousel){
	    	//add script and carousel options
	    	wp_enqueue_script( 'cycle2-carousel' );
	    	$arr_slider_option[] = "data-cycle-fx=carousel";
	    	$arr_slider_option[] = "data-cycle-carousel-fluid=true";
	    	$arr_slider_option[] = "data-cycle-carousel-visible=".$carousel_visible;
	    	$arr_slider_option[] = "data-cycle-carousel-visible-desktop=".$carousel_visible;
	    	$arr_slider_option[] = "data-cycle-carousel-visible-tablet=".$carousel_visible_tablet;
	    	$arr_slider_option[] = "data-cycle-carousel-visible-mobile=".$carousel_visible_mobile;
	    }else{
	    	$arr_slider_option[] = "data-cycle-fx=".$fx;
	    }
	    

	    $str_slider_option = implode(" ", $arr_slider_option);


	    //prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare css class for container--------------------------
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;
        $arr_container_class[] = $custom_class;
        $arr_container_class[] = $instance['text_align'];

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-parts-slider-style-".$style;	
		}

		//-----navigation style
		if($navigation_style > 0){
			$arr_container_class[] = "ss-parts-slider-navigation-style-".$navigation_style;	
		}

		//-----arrow icon
		$arr_container_class[] = $arrow_icon;

		//-----class related to image
        if($hide_image){
        	$arr_container_class[] = "ss-parts-hide-image";
        }

        if($carousel){
        	$arr_container_class[] = "ss-parts-carousel";
        }

        //-----implode all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        //end prepare----------------------------------------------

        //button style
        $str_button_style = "";
        if($button_style > 0){
        	$str_button_style = "ss-btn-style-".$button_style;
        }

		//query parts based on options
        $query = array(
	        'posts_per_page' => $number,
	        'post_type'     => array('ss_parts','ss_slides'),
	        'order'         => $order,
	        'orderby'		=> $order_by
        );

        if($category != ''){
        	$query['tax_query'] = array(
        							'relation' => 'OR',
						            array(
					                    'taxonomy' => 'ss_parts_category',
					                    'field' => 'term_id',
					                    'terms' => $category
						            ),
						            array(
					                    'taxonomy' => 'ss_parts_category',
					                    'field' => 'slug',
					                    'terms' => $category
						            ),
						            array(
					                    'taxonomy' => 'ss_slides_category',
					                    'field' => 'term_id',
					                    'terms' => $category
						            ),
						            array(
					                    'taxonomy' => 'ss_slides_category',
					                    'field' => 'slug',
					                    'terms' => $category
						            )
								);
        }

        $query_posts = new WP_Query( $query );
        
        //-----------------------------PRINT CONTENT--------------------------------
        //looping slides
        ?>
        
        <?php if ( $query_posts->have_posts() ) { ?>

        	<div id="<?php echo $id; ?>" class="ss-slideshow <?php echo $str_container_class; ?>" <?php echo $str_slider_option; ?> >

        	<?php
	        	$posts = $query_posts->get_posts();
	        	foreach ($posts as $post) {
	        		$part_id = $post->ID;

	        		//prepare image as slide background
	        		$style_image = "";
	        		$attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id( $part_id ), $image_size);
					$image_url = $attachment_data[0];

					if($hide_image){
						$image_url = "";
					}

					if($image_url != ""){
						$style_image = "background-image: url('".$image_url."')";
					}

					//get meta for link options
					$link = do_shortcode(get_post_meta($post->ID, 'ss_parts_url', true));
					$link_text = get_post_meta($post->ID, 'ss_parts_url_text', true);

					//open in new tab option
					$new_tab = get_post_meta($post->ID, 'ss_parts_new_tab', true);
					$str_new_tab = "";
					if($new_tab == "1"){
						$str_new_tab = ' target="_blank" ';
					}
			?>

					<div id="<?php echo $id.'-part-'.$part_id; ?>" class="ss-slide" style="<?php echo $style_image; ?>" data-background-image="<?php echo $image_url; ?>">
		        		<div class="ss-slide-caption">
				            <div class="ss-slide-caption-wrapper">

					            <?php if(!$hide_title){ ?>
					            	<?php if($title_as_link && $link != ""){ ?>
						        		<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="ss-slide-title-link">
						        	<?php } ?>

						        	<h3 class="ss-slide-title"><?php echo $post->post_title; ?></h3>

						        	<?php if($title_as_link && $link != ""){ ?>
						        		</a>
						        	<?php } ?>
					            <?php } ?>
						        

						        <?php if(!$hide_description){ ?>
						        	<div class="ss-slide-content">
					                    <p><?php echo do_shortcode(apply_filters("the_content",$post->post_content)); ?></p>
					                </div>
						        <?php } ?>

						        <?php if(!$hide_link && $link != ""){ ?>
						        	<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="btn <?php echo $str_button_style; ?>">
						        		<span>
						        			<?php echo $link_text; ?>
						        		</span>
						        	</a>
						        <?php } ?>

				        	</div>
				        </div>
				    </div>

			 	
				<?php } ?>

	        	<!-- Pagination -->
			    <div class="ss-browse ss-left cycle-prev"></div>
			    <div class="ss-browse ss-right cycle-next"></div>

			    <!-- Bullet navigation -->
			    <div class="ss-slide-navigation cycle-pager"></div>

        	</div>

    <?php
        }

        return true;

	}



	/**
	 *	Add SS Parts Slider Widget
	 * 
	 *  widget to show multiple parts as slider
	 *   
	 *	@author heryno
	 */
	class SS_Parts_Slider_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_parts_slider_widget', 
		        'SS Parts Slider', 
		        array( 'description' => 'Show parts as slider', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	    	
	        //echo $args['before_widget'];

	        //display widget content
	        ss_parts_slider_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$title = ! empty($instance['title']) ? esc_attr($instance['title']) : '';
	    	
	    	$category = ! empty($instance['category']) ? esc_attr($instance['category']) : '';
	        $number = ! empty($instance['number']) ? absint($instance['number']) : 0;
	        $order_by = ! empty($instance['order_by']) ? esc_attr($instance['order_by']) : 'ID';
	        $order = ! empty($instance['order']) ? esc_attr($instance['order']) : 'ASC';
	        
	        $image_size = ! empty($instance['image_size']) ? esc_attr($instance['image_size']) : 'thumbnail';

	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        $text_align = ! empty($instance['text_align']) ? esc_attr($instance['text_align']) : '0';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';
	        $button_style = ! empty($instance['button_style']) ? esc_attr($instance['button_style']) : '0';
	        $navigation_style = ! empty($instance['navigation_style']) ? esc_attr($instance['navigation_style']) : '0';
	        $arrow_icon = ! empty($instance['arrow_icon']) ? esc_attr($instance['arrow_icon']) : '';

	        $timeout = (!empty($instance['timeout']) || $instance['timeout'] === '0') ? $instance['timeout'] : 4000;
	        $fx = ! empty($instance['fx']) ? esc_attr($instance['fx']) : 'scrollHorz';
	        $carousel_visible = (!empty($instance['carousel_visible']) || $instance['carousel_visible'] === 0) ? $instance['carousel_visible'] : 2;
	        $carousel_visible_tablet = (!empty($instance['carousel_visible_tablet']) || $instance['carousel_visible_tablet'] === 0) ? $instance['carousel_visible_tablet'] : 2;
	        $carousel_visible_mobile = (!empty($instance['carousel_visible_mobile']) || $instance['carousel_visible_mobile'] === 0) ? $instance['carousel_visible_mobile'] : 1;

	        $args = array(
		        'type'     =>'ss_parts',
		        'taxonomy'    =>'ss_parts_category'
	        );
	        $categories = get_categories($args);

	        $args_slide = array(
		        'type'     =>'ss_slides',
		        'taxonomy'    =>'ss_slides_category'
	        );
	        $categories_slide = get_categories($args_slide);
	        
	        $arr_image_size = array(
	        	'thumbnail' => 'Thumbnail',
	        	'medium' => 'Medium',
	        	'large' => 'Large',
	        	'full' => 'Original Size',
	        );

	        $arr_text_align = array(
	        	'text-left' => 'Left',
	        	'text-center' => 'Center',
	        	'text-right' => 'Right',
	        );

	        $arr_style = array(
	        	0 => 'Default (No style)',
	        );

	        $arr_button_style = array(
	        	0 => 'Default (No style)',
	        	1 => 'Standard',
	        	2 => 'Style 2',
	        	3 => 'Style 3',
	        	4 => 'Style 4',
	        	5 => 'Style 5',
	        	6 => 'Style 6',
	        	7 => 'Style 7',
	        	8 => 'Style 8',
	        	9 => 'Style 9',
	        	10 => 'Style 10',
	        );

	        $arr_navigation_style = array(
	        	0 => 'Default (No style)',
	        	1 => 'Style 1',
	        	2 => 'Style 2',
	        	3 => 'Style 3',
	        	4 => 'Style 4',
	        	5 => 'Style 5',
	        	6 => 'Style 6',
	        	7 => 'Style 7',
	        	8 => 'Style 8',
	        	9 => 'Style 9',
	        	10 => 'Style 10',
	        );

	        $arr_arrow_icon = array(
	        	'' => 'Default (No style)',
	        	'ss-slides-icon-arrow' => 'Short arrow',
	        	'ss-slides-icon-long-arrow' => 'Long arrow',
	        	'ss-slides-icon-arrow-circle' => 'Arrow circle',
	        	'ss-slides-icon-caret' => 'Caret',
	        	'ss-slides-icon-chevron-circle' => 'Chevron circle',
	        	'ss-slides-icon-angle' => 'Angle',
	        	'ss-slides-icon-angle-double' => 'Angle double',
	        	'ss-slides-icon-hand' => 'Hand',
	        );

	        $arr_fx = array(
	        	'scrollHorz' => 'Scroll',
	        	'fade' => 'Fade',
	        	'fadeout' => 'Fade Out',
	        	'none' => 'None',
	        );

	        //column value for bootstrap
	        $arr_column = array('0' => '0', '12' => '1', '6' => '2', '4' => '3', '3' => '4', '2' => '6', '1' => '12');

	        ?>

		        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="hidden" value="<?php echo $title; ?>" />

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
			        <?php
				        foreach ($categories as $cat){
				            echo '<option value="' . $cat->cat_ID . '"'.($category == $cat->cat_ID ? 'selected' : '').' >' . $cat->name . '</option>';
				        }
				        foreach ($categories_slide as $cat){
				            echo '<option value="' . $cat->cat_ID . '"'.($category == $cat->cat_ID ? 'selected' : '').' >' . $cat->name . '</option>';
				        }
			        ?>
		        	</select>
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of slide:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="2" />
		        	(put 0 to show all slides) 
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order by:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
		            	<option value = "ID" <?php echo ($order_by == "ID" ? 'selected' : '') ?> >ID</option>
		            	<option value = "title" <?php echo ($order_by == "title" ? 'selected' : '') ?> >Title</option>
		            	<option value = "menu_order" <?php echo ($order_by == "menu_order" ? 'selected' : '') ?> >Order Value</option>
		        	</select>
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		            	<option value = "ASC" <?php echo ($order == "ASC" ? 'selected' : '') ?> >Ascending</option>
		            	<option value = "DESC" <?php echo ($order == "DESC" ? 'selected' : '') ?> >Descending</option>
		        	</select>
		        </p>

		        <br/>

	        	<p>
	        		<h4>Individual Part</h4>
	        	</p>

	        	<hr/>

	        	<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['image_as_link'], 'on'); ?> id="<?php echo $this->get_field_id('image_as_link'); ?>" name="<?php echo $this->get_field_name('image_as_link'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('image_as_link'); ?>"><?php _e('Image as Link'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['title_as_link'], 'on'); ?> id="<?php echo $this->get_field_id('title_as_link'); ?>" name="<?php echo $this->get_field_name('title_as_link'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('title_as_link'); ?>"><?php _e('Title as Link'); ?></label>
				</p>

	        	<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_image'], 'on'); ?> id="<?php echo $this->get_field_id('hide_image'); ?>" name="<?php echo $this->get_field_name('hide_image'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_image'); ?>"><?php _e('Hide Image'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_title'], 'on'); ?> id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_title'); ?>"><?php _e('Hide Title'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_description'], 'on'); ?> id="<?php echo $this->get_field_id('hide_description'); ?>" name="<?php echo $this->get_field_name('hide_description'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_description'); ?>"><?php _e('Hide Description'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_link'], 'on'); ?> id="<?php echo $this->get_field_id('hide_link'); ?>" name="<?php echo $this->get_field_name('hide_link'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_link'); ?>"><?php _e('Hide Link'); ?></label>
				</p>				

				<p>
		        	<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image size:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('image_size'); ?>" name="<?php echo $this->get_field_name('image_size'); ?>">
			        	<?php foreach ($arr_image_size as $index => $size){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $image_size, $index ); ?> >
			                	<?php echo $size; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

				<br/>

		        <p class="ss-editor-hide">
	        		<h4 class="ss-editor-hide">Layout &amp; Styling</h4>
	        	</p>

	        	<hr/>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('custom_class'); ?>"><?php _e('Custom Container Class:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_class'); ?>" name="<?php echo $this->get_field_name('custom_class'); ?>" type="text" value="<?php echo $custom_class; ?>" />
		        </p>
	        	
	        	<p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('custom_id'); ?>"><?php _e('Custom Container ID:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" type="text" value="<?php echo $custom_id; ?>" />
		        </p>

	        	<p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('text_align'); ?>"><?php _e('Text align:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('text_align'); ?>" name="<?php echo $this->get_field_name('text_align'); ?>">
			        	<?php foreach ($arr_text_align as $index => $available_text_align){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $text_align, $index ); ?> >
			                	<?php echo $available_text_align; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
			        	<?php foreach ($arr_style as $index => $available_style){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $style, $index ); ?> >
			                	<?php echo $available_style; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('button_style'); ?>"><?php _e('Link/Button Style:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('button_style'); ?>" name="<?php echo $this->get_field_name('button_style'); ?>">
			        	<?php foreach ($arr_button_style as $index => $available_button_style){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $button_style, $index ); ?> >
			                	<?php echo $available_button_style; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('navigation_style'); ?>"><?php _e('Navigation Style:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('navigation_style'); ?>" name="<?php echo $this->get_field_name('navigation_style'); ?>">
			        	<?php foreach ($arr_navigation_style as $index => $available_navigation_style){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $navigation_style, $index ); ?> >
			                	<?php echo $available_navigation_style; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('arrow_icon'); ?>"><?php _e('Arrow icon:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('arrow_icon'); ?>" name="<?php echo $this->get_field_name('arrow_icon'); ?>">
			        	<?php foreach ($arr_arrow_icon as $index => $available_arrow_icon){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $arrow_icon, $index ); ?> >
			                	<?php echo $available_arrow_icon; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <br/>

	        	<p>
	        		<h4>Slider Options</h4>
	        	</p>

	        	<hr/>

	        	<p>
		        	<label for="<?php echo $this->get_field_id('timeout'); ?>"><?php _e('Timeout:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('timeout'); ?>" name="<?php echo $this->get_field_name('timeout'); ?>" type="text" value="<?php echo $timeout; ?>" size="4" />
		        	miliseconds (put 0 for manual transition) 
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('fx'); ?>"><?php _e('Transition Effect:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('fx'); ?>" name="<?php echo $this->get_field_name('fx'); ?>">
			        	<?php foreach ($arr_fx as $index => $available_fx){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $fx, $index ); ?> >
			                	<?php echo $available_fx; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['disable_wrap'], 'on'); ?> id="<?php echo $this->get_field_id('disable_wrap'); ?>" name="<?php echo $this->get_field_name('disable_wrap'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('disable_wrap'); ?>"><?php _e('Disable wrap'); ?></label>
				</p>

		        <p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['carousel'], 'on'); ?> id="<?php echo $this->get_field_id('carousel'); ?>" name="<?php echo $this->get_field_name('carousel'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('carousel'); ?>"><?php _e('Carousel mode'); ?></label>
				</p>

				<p>
		        	<label for="<?php echo $this->get_field_id('carousel_visible'); ?>"><?php _e('Visible Slide:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('carousel_visible'); ?>" name="<?php echo $this->get_field_name('carousel_visible'); ?>" type="text" value="<?php echo $carousel_visible; ?>" size="2" />
		        	(for carousel)
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('carousel_visible_tablet'); ?>"><?php _e('Visible Slide Tablet:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('carousel_visible_tablet'); ?>" name="<?php echo $this->get_field_name('carousel_visible_tablet'); ?>" type="text" value="<?php echo $carousel_visible_tablet; ?>" size="2" />
		        	(for carousel)
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('carousel_visible_mobile'); ?>"><?php _e('Visible Slide Mobile:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('carousel_visible_mobile'); ?>" name="<?php echo $this->get_field_name('carousel_visible_mobile'); ?>" type="text" value="<?php echo $carousel_visible_mobile; ?>" size="2" />
		        	(for carousel)
		        </p>

	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['category'] = strip_tags($new_instance['category']);
	        $instance['order_by'] = strip_tags($new_instance['order_by']);
	        $instance['order'] = strip_tags($new_instance['order']);
	        $instance['number'] = filter_var($new_instance['number'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        
	        $instance['image_as_link'] = $new_instance['image_as_link'];
	        $instance['title_as_link'] = $new_instance['title_as_link'];
	        $instance['hide_title'] = $new_instance['hide_title'];
	        $instance['hide_description'] = $new_instance['hide_description'];
	        $instance['hide_image'] = $new_instance['hide_image'];
	        $instance['hide_link'] = $new_instance['hide_link'];
	        $instance['image_size'] = strip_tags($new_instance['image_size']);
	        
	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	$instance['text_align'] = strip_tags($new_instance['text_align']);
	       	$instance['style'] = strip_tags($new_instance['style']);
	       	$instance['button_style'] = strip_tags($new_instance['button_style']);
	       	$instance['navigation_style'] = strip_tags($new_instance['navigation_style']);
	       	$instance['arrow_icon'] = strip_tags($new_instance['arrow_icon']);

	       	$instance['timeout'] = filter_var($new_instance['timeout'], FILTER_SANITIZE_NUMBER_INT); //get only number
	       	$instance['fx'] = strip_tags($new_instance['fx']);
	       	$instance['carousel'] = $new_instance['carousel'];
	       	$instance['disable_wrap'] = $new_instance['disable_wrap'];
	       	$instance['carousel_visible'] = filter_var($new_instance['carousel_visible'], FILTER_SANITIZE_NUMBER_INT); //get only number
	       	$instance['carousel_visible_tablet'] = filter_var($new_instance['carousel_visible_tablet'], FILTER_SANITIZE_NUMBER_INT); //get only number
	       	$instance['carousel_visible_mobile'] = filter_var($new_instance['carousel_visible_mobile'], FILTER_SANITIZE_NUMBER_INT); //get only number

	       	//category name query parts based on options
        	$category = get_term_by('id',$instance['category'],'ss_parts_category');
        	$instance['title'] = strip_tags($category->name);

	        return $instance;
	    }
	}


	/**
	 * Run Part shortcode
	 * 
	 * @return html content
	 */
	function ss_parts_slider_shortcode($atts)
	{
	    $default_atts = array(
	    	'category' => '',
	    	'number' => '0',
	    	'order_by' => 'ID',
	    	'order' => 'ASC',

	    	'image_as_link' => NULL,
	    	'title_as_link' => NULL,
	    	'hide_title' => NULL,
	    	'hide_description' => NULL,
	    	'hide_image' => NULL,
	    	'hide_link' => NULL,
	    	'image_size' => 'thumbnail',

	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'text_align' => 'text-left',
	    	'style' => '0',
	    	'button_style' => '0',
	    	'navigation_style' => '0',
	    	'arrow_icon' => '',

	    	'timeout' => '4000',
	    	'fx' => 'scrollHorz',
	    	'disable_wrap' => NULL,
	    	'carousel' => NULL,
	    	'carousel_visible' => '2',
	    	'carousel_visible_tablet' => '2',
	    	'carousel_visible_mobile' => '1',
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();
	    
	    //display widget content
	    ss_parts_slider_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_parts_slider', 'ss_parts_slider_shortcode');
?>