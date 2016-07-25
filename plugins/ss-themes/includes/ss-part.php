<?php
	
	/**
	 *	Custom post type - Parts
	 * 
	 *  This post type can be use for showing content as part of the page
	 * 
	 *	@author heryno
	 */
	function ss_create_parts_post_type() {
	    register_post_type( 'ss_parts',
	        array(
	            'labels' => array(
	                'name'                => 'Parts',
	                'singular_name'       => 'part',
	            ),
	            'public'        => false,
	            'show_ui'		=> true,
	            'publicly_queryable' => false,
	            'exclude_from_search' => true,
	            'menu_position' => 16, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'page-attributes'),
	            'menu_icon'     => 'dashicons-align-left'
	        )
	    );

	    wp_register_style( 'ss-parts-style', plugins_url('../style/ss-parts.css', __FILE__) );
	    wp_enqueue_style( 'ss-parts-style' );

	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_parts_post_type' );


	/**
	 *	Custom category for Parts
	 * 
	 *  Create a custom category for parts post type so we can add/choose category for each part
	 * 
	 *	@author heryno
	 */
	function ss_create_parts_taxonomies() {
		register_taxonomy(
			'ss_parts_category',
			'ss_parts',
			array(
				'label' => 'Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_parts_category', 'ss_parts' ); 
	}
	add_action( 'init', 'ss_create_parts_taxonomies' );



	/**
	 *	Custom meta for Parts
	 * 
	 *  Create a custom meta for parts post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_parts_metabox($meta_boxes)
	{

	    $meta_boxes[] = array(
	        'id'       => 'ss_parts',
	        'title'    => 'Link',
	        'pages'    => 'ss_parts',
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
	                'desc'  => '',
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
	add_filter( 'rwmb_meta_boxes', 'ss_parts_metabox' );

	/**
	 *	Register script
	 * 
	 *  widget for single, multiple, open container, and close container
	 *   
	 *	@author heryno
	 */
	function ss_register_part_scripts() {
	    //wp_register_script( 'scrollreveal', plugins_url('../js/scrollreveal.min.js', __FILE__) );
	    wp_register_script( 'wow', plugins_url('../js/wow.min.js', __FILE__) );
	    wp_register_style( 'animate', plugins_url('../style/animate.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_part_scripts' );


	/**
	 *	Register Multiple SS Parts Widget
	 * 
	 *  widget for single, multiple, open container, and close container
	 *   
	 *	@author heryno
	 */
	function register_parts_widgets() {
	    register_widget( 'SS_Part_Widget' );
	    register_widget( 'SS_Parts_Widget' );
	    register_widget( 'SS_Parts_Slider_Widget' );
	    register_widget( 'SS_Parts_Accordion_Widget' );
	    register_widget( 'SS_Container_Open_Widget' );
	    register_widget( 'SS_Container_Close_Widget' );
	}
	add_action( 'widgets_init', 'register_parts_widgets' );


	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show Links content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_part_generate_html($instance){
		//only load js/css file if there is animation
		$animation = $instance['animation'];
		if($animation == null){
			$animation = "0";
		}

		//instance value can be null if we update plugin the old site, 
		//so we need to check null to prevent wow js load on old site if not needed
		if($animation != '0'){ 
			wp_enqueue_script( 'wow' );
			wp_enqueue_style( 'animate' );	
		}

		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];
        $part_id = $instance['part_id'];
        
        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        
        $image_as_link = ($instance['image_as_link'] && $instance['image_as_link'] != 'false') ? true : false;
        $title_as_link = ($instance['title_as_link'] && $instance['title_as_link'] != 'false') ? true : false;
        $hide_image = ($instance['hide_image'] && $instance['hide_image'] != 'false') ? true : false;
        $hide_title = ($instance['hide_title'] && $instance['hide_title'] != 'false') ? true : false;
        $hide_description = ($instance['hide_description'] && $instance['hide_description'] != 'false') ? true : false;
        $hide_link = ($instance['hide_link'] && $instance['hide_link'] != 'false') ? true : false;
        $show_extra_button = ($instance['show_extra_button'] && $instance['show_extra_button'] != 'false') ? true : false;
        $image_size = $instance['image_size'];

        $style = $instance['style'];
        $button_style = $instance['button_style'];

        //animation
        $arr_data_animation = array();
        if($animation != '0'){ 
        	$arr_data_animation['data-wow-offset'] = $instance['offset'];
        	$arr_data_animation['data-wow-delay'] = $instance['delay']."s";
        	$arr_data_animation['data-wow-duration'] = $instance['duration']."s";
        }

	    
	    //prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;
        $arr_container_class[] = $custom_class;
        $arr_container_class[] = $instance['text_align'];

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-part-style-".$style;	
		}

        //-----class related to image
        if($hide_image){
        	$arr_container_class[] = "ss-part-hide-image";
        }

        //-----class related to animation
        if($animation != '0'){
        	$arr_container_class[] = "wow";
        	$arr_container_class[] = $animation;
        }

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        
        //button style
        $str_button_style = "";
        if($button_style > 0){
        	$str_button_style = "ss-btn-style-".$button_style;
        }

        //query parts based on options
        $post = get_post($part_id);


        if($post){
    		$attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id( $part_id ), $image_size);
			$image_url = $attachment_data[0];

			//get meta for link options
			$link = esc_url(do_shortcode(get_post_meta($post->ID, 'ss_parts_url', true)));
			$link_text = get_post_meta($post->ID, 'ss_parts_url_text', true);
			
			//open in new tab option
			$new_tab = get_post_meta($post->ID, 'ss_parts_new_tab', true);
			$str_new_tab = "";
			if($new_tab == "1"){
				$str_new_tab = ' target="_blank" ';
			}
        ?>
        	<?php if($animation != '0'){ ?>
	        	<script type="text/javascript">
	        		jQuery(document).ready(function(){
	        			new WOW().init();	
	        		});
	        	</script>
        	<?php } ?>
			
			<!-- PART WIDGET -->
        	<div id="<?php echo $id; ?>" 
    			class="<?php echo $str_container_class; ?>" 
    			<?php echo ss_print_attributes($arr_data_animation); ?> 
    			>
				
				<!-- FEATURED IMAGE -->
        		<?php if(!$hide_image && $image_url != ""){ ?>
			        <div class="ss-part-image">
			        	<?php if($image_as_link){ ?>
			        		<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>">
			        	<?php } ?>

			        		<img src="<?php echo $image_url; ?>" alt="">
			        	
			        	<?php if($image_as_link){ ?>
			        		</a>
			        	<?php } ?>
			        </div>
		        <?php } ?>
		        
		        <!-- TITLE -->
		        <?php if(!$hide_title){ ?>
		        	<?php if($title_as_link){ ?>
		        		<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="ss-part-title-link">
		        	<?php } ?>

		        	<h2><?php echo $post->post_title; ?></h2>

		        	<?php if($title_as_link){ ?>
		        		</a>
		        	<?php } ?>
		        <?php } ?>
				
				<!-- CONTENT -->
		        <?php if(!$hide_description){ ?>
		        	<p><?php echo do_shortcode(apply_filters("the_content",$post->post_content)); ?></p>
		        <?php } ?>
		        
		        <!-- LINK -->
		        <?php if(!$hide_link && $link != ""){ ?>
		        	<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="btn <?php echo $str_button_style; ?>">
		        		<span>
		        			<?php echo $link_text; ?>
		        		</span>
		        	</a>
		        <?php } ?>
				
				<!-- EXTRA BUTTON -->
		        <?php if($show_extra_button){ ?>
		        	<span class="ss-part-button"></span>
		        <?php } ?>

		    </div>
        
        <?php

        }
	}


	/**
	 *	Add SS Parts Widget
	 * 
	 *  widget to show single part
	 *   
	 *	@author heryno
	 */
	class SS_Part_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_part_widget', 
		        'SS Part', 
		        array( 'description' => 'Show part content', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	    	
	        //echo $args['before_widget'];

	        //display widget content
	        ss_part_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$title = ! empty($instance['title']) ? esc_attr($instance['title']) : '';
	    	$part_ID = ! empty($instance['part_id']) ? esc_attr($instance['part_id']) : '';
	    	$image_size = ! empty($instance['image_size']) ? esc_attr($instance['image_size']) : 'thumbnail';
	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        $text_align = ! empty($instance['text_align']) ? esc_attr($instance['text_align']) : '0';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';
	        $button_style = ! empty($instance['button_style']) ? esc_attr($instance['button_style']) : '0';
	        
	        $animation = ! empty($instance['animation']) ? esc_attr($instance['animation']) : '0';
	        $offset = (! empty($instance['offset'])  || $instance['offset'] === '0') ? $instance['offset'] : 100;
	        $delay = (! empty($instance['delay']) || $instance['delay'] === '0') ? $instance['delay'] : 0.5;
	        $duration = (! empty($instance['duration']) || $instance['duration'] === '0') ? $instance['duration'] : 1;

	        $args = array(
		        'post_type'     	=> 'ss_parts',
		        'posts_per_page'   	=> -1,
		        'orderby'          	=> 'title',
				'order'            	=> 'ASC',
	        );

	        $parts = get_posts($args);
	        
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
	        	1 => 'Text Block',
	        	2 => 'Style 2',
	        	3 => 'Style 3',
	        	4 => 'Style 4',
	        	5 => 'Style 5',
	        	6 => 'Style 6',
	        	7 => 'Style 7',
	        	8 => 'Style 8',
	        	9 => 'Style 9',
	        	10 => 'Style 10',
	        	11 => 'Style 11',
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

	        $arr_animation = array(
	        	'0' => 'No animation',
	        	"bounceIn" => "bounceIn",
	          	"bounceInDown" => "bounceInDown",
	          	"bounceInLeft" => "bounceInLeft",
	          	"bounceInRight" => "bounceInRight",
	          	"bounceInUp" => "bounceInUp",
	          	"fadeIn" => "fadeIn",
				"fadeInDown" => "fadeInDown",
				"fadeInDownBig" => "fadeInDownBig",
				"fadeInLeft" => "fadeInLeft",
				"fadeInLeftBig" => "fadeInLeftBig",
				"fadeInRight" => "fadeInRight",
				"fadeInRightBig" => "fadeInRightBig",
				"fadeInUp" => "fadeInUp",
				"fadeInUpBig" => "fadeInUpBig",
				"flip" => "flip",
				"flipInX" => "flipInX",
				"flipInY" => "flipInY",
				"flipOutX" => "flipOutX",
				"flipOutY" => "flipOutY",
				"lightSpeedIn" => "lightSpeedIn",
				"rotateIn" => "rotateIn",
				"rotateInDownLeft" => "rotateInDownLeft",
				"rotateInDownRight" => "rotateInDownRight",
				"rotateInUpLeft" => "rotateInUpLeft",
				"rotateInUpRight" => "rotateInUpRight",
				"slideInUp" => "slideInUp",
				"slideInDown" => "slideInDown",
				"slideInLeft" => "slideInLeft",
				"slideInRight" => "slideInRight",
				"zoomIn" => "zoomIn",
				"zoomInDown" => "zoomInDown",
				"zoomInLeft" => "zoomInLeft",
				"zoomInRight" => "zoomInRight",
				"zoomInUp" => "zoomInUp",
	        );

	        ?>

		        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="hidden" value="<?php echo $title; ?>" />

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('part_id'); ?>"><?php _e('Part:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('part_id'); ?>" name="<?php echo $this->get_field_name('part_id'); ?>">
			        	<?php foreach ($parts as $part){ ?>
				            <option value="<?php echo $part->ID; ?>" <?php echo selected( $part_ID, $part->ID ); ?> >
			                	<?php echo $part->post_title; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>
	        	
	        	<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['image_as_link'], 'on'); ?> id="<?php echo $this->get_field_id('image_as_link'); ?>" name="<?php echo $this->get_field_name('image_as_link'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('image_as_link'); ?>"><?php _e('Featured Image as Link'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['title_as_link'], 'on'); ?> id="<?php echo $this->get_field_id('title_as_link'); ?>" name="<?php echo $this->get_field_name('title_as_link'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('title_as_link'); ?>"><?php _e('Title as Link'); ?></label>
				</p>

	        	<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_image'], 'on'); ?> id="<?php echo $this->get_field_id('hide_image'); ?>" name="<?php echo $this->get_field_name('hide_image'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_image'); ?>"><?php _e('Hide Featured Image'); ?></label>
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

				<p class="ss-editor-hide">
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_extra_button'], 'on'); ?> id="<?php echo $this->get_field_id('show_extra_button'); ?>" name="<?php echo $this->get_field_name('show_extra_button'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_extra_button'); ?>"><?php _e('Show Extra Button'); ?></label>
				</p>

				<p>
		        	<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Featured Image Size:'); ?></label>
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

	        	<hr class="ss-editor-hide" />

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

				<br class="ss-editor-hide"/>

		        <p>
	        		<h4>Animation</h4>
	        	</p>

	        	<hr/>

	        	<p>
		        	<label for="<?php echo $this->get_field_id('animation'); ?>"><?php _e('Animation:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('animation'); ?>" name="<?php echo $this->get_field_name('animation'); ?>">
			        	<?php foreach ($arr_animation as $index => $available_animation){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $animation, $index ); ?> >
			                	<?php echo $available_animation; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Offset:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" size="3" />
		        	px 
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('delay'); ?>"><?php _e('Delay:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('delay'); ?>" name="<?php echo $this->get_field_name('delay'); ?>" type="text" value="<?php echo $delay; ?>" size="3" />
		        	second/s 
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('duration'); ?>"><?php _e('Duration:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('duration'); ?>" name="<?php echo $this->get_field_name('duration'); ?>" type="text" value="<?php echo $duration; ?>" size="3" />
		        	second/s 
		        </p>
	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['part_id'] = strip_tags($new_instance['part_id']);
	        
	        $instance['image_as_link'] = $new_instance['image_as_link'];
	        $instance['title_as_link'] = $new_instance['title_as_link'];

	        $instance['hide_title'] = $new_instance['hide_title'];
	        $instance['hide_description'] = $new_instance['hide_description'];
	        $instance['hide_image'] = $new_instance['hide_image'];
	        $instance['hide_link'] = $new_instance['hide_link'];
	        $instance['show_extra_button'] = $new_instance['show_extra_button'];
	        $instance['image_size'] = strip_tags($new_instance['image_size']);

	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	$instance['text_align'] = strip_tags($new_instance['text_align']);
	       	$instance['style'] = strip_tags($new_instance['style']);
	       	$instance['button_style'] = strip_tags($new_instance['button_style']);

	       	$instance['animation'] = strip_tags($new_instance['animation']);
	       	$instance['offset'] = $new_instance['offset']; 
	       	$instance['delay'] = $new_instance['delay']; 
	       	$instance['duration'] = $new_instance['duration']; 

	       	//query parts based on options
        	$post = get_post($instance['part_id']);
        	$instance['title'] = strip_tags($post->post_title);

	        return $instance;
	    }
	}


	/**
	 * Run Part shortcode
	 * 
	 * @return html content
	 */
	function ss_part_shortcode($atts)
	{
	    $default_atts = array(
	    	'part_id' => '',
	    	'image_as_link' => NULL,
	    	'title_as_link' => NULL,
	    	'hide_title' => NULL,
	    	'hide_description' => NULL,
	    	'hide_image' => NULL,
	    	'hide_link' => NULL,
	    	'show_extra_button' => NULL,
	    	'image_size' => 'thumbnail',
	    	//layout & styling
	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'text_align' => 'text-left',
	    	'style' => '0',
	    	'button_style' => '0',
	    	//animation
	    	'animation' => '0',
	    	'offset' => "100",
	    	'delay' => "0.5",
	    	'duration' => "1",
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();
	    
	    //display widget content
	    ss_part_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_part', 'ss_part_shortcode');




	/**
	 *	Add SS Parts Widget
	 * 
	 *  widget to print container open HTML
	 *   
	 *	@author heryno
	 */
	class SS_Container_Open_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_container_open_widget', 
		        'SS Container Open', 
		        array( 'description' => '', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	        $custom_class = $instance['custom_class'];
        	$custom_id = $instance['custom_id'];

	        //prepare id
			if($custom_id != ""){
				$id = $custom_id;
			}

	    	echo "<div id='".$id."' class='".$custom_class." ".$instance['classname']."'>";
	        //echo $args['before_widget'];

	        //display widget content
	        

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        
	        ?>

		        <p>
		        	<label for="<?php echo $this->get_field_id('custom_class'); ?>"><?php _e('Custom Container Class:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_class'); ?>" name="<?php echo $this->get_field_name('custom_class'); ?>" type="text" value="<?php echo $custom_class; ?>" />
		        </p>
	        	
	        	<p>
		        	<label for="<?php echo $this->get_field_id('custom_id'); ?>"><?php _e('Custom Container ID:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" type="text" value="<?php echo $custom_id; ?>" />
		        </p>

	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	return $instance;
	    }
	}



	/**
	 *	Add SS Parts Widget
	 * 
	 *  widget to print container close HTML
	 *   
	 *	@author heryno
	 */
	class SS_Container_Close_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_container_close_widget', 
		        'SS Container Close', 
		        array( 'description' => '', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	echo "</div>";
	    }

	    //Back-end widget form.
	    public function form( $instance ) {
	    	
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	       	return $instance;
	    }
	}
?>