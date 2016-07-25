<?php $widgets = $GLOBALS['wp_widget_factory']->widgets; //var_dump($widgets); ?>

<!-- MODAL DIALOG FOR EACH WIDGET FORM -->
<?php foreach($widgets as $classname => $widget){ ?>
	<div id="ss-modal-add-widget-<?php echo $classname; ?>" class="modal fade ss-modal" role="dialog">
		<div class="modal-dialog modal-wide">
		
			<!-- MODAL CONTENT -->
			<div class="ss-editor-form modal-content">
				
				<div class="modal-header">
			    	<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Widget</h4>
			    </div>

				<div class="modal-body">
					<?php $widget_instance = new $classname(); ?>
					<?php $widget_instance->form(array()); ?>
				</div>

			</div>

		</div>
	</div>
<?php } ?>


<!-- MODAL DIALOG FOR CHOOSING WIDGET -->
<div id="ss-modal-add-widget" class="modal fade ss-modal" role="dialog">
	<div class="modal-dialog modal-wide">
	
		<!-- MODAL CONTENT -->
		<div class="ss-editor-form modal-content">
			
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Widget</h4>
		    </div>

			<div class="modal-body">
				<?php foreach($widgets as $classname => $widget){ ?>
					<a 
						class="ss-editor-button ss-editor-button-gray ss-editor-button-fix-width" 
						title="<?php echo $widget->widget_description; ?>" 
						href="" 
						data-widget-classname="<?php echo $classname; ?>"
						data-toggle="modal" 
						data-target="#ss-modal-add-widget-<?php echo $classname; ?>"
						>
						<?php echo $widget->name; ?>
					</a>
				<?php } ?>
			</div>

		</div>

	</div>
</div>
