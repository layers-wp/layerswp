/**
* Admin JS file
*
* This file contains global admin functions
 *
 * @package Hatch
 * @since Hatch 1.0
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
*/

jQuery(function($) {

	/**
	* 1 - Media Uploaders
	*/

	// 1.a - Image Remove Button
	var file_frame;
	$(document).on( 'click' , '.hatch-image-container .hatch-image-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

 		// Get the container
 		$container = $that.closest( '.hatch-image-container' );

		$that.siblings('img').remove();
		$container.removeClass( 'hatch-has-image' );
		$container.find('input').val('').hatch_trigger_change();
		$that.fadeOut();
		return false;
	});

	// 1.b - Image Upload Button
	$(document).on( 'click' , '.hatch-image-upload-button' , function(e){
		e.preventDefault();

		// "Hi Mom"
 		$that = $(this);

 		// Get the container
 		$container = $that.closest( '.hatch-image-container' );

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
			$container.find('.hatch-image-remove').fadeIn();

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

			$container.children('.hatch-image-display').eq(0).append( $image );

			// Add 'Has Image' Class
			$container.addClass( 'hatch-has-image' );

			// Trigger change event
			$container.find('input').val( attachment.id ).hatch_trigger_change();

			return;
		});

		// Finally, open the modal
		file_frame.open();
	});


	// 1.c - General File Remove Button
	$(document).on( 'click' , '.hatch-file-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$that.siblings('span').text('');
		$that.siblings('input').val('').hatch_trigger_change();

		$that.fadeOut();
		return false;
	});

	// 1.d - General File Upload Button
	$(document).on( 'click' , '.hatch-regular-uploader' , function(e){
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
			$that.siblings('input').val( attachment.id ).hatch_trigger_change();

			return;
		});

		// Finally, open the modal
		file_frame.open();

	});

	/**
	* 2 -Background Selectors
	*/
	$(document).on( 'click', '.hatch-background-selector li' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$type = $that.data('type');
		$id = $that.data('id');
		$index = $that.index();

		// Our main containing div, we could use .parent() but what if we change the depth of this li?
		$elements = $( $id + '-controller' ).find( '.hatch-controller-elements' );

		// Change the input value
		$( $id + '-type' ).val( $type ).hatch_trigger_change();

		// Switch the selectors
		$that.addClass( 'active' );
		$that.siblings().removeClass( 'active' );

		// Switch the view
		$elements.find( '.hatch-content' ).eq( $index ).addClass('section-active');
		$elements.find( '.hatch-content' ).eq( $index ).Ohsiblings().removeClass('section-active');
	});

	/**
	* 3 - Color Selectors
	*/
	hatch_set_color_selectors();
	$(document).on ( 'mouseup' , '#available-widgets .widget-tpl' , function(){

		$(this).find('input').hatch_trigger_change();

		$(this).find('.hatch-color-selector').each(function(){
			var $picker = $(this);
			$picker.closest('.wp-picker-container').replaceWith( $picker );
			setTimeout( function() {
				hatch_set_color_selectors();
			} , 250 );
		});

	} );

	function hatch_set_color_selectors(){

		jQuery('.hatch-color-selector').wpColorPicker({
			change: function(event, ui){
				$(event.target).val( ui.color.toString() ).hatch_trigger_change();
			},
			clear: function() {
				$(event.target).hatch_trigger_change();
			},
		});
	}

	/**
	* 4 - Sortable Columns
	*/
	hatch_set_sortable_cols();

	function hatch_set_sortable_cols(){
		if( $.sortable == undefined ) return;

		$( '.hatch-sortable' ).sortable({
			placeholder: "hatch-sortable-drop"
		});
	}


	/**
	* 5 - Tabs
	*/
	$( document ).on( 'click' , '.hatch-tabs li' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Get the Tab Index
		$i = $that.index();

		// Make this tab active
		$that.addClass( 'active' ).siblings().removeClass( 'active' );

		// Get the nearest tab containers
		$tab_nav = $that.closest( '.hatch-nav-tabs' );
		$tab_container = $tab_nav.siblings('.hatch-tab-content');

		// Show/Hide tabs
		$tab_container.find( 'section.hatch-tab-content' ).eq( $i ).slideDown().siblings( 'section.hatch-tab-content' ).slideUp();
	});


	/**
	* 6 - Design Controller Toggles
	*/
	$( document ).on( 'click' , '.widget .hatch-visuals-wrapper li.hatch-visuals-item a.hatch-icon-wrapper' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.parent().toggleClass( 'hatch-active' );

		// Close siblings
		$that.parent().siblings( '.hatch-visuals-item' ).removeClass( 'hatch-active' );
	});

	$( document ).on( 'click' , '.widget .hatch-visuals-wrapper li.hatch-visuals-item label.hatch-icon-wrapper' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.addClass( 'hatch-active' );

		// Close siblings
		$that.siblings( '.hatch-icon-wrapper' ).removeClass( 'hatch-active' );

		// Trigger change
		$that.find('input ').hatch_trigger_change();
		$that.siblings('input ').hatch_trigger_change();
	});


	$( document ).on( 'click' , '[id^="input_hatch"] .hatch-visuals-item' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.addClass( 'hatch-active' );

		// Close siblings
		$that.siblings( '.hatch-visuals-item' ).removeClass( 'hatch-active' );

	});


	/**
	* 7 - Design Controller Height Matcher
	*/
	$(window).bind( 'resize load', function(){
		hatch_set_visual_wrapper_height();
	} );
	function hatch_set_visual_wrapper_height(){
		// Set the visual wrapper to the same height as the window
		// $( '.hatch-visuals-wrapper' ).css( 'height' , $(window).height() );
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

			// Scroll to this widget
			$iframe = $( '#customize-preview iframe' ).contents();
			$iframe.find('html, body').animate({
				scrollTop: $iframe.find( '#' + $widget_id ).offset().top
		    }, 850);

		}
	});

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
			textarea.hatch_trigger_change();
		});
	});

	$( document ).on( 'keyup mouseup' , '.hatch-tiny-mce-textarea' , function(e){

		// "Hi Mom!"
		$that = $(this);

		// Update the 'Medium Editor' with our information
		$that.siblings( '.editible' ).html( $that.val() );
	});

	$( document ).on( 'click' , '.hatch-tiny-mce-switch' , function(e){
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

		$that.siblings( 'textarea' ).toggleClass( 'hatch-hide' );
		$that.siblings( '.editible' ).toggleClass( 'hatch-hide' );

	});

	/**
	* 10 - Trigger input changes
	*/

	$.fn.hatch_trigger_change = function() {

		// Trigger 'change' and 'blur' to reset the customizer
		$changed = $(this).trigger("change").trigger("blur");
		$( document ).trigger( 'widget-synced', $(this).closest( '.control-section' ).find( '.widget:first' ) );
	};

	/**
	* 11 - Trigger input changes
	*/

	$('.hatch-visuals-wrapper').each(function(){
			// "Hi Mom!"
			$that = $(this);

			if( $that.find( 'li' ).length > 2 ){
				$that.find( 'li' ).eq(-1).addClass( 'hatch-last' );
				$that.find( 'li' ).eq(-2).addClass( 'hatch-last' );
			}
	});


});

