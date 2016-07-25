<?php

	/**
	 *	Custom post type - Links
	 * 
	 *  This post type can be use for showing brand/affiliate logo + url
	 * 
	 *	@author heryno
	 */
	function ss_create_links_post_type() {
	    register_post_type( 'ss_links',
	        array(
	            'labels' => array(
	                'name'                => 'Links',
	                'singular_name'       => 'Link',
	            ),
	            'public'        => true,
	            'menu_position' => 11, //under media
	            'supports'      => array('title', 'editor', 'thumbnail', 'taxonomy', 'excerpt', 'page-attributes'),
	            'menu_icon'     => 'dashicons-admin-links'
	        )
	    );

	    wp_register_style( 'ss-links-style', plugins_url('../style/ss-links.css', __FILE__) );
	    add_theme_support( 'post-thumbnails' );
	}
	add_action( 'init', 'ss_create_links_post_type' );


	/**
	 *	Custom category for Links
	 * 
	 *  Create a custom category for links post type so we can add/choose category for each link
	 * 
	 *	@author heryno
	 */
	function ss_create_links_taxonomies() {
		register_taxonomy(
			'ss_links_category',
			'ss_links',
			array(
				'label' => 'Categories',
				'show_in_quick_edit' => true,
				'show_admin_column' => true,
				'hierarchical' => true,
				'query_var' => true
			)
		);

		//just to be safe, interconnect taxonomy and custom post type
		register_taxonomy_for_object_type( 'ss_links_category', 'ss_links' ); 
	}
	add_action( 'init', 'ss_create_links_taxonomies' );



	/**
	 *	Custom meta for Links
	 * 
	 *  Create a custom meta for links post type using metabox.io
	 * 
	 *  Required metabox.io plugin
	 *	@author heryno
	 */
	function ss_links_metabox($meta_boxes)
	{
	    $prefix = 'ss_';

	    $meta_boxes[] = array(
	        'id'       => 'ss_links',
	        'title'    => 'Link and Logo',
	        'pages'    => 'ss_links',
	        'context'  => 'normal',
	        'priority' => 'high',
	        'fields' => array(
	            array(
	                'name'  => 'Link to',
	                'desc'  => 'url sample : http://www.example.com',
	                'id'    => 'ss_links_url',
	                'type'  => 'url',
	                'std'   => '',
	                'class' => 'widefat',
	                'clone' => false,
	            ),
	            array(
	                'name'  => 'Secondary Image',
	                'desc'  => '(optional) use for hover and other animations',
	                'id'    => 'ss_links_secondary_image',
	                'type'  => 'image_advanced',
	                'std'   => '',
	                'class' => '',
	                'clone' => false,
	            )
	        )
	    );
	    return $meta_boxes;
	}
	add_filter( 'rwmb_meta_boxes', 'ss_links_metabox' );



	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show Links content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_links_generate_html($instance){
		wp_enqueue_style( 'ss-links-style' );

		//prepare widget options variable
        //$title = apply_filters( 'widget_title', $instance['title'] );
        $text = $instance['text'];
        $category = $instance['category'];
        $number = $instance['number'];
        if($number == 0){ //when user input number 0, that mean show all posts
        	$number = -1; //set number for posts per page to -1 to show all posts
        }
        $order_by = $instance['order_by'];
        $order = $instance['order'];
        
        $custom_class = $instance['custom_class'];
        $number_of_column = $instance['number_of_column'];
        $number_of_column_tablet = $instance['number_of_column_tablet'];
        $number_of_column_mobile = $instance['number_of_column_mobile'];
        $min_height = $instance['min_height'];

        $link_title = $instance['link_title'];
        $hide_image = ($instance['hide_image'] && $instance['hide_image'] != 'false') ? true : false;
        $disable_link = $instance['disable_link'] ? true : false;
        $style = $instance['style'];
	       
		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        //-----custom class
        $arr_container_class[] = $custom_class;

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-links-style-".$style;	
		}

        //-----class related to title position
        if($link_title == 'top'){
        	$arr_container_class[] = 'ss-links-show-title-top';	
        }else if($link_title == 'bottom'){
        	$arr_container_class[] = 'ss-links-show-title-bottom';
        }else{
        	$arr_container_class[] = 'ss-links-hide-title';
        }

        //-----class related to image
        if($hide_image){
        	$arr_container_class[] = "ss-links-hide-image";
        }

        //-----class related to column
        if ( $number_of_column > 0 ) {
        	$arr_container_class[] = "ss-links-".$number_of_column."-col ";
        }
        if ( $number_of_column_tablet > 0 ) {
        	$arr_container_class[] = "ss-links-".$number_of_column_tablet."-col-tb ";
        }
        if ( $number_of_column_mobile > 0 ) {
        	$arr_container_class[] = "ss-links-".$number_of_column_mobile."-col-mb ";
        }

        //-----implode all class name to string
        $str_setting_style = implode(" ", $arr_container_class);

        //style for container min height if specify
        if($min_height != '' && $min_height != 0){
        	$str_min_height = " style='min-height:".$min_height."px' ";
        }
        

        //query links based on options
        $query = array(
	        'posts_per_page' => $number,
	        'post_type'     => 'ss_links',
	        'order'         => $order,
	        'orderby'		=> $order_by
        );

        if($category != ''){
        	$query['tax_query'] = array(
        							'relation' => 'OR',
						            array(
					                    'taxonomy' => 'ss_links_category',
					                    'field' => 'term_id',
					                    'terms' => $category
						            ),
						            array(
					                    'taxonomy' => 'ss_links_category',
					                    'field' => 'slug',
					                    'terms' => $category
						            )
								);
        }

        $query_posts = new WP_Query( $query );
        

        //-----------------------------PRINT CONTENT--------------------------------
        //looping links
        if ( $query_posts->have_posts() ) {

        	echo "<span class='ss-links-widget-text'>".$text."</span>";
	        	
	        echo '<ul class="ss-links-container '.$str_setting_style.'">';
	        
	        while ( $query_posts->have_posts() ) {
	            $query_posts->the_post();
	            
	            //get feature image
	            $attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
    			$image_url = $attachment_data[0];

    			//get extra meta
	            $link = get_post_meta(get_the_ID(), 'ss_links_url', true);
	            $secondary_image = get_post_meta(get_the_ID(), 'ss_links_secondary_image', true);

	            echo '<li>';

	            //a tag or div tag depends on widget setting
	            if($disable_link){
	            	echo "<div class='ss-links-single-container'>";
	            }else{
	            	echo "<a class='ss-links-single-container' href='". $link ."' target='_blank'>";	
	            }
	            
	            //title above
	            if( $link_title == 'top' ){
	            	echo "<span class='ss-links-title ss-links-title-top'>".get_the_title()."</span>";
	            }

	            //img tag depends on widget setting and if links has thumbnail
	            if ( !$hide_image && has_post_thumbnail() ) {
	                echo "<span class='ss-links-img-container' ".$str_min_height." >";
	                echo "<img src='" .$image_url. "' />";
	                echo "</span>";
	            }

	            //title below
	            if( $link_title == 'bottom' ){
	            	echo "<span class='ss-links-title ss-links-title-bottom'>".get_the_title()."</span>";
	            }

	            //closing a tag or div tag depends on widget setting
	            if($disable_link){
	            	echo "</div>";
	            }else{
	            	echo '</a>';	
	            }

	            echo '</li>';
	        }

	        echo '</ul>';
    	}

        //Restore original Post Data
		wp_reset_postdata();
	}



	/**
	 *	Add SS Links Widget
	 * 
	 *  widget to show links base on category
	 *   
	 *	@author heryno
	 */
	class SS_links_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_links_widget', 
		        __('SS Links', 'ss_links_domain'), 
		        array( 'description' => __( 'Show links', 'ss_links_domain' ), ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$title = apply_filters( 'widget_title', $instance['title'] );

	    	
	        echo $args['before_widget'];
	        
	        //display title if not empty/just space
	        if ( ! empty( $title ) && trim($title) != "" ){
	        	echo "<span class='ss-links-widget-title'>".$args['before_title'] . $title . $args['after_title']."</span>";	
	        }

	        //display widget content
	        ss_links_generate_html($instance);

	        echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Links', 'text_domain' );
	        $text = ! empty($instance['text']) ? esc_attr($instance['text']) : '';
	        $category = ! empty($instance['category']) ? esc_attr($instance['category']) : '';
	        $number = ! empty($instance['number']) ? absint($instance['number']) : 0;
	        $order_by = ! empty($instance['order_by']) ? esc_attr($instance['order_by']) : 'ID';
	        $order = ! empty($instance['order']) ? esc_attr($instance['order']) : 'ASC';
	        $link_title = ! empty($instance['link_title']) ? esc_attr($instance['link_title']) : 'hide';
	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $number_of_column = ! empty($instance['number_of_column']) ? absint($instance['number_of_column']) : 0;
	        $number_of_column_tablet = ! empty($instance['number_of_column_tablet']) ? absint($instance['number_of_column_tablet']) : 0;
	        $number_of_column_mobile = ! empty($instance['number_of_column_mobile']) ? absint($instance['number_of_column_mobile']) : 0;
	        $min_height = ! empty($instance['min_height']) ? absint($instance['min_height']) : 0;
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';

	        $args = array(
		        'type'     =>'ss_links',
		        'taxonomy'    =>'ss_links_category'
	        );
	        $categories = get_categories($args);
	        
	        $arr_style = array(
	        	0 => 'Default',
	        	1 => 'Opacity',
	        	2 => 'Grayscale',
	        	3 => 'Sepia',
	        );

	        ?>

		        <p>
		        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		        	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label> 
		        	<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" ><?php echo $text; ?></textarea>
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
			        <?php
				        foreach ($categories as $cat){
				            echo '<option value="' . $cat->cat_ID . '"'.($category == $cat->cat_ID ? 'selected' : '').' >' . $cat->name . '</option>';
				        }
			        ?>
		        	</select>
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of links:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="2" />
		        	(put 0 to show all links) 
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order by:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
		            	<option value = "ID" <?php echo ($order_by == "ID" ? 'selected' : '') ?> >ID</option>
		            	<option value = "title" <?php echo ($order_by == "title" ? 'selected' : '') ?> >Title</option>
		            	<option value = "menu_order" <?php echo ($order_by == "menu_order" ? 'selected' : '') ?> >Order Value</option>
		        	</select>
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		            	<option value = "ASC" <?php echo ($order == "ASC" ? 'selected' : '') ?> >Ascending</option>
		            	<option value = "DESC" <?php echo ($order == "DESC" ? 'selected' : '') ?> >Descending</option>
		        	</select>
		        </p>

		        <br/>

	        	<p>
	        		<h4>Individual Link</h4>
	        	</p>

	        	<hr/>
	        	
	        	<p>
		        	<label for="<?php echo $this->get_field_id('link_title'); ?>"><?php _e('Link title:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('link_title'); ?>" name="<?php echo $this->get_field_name('link_title'); ?>">
		            	<option value = "hide" <?php echo ($link_title == "hide" ? 'selected' : '') ?> >Don't Show</option>
		            	<option value = "top" <?php echo ($link_title == "top" ? 'selected' : '') ?> >Above Image</option>
		            	<option value = "bottom" <?php echo ($link_title == "bottom" ? 'selected' : '') ?> >Below Image</option>
		        	</select>
		        </p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_image'], 'on'); ?> id="<?php echo $this->get_field_id('hide_image'); ?>" name="<?php echo $this->get_field_name('hide_image'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_image'); ?>"><?php _e('Hide Image'); ?></label>
				</p>

				<p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['disable_link'], 'on'); ?> id="<?php echo $this->get_field_id('disable_link'); ?>" name="<?php echo $this->get_field_name('disable_link'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('disable_link'); ?>"><?php _e('Disable Link'); ?></label>
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
		        	<label for="<?php echo $this->get_field_id('number_of_column'); ?>"><?php _e('Number of column for desktop:'); ?></label>
		        	<select id="<?php echo $this->get_field_id( 'number_of_column' ); ?>" name="<?php echo $this->get_field_name( 'number_of_column' ); ?>" >	
		            	<!-- Generate all items of drop-down list -->
		            	<?php for ( $j = 0; $j <= 20; $j++ ) { ?>
			                <option value="<?php echo $j; ?>" <?php echo selected( $number_of_column, $j ); ?> >
			                	<?php echo $j; ?>
			                </option>
		                <?php } ?>
		        	</select>
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id('number_of_column_tablet'); ?>"><?php _e('Number of column for tablet:'); ?></label> &nbsp;&nbsp;
		        	<select id="<?php echo $this->get_field_id( 'number_of_column_tablet' ); ?>" name="<?php echo $this->get_field_name( 'number_of_column_tablet' ); ?>" >	
			            <!-- Generate all items of drop-down list -->
			            <?php for ( $j = 0; $j <= 10; $j++ ) { ?>
			                <option value="<?php echo $j; ?>" <?php echo selected( $number_of_column_tablet, $j ); ?> >
			                	<?php echo $j; ?>
			                </option>
		                <?php } ?>
		             </select>
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id('number_of_column_mobile'); ?>"><?php _e('Number of column for mobile:'); ?></label> &nbsp;
		        	<select id="<?php echo $this->get_field_id( 'number_of_column_mobile' ); ?>" name="<?php echo $this->get_field_name( 'number_of_column_mobile' ); ?>" >	
			            <!-- Generate all items of drop-down list -->
			            <?php for ( $j = 0; $j <= 10; $j++ ) { ?>
			                <option value="<?php echo $j; ?>" <?php echo selected( $number_of_column_mobile, $j ); ?> >
			                	<?php echo $j; ?>
			                </option>
			            <?php } ?>
		            </select>
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id('min_height'); ?>"><?php _e('Container min height:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('min_height'); ?>" name="<?php echo $this->get_field_name('min_height'); ?>" type="text" value="<?php echo $min_height; ?>" size="4" />
		        	px (put 0 not specify) 
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
	        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	        $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';

	        $instance['category'] = strip_tags($new_instance['category']);
	        $instance['order_by'] = strip_tags($new_instance['order_by']);
	        $instance['order'] = strip_tags($new_instance['order']);
	        $instance['number'] = filter_var($new_instance['number'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        
	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['number_of_column'] = filter_var($new_instance['number_of_column'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        $instance['number_of_column_tablet'] = filter_var($new_instance['number_of_column_tablet'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        $instance['number_of_column_mobile'] = filter_var($new_instance['number_of_column_mobile'], FILTER_SANITIZE_NUMBER_INT); //get only number
			$instance['min_height'] = filter_var($new_instance['min_height'], FILTER_SANITIZE_NUMBER_INT); //get only number

	        $instance['link_title'] = strip_tags($new_instance['link_title']);
	        $instance['hide_image'] = $new_instance['hide_image'];
	        $instance['disable_link'] = $new_instance['disable_link'];
	        $instance['style'] = strip_tags($new_instance['style']);

	        return $instance;
	    }
	}

	function register_links_widgets() {
	    register_widget( 'SS_links_Widget' );

	    //add register new widget here
	}
	add_action( 'widgets_init', 'register_links_widgets' );


	/**
	 * Run Links shortcode
	 * 
	 * @return html content
	 */
	function ss_links_shortcode($atts)
	{
	    $default_atts = array(
	    	'text' => '',
	    	'category' => '',
	    	'number' => '0',
	    	'order_by' => 'ID',
	    	'order' => 'ASC',
	    	'link_title' => 'hide',
	    	'hide_image' => NULL,
	    	'disable_link' => NULL,
	    	'custom_class' => '',
	    	'number_of_column' => '1',
	    	'number_of_column_tablet' => '1',
	    	'number_of_column_mobile' => '1',
	    	'min_height' => '0',
	    	'style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();

		//display widget content
	    ss_links_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_links', 'ss_links_shortcode');

?>