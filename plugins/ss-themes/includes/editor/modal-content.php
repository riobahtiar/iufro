<div id="myModal<?php echo $widget_instance->id; ?>content<?php echo $content_id; ?>" class="modal fade ss-modal" role="dialog">
	<div class="modal-dialog modal-wide">
		
		<!-- MODAL CONTENT -->
		<div class="ss-editor-form modal-content">
			
			<form method="POST" action="">
				<div class="modal-header">
			    	<button type="button" class="close" data-dismiss="modal">&times;</button>
			    	<?php if($content_id == "0"){ ?>
						<h4 class="modal-title">Add Content</h4>
			    	<?php }else{ ?>
			    		<h4 class="modal-title">Edit Content</h4>
			    	<?php } ?>
			    </div>
				
				<div class="modal-body">
					
					<!-- TAB PANEL -->
					<ul class="nav nav-tabs">
						
						<li class="active"><a data-toggle="tab" href="#tab-content<?php echo $widget_instance->id; ?>">Content</a></li>
						
					</ul>
					
					<!-- TAB CONTENT -->
					<div class="tab-content">
						
						<div id="tab-content<?php echo $widget_instance->id; ?>" class="tab-pane fade in active">
							
							<!-- TITLE -->
							<div class="form-group">
								<label for="ssTitle"><!-- Title --></label>
								<input class="form-control" type="text" name="ss-title" value="<?php echo htmlentities($content_title,ENT_QUOTES); ?>">
							</div>

							<!-- CONTENT -->
							<div class="form-group">
								<!-- <label for="">Content</label> -->
								<?php wp_editor($content_content,"content".$content_id,array('editor_height'=>'200px','textarea_name'=>'ss-content') ); ?>
							</div>
							
							
							<div class="row">
																				
								<div class="col-md-9">
									<!-- METABOX -->
									<div class="form-group">
										<h4>Link</h4>

										<label>Link To</label>
										<input class="form-control" type="text" name="ss-parts-url" value="<?php echo $link; ?>" data-toggle="tooltip" title="Hooray!">

										<label>Link Text</label>
										<input class="form-control" type="text" name="ss-parts-url-text" value="<?php echo $link_text; ?>" >
										
										<div class="checkbox">
											<label>
												<input type="checkbox" name="ss-parts-new-tab" value="1" <?php checked( $new_tab, '1' ); ?> > Open in new tab
											</label>
										</div>

									</div>
								</div>

								<div class="col-md-3">
									<!-- FEATURED IMAGE -->
									<div class="form-group">
										<h4>Featured image</h4>
										<div id="ss-editor-image-container<?php echo $content_id; ?>" 
											class="ss-editor-media-uploader" 
											data-post-id="<?php echo $content_id; ?>" >
											<?php if($content_image_url == ""){ ?>
												<a class="ss-editor-set-image" href="" >Set featured image</a>
											<?php }else{ ?>
												<img src="<?php echo $content_image_url; ?>">
											<?php } ?>
										</div>

										
										<a id="ss-editor-remove-image<?php echo $content_id; ?>"
											class="ss-editor-remove-image" 
											href="" 
											data-post-id="<?php echo $content_id; ?>"
											<?php if($content_image_url == ""){ echo "style='display:none'"; } ?> >
											Remove featured image
										</a>
										

										<input id="ss-editor-image<?php echo $content_id; ?>" type="hidden" name="ss-featured-image-id" value=""></input>
									</div>
								</div>

							</div>
							
							
							<input type="hidden" name="ss-content-id" value="<?php echo $content_id; ?>"></input>
							<input type="hidden" name="ss-editor-form-origin" value="ss-editor"></input>
							<input type="hidden" name="ss-editor-post-type" value="<?php echo $last_post_type; ?>"></input>
							<input type="hidden" name="ss-editor-widget-area" value="<?php echo $widget_area; ?>"></input>
							<input type="hidden" name="ss-editor-content-category" value="<?php echo $instance['category']; ?>"></input>
							<input type="hidden" name="ss-editor-content-menu-order" value="<?php echo $content_menu_order; ?>"></input>
						</div>
						

					</div>

				</div>

				<div class="modal-footer">
					<?php if($content_id == "0"){ ?>
						<button type="submit" class="ss-editor-button ss-editor-button-primary">Save</button>
					<?php }else{ ?>
						<button type="submit" class="ss-editor-button ss-editor-button-delete ss-editor-delete-content" value="delete" data-toggle="modal" data-target="#ss-editor-confirm-delete-content" data-content-id="<?php echo $content_id; ?>" data-content-post-type="<?php echo $last_post_type; ?>">Delete</button>
						<button type="submit" class="ss-editor-button ss-editor-button-primary">Update</button>
					<?php } ?>
			    </div>
			</form>


		</div>

	</div>
</div>