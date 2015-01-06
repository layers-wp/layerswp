/**
* Admin JS file
*
* This file contains global admin functions
 *
 * @package Layers
 * @since Layers 1.0
 * Contents
 * 1 - Media Uploaders
 * 1.a - Image Remove Button
 * 1.b - Image Upload Button
 * 1.c - General File Remove Button
 * 1.d - General File Upload Button
 * 2 - Background Selectors
 * 3 - Color Selectors
 * 4 - Sortable Columns
 * 5 - Tabs
 * 6 - Design Controller toggles
 * 7 - Design Controller Height Matcher
 * 8 - Widget Focussing
 * 9 - Init 'Medium' editors
 * 10 - Trigger input changes
 * 11 - Add Last Class to Design Bar Elements
 * 12 - Show/Hide linked elements
*/

jQuery(function($) {

	/**
	* 1 - Media Uploaders
	*/

	// 1.a - Image Remove Button
	var file_frame;
	$(document).on( 'click' , '.layers-image-container .layers-image-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

 		// Get the container
 		$container = $that.closest( '.layers-image-container' );

		$that.siblings('img').remove();
		$container.removeClass( 'layers-has-image' );
		$container.find('input').val('').layers_trigger_change();
		$that.fadeOut();
		return false;
	});

	// 1.b - Image Upload Button
	$(document).on( 'click' , '.layers-image-upload-button' , function(e){
		e.preventDefault();

		// "Hi Mom"
 		$that = $(this);

 		// Get the container
 		$container = $that.closest( '.layers-image-container' );

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.close();
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $that.data( 'title' ),
			button: {
				text: $that.data( 'button_text' ),
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			// Remove any old image
			$container.find('img').remove();

			// Fade in Remove button
			$container.find('.layers-image-remove').fadeIn();

			// Set attachment to the larege/medium size if they're defined
			if( undefined !== attachment.sizes.large ) {
				$attachment = attachment.sizes.large;
			} else if ( undefined !== attachment.sizes.medium )  {
				$attachment = attachment.sizes.medium;
			} else {
				$attachment = attachment;
			}

			// Create new image object
			var $image = $('<img />').attr({
				class: 'image-reveal',
				src:  $attachment.url,
				height:  $attachment.height,
				width: $attachment.width
			});

			$container.children('.layers-image-display').eq(0).append( $image );

			// Add 'Has Image' Class
			$container.addClass( 'layers-has-image' );

			// Trigger change event
			$container.find('input').val( attachment.id ).layers_trigger_change();

			return;
		});

		// Finally, open the modal
		file_frame.open();
	});


	// 1.c - General File Remove Button
	$(document).on( 'click' , '.layers-file-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$that.siblings('span').text('');
		$that.siblings('input').val('').layers_trigger_change();

		$that.fadeOut();
		return false;
	});

	// 1.d - General File Upload Button
	$(document).on( 'click' , '.layers-regular-uploader' , function(e){
		e.preventDefault();

		// "Hi Mom"
 		$that = $(this);

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.close();
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $that.data( 'title' ),
			button: {
				text: $that.data( 'button_text' ),
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			// Fade in Remove button
			$that.siblings('small').fadeIn();

			// Add file name to the <span>
			$that.siblings('span').text( attachment.filename );

			// Trigger change event
			$that.siblings('input').val( attachment.id ).layers_trigger_change();

			return;
		});

		// Finally, open the modal
		file_frame.open();

	});

	/**
	* 2 -Background Selectors
	*/
	$(document).on( 'click', '.layers-background-selector li' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$type = $that.data('type');
		$id = $that.data('id');
		$index = $that.index();

		// Our main containing div, we could use .parent() but what if we change the depth of this li?
		$elements = $( $id + '-controller' ).find( '.layers-controller-elements' );

		// Change the input value
		$( $id + '-type' ).val( $type ).layers_trigger_change();

		// Switch the selectors
		$that.addClass( 'active' );
		$that.siblings().removeClass( 'active' );

		// Switch the view
		$elements.find( '.layers-content' ).eq( $index ).addClass('section-active');
		$elements.find( '.layers-content' ).eq( $index ).siblings().removeClass('section-active');
	});

	/**
	* 3 - Color Selectors
	*/
	layers_set_color_selectors();
	$(document).on ( 'widget-added' , function( event, widget_focus ){

		$(this).find('.layers-color-selector').each(function(){
			var $picker = $(this);
			$picker.closest('.wp-picker-container').replaceWith( $picker );
			setTimeout( function() {
				layers_set_color_selectors();
			} , 250 );
		});

	} );

	function layers_set_color_selectors(){
		
		jQuery('.layers-color-selector').wpColorPicker({
			change: function(event, ui){
				if( 'undefined' !== typeof event ){
					
					//Update the color input
					$(event.target).val( ui.color.toString() );
					
					// Debounce the color changes
					layers_debounce_color_selector( event.target );
					
				}
			},
			clear: function() {
				if( 'undefined' !== typeof event ){
					
					// Debounce the reset change
					layers_debounce_color_selector( event.target );
				}
			},
		});
	}
	
	var layers_debounce_color_selector = _.debounce(function( element ){
		$( element ).layers_trigger_change();
	}, 200);

	/**
	* 4 - Sortable Columns
	*/
	layers_set_sortable_cols();

	function layers_set_sortable_cols(){
		if( $.sortable == undefined ) return;

		$( '.layers-sortable' ).sortable({
			placeholder: "layers-sortable-drop"
		});
	}


	/**
	* 5 - Tabs
	*/
	$( document ).on( 'click' , '.layers-tabs li' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Get the Tab Index
		$i = $that.index();

		// Make this tab active
		$that.addClass( 'active' ).siblings().removeClass( 'active' );

		// Get the nearest tab containers
		$tab_nav = $that.closest( '.layers-nav-tabs' );
		$tab_container = $tab_nav.siblings('.layers-tab-content');

		// Show/Hide tabs
		$tab_container.find( 'section.layers-tab-content' ).eq( $i ).slideDown().siblings( 'section.layers-tab-content' ).slideUp();
	});


	/**
	* 6 - Design Controller toggles
	*/
	$( document ).on( 'click' , '.widget .layers-visuals-wrapper li.layers-visuals-item a.layers-icon-wrapper' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Close siblings
		$( '.layers-visuals-item.layers-active' ).not( $that.parent() ).removeClass( 'layers-active' );

		// Toggle active state
		$that.parent().toggleClass( 'layers-active' );
	});

	$( document ).on( 'click' , '.widget .layers-visuals-wrapper li.layers-visuals-item label.layers-icon-wrapper' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.addClass( 'layers-active' );

		// Close siblings
		$that.siblings( '.layers-icon-wrapper' ).removeClass( 'layers-active' );
	});


	$( document ).on( 'click' , '[id^="input_layers"] .layers-visuals-item' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.addClass( 'layers-active' );

		// Close siblings
		$that.siblings( '.layers-visuals-item' ).removeClass( 'layers-active' );

	});

	/**
	* 7 - Design Controller Height Matcher
	*/
	$(window).bind( 'resize load', function(){
		layers_set_visual_wrapper_height();
	} );
	function layers_set_visual_wrapper_height(){
		// Set the visual wrapper to the same height as the window
		// $( '.layers-visuals-wrapper' ).css( 'height' , $(window).height() );
	}

	/**
	* 8 - Widget Focussing
	*/
	$( document ).on( 'click focus' , '.control-panel-content .widget-rendered' , function(e){
		// "Hi Mom"
		$that = $(this);
		if( !$that.hasClass( 'expanded' ) ){

			// Get the id of this widget
			$widget_id = $that.find( '.widget-id' ).val();

			// Focus on the active widget
			layers_widget_focus( $widget_id )
		}
	});

	$( document ).on( 'widget-updated' , function( updatedWidgetId ){
		setTimeout(
			layers_widget_focus( updatedWidgetId ),
			1000
		)
	});

	function layers_widget_focus( $widget_id ){

		// Scroll to this widget
		$iframe = $( '#customize-preview iframe' ).contents();

		$iframe.find('html, body').animate({
			scrollTop: $iframe.find( '#' + $widget_id ).offset().top
	    }, 850);
	}

	/**
	* 9 - Init 'Medium' editors
	*/

	$( '.editible' ).each( function(){
		// "Hi Mom"
		var $that = $(this);

		// Set the ID for this element
		var id = $that.data ( 'id' );

		var editor = new MediumEditor('.editible-' + id, {
				anchorButton: true,
				anchorButtonClass: 'button'
			});

		$( '.editible-' + id  ).on( 'input' , function(e){
			// "Hi Mom!"
			$that = $(this);

			// Set the input
			var textarea = $( '#' + id );

			textarea.val( $that.html() );
			textarea.layers_trigger_change();
		});
	});

	$( document ).on( 'keyup mouseup' , '.layers-tiny-mce-textarea' , function(e){

		// "Hi Mom!"
		$that = $(this);

		// Update the 'Medium Editor' with our information
		$that.siblings( '.editible' ).html( $that.val() );
	});

	$( document ).on( 'click' , '.layers-tiny-mce-switch' , function(e){
		e.preventDefault();

		// "Hi Mom!"
		$that = $(this);

		// Switch text editor mode
		if( 'visual' ==  $that.data( 'mode' ) ){

			// Switch modes
			$that.data( 'mode' , 'html' );

			// Change Button Label to 'Visual'
			$that.text( $that.data( 'visual_label' ) );
		} else {

			// Switch modes
			$that.data( 'mode' , 'visual' );

			// Change Button Label to 'HTML'
			$that.text( $that.data( 'html_label' ) );
		}

		$that.siblings( 'textarea' ).toggleClass( 'layers-hide' );
		$that.siblings( '.editible' ).toggleClass( 'layers-hide' );

	});

	/**
	* 10 - Trigger input changes
	*/

	$.fn.layers_trigger_change = function() {
		
		// Trigger 'change' and 'blur' to reset the customizer
		$changed = $(this).trigger("change").trigger("blur");
		
		//var $widget_synced = $( document ).trigger( 'widget-synced', $(this).closest( '.control-section' ).find( '.widget:first' ) );
		//console.log( $widget_synced );
		
		// Reset 'show if' selectors;
		layers_apply_show_if_selectors();
	};

	/**
	* 11 - Add Last Class to Elements
	*/

	$('.layers-visuals-wrapper').each(function(){
			// "Hi Mom!"
			$that = $(this);

			if( $that.find( 'li' ).length > 3 ){
				$that.find( 'li' ).eq(-1).addClass( 'layers-last' );
				$that.find( 'li' ).eq(-2).addClass( 'layers-last' );
			}
	});

	/**
	* 12 - Show/Hide linked elements
	*/

	// Instantiate the show/hide lookup
	layers_apply_show_if_selectors();

	function layers_apply_show_if_selectors(){
		$('[data-show-if-selector]').each(function(){
			// "Hi Mom!"
			$that = $(this);
			var $selector = $that.data( 'show-if-selector' );

			$( document ).on( 'change' , $selector , function(e){

				$('[data-show-if-selector="' + $selector + '"]').each(function(){
					$input = $(this);

					var $value = $input.data( 'show-if-value' );

					console.log(
							"Input: " + $( $selector ).val() +
							"Selector: " + $selector +
							"Show If: " + $value +
							"Found? " + $value.indexOf( $( $selector ).val() )
						);

					if( $value.indexOf( $( $selector ).val() ) > -1 ){
						$input.removeClass( 'layers-hide' );
					} else {
						$input.addClass( 'layers-hide' );
					}
				})
			});
		});
	}

});

