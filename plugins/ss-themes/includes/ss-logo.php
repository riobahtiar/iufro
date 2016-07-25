<?php
	
	function ss_register_logo_style() {
	    wp_register_style( 'ss-logo-style', plugins_url('../style/ss-logo.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_logo_style' );


	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show Links content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_logo_generate_html($instance){
		global $ss_theme_opt;

		wp_enqueue_style( 'ss-logo-style' );

		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];

        $custom_image_url = do_shortcode($instance['custom_image_url']);
        $custom_headline = $instance['custom_headline'];
        $show_headline = ($instance['show_headline'] && $instance['show_headline'] != 'false') ? true : false;
        $custom_url = do_shortcode($instance['custom_url']);

        $custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        $max_height = $instance['max_height'];
        $max_width = $instance['max_width'];
		$style = $instance['style'];
	       
		
		//prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;

        //-----custom class
        $arr_container_class[] = $custom_class;

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-logo-style-".$style;	
		}

        //-----class related to headline
        if($show_headline){
        	$arr_container_class[] = 'ss-logo-show-headline';	
        }

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        //style for image if specify
        if($max_height != '' && $max_height != 0){
        	$str_max_height = "max-height:".$max_height."px' ";
        }
        if($max_width != '' && $max_width != 0){
        	$str_max_width = "max-width:".$max_width."px' ";
        }
        if($str_max_height != '' || $str_max_width != ''){
        	$str_image_style = "style='".$str_max_height."; ".$str_max_width."'";
        }

        //image from theme options
        $image_url = $ss_theme_opt['logo']['url'];

        //use custom image if not empty
        if($custom_image_url != ""){
        	$image_url = $custom_image_url;
        }

        //target url
        $target_url = get_site_url();

        if($custom_url != ""){
        	$target_url = $custom_url;
        }

        echo "<div id='".$id."' class='ss-logo-container widget ".$str_container_class."'>";
        echo "<a href='".$target_url."'>";
        echo "<img ".$str_image_style." src='".$image_url."'>";
        echo "</a>";
        echo "</div>";

        
	}


	/**
	 *	Add SS Logo Widget
	 * 
	 *  widget to show main logo
	 *   
	 *	@author heryno
	 */
	class ss_logo_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_logo_widget', 
		        __('SS Logo', 'ss_logo_domain'), 
		        array( 'description' => __( 'Show logo', 'ss_logo_domain' ), ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {
	        $instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;
	        
	        //echo $args['before_widget'];

	        //display widget content
	        ss_logo_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	        $custom_image_url = ! empty($instance['custom_image_url']) ? esc_attr($instance['custom_image_url']) : '';
	        $custom_headline = ! empty($instance['custom_headline']) ? esc_attr($instance['custom_headline']) : '';
	        $custom_url = ! empty($instance['custom_url']) ? esc_attr($instance['custom_url']) : '';
	        $custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : 'logo';
	        $max_height = ! empty($instance['max_height']) ? absint($instance['max_height']) : 0;
	        $max_width = ! empty($instance['max_width']) ? absint($instance['max_width']) : 0;
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';

	        $arr_style = array(
	        	0 => 'Default',
	        	1 => 'Opacity',
	        	2 => 'Grayscale',
	        	3 => 'Sepia',
	        	4 => 'Flash'
	        );

	        ?>

	        	<p>
		        	<label for="<?php echo $this->get_field_id('custom_image_url'); ?>"><?php _e('Custom image URL:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_image_url'); ?>" name="<?php echo $this->get_field_name('custom_image_url'); ?>" type="text" value="<?php echo $custom_image_url; ?>" />
		        </p>

		        <p>
		        	<label for="<?php echo $this->get_field_id('custom_headline'); ?>"><?php _e('Custom Headline:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_headline'); ?>" name="<?php echo $this->get_field_name('custom_headline'); ?>" type="text" value="<?php echo $custom_headline; ?>" />
		        </p>

		        <p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['show_headline'], 'on'); ?> id="<?php echo $this->get_field_id('show_headline'); ?>" name="<?php echo $this->get_field_name('show_headline'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('show_headline'); ?>"><?php _e('Show Headline'); ?></label>
				</p>

				<p>
		        	<label for="<?php echo $this->get_field_id('custom_url'); ?>"><?php _e('Custom URL:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_url'); ?>" name="<?php echo $this->get_field_name('custom_url'); ?>" type="text" value="<?php echo $custom_url; ?>" />
		        </p>

				<br/>

		        <p class="ss-editor-hide">
	        		<h4 class="ss-editor-hide">Layout &amp; Styling</h4>
	        	</p>

	        	<hr class="ss-editor-hide"/>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('custom_class'); ?>"><?php _e('Custom Container Class:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_class'); ?>" name="<?php echo $this->get_field_name('custom_class'); ?>" type="text" value="<?php echo $custom_class; ?>" />
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('custom_id'); ?>"><?php _e('Custom Container ID:'); ?></label>
		        	<input class="widefat" id="<?php echo $this->get_field_id('custom_id'); ?>" name="<?php echo $this->get_field_name('custom_id'); ?>" type="text" value="<?php echo $custom_id; ?>" />
		        </p>
	        	
		        
		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('max_height'); ?>"><?php _e('Logo maximum height:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('max_height'); ?>" name="<?php echo $this->get_field_name('max_height'); ?>" type="text" value="<?php echo $max_height; ?>" size="4" />
		        	px (put 0 not specify) 
		        </p>

		        <p class="ss-editor-hide">
		        	<label for="<?php echo $this->get_field_id('max_width'); ?>"><?php _e('Logo maximum width:'); ?></label> &nbsp;&nbsp;
		        	<input id="<?php echo $this->get_field_id('max_width'); ?>" name="<?php echo $this->get_field_name('max_width'); ?>" type="text" value="<?php echo $max_width; ?>" size="4" />
		        	px (put 0 not specify) 
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

	        <?php 
	    }
	    
	    //Sanitize widget form values as they are saved.
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $instance['custom_image_url'] = ( ! empty( $new_instance['custom_image_url'] ) ) ? strip_tags( $new_instance['custom_image_url'] ) : '';
	        $instance['custom_headline'] = ( ! empty( $new_instance['custom_headline'] ) ) ? strip_tags( $new_instance['custom_headline'] ) : '';
	        $instance['show_headline'] = $new_instance['show_headline'];
	        $instance['custom_url'] = ( ! empty( $new_instance['custom_url'] ) ) ? strip_tags( $new_instance['custom_url'] ) : '';

	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
			$instance['max_height'] = filter_var($new_instance['max_height'], FILTER_SANITIZE_NUMBER_INT); //get only number
			$instance['max_width'] = filter_var($new_instance['max_width'], FILTER_SANITIZE_NUMBER_INT); //get only number
			$instance['style'] = strip_tags($new_instance['style']);

	        return $instance;
	    }
	}

	function register_logo_widgets() {
	    register_widget( 'ss_logo_Widget' );

	    //add register new widget here
	}
	add_action( 'widgets_init', 'register_logo_widgets' );


	/**
	 * Run Logo shortcode
	 * 
	 * @return html content
	 */
	function ss_logo_shortcode($atts)
	{
	    $default_atts = array(
	    	'classname' => '',
	    	'id' => '',
	    	'custom_image_url' => '',
	    	'custom_headline' => '',
	    	'show_headline' => '0',
	    	'custom_url' => '',
	    	'custom_class' => '',
	    	'custom_id' => 'logo',
	    	'max_height' => '0',
	    	'max_width' => '0',
	    	'style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();

		//display widget content
	    ss_logo_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_logo', 'ss_logo_shortcode');
?>