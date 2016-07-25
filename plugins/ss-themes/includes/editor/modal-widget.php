				<div id="myModal<?php echo $widget_instance->id; ?>" class="modal fade ss-modal" role="dialog">
					<div class="modal-dialog modal-wide">
						
						<!-- MODAL CONTENT -->
						<div class="ss-editor-form modal-content">
							
							<form method="POST" action="">
								<div class="modal-header">
							    	<button type="button" class="close" data-dismiss="modal">&times;</button>
							    	<h4 class="modal-title">Edit <?php echo $content_post_type; ?></h4>
							    </div>
								
								<div class="modal-body">
									
									<!-- TAB PANEL -->
									<ul class="nav nav-tabs">
										<?php if($content_post_id != ""){ ?>
											<li class="active"><a data-toggle="tab" href="#tab-content<?php echo $widget_instance->id; ?>">Content</a></li>
											<li><a data-toggle="tab" href="#tab-widget<?php echo $widget_instance->id; ?>">Widget Setting</a></li>
										<?php }else{ ?>
											<li class="active"><a data-toggle="tab" href="#tab-widget<?php echo $widget_instance->id; ?>">Widget Setting</a></li>
										<?php } ?>
									</ul>
									
									<!-- TAB CONTENT -->
									<div class="tab-content">
										
										<?php if($content_post_id != ""){ ?>
											<div id="tab-content<?php echo $widget_instance->id; ?>" class="tab-pane fade in active">
												
												<!-- TITLE -->
												<div class="form-group">
													<label for="ssTitle"><!-- Title --></label>
													<input class="form-control" type="text" name="ss-title" value="<?php echo htmlentities($content->post_title,ENT_QUOTES); ?>">
												</div>

												<!-- CONTENT -->
												<div class="form-group">
													<!-- <label for="">Content</label> -->
													<?php wp_editor($content->post_content,"content".$content_post_id,array('editor_height'=>'200px','textarea_name'=>'ss-content') ); ?>
												</div>
												
												
												<div class="row">
													
													<?php if(in_array($content_post_type, $arr_custom_post_type)){ ?>
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
													<?php } ?>

													<div class="col-md-3">
														<!-- FEATURED IMAGE -->
														<div class="form-group">
															<h4>Featured image</h4>
															<div id="ss-editor-image-container<?php echo $content_post_id; ?>" 
																class="ss-editor-media-uploader" 
																data-post-id="<?php echo $content_post_id; ?>" >
																<?php if($content_image_url == ""){ ?>
																	<a class="ss-editor-set-image" href="" >Set featured image</a>
																<?php }else{ ?>
																	<img src="<?php echo $content_image_url; ?>">
																<?php } ?>
															</div>

															
															<a id="ss-editor-remove-image<?php echo $content_post_id; ?>"
																class="ss-editor-remove-image" 
																href="" 
																data-post-id="<?php echo $content_post_id; ?>"
																<?php if($content_image_url == ""){ echo "style='display:none'"; } ?> >
																Remove featured image
															</a>
															

															<input id="ss-editor-image<?php echo $content_post_id; ?>" type="hidden" name="ss-featured-image-id" value=""></input>
														</div>
													</div>

												</div>
												

												
												
												<input type="hidden" name="ss-editor-content-id" value="<?php echo $content_post_id; ?>"></input>
												<input type="hidden" name="ss-editor-form-origin" value="ss-editor"></input>

											</div>
										<?php } ?>
										
										<!-- TAB WIDGET -->
										<div id="tab-widget<?php echo $widget_instance->id; ?>" class="tab-pane fade <?php if($content_post_id == ""){ echo 'in active'; }?> ">
											
											<input type="hidden" name="ss-editor-widget-id" value="<?php echo $widget_instance->id; ?>"></input>
											<input type="hidden" name="ss-editor-widget-id-base" value="<?php echo $widget_instance->id_base; ?>"></input>
											<input type="hidden" name="ss-editor-widget-classname" value="<?php echo get_class($widget_instance); ?>"></input>
											<?php //var_dump($widget_instance->id_base); ?>
											<?php $widget_instance->form($instance); ?>

										</div>

									</div>

								</div>

								<div class="modal-footer">
									<?php if($edit_content_url != "" && !$is_multiple_content){ ?>
										<a target='_blank' href='<?php echo $edit_content_url; ?>' class='ss-editor-button ss-editor-button-primary' title='edit content'>Edit Content</a>
									<?php } ?>
									<button type="submit" class="ss-editor-button ss-editor-button-primary">Update</button>
							    </div>
							</form>


						</div>

					</div>
				</div>