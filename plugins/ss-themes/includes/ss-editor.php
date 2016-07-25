<?php
	/**
	 *	Register editor script
	 *
	 * script for moving editor content inside widget container
	 * moving modal component outside widget to fix overlay issue
	 *   
	 *	@author heryno
	 */
	function ss_register_editor_scripts() {
	    //wp_register_script( 'scrollreveal', plugins_url('../js/scrollreveal.min.js', __FILE__) );
	    wp_register_script( 'ss-editor-script', plugins_url('../js/ss-editor.js', __FILE__) );
	    wp_register_script( 'jquery-ui', plugins_url('../js/jquery-ui.min.js', __FILE__) );
	}
	add_action( 'init', 'ss_register_editor_scripts' );


	/**
	 * Register editor style
	 *
	 * @author heryno
	 */
	function ss_register_editor_style() {
	    wp_register_style( 'ss-editor-style', plugins_url('../style/ss-editor.css', __FILE__) );
	}
	add_action( 'init', 'ss_register_editor_style' );


	/**
	 * Enqueue all scripts required for media uploader
	 * used for upload/set featured image
	 *
	 * @author heryno
	 */
	function ss_editor_enqueue_media_uploader() {
		if(isset($_GET['editor']) && $_GET['editor'] == '1' && current_user_can('manage_options')){
	    	wp_enqueue_media();
		}
	}
	add_action("wp_enqueue_scripts", "ss_editor_enqueue_media_uploader");


	/**
	 * Enqueue scripts
	 * add localize javascript variable for admin ajax url
	 *
	 * @author  heryno
	 */
	function ss_editor_enqueue_scripts() {
	    wp_localize_script( "ss-editor-script", "ss_editor_ajax_url", admin_url( 'admin-ajax.php' ) );
	}
	add_action( "wp_enqueue_scripts", "ss_editor_enqueue_scripts" );


	/**
	 * Add edit homepage button at admin bar only show on homepage
	 *
	 * use query string editor = 1 to determine editing state.
	 * 
	 * @param  Object $wp_admin_bar global variable for admin bar
	 * @author heryno
	 */
	function ss_editor_toolbar( $wp_admin_bar ) {
		
		//only show on home page
		if( is_front_page()  && current_user_can('manage_options') ){

			//edit button state control
			if( isset($_GET['editor']) && $_GET['editor'] == '1' ){
				$args = array(
					'id'    => 'ss_editor',
					'title' => 'Finish Edit Homepage',
					'href'  => home_url(),
					'meta'  => array( 'class' => 'ss-editor-button ss-editor-active' )
				);
			}else{
				$args = array(
					'id'    => 'ss_editor',
					'title' => 'Edit Homepage',
					'href'  => home_url().'/?editor=1',
					'meta'  => array( 'class' => 'ss-editor-button ss-editor-non-active' )
				);
			}
			
			$wp_admin_bar->add_node( $args );

		}
	}
	add_action( 'admin_bar_menu', 'ss_editor_toolbar', 999 );


	/**
	 * Show editor button for ss theme widget
	 * 
	 * @param  Object $instance widget instance
	 * @param  Object $this     widget class
	 * @param  Array $args    	widget arguments by themes
	 * @return Object           widget instance
	 * @author heryno
	 */
	function ss_editor_widget_display($instance, $this, $args) {
		//widget instance
		$widget_instance = $this;
		$widget_area = $args['id'];
		//var_dump($widget_instance->id);
		//var_dump($widget_instance);

		if(isset($_GET['editor']) && $_GET['editor'] == '1' && current_user_can('manage_options')){
			
			//array for custom post type name mapping
			$arr_custom_post_type_name = 	array(
												'ss_parts' => 'Content', 
												'ss_home' => 'Home Content', 
												'ss_header' => 'Header Content', 
												'ss_sidebar' => 'Sidebar Content', 
												'ss_footer' => 'Footer Content', 
												'ss_slides' => 'Slide',
												'page' => 'Page'
											);

			//array for our own custom post type
			$arr_custom_post_type = array(
										'ss_parts' => 'Content', 
										'ss_home' => 'Home Content', 
										'ss_header' => 'Header Content', 
										'ss_sidebar' => 'Sidebar Content', 
										'ss_footer' => 'Footer Content', 
										'ss_slides' => 'Slide',
									);
			
			$arr_widget_no_editor = array(
										'SS Container Open',
										'SS Container Close'
									);

			//enqueue style and script
			wp_enqueue_style( 'ss-editor-style', false, array(), '1.0', true );
			wp_enqueue_script( 'ss-editor-script', false, array(), '1.0', true );
			wp_enqueue_script( 'jquery-ui', false, array(), '1.0', true );
			//wp_enqueue_media();

			//prepare variable for modal content
			$edit_content_url = "";
			$content_post_id = "";
			$content_post_type = "Widget";
			$content_image_url = "";
			$is_multiple_content = false;

			//set edit url and content id based on widget type
			if($args['widget_name'] == "SS Menu"){
				$edit_content_url = home_url()."/wp-admin/nav-menus.php";	
			}else if($args['widget_name'] == "SS Parts" || $args['widget_name'] == "SS Parts Slider" || $args['widget_name'] == "SS Parts Accordion"){
				$edit_content_url = home_url()."/wp-admin/edit.php?post_type=ss_parts";	
				$is_multiple_content = true;
			}else if($args['widget_name'] == "SS Part"){
				//$edit_content_url = get_edit_post_link($instance['part_id']);
				$content_post_id = $instance['part_id'];
			}else if($args['widget_name'] == "SS Page"){
				//$edit_content_url = get_edit_post_link($instance['page_id']);
				$content_post_id = $instance['page_id'];
			}

			//set content data based on content id
			if($content_post_id != ""){
				$content_post_type = $arr_custom_post_type_name[get_post_type($content_post_id)];				

				//get image url
				$attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id( $content_post_id ), 'thumbnail');
				$content_image_url = $attachment_data[0];
			}


			//data attribute for ss editor bar
			//need to put target widget id so we can assign each bar to its widget container
			//this attribute will be used by ss-editor.js to move editor bar to inside widget
			$arr_ss_editor_data_attribute = array();
			$arr_ss_editor_data_attribute['data-widget-id'] = $args['widget_id'];
			if(is_ss_widget($widget_instance->id_base) && $instance['custom_id'] != ""){
				$arr_ss_editor_data_attribute['data-widget-id'] = $instance['custom_id'];
			}

			//original id is used for widget sorting, we need to send the original id as in database
			//widget on ss theme can have their custom id, so we need extra data for original id
			$arr_ss_editor_data_attribute['data-widget-original-id'] = $args['widget_id'];



			//show editor bar, exclude certain widget. ie. ss container
			//TODO: show special bar for container open
			if( !in_array($args['widget_name'], $arr_widget_no_editor) ){
			?>
				
				<!-- EDITOR BAR -->
				<span class='ss-editor row' <?php echo ss_print_attributes($arr_ss_editor_data_attribute); ?> >

					<!-- editor header title -->
					<div class="ss-editor-header">
						<i class="fa fa-arrows ss-editor-move-handle ss-editor-button ss-editor-button-handle"></i>
						<?php if($content_post_id == ""){ ?>
							<?php echo $args['widget_name']; ?>
						<?php }else{ ?>
							<?php echo $content_post_type; ?>
							- 
							<?php echo wp_trim_words(strip_tags(get_the_title($content_post_id)),8,"..."); ?>
						<?php } ?>
					</div>
					
					<!-- editor button -->
					<div class="ss-editor-button-container">

							<a 
								href='' 
								class='ss-editor-button ss-editor-button-delete ss-editor-delete-widget fa fa-trash' 
								title='delete content' 
								data-widget-area="<?php echo $widget_area; ?>" 
								data-widget-id-base="<?php echo $widget_instance->id_base; ?>"
								data-widget-id="<?php echo $widget_instance->id; ?>"
								data-toggle="modal" 
								data-target="#ss-editor-confirm-delete-widget"
								>
							</a>
							<a 
								href='' 
								class='ss-editor-button ss-editor-button-primary fa fa-pencil-square-o' 
								title='edit content' 
								data-toggle="modal" 
								data-target="#myModal<?php echo $widget_instance->id; ?>"
								>
							</a>
						
					</div>
					


					<?php if($is_multiple_content){ //get content and show each edit link ?>

						<!-- MULTIPLE CONTENT -->
						<div 
							class="col-md-12 ss-editor-extra-row ss-editor-content-sortable" 
							data-widget-id="<?php echo $widget_instance->id; ?>" 
							data-widget-id-base="<?php echo $widget_instance->id_base; ?>"  
							data-widget-classname="<?php echo get_class($widget_instance); ?>" >

						<?php 
							$category = $instance['category'];
					        $number = $instance['number'];
					        if($number == 0){ //when user input number 0, that mean show all posts
					        	$number = -1; //set number for posts per page to -1 to show all posts
					        }
					        $order_by = $instance['order_by'];
					        $order = $instance['order'];

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
					        $multiple_content_posts = $query_posts->get_posts();

					        //get content post type to determine where new content should be saved
					        $last_post_type = ""; 

        					foreach ($multiple_content_posts as $post) {
        						$last_post_type = get_post_type($post->ID);

        						//get meta
								$link = get_post_meta($post->ID, 'ss_parts_url', true);
								$link_text = get_post_meta($post->ID, 'ss_parts_url_text', true);
								$new_tab = get_post_meta($post->ID, 'ss_parts_new_tab', true);

								//get image
								$attachment_data = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail');
								$content_image_url = $attachment_data[0];

								//prepare variable to used by modal-content.php
								$content_id = $post->ID;
								$content_title = $post->post_title;
								$content_content = $post->post_content;
								$content_menu_order = "0";
								
								//thumbnail on each content button. default to no image
								$editor_bar_image_url = plugins_url( '../images/no_image.png', __FILE__ );
								if($content_image_url){
									$editor_bar_image_url = $content_image_url;
								}
        					?>
								<a target='_blank' id="<?php echo $widget_instance->id; ?>content<?php echo $post->ID; ?>" href='' class='ss-editor-button ss-editor-button-secondary ss-editor-content-moveable' title='edit content' data-toggle="modal" data-target="#myModal<?php echo $widget_instance->id; ?>content<?php echo $post->ID; ?>" data-widget-id="<?php echo $widget_instance->id; ?>-part-<?php echo $post->ID; ?>">
									<i class="fa fa-arrows ss-editor-move-handle"></i>&nbsp;
									<img width="30px" height="30px" src="<?php echo $editor_bar_image_url; ?>" />&nbsp;
									<?php echo wp_trim_words(strip_tags($post->post_title),8,"..."); ?> &nbsp; <i class="fa fa-pencil-square-o"></i>
								</a>

								<?php include("editor/modal-content.php"); ?>

        					<?php
        					}
						?>
							
							<a 
								target='_blank' 
								id="<?php echo $widget_instance->id; ?>content0" 
								href='' 
								class='ss-editor-button ss-editor-button-primary fa fa-plus' 
								title='add content' 
								data-toggle="modal" 
								data-target="#myModal<?php echo $widget_instance->id; ?>content0" 
								data-widget-id="<?php echo $widget_instance->id; ?>-part-0">
							</a>

							<?php 
								$content_id = "0";
								$content_title = "";
								$content_content = "";
								$content_image_url = "";
								$content_menu_order = count($multiple_content_posts) + 1;

								include("editor/modal-content.php");
							?>

						</div>

					<?php } //end of is multiple content ?>

				</span>
				<!-- END OF EDITOR BAR -->
				


				<!-- FORM CONTENT EDITOR -->
				<?php if($content_post_id != ""){ ?>
					<?php 
						$content = get_post($content_post_id); 
						$link = get_post_meta($content_post_id, 'ss_parts_url', true);
						$link_text = get_post_meta($content_post_id, 'ss_parts_url_text', true);
						
						//open in new tab option
						$new_tab = get_post_meta($content_post_id, 'ss_parts_new_tab', true);
					?>
				<?php } ?>
				
			<?php
				include("editor/modal-widget.php");

			}

			

			
		}
		return $instance;
	}
	add_filter('widget_display_callback', 'ss_editor_widget_display', 10, 3);


	/**
	 *  Process editor POST to save content from editor update
	 *
	 *  When on editing mode, post submit will be capture by this function
	 *  To check if this is from editing form, check for ss-editor-form-oring post
	 *
	 * @author heryno
	 */
	function ss_editor_process_post() {
		

		//var_dump($_POST);
		//die();
		//$widget_area = get_option('sidebars_widgets',true);
		//var_dump($widget_area['header-top']);

		if(current_user_can('manage_options')){
			
			//process widget
			if( isset( $_POST['ss-editor-widget-id'] ) ) {
				$widget_id = $_POST['ss-editor-widget-id'];
				$widget_id_base = $_POST['ss-editor-widget-id-base'];

				//check if post come from delete dialog
		        if(isset($_POST['action']) && $_POST['action'] == 'delete'){

		        	$widget_area = $_POST['ss-editor-widget-area'];

		        	//get widget index and old instance using widget base id
					if ( preg_match( '/' . $widget_id_base . '-([0-9]+)$/', $widget_id, $matches ) ){
						$widget_index = $matches[1];
						
						//remove widget from widget area
						//get current widget area widget list
						$sidebars_widgets = get_option("sidebars_widgets", true);
						$current_widget_area = $sidebars_widgets[$widget_area];

						//if widget id exists in array list, delete
						if(($key = array_search($widget_id, $current_widget_area)) !== false) {
							unset($current_widget_area[$key]);

							//reorder index
							$current_widget_area = array_values($current_widget_area);

							//save to wp_options
							$sidebars_widgets[$widget_area] = $current_widget_area;
							update_option("sidebars_widgets", $sidebars_widgets);
						}

						//remove widget from widget list
						//get widget instance from database
						$old_instances = get_option("widget_".$widget_id_base,true);

						//if instance found remove and save
						if(isset($old_instances[$widget_index])){
							unset($old_instances[$widget_index]);
							update_option("widget_".$widget_id_base,$old_instances);
						}
						
					}

		        }else{ //update widget

		        	$widget_classname = $_POST['ss-editor-widget-classname'];
				
					//get widget index and old instance using widget base id
					if ( preg_match( '/' . $widget_id_base . '-([0-9]+)$/', $widget_id, $matches ) ){
						$widget_index = $matches[1];
						
						//get widget instance from database
						$old_instances = get_option("widget_".$widget_id_base,true);
						
						//if instance found update and save
						if(isset($old_instances[$widget_index])){
							$old_instance = $old_instances[$widget_index];
							$new_instance = $_POST['widget-'.$widget_id_base][$widget_index];

							//instantiate class to use update method
							$edited_widget = new $widget_classname();
							$updated_instance = $edited_widget->update($new_instance,$old_instance);
							

							//save to database
							$old_instances[$widget_index] = $updated_instance;

							//var_dump($old_instances);
							//die();
							update_option("widget_".$widget_id_base,$old_instances);
						}	
					}

		        }
				
				
			}

			//process post content
		    if( isset( $_POST['ss-editor-form-origin'] ) ) {

		        //post data for content
		        $id = $_POST['ss-editor-content-id'];

		        //check if post come from delete dialog
		        if(isset($_POST['action']) && $_POST['action'] == 'delete'){

		        	$content_post_type = $_POST["ss-editor-post-type"];

		        	//remove category, not actually delete post
		        	wp_set_object_terms($id, array(), $content_post_type."_category");

		        }else{ //insert or update content
		        	
		        	//content
		        	$title = $_POST['ss-title'];
			        $content = $_POST['ss-content'];
			        $featured_image_id = $_POST['ss-featured-image-id'];

			        //meta
			        $ss_parts_url = $_POST['ss-parts-url'];
			        $ss_parts_url_text = $_POST['ss-parts-url-text'];
			        $ss_parts_new_tab = '0';
			        if(isset($_POST['ss-parts-new-tab'])){
			        	$ss_parts_new_tab = $_POST['ss-parts-new-tab'];
			        }
			        
			        //id 0 mean new content
			        if($id == "0"){

			        	//get extra information from hidden input
			        	$content_post_type = $_POST["ss-editor-post-type"];
			        	$content_menu_order = $_POST['ss-editor-content-menu-order'];
			        	
			        	//insert post
				        $my_post = 	array(
								    	'ID'           => $id,
								    	'post_title'   => $title,
								    	'post_content' => $content,
								    	'post_type'	   => $content_post_type,
								    	'menu_order'   => $content_menu_order,
								    	'post_status'  => 'Publish'
									);
						$id = wp_insert_post( $my_post );
						
						//set category for multi content widget. ie: ss_parts, ss_parts_slide
						$content_categories = array(intval($_POST['ss-editor-content-category']));
						wp_set_object_terms($id, $content_categories, $content_post_type."_category");

			        }else{
			        	//update post
				        $my_post = 	array(
								    	'ID'           => $id,
								    	'post_title'   => $title,
								    	'post_content' => $content,
									);
						wp_update_post( $my_post );	
			        }
			        

					//update featured image
					if($featured_image_id != "" && $featured_image_id != 0){
						set_post_thumbnail($id, $featured_image_id);
					}

					if($featured_image_id == "-1"){
						delete_post_thumbnail($id);
					}

					//update post meta
					update_post_meta($id,'ss_parts_url',$ss_parts_url);
					update_post_meta($id,'ss_parts_url_text',$ss_parts_url_text);
					update_post_meta($id,'ss_parts_new_tab',$ss_parts_new_tab);

		        }

		        

		    }


		    if( isset( $_POST['ss-editor-widget-id'] ) || isset( $_POST['ss-editor-form-origin']) ) {
			    
			    //redirect to the same page. this will prevent the browser to asking re-submit data when user refresh the page
				$current_url = esc_url("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
				header("Location:".$current_url);
				die();

			}
		}
	}
	add_action( 'init', 'ss_editor_process_post' );



	/**
	 * Print modal container and ajax loader gif
	 *
	 * use by ss editor ajax call to show loading state and prevent
	 * user interaction before ajax call is complete
	 * 
	 * @author heryno
	 */
	function ss_editor_print_ajax_loader(){
		if(isset($_GET['editor']) && $_GET['editor'] == '1' && current_user_can('manage_options')){
			$loader_image = plugins_url( '../images/loader.gif', __FILE__ );
			echo "<div id='ss-editor-ajax-loader' style='display:none'><img src='".$loader_image."'><span>Saving...</span></div>";
		}
	}
	add_action( 'wp_footer', 'ss_editor_print_ajax_loader');


	/**
	 * Print extra DOM element for editor
	 *
	 * modal delete content use for delete content dialog
	 * modal delete widget use for delete widget dialog
	 * widget area bar use for extra control and will be duplicate on each widget area
	 * 
	 * @author heryno
	 */
	function ss_editor_print_delete_dialog(){
		if(isset($_GET['editor']) && $_GET['editor'] == '1' && current_user_can('manage_options')){
			include("editor/modal-delete-content.php");
			include("editor/modal-delete-widget.php");
			include("editor/widget-area-bar.php");
			include("editor/modal-add-widget.php");
		}
	}
	add_action( 'wp_footer', 'ss_editor_print_delete_dialog');


	/**
	 * save content re-order ajax callback
	 * 
	 * @return integer 	1=success
	 */
	function ss_editor_reorder_content_callback() {
		global $wpdb; 
		
		$widget_id = $_POST['widget_id'];
		$widget_id_base = $_POST['widget_id_base'];
		$widget_classname = $_POST['widget_classname'];
		$content_order = stripslashes($_POST['content_order']); //array of content id in json string
		$content_order = json_decode($content_order);


		//---update menu order of each post---
		$x = 1;
		foreach ($content_order as $content_post_id) {
			$content_post_id = str_replace($widget_id."content", "", $content_post_id); //remove the widget id part

			$my_post = array(
			    'ID'           => $content_post_id,
			    'menu_order'   => $x, //ascending order start from 1
			);

			// Update the post into the database
			wp_update_post( $my_post );
			
			$x++;
		}
		
		
		//---update widget to use menu order for sorting---
		//get widget index and old instance using widget base id
		if ( preg_match( '/' . $widget_id_base . '-([0-9]+)$/', $widget_id, $matches ) ){
			$widget_index = $matches[1];

			//get widget instance from database
			$old_instances = get_option("widget_".$widget_id_base,true);

			//if instance found update and save
			if(isset($old_instances[$widget_index])){
				$old_instance = $old_instances[$widget_index];
				$new_instance = $old_instance;
				$new_instance['order'] = 'ASC';
				$new_instance['order_by'] = 'menu_order';

				//instantiate class to use update method
				$edited_widget = new $widget_classname();
				$updated_instance = $edited_widget->update($new_instance,$old_instance);
				

				//save to database
				$old_instances[$widget_index] = $updated_instance;

				//var_dump($old_instances);
				//die();
				update_option("widget_".$widget_id_base,$old_instances);

				//get new content
				ob_start();

				//add "edited" suffix to prevent conflict with existing id on layout, see ss-editor.js for further reference
				$edited_widget->id = $widget_id."edited";
				$edited_widget->widget(array(), $new_instance);
				$new_content = ob_get_clean();
				
				$result = array();
				$result['status'] = "1";
				$result['message'] = $new_content;

				echo json_encode($result);
			}
		}

		//echo "1";

		wp_die(); // this is required to terminate immediately and return a proper response
	}
	add_action( 'wp_ajax_ss_editor_reorder_content', 'ss_editor_reorder_content_callback' );


	/**
	 * save widget re-order ajax callback
	 * 
	 * @return integer 	1=success
	 */
	function ss_editor_reorder_widget_callback(){
		global $wpdb; 

		$widget_area = $_POST['widget_area'];
		$widget_order = stripslashes($_POST['widget_order']); //array of widget id in json string
		$widget_order = json_decode($widget_order);

		//get widget area widget list from wp_options table
		$sidebars_widgets = get_option("sidebars_widgets", true);
		$current_widget_area = $sidebars_widgets[$widget_area];
		
		//check the number of widget is consistent
		if(count($current_widget_area) == count($widget_order)){
			$sidebars_widgets[$widget_area] = $widget_order;
			update_option("sidebars_widgets", $sidebars_widgets);	
			echo "1";
		}else{
			echo "0";
		}
		
	}
	add_action( 'wp_ajax_ss_editor_reorder_widget', 'ss_editor_reorder_widget_callback' );




	/*
	*  Add edit content link on page
	*/
	function ss_editor_the_content($content){
		if(isset($_GET['editor']) && $_GET['editor'] == '1' && current_user_can('manage_options')){
			wp_enqueue_style( 'ss-editor-style' );
			$edit_content_url = get_edit_post_link();

			$new_content = "<span class='ss-editor'>";
			$new_content .= "<h3>Page Content</h3>";
			$new_content .=  " - <a target='_blank' href='".$edit_content_url."'>edit content</a>";
			$new_content .= "</span>";
			$new_content .= $content;
			return $new_content;
		}else{
			return $content;
		}
	}
	//add_filter('the_content', 'ss_editor_the_content');

?>