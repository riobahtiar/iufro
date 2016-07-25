<?php
	
	function ss_register_parent_child_links_style() {
	    wp_register_style( 'ss-parent-child-links-style', plugins_url('../style/ss-parent-child-links.css', __FILE__) );
	    wp_enqueue_style( 'ss-parent-child-links-style' );
	}
	add_action( 'init', 'ss_register_parent_child_links_style' );


	/**
	 *	Generate HTML for widget
	 * 
	 *  used by shortcode and widget to show content
	 *   
	 *	@author heryno
	 *  @param array $instance array associative contain all the relevant setup information
	 */	
	function ss_parent_child_link_generate_html($instance){
		//prepare widget options variable
		$classname = $instance['classname'];
		$id = $instance['id'];

		$force_show_parent = ($instance['force_show_parent'] && $instance['force_show_parent'] != 'false') ? true : false;

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

		//-----widget style
		if($style > 0){
			$arr_container_class[] = "ss-menu-style-".$style;	
		}

        //-----imploade all class name to string
        $str_container_class = implode(" ", $arr_container_class);

        //determine which post as parent, if no post found then don't show
        global $post;
        if(!$post){
        	$parent = 0;
        }else{
        	if(has_children()){
        		$parent = $post->ID;
	        }else{
				$parent = $post->post_parent;	
	        }	
        }
        
        
		if($parent != 0){
			//show content
        ?>

	        <div id="<?php echo $id; ?>" class="ss-parent-child-links-container widget <?php echo $str_container_class; ?>">
	        
		        <?php if($instance['title'] != ""){ ?>
		    		<h2><?php echo $instance['title']; ?></h2>
		    	<?php } ?>


		    	<?php if(!has_children() || $force_show_parent){ ?>
					<span class='ss-parent-child-links-parent-title'>
						<a href="<?php echo get_permalink($parent); ?>">
							<h3><?php echo get_the_title($parent); ?></h3>
						</a>
					</span>
				<?php } ?>


				<ul class='ss-parent-child-links-child-list'>
					<?php wp_list_pages( 'child_of='.$parent.'&title_li=' ); ?>
				</ul>
	        </div>

	    <?php
    	}

        
	}


	/**
	 *	Add SS Logo Widget
	 * 
	 *  widget to show main logo
	 *   
	 *	@author heryno
	 */
	class SS_Parent_Child_Links_Widget extends WP_Widget {
	    //Register widget with WordPress.
	    function __construct() {
	        parent::__construct(
		        'ss_parent_child_links_widget', 
		        'SS Parent/Child Links', 
		        array( 'description' => 'Show dynamic parent-child links base on current page', ) 
	        );
	    }
	    
	    // Front-end display of widget.
	    public function widget( $args, $instance ) {

	        $instance['classname'] = $this->widget_options['classname'];
	        $instance['id'] = $this->id;
	        
	        //echo $args['before_widget'];

	        //display widget content
	        ss_parent_child_link_generate_html($instance);
	        //echo $args['after_widget'];
	    }
	    

	    //Back-end widget form.
	    public function form( $instance ) {
	    	$title = ! empty( $instance['title'] ) ? $instance['title'] : __( '', 'text_domain' );
	       	
	       	$custom_class = ! empty($instance['custom_class']) ? esc_attr($instance['custom_class']) : '';
	        $custom_id = ! empty($instance['custom_id']) ? esc_attr($instance['custom_id']) : '';
	        $style = ! empty($instance['style']) ? esc_attr($instance['style']) : '0';

	        $arr_style = array(
	        	0 => 'Default',
	        );


	        ?>

	        	<p>
		        	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		        	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		        </p>

		        <p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['force_show_parent'], 'on'); ?> id="<?php echo $this->get_field_id('force_show_parent'); ?>" name="<?php echo $this->get_field_name('force_show_parent'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('force_show_parent'); ?>"><?php _e('Force show parent link on parent page'); ?></label>
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
	        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
	        $instance['force_show_parent'] = $new_instance['force_show_parent'];

	        $instance['custom_class'] = ( ! empty( $new_instance['custom_class'] ) ) ? strip_tags( $new_instance['custom_class'] ) : '';
	        $instance['custom_id'] = ( ! empty( $new_instance['custom_id'] ) ) ? strip_tags( $new_instance['custom_id'] ) : '';
			$instance['style'] = strip_tags($new_instance['style']);

	        return $instance;
	    }
	}

	function register_parent_child_links_widgets() {
	    register_widget( 'SS_Parent_Child_Links_Widget' );

	    //add register new widget here
	}
	add_action( 'widgets_init', 'register_parent_child_links_widgets' );


	/**
	 * Run Logo shortcode
	 * 
	 * @return html content
	 */
	function ss_parent_child_links_shortcode($atts)
	{
	    $default_atts = array(
	    	'title' => '',
	    	'force_show_parent' => NULL,
	    	'classname' => '',
	    	'id' => '',
	    	'custom_class' => '',
	    	'custom_id' => '',
	    	'style' => '0'
	    );

	    $atts = shortcode_atts($default_atts,$atts);

	    ob_start();

		//display widget content
	    ss_parent_child_link_generate_html($instance);
	    
	    return ob_get_clean();
	}

	add_shortcode('ss_parent_child_links', 'ss_parent_child_links_shortcode');
?>