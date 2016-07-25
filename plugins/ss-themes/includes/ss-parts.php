<?php
	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show parts content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_parts_generate_html($instance){
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
        $title_position = $instance['title_position'];
        $image_as_link = ($instance['image_as_link'] && $instance['image_as_link'] != 'false') ? true : false;
        $title_as_link = ($instance['title_as_link'] && $instance['title_as_link'] != 'false') ? true : false;
        $hide_image = ($instance['hide_image'] && $instance['hide_image'] != 'false') ? true : false;
        $hide_description = ($instance['hide_description'] && $instance['hide_description'] != 'false') ? true : false;
        $hide_link = ($instance['hide_link'] && $instance['hide_link'] != 'false') ? true : false;
        $image_size = $instance['image_size'];

        //layout and styling
        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        $number_of_column = $instance['number_of_column'];
        $number_of_column_tablet = $instance['number_of_column_tablet'];
        $number_of_column_mobile = $instance['number_of_column_mobile'];
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
        $arr_container_class[] = $instance['text_align'];

		//-----widget style
		$arr_style_dependency = array('');
		$arr_style_dependency[1] = 'ss-image-block'; $arr_style_dependency[2] = 'ss-image-block';
		$arr_style_dependency[3] = 'ss-image-block'; $arr_style_dependency[4] = 'ss-image-block';
		$arr_style_dependency[5] = 'ss-image-block'; $arr_style_dependency[6] = 'ss-image-block';
		$arr_style_dependency[7] = 'ss-image-block'; $arr_style_dependency[8] = 'ss-image-block';
		$arr_style_dependency[9] = 'ss-image-block'; $arr_style_dependency[10] = 'ss-image-block';
		$arr_style_dependency[11] = 'ss-text-block'; $arr_style_dependency[12] = 'ss-text-block';
		$arr_style_dependency[13] = 'ss-text-block'; $arr_style_dependency[14] = 'ss-text-block';
		$arr_style_dependency[15] = 'ss-text-block'; $arr_style_dependency[16] = 'ss-text-block';
		$arr_style_dependency[17] = 'ss-text-block'; $arr_style_dependency[18] = 'ss-text-block';
		$arr_style_dependency[19] = 'ss-text-block'; $arr_style_dependency[20] = 'ss-text-block';
		$arr_style_dependency[21] = 'ss-text-block'; $arr_style_dependency[22] = 'ss-text-block';

		if($style > 0){
			$arr_container_class[] = "ss-parts-style-".$style;	

			if(isset($arr_style_dependency[$style])){
				$arr_container_class[] = $arr_style_dependency[$style];
			}
		}

		//-----class related to title position
        if($title_position == 'top'){
        	$arr_container_class[] = 'ss-parts-show-title-top';	
        }else if($title_position == 'bottom'){
        	$arr_container_class[] = 'ss-parts-show-title-bottom';
        }else{
        	$arr_container_class[] = 'ss-parts-hide-title';
        }

        //-----class related to image
        if($hide_image){
        	$arr_container_class[] = "ss-parts-hide-image";
        }

        //-----class related to column
        if($number_of_column > 0 || $number_of_column_tablet > 0 || $number_of_column_mobile > 0){
        	$arr_container_class[] = "row";
        }

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);


        //prepare column class for single part
        $arr_single_container_class = array();
        if($number_of_column > 0){
        	$arr_single_container_class[] = "col-md-".$number_of_column;
        }
        if($number_of_column_tablet > 0){
        	$arr_single_container_class[] = "col-sm-".$number_of_column_tablet;
        }
        if($number_of_column_mobile > 0){
        	$arr_single_container_class[] = "col-xs-".$number_of_column_mobile;
        }
        $str_single_container_class = implode(" ", $arr_single_container_class);

        
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
        //looping links
        if ( $query_posts->have_posts() ) {

        	//start widget container
        	echo '<div id="'.$id.'" class="'.$str_container_class.'">';

        	if($instance['main_title'] != ""){
	    		echo "<h2 class='ss-parts-main-title col-md-12'>".$instance['main_title']."</h2>";
	    	}

        	$posts = $query_posts->get_posts();
        	foreach ($posts as $post) {
        		$part_id = $post->ID;
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

				<div id="<?php echo $id.'-part-'.$part_id; ?>" class="ss-parts-single-part <?php echo $str_single_container_class; ?>">
	        		
		            <?php if( $title_position == 'top' ){ ?>
		            	<?php if($title_as_link){ ?>
			        		<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="ss-parts-title-link">
			        	<?php } ?>

			        	<h2><?php echo $post->post_title; ?></h2>

			        	<?php if($title_as_link){ ?>
			        		</a>
			        	<?php } ?>
		            <?php } ?>

	        		<?php if(!$hide_image && $image_url != ""){ ?>
				        <div class="ss-parts-image">
				        	<?php if($image_as_link){ ?>
				        		<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>">
				        	<?php } ?>

				        		<img src="<?php echo $image_url; ?>" alt="">
				        	
				        	<?php if($image_as_link){ ?>
				        		</a>
				        	<?php } ?>
				        </div>
			        <?php } ?>
			        
			        
		        	<?php if( $title_position == 'bottom' ){ ?>
		            	<?php if($title_as_link){ ?>
			        		<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="ss-parts-title-link">
			        	<?php } ?>

			        	<h2><?php echo $post->post_title; ?></h2>

			        	<?php if($title_as_link){ ?>
			        		</a>
			        	<?php } ?>
		            <?php } ?>
			        

			        <?php if(!$hide_description){ ?>
			        	<p><?php echo do_shortcode(apply_filters("the_content",$post->post_content)); ?></p>
			        <?php } ?>

			        <?php if(!$hide_link && $link != ""){ ?>
			        	<a <?php echo $str_new_tab; ?> href="<?php echo $link; ?>" class="btn <?php echo $str_button_style; ?>">
			        		<span>
			        			<?php echo $link_text; ?>
			        		</span>
			        	</a>
			        <?php } ?>

			    </div>

			

			<?php

        	}

        	echo "</div>"; //closing widget container
        }

        return true;

	}



	/**
	 *	Add SS Parts Widget
	 * 
	 *  widget to show multiple part
	 *   
	 *	@author heryno
	 */
	class SS_Parts_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_parts_widget', 
		        'SS Parts', 
		        array( 'description' => 'Show parts content', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	    	$instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;

	    	
	        //echo $args['before_widget'];

	        //display widget content
	        ss_parts_generate_html($instance);

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
	        
	        $title_position = ! empty($instance['title_position']) ? esc_attr($instance['title_position']) : 'bottom';
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
	        	1 => 'Style 1 (image block)',
	        	2 => 'Style 2 (image block)',
	        	3 => 'Style 3 (image block)',
	        	4 => 'Style 4 (image block)',
	        	5 => 'Style 5 (image block)',
	        	6 => 'Style 6 (image block)',
	        	7 => 'Style 7 (image block)',
	        	8 => 'Style 8 (image block)',
	        	9 => 'Style 9 (image block)',
	        	10 => 'Style 10 (image block)',
	        	11 => 'Style 11 (Title Link)',
	        	12 => 'Style 12 (Title Link)',
	        	13 => 'Style 13 (Title Link)',
	        	14 => 'Style 14 (Title Link)',
	        	15 => 'Style 15 (Title Link)',
	        	16 => 'Style 16 (Title Link)',
	        	17 => 'Style 17 (Title Link)',
	        	18 => 'Style 18 (Title Link)',
	        	19 => 'Style 19 (Title Link)',
	        	20 => 'Style 20 (Title Link)',
	        	21 => 'Style 21 (Title Link)',
	        	22 => 'Style 22 (Title Link)',
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

		        <p class="ss-editor-hide">
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
		        	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of content:'); ?></label> 
		        	<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="2" />
		        	(put 0 to show all content) 
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

		        <br/>

	        	<p>
	        		<h4>Each Individual Content</h4>
	        	</p>

	        	<hr/>
	        	
	        	<p>
		        	<label for="<?php echo $this->get_field_id('title_position'); ?>"><?php _e('Title Position:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('title_position'); ?>" name="<?php echo $this->get_field_name('title_position'); ?>">
		            	<option value = "hide" <?php echo ($title_position == "hide" ? 'selected' : '') ?> >Don't Show</option>
		            	<option value = "top" <?php echo ($title_position == "top" ? 'selected' : '') ?> >Above Featured Image</option>
		            	<option value = "bottom" <?php echo ($title_position == "bottom" ? 'selected' : '') ?> >Below Featured Image</option>
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
				    <label for="<?php echo $this->get_field_id('hide_image'); ?>"><?php _e('Hide Featured Image'); ?></label>
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
		        	<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Featured Image size:'); ?></label>
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

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('custom_class'); ?>"><?php _e('Custom Container Class:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_class'); ?>" name="<?php echo $this->get_field_name('custom_class'); ?>" type="text" value="<?php echo $custom_class; ?>" />
		        </p>
	        	
	        	<p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('custom_id'); ?>"><?php _e('Custom Container ID:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" type="text" value="<?php echo $custom_id; ?>" />
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('number_of_column'); ?>"><?php _e('Number of column for desktop:'); ?></label>
		        	<select id="<?php echo $this->get_field_id( 'number_of_column' ); ?>" name="<?php echo $this->get_field_name( 'number_of_column' ); ?>" >	
		            	<!-- Generate all items of drop-down list -->
		            	<?php //for ( $j = 0; $j <= 20; $j++ ) { ?>
		            	<?php foreach($arr_column as $value => $column){ ?>
			                <option value="<?php echo $value; ?>" <?php echo selected( $number_of_column, $value ); ?> >
			                	<?php echo $column; ?>
			                </option>
		                <?php } ?>
		        	</select>
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id('number_of_column_tablet'); ?>"><?php _e('Number of column for tablet:'); ?></label> &nbsp;&nbsp;
		        	<select id="<?php echo $this->get_field_id( 'number_of_column_tablet' ); ?>" name="<?php echo $this->get_field_name( 'number_of_column_tablet' ); ?>" >	
			            <!-- Generate all items of drop-down list -->
			            <?php //for ( $j = 0; $j <= 20; $j++ ) { ?>
		            	<?php foreach($arr_column as $value => $column){ ?>
			                <option value="<?php echo $value; ?>" <?php echo selected( $number_of_column_tablet, $value ); ?> >
			                	<?php echo $column; ?>
			                </option>
		                <?php } ?>
		             </select>
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id('number_of_column_mobile'); ?>"><?php _e('Number of column for mobile:'); ?></label> &nbsp;
		        	<select id="<?php echo $this->get_field_id( 'number_of_column_mobile' ); ?>" name="<?php echo $this->get_field_name( 'number_of_column_mobile' ); ?>" >	
			            <!-- Generate all items of drop-down list -->
			            <?php //for ( $j = 0; $j <= 20; $j++ ) { ?>
		            	<?php foreach($arr_column as $value => $column){ ?>
			                <option value="<?php echo $value; ?>" <?php echo selected( $number_of_column_mobile, $value ); ?> >
			                	<?php echo $column; ?>
			                </option>
		                <?php } ?>
		            </select>
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
	        
	        $instance['title_position'] = strip_tags($new_instance['title_position']);
	        $instance['image_as_link'] = $new_instance['image_as_link'];
	        $instance['title_as_link'] = $new_instance['title_as_link'];
	        $instance['hide_description'] = $new_instance['hide_description'];
	        $instance['hide_image'] = $new_instance['hide_image'];
	        $instance['hide_link'] = $new_instance['hide_link'];
	        $instance['image_size'] = strip_tags($new_instance['image_size']);
	        
	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
	       	$instance['number_of_column'] = filter_var($new_instance['number_of_column'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        $instance['number_of_column_tablet'] = filter_var($new_instance['number_of_column_tablet'], FILTER_SANITIZE_NUMBER_INT); //get only number
	        $instance['number_of_column_mobile'] = filter_var($new_instance['number_of_column_mobile'], FILTER_SANITIZE_NUMBER_INT); //get only number
			
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
	function ss_parts_shortcode($atts)
	{
	    $default_atts = array(
	    	'main_title' => '',
	    	'category' => '',
	    	'number' => '0',
	    	'order_by' => 'ID',
	    	'order' => 'ASC',

	    	'title_position' => 'bottom',
	    	'image_as_link' => NULL,
	    	'title_as_link' => NULL,
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
	    	'button_style' => '0',
	    	'classname' => 'ss_parts_shortcode',
	    	'id' => '',
	    );

	    $atts = shortcode_atts($default_atts,$atts);

		//display widget content
		ob_start();
	    
	    ss_parts_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_parts', 'ss_parts_shortcode');
?>