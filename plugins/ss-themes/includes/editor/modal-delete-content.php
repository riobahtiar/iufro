		<div class="modal fade ss-modal ss-modal-delete" id="ss-editor-confirm-delete-content" role="dialog" >
		    <div class="ss-editor-form modal-dialog">

		    	<form method="POST" action="">

			        <div class="modal-content">
			            <div class="modal-header">
			            	<button type="button" class="close" data-dismiss="modal">&times;</button>
			                <h4 class="modal-title">Delete Content</h4>
			            </div>
			            <div class="modal-body">
			                Are you sure want to delete this content?
			            </div>
			            <div class="modal-footer">
			            	<input type="hidden" name="ss-editor-content-id" value="0" id="ss-editor-delete-content-id"></input>
			            	<input type="hidden" name="ss-editor-post-type" value="" id="ss-editor-delete-content-post-type"></input>	
							<input type="hidden" name="ss-editor-form-origin" value="ss-editor"></input>
			                <button type="button" class="ss-editor-button ss-editor-button-primary" data-dismiss="modal">Cancel</button>
			                <button type="submit" name="action" class="ss-editor-button ss-editor-button-delete" value="delete">Delete</button>
			            </div>
			        </div>

		        </form>

		    </div>
		</div>