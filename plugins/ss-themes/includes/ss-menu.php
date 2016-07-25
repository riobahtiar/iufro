<?php
	
	function ss_register_menu_style() {
	    wp_register_style( 'ss-menu-style', plugins_url('../style/ss-menu.css', __FILE__) );
	    wp_enqueue_style( 'ss-menu-style' );
	}
	add_action( 'init', 'ss_register_menu_style' );


	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show Menu content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_menu_generate_html($instance){
		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];

		$menu_location = $instance['menu_location'];
		$submenu_direction = ($instance['submenu_direction'] && $instance['submenu_direction'] != 'false') ? true : false;

       	$custom_class = $instance['custom_class'];
        $custom_id = $instance['custom_id'];
        $style = $instance['style'];
	       
		
		//prepare id
		if($custom_id != ""){
			$id = $custom_id;
		}

		//prepare class for container
        $arr_container_class = array(); //store class name in array
        
        $arr_container_class[] = $classname;
        $arr_container_class[] = $custom_class;

        if($submenu_direction){
			$arr_container_class[] = "navbar-level-right";
        }

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-menu-style-".$style;
		}

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        
        echo "<div id='".$id."' class='ss-menu-container widget ".$str_container_class."'>";
        
        if($instance['title'] != ""){
    		echo "<h2>".$instance['title']."</h2>";
    	}

        wp_nav_menu( array( 
        	'theme_location' => $menu_location, 
        	'menu_id' => 'menu-header', 
        	'container_class' => 'menu-header-container',
        	'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' ) 
        );

        //for bootstrap use walker
        //wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'menu-header', 'container' => false, 'items_wrap' => '<ul id="%1$s" class="menu %2$s">%3$s</ul>', 'walker' => new wp_bootstrap_navwalker() ) );

        echo "</div>";

        
	}


	/**
	 *	Add SS Logo Widget
	 * 
	 *  widget to show main logo
	 *   
	 *	@author heryno
	 */
	class ss_menu_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_menu_widget', 
		        'SS Menu', 
		        array( 'description' => 'Show menu', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {

	        $instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;
	        
	        //echo $args['before_widget'];

	        //display widget content
	        ss_menu_generate_html($instance);

	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
	       	$menu_location = ! empty($instance['menu_location']) ? esc_attr($instance['menu_location']) : '';

	       	$custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : 'navbar';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';

	        $arr_style = array(
	        	0 => 'Default',
	        );

	        $menus = get_registered_nav_menus();

	        ?>

	        	<p>
		        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		        	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		        </p>
		        
		        <p>
		        	<label for="<?php echo $this->get_field_id('menu_location'); ?>"><?php _e('Menu Location:'); ?></label>
		        	<select class="widefat" id="<?php echo $this->get_field_id('menu_location'); ?>" name="<?php echo $this->get_field_name('menu_location'); ?>">
			        	<?php foreach ($menus as $location => $location_name){ ?>
				    		<option value="<?php echo $location; ?>" <?php echo selected( $menu_location, $location ); ?> >
			                	<?php echo $location_name; ?>
			                </option>
				    	<?php } ?>
		        	</select>
		        </p>

		        <p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['submenu_direction'], 'on'); ?> id="<?php echo $this->get_field_id('submenu_direction'); ?>" name="<?php echo $this->get_field_name('submenu_direction'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('submenu_direction'); ?>"><?php _e('Submenu direction to right'); ?></label>
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
	        $instance['menu_location'] = strip_tags($new_instance['menu_location']);
	        $instance['submenu_direction'] = $new_instance['submenu_direction'];

	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
			$instance['style'] = strip_tags($new_instance['style']);

	        return $instance;
	    }
	}

	function register_menu_widgets() {
	    register_widget( 'ss_menu_Widget' );

	    //add register new widget here
	}
	add_action( 'widgets_init', 'register_menu_widgets' );


	/**
	 * Run Logo shortcode
	 * 
	 * @return html content
	 */
	function ss_menu_shortcode($atts)
	{
	    $default_atts = array(
	    	'title' => '',
	    	'classname' => '',
	    	'id' => 'navbar',
	    	'menu_location' => '',
	    	'submenu_direction' => NULL,
	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();

		//display widget content
	    ss_menu_generate_html($atts);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_menu', 'ss_menu_shortcode');
?>