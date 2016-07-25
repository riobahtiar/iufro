<?php
	function ss_register_parts_accordion_style() {
	    wp_register_style( 'ss-parts-accordion-style', plugins_url('../style/ss-parts-accordion.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_parts_accordion_style' );

	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show parts content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_parts_accordion_generate_html($instance){
		wp_enqueue_style( 'ss-parts-accordion-style' );

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
        $initial_state = $instance['initial_state'];

        //individual link setting
        $image_as_link = ($instance['image_as_link'] && $instance['image_as_link'] != 'false') ? true : false;
        $hide_image = ($instance['hide_image'] && $instance['hide_image'] != 'false') ? true : false;
        $hide_description = ($instance['hide_description'] && $instance['hide_description'] != 'false') ? true : false;
        $hide_link = ($instance['hide_link'] && $instance['hide_link'] != 'false') ? true : false;
        $image_size = $instance['image_size'];

        //layout and styling
        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
		$style = $instance['style'];
        $button_style = $instance['button_style'];
	    

	    //prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;
        $arr_container_class[] = $custom_class;
        $arr_container_class[] = 'widget';
        $arr_container_class[] = $instance['text_align'];

		if($style > 0){
			$arr_container_class[] = "ss-parts-accordion-style-".$style;	
		}

        //-----class related to image
        if($hide_image){
        	$arr_container_class[] = "ss-parts-accordion-hide-image";
        }

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);


        //button style
        $str_button_style = "";
        if($button_style > 0){
        	$str_button_style = "ss-btn-style-".$button_style;
        }

        //query parts based on options
        $query = array(
	        'posts_per_page' => $number,
	        'post_type'     => 'ss_parts',
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
						            )
								);
        }

        $query_posts = new WP_Query( $query );

        //-----------------------------PRINT CONTENT--------------------------------

        ?>
        

		<?php if ( $query_posts->have_posts() ) { ?>
			<div id="<?php echo $id; ?>" class="<?php echo $str_container_class; ?>">

				<?php if($instance['main_title'] != ""){ ?>
		    		<h2 class='ss-parts-accordion-main-title'><?php echo $instance['main_title']; ?></h2>
		    	<?php } ?>

				<div class="panel-group" id="accordion-<?php echo $id; ?>" >
					  
					<?php
						$posts = $query_posts->get_posts();

						$first_part = true;

			        	foreach ($posts as $post) {
			        		$part_id = $post->ID;
			        		$attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id( $part_id ), $image_size);
							$image_url = $attachment_data[0];

							$link = do_shortcode(get_post_meta($post->ID, 'ss_parts_url', true));
							$link_text = get_post_meta($post->ID, 'ss_parts_url_text', true);

							$first_part_class = "";
							if(($first_part && $initial_state == 'first') || $initial_state == 'expand'){
								$first_part_class = "in";
								$first_part = false;
							}
					?>

					  	<div class="panel panel-default ss-parts-accordion-single-part">
						    <div class="panel-heading">
						      <a class="panel-title" data-toggle="collapse" data-parent="#accordion-<?php echo $id; ?>" href="#<?php echo $id.'-part-'.$part_id; ?>">
						        <?php echo $post->post_title; ?>
						      </a>
						    </div>

						    <div id="<?php echo $id.'-part-'.$part_id; ?>" class="panel-body collapse <?php echo $first_part_class; ?>">
						    	<div class="accordion-inner">
						        	
						        	<?php if(!$hide_image && $image_url != ""){ ?>
								        <div class="ss-parts-accordion-image">
								        	<?php if($image_as_link){ ?>
								        		<a href="<?php echo $link; ?>">
								        	<?php } ?>

								        		<img src="<?php echo $image_url; ?>" alt="">
								        	
								        	<?php if($image_as_link){ ?>
								        		</a>
								        	<?php } ?>
								        </div>
							        <?php } ?>
							        

							        <?php if(!$hide_description){ ?>
							        	<p><?php echo do_shortcode(apply_filters("the_content",$post->post_content)); ?></p>
							        <?php } ?>

							        <?php if(!$hide_link && $link != ""){ ?>
							        	<a href="<?php echo $link; ?>" class="btn <?php echo $str_button_style; ?>">
							        		<span>
							        			<?php echo $link_text; ?>
							        		</span>
							        	</a>
							        <?php } ?>

						    	</div>
						    </div>
					  	</div>

					<?php } ?>

				</div>
			</div>

		<?php } ?>

        <?php

        return true;

	}



	/**
	 *	Add SS Parts Accordion Widget
	 * 
	 *  widget to show multiple part as accordion
	 *   
	 *	@author heryno
	 */
	class SS_Parts_Accordion_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_parts_accordion_widget', 
		        'SS Parts Accordion', 
		        array( 'description' => 'Show parts content as accordion', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	    	
	        //echo $args['before_widget'];

	        //display widget content
	        ss_parts_accordion_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$title = ! empty($instance['title']) ? esc_attr($instance['title']) : '';
	    	
	    	$main_title = ! empty($instance['main_title']) ? esc_attr($instance['main_title']) : '';
	    	$category = ! empty($instance['category']) ? esc_attr($instance['category']) : '';
	        $number = ! empty($instance['number']) ? absint($instance['number']) : 0;
	        $order_by = ! empty($instance['order_by']) ? esc_attr($instance['order_by']) : 'ID';
	        $order = ! empty($instance['order']) ? esc_attr($instance['order']) : 'ASC';
	        
	        $initial_state = ! empty($instance['initial_state']) ? esc_attr($instance['initial_state']) : 'first';
	        $image_size = ! empty($instance['image_size']) ? esc_attr($instance['image_size']) : 'thumbnail';

	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        $number_of_column = ! empty($instance['number_of_column']) ? absint($instance['number_of_column']) : 0;
	        $number_of_column_tablet = ! empty($instance['number_of_column_tablet']) ? absint($instance['number_of_column_tablet']) : 0;
	        $number_of_column_mobile = ! empty($instance['number_of_column_mobile']) ? absint($instance['number_of_column_mobile']) : 0;
	        $text_align = ! empty($instance['text_align']) ? esc_attr($instance['text_align']) : '0';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';
	        $button_style = ! empty($instance['button_style']) ? esc_attr($instance['button_style']) : '0';

	        $args = array(
		        'type'     =>'ss_parts',
		        'taxonomy'    =>'ss_parts_category'
	        );
	        $categories = get_categories($args);
	        
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

	        //column value for bootstrap
	        $arr_column = array('0' => '0', '12' => '1', '6' => '2', '4' => '3', '3' => '4', '2' => '6', '1' => '12');

	        ?>

		        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="hidden" value="<?php echo $title; ?>" />
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id( 'main_title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		        	<input class="widefat" id="<?php echo $this->get_field_id( 'main_title' ); ?>" name="<?php echo $this->get_field_name( 'main_title' ); ?>" type="text" value="<?php echo esc_attr( $main_title ); ?>" />
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
		        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of parts:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="2" />
		        	(put 0 to show all parts) 
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('order_by'); ?>"><?php _e('Order by:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('order_by'); ?>" name="<?php echo $this->get_field_name('order_by'); ?>">
		            	<option value = "ID" <?php echo ($order_by == "ID" ? 'selected' : '') ?> >ID</option>
		            	<option value = "title" <?php echo ($order_by == "title" ? 'selected' : '') ?> >Title</option>
		            	<option value = "menu_order" <?php echo ($order_by == "menu_order" ? 'selected' : '') ?> >Order Value</option>
		            	<option value = "rand" <?php echo ($order_by == "rand" ? 'selected' : '') ?> >Random</option>
		        	</select>
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
		            	<option value = "ASC" <?php echo ($order == "ASC" ? 'selected' : '') ?> >Ascending</option>
		            	<option value = "DESC" <?php echo ($order == "DESC" ? 'selected' : '') ?> >Descending</option>
		        	</select>
		        </p>
	        	
	        	<p>
		        	<label for="<?php echo $this->get_field_id('initial_state'); ?>"><?php _e('Initial State:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('initial_state'); ?>" name="<?php echo $this->get_field_name('initial_state'); ?>">
		            	<option value = "first" <?php echo ($initial_state == "first" ? 'selected' : '') ?> >First</option>
		            	<option value = "expand" <?php echo ($initial_state == "expand" ? 'selected' : '') ?> >Expand</option>
		            	<option value = "collapse" <?php echo ($initial_state == "collapse" ? 'selected' : '') ?> >Collapse</option>
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
				    <input class="checkbox" type="checkbox" <?php checked($instance['hide_image'], 'on'); ?> id="<?php echo $this->get_field_id('hide_image'); ?>" name="<?php echo $this->get_field_name('hide_image'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('hide_image'); ?>"><?php _e('Hide Image'); ?></label>
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
		        	<label for="<?php echo $this->get_field_id('text_align'); ?>"><?php _e('Text align:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('text_align'); ?>" name="<?php echo $this->get_field_name('text_align'); ?>">
			        	<?php foreach ($arr_text_align as $index => $available_text_align){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $text_align, $index ); ?> >
			                	<?php echo $available_text_align; ?>
			                </option>
				    	<?php } ?>
		        	</select>
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

		        <p>
		        	<label for="<?php echo $this->get_field_id('button_style'); ?>"><?php _e('Link/Button Style:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('button_style'); ?>" name="<?php echo $this->get_field_name('button_style'); ?>">
			        	<?php foreach ($arr_button_style as $index => $available_button_style){ ?>
				    		<option value="<?php echo $index; ?>" <?php echo selected( $button_style, $index ); ?> >
			                	<?php echo $available_button_style; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['main_title'] = ( ! empty( $new_instance['main_title'] ) ) ? strip_tags( $new_instance['main_title'] ) : '';
	        $instance['category'] = strip_tags($new_instance['category']);
	        $instance['order_by'] = strip_tags($new_instance['order_by']);
	        $instance['order'] = strip_tags($new_instance['order']);
	        $instance['number'] = filter_var($new_instance['number'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        
	        $instance['initial_state'] = strip_tags($new_instance['initial_state']);
	        $instance['image_as_link'] = $new_instance['image_as_link'];
	        $instance['hide_description'] = $new_instance['hide_description'];
	        $instance['hide_image'] = $new_instance['hide_image'];
	        $instance['hide_link'] = $new_instance['hide_link'];
	        $instance['image_size'] = strip_tags($new_instance['image_size']);
	        
	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	
	       	$instance['text_align'] = strip_tags($new_instance['text_align']);
	       	$instance['style'] = strip_tags($new_instance['style']);
	       	$instance['button_style'] = strip_tags($new_instance['button_style']);


	       	//todo: category name query parts based on options
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
	function ss_parts_accordion_shortcode($atts)
	{
	    $default_atts = array(
	    	'main_title' => '',
	    	'category' => '',
	    	'number' => '0',
	    	'order_by' => 'ID',
	    	'order' => 'ASC',

	    	'initial_state' => 'first',
	    	'image_as_link' => NULL,
	    	'hide_description' => NULL,
	    	'hide_image' => NULL,
	    	'hide_link' => NULL,
	    	'image_size' => 'thumbnail',

	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'number_of_column' => '1',
	    	'number_of_column_tablet' => '1',
	    	'number_of_column_mobile' => '1',
	    	'text_align' => 'text-left',
	    	'style' => '0',
	    	'button_style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();
	    
	    //display widget content
	    ss_parts_accordion_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_parts_accordion', 'ss_parts_accordion_shortcode');
?>