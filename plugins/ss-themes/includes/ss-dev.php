<?php
	function ss_register_dev_style() {
	    wp_register_style( 'ss-dev-style', plugins_url('../style/ss-dev.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_dev_style' );

	
	function ss_dev_widget_name($instance, $this, $args) {
		//$this->form($instance);
		//var_dump($this);
		//$wid = new $this;
		//$wid->form($instance);

		if(isset($_GET['dev']) && $_GET['dev'] == '1' && current_user_can('manage_options')){
			$edit_content_url = "";
			if($args['widget_name'] == "SS Menu"){
				$edit_content_url = home_url()."/wp-admin/nav-menus.php";	
			}else if($args['widget_name'] == "SS Parts" || $args['widget_name'] == "SS Parts Slider"){
				$edit_content_url = home_url()."/wp-admin/edit.php?post_type=ss_parts";	
			}else if($args['widget_name'] == "SS Part"){
				$edit_content_url = get_edit_post_link($instance['part_id']);
			}

			wp_enqueue_style( 'ss-dev-style' );
			echo "<span class='ss-dev'>";
			echo "<h3>".$args['name']."</h3> - <b>".$args['widget_name']."</b> - ".$args['widget_id'];
			
			if($edit_content_url != ""){
				echo " - <a target='_blank' href='".$edit_content_url."'>edit content</a>";	
			}
			
			if($_GET['setting'] == '1'){
				echo "<br/>";
				var_dump($instance);
			}

			if($args['widget_name'] == "SS Part"){
				//ss_part_edit_form($instance['part_id']);
			}

			echo "</span>";

			
		}
		return $instance;
	}
	add_filter('widget_display_callback', 'ss_dev_widget_name', 10, 3);


	function ss_part_edit_form($part_id){
		$post = get_post($part_id);
	?>

		<form>
			<input type="text" name="part_id" value="<?php echo $part_id; ?>">
			<textarea><?php echo $post->post_content; ?></textarea>
		</form>

	<?php
	}

	/*
	*  Add edit content link on page
	*/
	function ss_dev_the_content($content){
		if(isset($_GET['dev']) && $_GET['dev'] == '1' && current_user_can('manage_options')){
			wp_enqueue_style( 'ss-dev-style' );
			$edit_content_url = get_edit_post_link();

			$new_content = "<span class='ss-dev'>";
			$new_content .= "<h3>Page Content</h3>";
			$new_content .=  " - <a target='_blank' href='".$edit_content_url."'>edit content</a>";
			$new_content .= "</span>";
			$new_content .= $content;
			return $new_content;
		}else{
			return $content;
		}
	}
	add_filter('the_content', 'ss_dev_the_content');

?>