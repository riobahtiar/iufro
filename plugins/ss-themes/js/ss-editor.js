jQuery(document).ready(function(){

	//collapse/expand all widget content trigger by widget area bar
	jQuery(".ss-editor-widget-area-collapse").live("click",function(evt){
		evt.preventDefault();

		if(jQuery(this).data("ssEditorState") == "expand"){
			jQuery(this).data("ssEditorState","collapse");
			jQuery(this).removeClass("fa-toggle-up");
			jQuery(this).addClass("fa-toggle-down");
			jQuery(this).attr("title","Expand Content");

			//select into parent widget area section, then all widget content except editor bar
			jQuery(this).parent().parent().parent().children(".ss-editor-moveable").children().not(".ss-editor").slideUp();
		}else{
			jQuery(this).data("ssEditorState","expand");
			jQuery(this).removeClass("fa-toggle-down");
			jQuery(this).addClass("fa-toggle-up");
			jQuery(this).attr("title","Collapse Content");

			//select into parent widget area section, then all widget content except editor bar
			jQuery(this).parent().parent().parent().children(".ss-editor-moveable").children().not(".ss-editor").slideDown();
		}

	});


	//get widget area bar (print on footer) and duplicate it into each widget area section
	var widgetBarHTML = jQuery("#ss-editor-widget-area-bar").html();
	jQuery("#ss-editor-widget-area-bar").detach(); //remove from layout but keep all associate function

	var widgetAreas = ["header-top","header-middle","header-bottom","home-top","home-middle","home-bottom","footer-top","footer-middle","footer-bottom"];
	for(x in widgetAreas){
		if(jQuery("#"+widgetAreas[x]).length){
			var widgetAreaName = widgetAreas[x].replace("-"," ");

			jQuery("#"+widgetAreas[x]).prepend(widgetBarHTML);
			jQuery("#"+widgetAreas[x]+" .ss-editor-widget-area-bar .ss-editor-header").html("Widget Area: "+widgetAreaName);
			jQuery("#"+widgetAreas[x]+" .ss-editor-button-add").data("widgetArea",widgetAreas[x]);
		}
	}

	

	//trigger dialog for delete widget confirmation
	jQuery(".ss-editor-delete-widget").click(function(){
		var widgetArea = jQuery(this).data("widgetArea");
		var widgetID = jQuery(this).data("widgetId");
		var widgetIDBase = jQuery(this).data("widgetIdBase");

		jQuery("#ss-editor-confirm-delete-widget input[name='ss-editor-widget-area']").val(widgetArea);
		jQuery("#ss-editor-confirm-delete-widget input[name='ss-editor-widget-id']").val(widgetID);
		jQuery("#ss-editor-confirm-delete-widget input[name='ss-editor-widget-id-base']").val(widgetIDBase);
	});


	//trigger dialog for delete content on multi content widget
	jQuery(".ss-editor-delete-content").click(function(evt){
		evt.preventDefault();

		var contentID = jQuery(this).data("contentId");
		var contentPostType = jQuery(this).data("contentPostType");
		jQuery("#ss-editor-delete-content-id").val(contentID);
		jQuery("#ss-editor-delete-content-post-type").val(contentPostType);
	});


	// move editor bar inside widget container
	// editor bar consistent with layout, prevent layout break
	// add moveable class to activate sortable function
	jQuery('.ss-editor').each(function(){
		var widgetID = jQuery(this).data('widgetId');
		if(widgetID != null){
			jQuery(this).prependTo("#"+widgetID);
			jQuery(this).addClass('ss-editor-moved');
			jQuery("#"+widgetID).addClass('ss-editor-moveable');
		}
	});

	//jQuery(".ss-editor-moveable").children().not(".ss-editor").hide();

	//move all modal dialog to beginning of body tag so that it won't overlap by other element
	jQuery('.ss-modal').each(function(){
		jQuery(this).prependTo('body');
	});


	var media_uploader = null;
	var ss_editor_current_post_id = 0;

	//deprecated
	function open_media_uploader_image()
	{
	    media_uploader = wp.media({
	    	title: "Set Featured Image", 
	        frame: "post",
	        state: "insert",
	        multiple: false
	    });
	    console.log(media_uploader);

	    media_uploader.on("insert", function(){
	        var json = media_uploader.state().get("selection").first().toJSON();

	        //add image into container and show remove image link
	        jQuery("#ss-editor-image"+ss_editor_current_post_id).val(json.id);
	        jQuery("#ss-editor-image-container"+ss_editor_current_post_id).html("<img src='"+json.sizes.thumbnail.url+"'>");
	        jQuery("#ss-editor-remove-image"+ss_editor_current_post_id).show();
	        
	    });

	    media_uploader.open();
	}

	//handle media upload using default wordpress upload feature
	function open_media_uploader_image2(){
		var insertImage = wp.media.controller.Library.extend({
		    defaults :  _.defaults({
		            id:        'insert-image',
		            title:      'Set Featured Image',
		            allowLocalEdits: false,
		            displaySettings: false,
		            displayUserSettings: false,
		            multiple : false,
		            type : 'image'//audio, video, application/pdf, ... etc
		      }, wp.media.controller.Library.prototype.defaults )
		});

		//Setup media frame
		var frame = wp.media({
		    button : { text : 'Select' },
		    state : 'insert-image',
		    states : [
		        new insertImage()
		    ]
		});

		//on close, if there is no select files, remove all the files already selected in your main frame
		frame.on('close',function() {

		});

		frame.on( 'select',function() {
		    var state = frame.state('insert-image');
		    var selection = state.get('selection');
		    var json = selection.first().toJSON();

		    if ( ! selection ) return;

		    jQuery("#ss-editor-image"+ss_editor_current_post_id).val(json.id);
	        jQuery("#ss-editor-image-container"+ss_editor_current_post_id).html("<img src='"+json.sizes.thumbnail.url+"'>");
	        jQuery("#ss-editor-remove-image"+ss_editor_current_post_id).show();

		    
		});

		//reset selection in popup, when open the popup
		frame.on('open',function() {
		    var selection = frame.state('insert-image').get('selection');

		    //remove all the selection first
		    selection.each(function(image) {
		        var attachment = wp.media.attachment( image.attributes.id );
		        attachment.fetch();
		        selection.remove( attachment ? [ attachment ] : [] );
		    });

		});

		//now open the popup
		frame.open();
	}

	//trigger media upload interface
	//store post id at temp variable so image upload result can be put on the right editor dialog
	jQuery('.ss-editor-media-uploader').click(function(evt){
		evt.preventDefault();

		ss_editor_current_post_id = jQuery(this).data('postId');
		open_media_uploader_image2();

		
	});

	//remove image event
	jQuery(".ss-editor-remove-image").click(function(evt){
		evt.preventDefault();

		ss_editor_current_post_id = jQuery(this).data('postId');

		jQuery("#ss-editor-image"+ss_editor_current_post_id).val("-1");
		jQuery("#ss-editor-image-container"+ss_editor_current_post_id).html("<a href='' >Set featured image</a>");
		jQuery(this).hide();
	});


	//multipart content sort
	jQuery( ".ss-editor-content-sortable" ).sortable({
		items: "> .ss-editor-content-moveable",
		cursor: "move",
		stop: function( event, ui ) {
			jQuery("#ss-editor-ajax-loader").show();

			var finalOrder = jQuery(this).sortable("toArray");
			var finalOrderJSONString = JSON.stringify(finalOrder);

			var widgetID = jQuery(this).data("widgetId");
			var widgetIDBase = jQuery(this).data("widgetIdBase");
			var widgetClassname = jQuery(this).data("widgetClassname");

			var data = {
				'action': 'ss_editor_reorder_content',
				'widget_id': widgetID,
				'widget_id_base': widgetIDBase,
				'widget_classname': widgetClassname,
				'content_order': finalOrderJSONString
			};

			jQuery.post(ss_editor_ajax_url, data, function(response) {
				var result = jQuery.parseJSON(response);


				if(result.status == '1'){
					//if success, new widget generated html will be returned with id contains "edited" suffix
					//put it as next item
					//remove content from current widget
					//add new content to current widget
					jQuery("#"+widgetID).after(result.message);
					jQuery("#"+widgetID+" > div").detach();
					jQuery("#"+widgetID+" > h2").detach();
					jQuery("#"+widgetID).append(jQuery("#"+widgetID+"edited").html());
					jQuery("#"+widgetID+"edited").remove();

					//redo init for slider
					app.init();

					jQuery("#ss-editor-ajax-loader").hide();
				}

			});
		}
	});


	//widget sort
	jQuery( ".header-wrapper, .home-wrapper, .footer-wrapper" ).sortable({
		items: "> .ss-editor-moveable",
		cursor: "move",
		handle: ".ss-editor-move-handle",
		stop: function( event, ui ) {
			jQuery("#ss-editor-ajax-loader").show();

			var finalOrder = jQuery(this).sortable("toArray");
			
			//for ss theme widget, widget id might use custom id
			//so we need to get the data widget-original-id from ss editor bar
			//that put inside the widget container by our js script
			var widgetOrder = [];
			for(x in finalOrder){
				widgetOrder[x] =  jQuery("#"+finalOrder[x]+" > .ss-editor").data("widgetOriginalId");
			}
			var finalOrderJSONString = JSON.stringify(widgetOrder);

			console.log(jQuery(this).attr('id'));
			console.log(finalOrderJSONString);

			//send new order to wordpress
			var data = {
				'action': 'ss_editor_reorder_widget',
				'widget_area': jQuery(this).attr('id'),
				'widget_order': finalOrderJSONString
			};

			jQuery.post(ss_editor_ajax_url, data, function(response) {
				//alert('Got this from the server: ' + response);
				console.log(response);
				
				jQuery("#ss-editor-ajax-loader").hide();
			});
		}
	});

});