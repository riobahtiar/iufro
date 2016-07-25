<?php
	function ss_register_page_style() {
	    wp_register_style( 'ss-page-style', plugins_url('../style/ss-page.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_page_style' );

	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show Links content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_page_generate_html($instance){
		wp_enqueue_style( 'ss-page-style' );

		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];
        $page_id = $instance['page_id'];
        
        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        
        $image_as_link = ($instance['image_as_link'] && $instance['image_as_link'] != 'false') ? true : false;
        $title_as_link = ($instance['title_as_link'] && $instance['title_as_link'] != 'false') ? true : false;
        $hide_image = ($instance['hide_image'] && $instance['hide_image'] != 'false') ? true : false;
        $hide_title = ($instance['hide_title'] && $instance['hide_title'] != 'false') ? true : false;
        $hide_description = ($instance['hide_description'] && $instance['hide_description'] != 'false') ? true : false;
        $hide_link = ($instance['hide_link'] && $instance['hide_link'] != 'false') ? true : false;
        $link_text = $instance['link_text'];
        $image_size = $instance['image_size'];

        $style = $instance['style'];
	    
	    //prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;
        $arr_container_class[] = $custom_class;

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-page-style-".$style;	
		}

        //-----class related to image
        if($hide_image){
        	$arr_container_class[] = "ss-page-hide-image";
        }

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        
        //query links based on options
        $post = get_post($page_id);


        if($post){
    		$attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id( $page_id ), $image_size);
			$image_url = $attachment_data[0];

			$link = get_permalink($post);
        ?>
        
        	<div id="<?php echo $id; ?>" class="<?php echo $str_container_class; ?>">
        		<?php if(!$hide_image && $image_url != ""){ ?>
			        <div class="ss-page-image">
			        	<?php if($image_as_link){ ?>
			        		<a href="<?php echo $link; ?>">
			        	<?php } ?>

			        		<img src="<?php echo $image_url; ?>" alt="">
			        	
			        	<?php if($image_as_link){ ?>
			        		</a>
			        	<?php } ?>
			        </div>
		        <?php } ?>

		        <?php if(!$hide_title){ ?>
		        	<?php if($title_as_link){ ?>
		        		<a href="<?php echo $link; ?>" class="ss-page-title-link">
		        	<?php } ?>

		        	<h2><?php echo $post->post_title; ?></h2>

		        	<?php if($title_as_link){ ?>
		        		</a>
		        	<?php } ?>
		        <?php } ?>

		        <?php if(!$hide_description){ ?>
		        	<p><?php echo do_shortcode(apply_filters("the_content",$post->post_content)); ?></p>
		        <?php } ?>

		        <?php if(!$hide_link){ ?>
		        	<a href="<?php echo $link; ?>" class="btn"><?php echo $link_text; ?></a>
		        <?php } ?>

		    </div>
        
        <?php

        }
	}



	/**
	 *	Add SS Page Widget
	 * 
	 *  widget to show single page
	 *   
	 *	@author heryno
	 */
	class SS_Page_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_page_widget', 
		        'SS Page', 
		        array( 'description' => 'Show page content', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	    	
	        //echo $args['before_widget'];

	        //display widget content
	        ss_page_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$title = ! empty($instance['title']) ? esc_attr($instance['title']) : '';
	    	$page_ID = ! empty($instance['page_id']) ? esc_attr($instance['page_id']) : '';
	        $link_text = ! empty($instance['link_text']) ? esc_attr($instance['link_text']) : 'See more';
	        $image_size = ! empty($instance['image_size']) ? esc_attr($instance['image_size']) : 'thumbnail';
	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';

	        $args = array(
		        'post_type'     	=> 'page',
		        'posts_per_page'   	=> -1,
		        'orderby'          	=> 'title',
				'order'            	=> 'ASC',
	        );

	        $pages = get_posts($args);
	        
	        $arr_image_size = array(
	        	'thumbnail' => 'Thumbnail',
	        	'medium' => 'Medium',
	        	'large' => 'Large',
	        	'full' => 'Original Size',
	        );

	        $arr_style = array(
	        	0 => 'Default',
	        );

	        ?>
	        	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="hidden" value="<?php echo $title; ?>" />

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('page_id'); ?>" name="<?php echo $this->get_field_name('page_id'); ?>">
			        	<?php foreach ($pages as $page){ ?>
				            <option value="<?php echo $page->ID; ?>" <?php echo selected( $page_ID, $page->ID ); ?> >
			                	<?php echo $page->post_title; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>
	        	
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
		        	<label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link Text:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo $link_text; ?>" />
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

		        <p>
	        		<h4>Layout &amp; Styling</h4>
	        	</p>

	        	<hr/>

		        <p>
		        	<label for="<?php echo $this->get_field_id('custom_class'); ?>"><?php _e('Custom Container Class:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_class'); ?>" name="<?php echo $this->get_field_name('custom_class'); ?>" type="text" value="<?php echo $custom_class; ?>" />
		        </p>
	        	
	        	<p>
		        	<label for="<?php echo $this->get_field_id('custom_id'); ?>"><?php _e('Custom Container ID:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" type="text" value="<?php echo $custom_id; ?>" />
		        </p>

	        	<p>
		        	<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
			        	<?php foreach ($arr_style as $index => $available_style){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $style, $index ); ?> >
			                	<?php echo $available_style; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['page_id'] = strip_tags($new_instance['page_id']);

	        $instance['image_as_link'] = $new_instance['image_as_link'];
	        $instance['title_as_link'] = $new_instance['title_as_link'];

	        $instance['hide_image'] = $new_instance['hide_image'];
	        $instance['hide_title'] = $new_instance['hide_title'];
	        $instance['hide_description'] = $new_instance['hide_description'];
	        $instance['hide_link'] = $new_instance['hide_link'];
	        $instance['link_text'] = ( ! empty( $new_instance['link_text'] ) ) ? strip_tags( $new_instance['link_text'] ) : '';
	        $instance['image_size'] = strip_tags($new_instance['image_size']);

	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	$instance['style'] = strip_tags($new_instance['style']);

	       	//query links based on options
        	$post = get_post($instance['page_id']);
        	$instance['title'] = strip_tags($post->post_title);

	        return $instance;
	    }
	}

	function register_pages_widgets() {
	    register_widget( 'SS_Page_Widget' );
	    register_widget( 'SS_Current_Page_Widget' );

	    //add register new widget here
	}
	add_action( 'widgets_init', 'register_pages_widgets' );


	/**
	 * Run Page shortcode
	 * 
	 * @return html content
	 */
	function ss_page_shortcode($atts)
	{
	    $default_atts = array(
	    	'page_id' => '',
	    	'image_as_link' => NULL,
	    	'title_as_link' => NULL,
	    	'hide_image' => NULL,
	    	'hide_title' => NULL,
	    	'hide_description' => NULL,
	    	'hide_link' => NULL,
	    	'link_text' => '',
	    	'image_size' => 'thumbnail',
	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

		//display widget content
	    ss_page_generate_html($atts);
	}

	add_shortcode('ss_page', 'ss_page_shortcode');







	//---------------------------------Widget show current page/post content--------------------------------
	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show Links content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_current_page_generate_html($instance){
		wp_enqueue_style( 'ss-page-style' );

		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];
        
        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        
        $show_image = ($instance['show_image'] && $instance['show_image'] != 'false') ? true : false;
        $show_title = ($instance['show_title'] && $instance['show_title'] != 'false') ? true : false;
        $show_author = ($instance['show_author'] && $instance['show_author'] != 'false') ? true : false;
        $show_date = ($instance['show_date'] && $instance['show_date'] != 'false') ? true : false;
        $show_comment_number = ($instance['show_comment_number'] && $instance['show_comment_number'] != 'false') ? true : false;
        $show_description = ($instance['show_description'] && $instance['show_description'] != 'false') ? true : false;
        $image_size = $instance['image_size'];

        $style = $instance['style'];
	    
	    //prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;
        $arr_container_class[] = $custom_class;

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-current-page-style-".$style;	
		}

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        ?>
        	
        	
        	<?php if(($show_image && has_post_thumbnail()) || $show_title || $show_author || $show_date || $show_comment_number || $show_description){ ?>
	        	<div id="<?php echo $id; ?>" class="ss-current-page <?php echo $str_container_class; ?>">
	        		
	        		<?php if($show_image){ ?>
		        		<div class="post-thumbnail">
		                    <?php the_post_thumbnail($image_size); ?>
		                </div>
	                <?php } ?>

	                <?php if($show_title){ ?>
	                	<?php the_title( '<h2 class="post-title">', '</h2>' ); ?>
	                <?php } ?>

	                <?php if($show_author){ ?>
	                	<span class="post-author">
	                		<?php the_author(); ?>
	                	</span>
	                <?php } ?>

	                <?php if($show_date){ ?>
	               		<span class="post-date">
	                		<?php the_date(); ?>
	                	</span>
	                <?php } ?>

	                <?php if($show_comment_number){ ?>
	                	<span class="post-comments-number">
	               			<?php comments_number(); ?>
	               		</span>
	                <?php } ?>

	                <?php if($show_description){ ?>
		                <div class="post-entry">
		                    <?php the_content(); ?>
		                </div>
	                <?php } ?>

			    </div>
        	<?php } ?>


        <?php

        
	}


	/**
	 *	Add SS Current Post/Page Widget
	 * 
	 *  widget to show single page
	 *   
	 *	@author heryno
	 */
	class SS_Current_Page_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_current_page_widget', 
		        'SS Current Page/Post', 
		        array( 'description' => 'Show current page/post content', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	    	
	        //echo $args['before_widget'];

	        //display widget content
	        ss_current_page_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	        $image_size = ! empty($instance['image_size']) ? esc_attr($instance['image_size']) : 'thumbnail';

	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';
	       
	        $arr_image_size = array(
	        	'thumbnail' => 'Thumbnail',
	        	'medium' => 'Medium',
	        	'large' => 'Large',
	        	'full' => 'Original Size',
	        );

	        $arr_style = array(
	        	0 => 'Default',
	        );

	        ?>
	        	
				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?> id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show Image'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_title'], 'on'); ?> id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e('Show Title'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_author'], 'on'); ?> id="<?php echo $this->get_field_id('show_author'); ?>" name="<?php echo $this->get_field_name('show_author'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_author'); ?>"><?php _e('Show Author'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_date'], 'on'); ?> id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show Date'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_comment_number'], 'on'); ?> id="<?php echo $this->get_field_id('show_comment_number'); ?>" name="<?php echo $this->get_field_name('show_comment_number'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_comment_number'); ?>"><?php _e('Show Comment Number'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_description'], 'on'); ?> id="<?php echo $this->get_field_id('show_description'); ?>" name="<?php echo $this->get_field_name('show_description'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_description'); ?>"><?php _e('Show Content'); ?></label>
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

		        <p>
	        		<h4>Layout &amp; Styling</h4>
	        	</p>

	        	<hr/>

		        <p>
		        	<label for="<?php echo $this->get_field_id('custom_class'); ?>"><?php _e('Custom Container Class:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_class'); ?>" name="<?php echo $this->get_field_name('custom_class'); ?>" type="text" value="<?php echo $custom_class; ?>" />
		        </p>
	        	
	        	<p>
		        	<label for="<?php echo $this->get_field_id('custom_id'); ?>"><?php _e('Custom Container ID:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" type="text" value="<?php echo $custom_id; ?>" />
		        </p>

	        	<p>
		        	<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
			        	<?php foreach ($arr_style as $index => $available_style){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $style, $index ); ?> >
			                	<?php echo $available_style; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        
	        $instance['show_image'] = $new_instance['show_image'];
	        $instance['show_title'] = $new_instance['show_title'];
	        $instance['show_author'] = $new_instance['show_author'];
	        $instance['show_date'] = $new_instance['show_date'];
	        $instance['show_comment_number'] = $new_instance['show_comment_number'];
	        $instance['show_description'] = $new_instance['show_description'];
	        $instance['image_size'] = strip_tags($new_instance['image_size']);

	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	$instance['style'] = strip_tags($new_instance['style']);

	        return $instance;
	    }
	}


	/**
	 * Run Page shortcode
	 * 
	 * @return html content
	 */
	function ss_current_page_shortcode($atts)
	{
	    $default_atts = array(
	    	'show_image' => NULL,
	    	'show_title' => NULL,
	    	'show_author' => NULL,
	    	'show_date' => NULL,
	    	'show_comment_number' => NULL,
	    	'show_description' => NULL,
	    	'image_size' => 'thumbnail',
	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();

		//display widget content
	    ss_current_page_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_current_page', 'ss_current_page_shortcode');

?>