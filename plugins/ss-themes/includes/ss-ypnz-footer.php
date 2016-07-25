<?php

	/**
	 *	Add SS YPNZ Footer Widget
	 * 
	 *  widget to show footer with Yellow logo
	 *   
	 *	@author heryno
	 */
	class SS_YPNZ_Footer_Widget extends WP_Widget {

	    /**
	     * Register widget with WordPress.
	     */
	    function __construct() {
	        parent::__construct(
	            'ss_ypnz_footer_widget', // Base ID
	            __( 'SS YPNZ Footer', 'text_domain' ), // Name
	            array( 'description' => __( 'Widget to show copyright text and Yellow Logo', 'text_domain' ), ) // Args
	        );
	    }

	    
	    //Front-end display of widget
	    public function widget( $args, $instance ) {
	        $blog_name = get_bloginfo('name');
	        $year = $instance['year'];
	        $width = 'width = "'.$instance['width'].'px"';
	        $image_url = plugins_url( '../images/yellow_black.png', __FILE__ );
	        $use_altenate = ($instance['use_altenate'] && $instance['use_altenate'] != 'false') ? true : false;
	        if($use_altenate){
	        	$image_url = plugins_url( '../images/yellow_white.png', __FILE__ );
	        }

	        ?>

	        	<div class="ss-ypnz-footer-widget" id="<?php echo $this->id; ?>">
	        		<div class="ss-ypnz-footer-line-1">
	        			&copy; Copyright <?php echo date('Y'); ?>. <?php echo $blog_name; ?>. All Rights Reserved.
	        		</div>
	        		<div class="ss-ypnz-footer-line-2">
	        			Designed by: <img src="<?php echo $image_url; ?>" <?php echo $width; ?> >
	        		</div>
	        	</div>

	        <?php
	        
	    }

	    /**
	     * Back-end widget form.
	     *
	     * @see WP_Widget::form()
	     *
	     * @param array $instance Previously saved values from database.
	     */
	    public function form( $instance ) {
	    	$current_year = date('Y');
	        $year = ! empty( $instance['year'] ) ? $instance['year'] : $current_year;
	        $width = ! empty( $instance['width'] ) ? $instance['width'] : '75';
	        
	        ?>
	        
		        <p>
			        <label for="<?php echo $this->get_field_id( 'year' ); ?>"><?php _e( 'Year:' ); ?></label> 
			        <input class="widefat" id="<?php echo $this->get_field_id( 'year' ); ?>" name="<?php echo $this->get_field_name( 'year' ); ?>" type="text" value="<?php echo esc_attr( $year ); ?>">
		        </p>

		        <p>
			        <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width:' ); ?></label> 
			        <input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>">
		        </p>
		        
		        <p>
				    <input class="checkbox" type="checkbox" <?php checked($instance['use_altenate'], 'on'); ?> id="<?php echo $this->get_field_id('use_altenate'); ?>" name="<?php echo $this->get_field_name('use_altenate'); ?>" /> 
				    <label for="<?php echo $this->get_field_id('use_altenate'); ?>"><?php _e('Use white version'); ?></label>
				</p>

	        <?php 
	        
	    }

	    /**
	     * Sanitize widget form values as they are saved.
	     *
	     * @see WP_Widget::update()
	     *
	     * @param array $new_instance Values just sent to be saved.
	     * @param array $old_instance Previously saved values from database.
	     *
	     * @return array Updated safe values to be saved.
	     */
	    public function update( $new_instance, $old_instance ) {
	        $instance = array();
	        $current_year = date('Y');
	        $instance['year'] = ( ! empty( $new_instance['year'] ) ) ? strip_tags( $new_instance['year'] ) : $current_year;
	        $instance['width'] = ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '75';
	        $instance['use_altenate'] = $new_instance['use_altenate'];

	        return $instance;
	    }

	} 

	function register_ypnz_footer_widgets() {
	    register_widget( 'SS_YPNZ_Footer_Widget' );

	    //add register new widget here
	}
	add_action( 'widgets_init', 'register_ypnz_footer_widgets' );


?>