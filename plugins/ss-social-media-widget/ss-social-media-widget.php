<?php
/*
Plugin Name: Social Media Widget for Boost theme
Description: Social media plugin for wordpress, a widget that allow you to display social media icons
Author: Yanuar
License: GPL2
*/

/**
 * Adds Social Media widget.
 */
class Ss_Social_Media_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'ss_social_media_widget', // Base ID
			__( 'SS Social Media', 'text_domain' ), // Name
			array( 'description' => __( 'Widget to display social media icons n links', 'text_domain' ), ) // Args
		);

		$this->networks = array(
			'facebook' => array(
				'title' => 'Facebook',
				'image' => 'facebook'
			),
			'googleplus' => array(
				'title' => 'Google+',
				'image' => 'google-plus'
			),
			'twitter' => array(
				'title' => 'Twitter',
				'image' => 'twitter'
			),
			'linkedin' => array(
				'title' => 'Linkedin',
				'image' => 'linkedin'
			),
			'instagram' => array(
				'title' => 'Instagram',
				'image' => 'instagram'
			),
			'youtube' => array(
				'title' => 'Youtube',
				'image' => 'youtube'
			),
			'pinterest' => array(
				'title' => 'Pinterest',
				'image' => 'pinterest'
			)
		);

		$this->colors = array('black', 'blue', 'green', 'yellow', 'white', 'cyan', 'red', 'magenta', 'custom');
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		$wsize = $instance['size'];
		if ( $wsize==1 ) {
			$wsize = "lg";
		} else {
			$wsize = $wsize.'x';
		}
		//check if custom color for icon has been set
		if ( $instance['color_custom']!='' ) {
			$color_icon = $instance['color_custom'];
		} else {
			$color_icon = $instance['color_icon'];
		}
		//check if custom color for background has been set
		if ( $instance['color_custom_bg']!='' ) {
			$color_bg = $instance['color_custom_bg'];
		} else {
			$color_bg = $instance['color_bg'];
		}
		//check if custom color for hover has been set
		if ( $instance['color_custom_hover']!='' ) {
			$color_hover = $instance['color_custom_hover'];
		} else {
			$color_hover = $instance['color_hover'];
		}
		//check if circle background enabled
		if ( $instance['bg_enable']=='1' ) {
			$bg_enable = "<i class='fa fa-circle fa-stack-2x' ></i>";
		}

		?>
		<div id="ss-social-media-widget">
			<p>
				<?php echo $instance['text']; ?>
			</p>

			<input type="hidden" class="color-hover" value="<?php echo $color_hover; ?>" />
			<?php foreach ($this->networks as $slug => $ndata) : 
				if ( $instance[$slug]!= "http://") { ?>
					<a href="<?php echo $instance[$slug]; ?>" target="_blank" >
						<span class="fa-stack fa-<?php echo $wsize; ?>" style="color: <?php echo $color_bg; ?>;" 
							onmouseover="jQuery(this).css('color', '<?php echo $color_hover; ?>')" 
							onmouseout="jQuery(this).css('color', '<?php echo $color_bg; ?>')"
						>
							<?php echo "$bg_enable"; ?>
							<i class="fa fa-<?php echo $ndata['image']; ?> fa-stack-1x fa-inverse fa-fw" style="color: <?php echo $color_icon; ?>;" ></i>
						</span>
					</a>
			<?php
				}
			 endforeach;
			 ?>
		</div>
		<?php
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$size = esc_attr($instance['size']);
		$color_icon = esc_attr($instance['color_icon']);
		$color_custom = esc_attr($instance['color_custom']);
		$bg_enable = esc_attr($instance['bg_enable']);
		$color_bg = esc_attr($instance['color_bg']);
		$color_custom_bg = esc_attr($instance['color_custom_bg']);
		$color_hover = esc_attr($instance['color_hover']);
		$color_custom_hover = esc_attr($instance['color_custom_hover']);

		foreach ($this->networks as $slug => $ndata) {
			$$slug = $instance[$slug];
			// ${$slug."_title"} = $instance[$slug."_title"];
		}
		
		?>
		<p>		<!-- widget title -->
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

		<p>		<!-- widget text -->
		<label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Widget text:' ); ?></label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" value="<?php echo esc_attr( $text ); ?>" rows="3"></textarea>
		</p>
		
		<p>		<!-- widget size -->
		<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Icon size:' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" >
            <!-- Generate all items of drop-down list -->
            <?php for ( $j = 1; $j <= 5; $j++ ) { ?>
                <option value="<?php echo $j; ?>" <?php echo selected( $size, $j ); ?>>
                <?php echo $j.'x'; } ?>
                </option>
            </select>
		</p>

		<p>	<!-- widget icon color -->
			<label for="<?php echo $this->get_field_id( 'color_icon' ); ?>"><?php _e( 'Icon color:' ); ?></label>
			<select class="widefat color-select" id="<?php echo $this->get_field_id( 'color_icon' ); ?>" name="<?php echo $this->get_field_name( 'color_icon' ); ?>">
			<?php foreach ($this->colors as $c) : ?>
				<option value="<?php echo $c; ?>" <?php echo selected($color_icon, $c) ?>><?php _e($c); ?></option>
			<?php endforeach; ?>
			</select>
		</p>

		<p>	<!-- widget custom icon color -->
			<label for="<?php echo $this->get_field_id( 'color_custom' ); ?>"><?php _e( 'Custom icon color:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'color_custom' ); ?>" name="<?php echo $this->get_field_name( 'color_custom' ); ?>" type="text" value="<?php echo esc_attr( $color_custom ); ?>" >
		</p>

		<p>	<!-- widget enable circle background -->
			<label for="<?php echo $this->get_field_id( 'bg_enable' ); ?>"><?php _e( 'Enable circle background:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'bg_enable' ); ?>" name="<?php echo $this->get_field_name( 'bg_enable' ); ?>" type="checkbox" value="1" 
			<?php if ( $bg_enable==1 ) { echo "checked"; } ?>
            />
		</p>

		<p>	<!-- widget background color -->
			<label for="<?php echo $this->get_field_id( 'color_bg' ); ?>"><?php _e( 'Circle background color:' ); ?></label>
			<select class="widefat color-select" id="<?php echo $this->get_field_id( 'color_bg' ); ?>" name="<?php echo $this->get_field_name( 'color_bg' ); ?>">
			<?php foreach ($this->colors as $c) : ?>
				<option value="<?php echo $c; ?>" <?php echo selected($color_bg, $c) ?>><?php _e($c); ?></option>
			<?php endforeach; ?>
			</select>
		</p>

		<p>	<!-- widget custom background color -->
			<label for="<?php echo $this->get_field_id( 'color_custom_bg' ); ?>"><?php _e( 'Custom circle background color:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'color_custom_bg' ); ?>" name="<?php echo $this->get_field_name( 'color_custom_bg' ); ?>" type="text" value="<?php echo esc_attr( $color_custom_bg ); ?>" >
		</p>

		<p>	<!-- widget hover color -->
			<label for="<?php echo $this->get_field_id( 'color_hover' ); ?>"><?php _e( 'Hover color:' ); ?></label>
			<select class="widefat color-select" id="<?php echo $this->get_field_id( 'color_hover' ); ?>" name="<?php echo $this->get_field_name( 'color_hover' ); ?>">
			<?php foreach ($this->colors as $c) : ?>
				<option value="<?php echo $c; ?>" <?php echo selected($color_hover, $c) ?>><?php _e($c); ?></option>
			<?php endforeach; ?>
			</select>
		</p>

		<p>	<!-- widget custom hover color -->
			<label for="<?php echo $this->get_field_id( 'color_custom_hover' ); ?>"><?php _e( 'Custom hover color:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'color_custom_hover' ); ?>" name="<?php echo $this->get_field_name( 'color_custom_hover' ); ?>" type="text" value="<?php echo esc_attr( $color_custom_hover ); ?>" >
		</p>

		<hr/>
		
			<!-- widget URL -->
		<?php foreach ($this->networks as $slug => $ndata) : ?>
			<p> <!-- Social Media -->
				<label><strong><?php _e( $ndata['title'].' URL:'); ?></strong></label>
				<input id="<?php echo $this->get_field_id( $slug ); ?>" name="<?php echo $this->get_field_name( $slug ); ?>" value="<?php echo !empty($instance[$slug]) ? $instance[$slug] : 'http://'; ?>" class="widefat" type="text" />
			</p>
		<?php endforeach; ?>

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
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['text'] = ( ! empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
		$instance['size'] = ( ! empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
		$instance['color_icon'] = ( ! empty( $new_instance['color_icon'] ) ) ? strip_tags( $new_instance['color_icon'] ) : '';
		$instance['color_custom'] = ( ! empty( $new_instance['color_custom'] ) ) ? strip_tags( $new_instance['color_custom'] ) : '';
		$instance['bg_enable'] = ( ! empty( $new_instance['bg_enable'] ) ) ? strip_tags( $new_instance['bg_enable'] ) : '';
		$instance['color_bg'] = ( ! empty( $new_instance['color_bg'] ) ) ? strip_tags( $new_instance['color_bg'] ) : '';
		$instance['color_custom_bg'] = ( ! empty( $new_instance['color_custom_bg'] ) ) ? strip_tags( $new_instance['color_custom_bg'] ) : '';
		$instance['color_hover'] = ( ! empty( $new_instance['color_hover'] ) ) ? strip_tags( $new_instance['color_hover'] ) : '';
		$instance['color_custom_hover'] = ( ! empty( $new_instance['color_custom_hover'] ) ) ? strip_tags( $new_instance['color_custom_hover'] ) : '';
		
		foreach ($this->networks as $slug => $ndata) {
			$instance[$slug] = !empty($new_instance[$slug]) ? strip_tags( $new_instance[$slug] ) : 'http://';
			// $instance[$slug.'_title'] = strip_tags( $new_instance[$slug.'_title'] );
		}

		return $instance;
	}

} // end class Ss_Social_Media_Widget

// register YPNZ_Footer_Widget widget
    function register_social_media_widget() {
        register_widget( 'ss_social_media_widget' );
    }
    add_action( 'widgets_init', 'register_social_media_widget' );
?>
