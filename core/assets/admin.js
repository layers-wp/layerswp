/**
 * Admin JS file
 *
 * This file contains global admin functions
 *
 * @package Layers
 * @since Layers 1.0.0
 *
 * Contents
 * 1 - Enqueue Initialisation Helper
 * 2 - Media Uploaders
 * 2.a - Image Remove Button
 * 2.b - Image Upload Button
 * 2.c - General File Remove Button
 * 2.d - General File Upload Button
 * 3 - Background Selectors
 * 4 - Color Selectors
 * 5 - Sortable Columns
 * 6 - Tabs
 * 7 - Design Controller toggles
 * 8 - Design Controller Height Matcher
 * 9 - Widget Focussing
 * 10 - Init 'Medium' editors
 * 11 - Trigger input changes
 * 12 - Add Last Class to Design Bar Elements
 * 13 - Show/Hide linked elements
 * 14 - Run Initialisations
 * 15 - Layers Custom Easing
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery(function($) {

	/**
	* 1 - Enqueue Initialisation Helper
	*
	* Used to stagger the initialisation of elements to avoid Firefox non-responsive script warning.
	* Function adds individual function to an array that is initialised step by step at the end of the file.
	*/

	var $layers_init_array = [];

	function layers_enqueue_init( $init_function ) {
		$layers_init_array.push( $init_function );
	}

	/**
	* 2 - Media Uploaders
	*/

	// 2.a - Image Remove Button
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

	// 2.b - Image Upload Button
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
			if ( undefined !== attachment.sizes.medium )  {
				$attachment = attachment.sizes.medium;
			} else if( undefined !== attachment.sizes.large ) {
				$attachment = attachment.sizes.large;
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


	// 2.c - General File Remove Button
	$(document).on( 'click' , '.layers-file-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$that.siblings('span').text('');
		$that.siblings('input').val('').layers_trigger_change();

		$that.fadeOut();
		return false;
	});

	// 2.d - General File Upload Button
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
	* 3 -Background Selectors
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
	* 4 - Color Selectors
	*/

	layers_enqueue_init( function(){ layers_set_color_selectors( document ) } );

	function layers_set_color_selectors( element ){

		$(element).find('.layers-color-selector').wpColorPicker({
			change: function(event, ui){
				if( 'undefined' !== typeof event ){

					//Update the color input
					$(event.target).val( ui.color.toString() );

					// Debounce the color changes
					layers_debounce_input( event.target );
				}
			},
			clear: function(event) {
				if( 'undefined' !== typeof event ){

					// Debounce the reset change
					layers_debounce_input( jQuery(event.target).parent('.wp-picker-input-wrap').find('.wp-color-picker') );
				}
			},
		});

	}

	// Initialise color selectors on widget add.

	$(document).on ( 'widget-added' , function( event, widget_focus ){
		$( widget_focus ).find('.layers-color-selector').each(function(){
			var $picker = $(this);
			$picker.closest('.wp-picker-container').replaceWith( $picker );
		});

		setTimeout( function() {
			layers_set_color_selectors( widget_focus );
		} , 250 );
	} );

	// Debounce function for color changing.

	var layers_debounce_input = _.debounce(function( element ){
		$( element ).layers_trigger_change();
	}, 200);

	/**
	* 5 - Sortable Columns
	*/

	layers_enqueue_init( function(){ layers_set_sortable_cols(); } );

	function layers_set_sortable_cols(){
		if( $.sortable == undefined ) return;

		$( '.layers-sortable' ).sortable({
			placeholder: "layers-sortable-drop"
		});
	}


	/**
	* 6 - Tabs
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
	* 7 - Design Controller toggles
	*/
	$( document ).on( 'click' , '.widget .layers-visuals-wrapper li.layers-visuals-item a.layers-icon-wrapper' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Close siblings
		$(this).closest( '.layers-visuals-wrapper' ).find( '.layers-visuals-item.layers-active' ).not( $that.parent() ).removeClass( 'layers-active' );

		// Toggle active state
		$that.parent().toggleClass( 'layers-active' );
	});

	$( document ).on( 'click' , '.widget .layers-visuals-wrapper li.layers-visuals-item label.layers-icon-wrapper' , function(e){
		// "Hi Mom"
		$that = $(this);

 		// Get the input value
		$value = $('#' + $that.attr( 'for' ) ).val();

		// Capture the closest fellow form items
		$form_items = $that.closest( '.layers-form-item' ).siblings( '.layers-form-item' ).length

 		if( 0 == $form_items ){
			$that.closest( '.layers-pop-menu-wrapper' ).siblings( '.layers-icon-wrapper' ).find( 'span[class^="icon-"]' ).attr( 'class', 'icon-' + $value );
		}
		// Toggle active state
		$that.addClass( 'layers-active' );

		// Close siblings
		$that.siblings( '.layers-icon-wrapper' ).removeClass( 'layers-active' );
	});


	$( document ).on( 'click' , '[id^="layers-customize"] .layers-visuals-item' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.addClass( 'layers-active' );

		// Close siblings
		$that.siblings( '.layers-visuals-item' ).removeClass( 'layers-active' );

	});

	/**
	* 8 - Design Controller Height Matcher
	*/
	$(window).bind( 'resize load', function(){
		layers_set_visual_wrapper_height();
	} );
	function layers_set_visual_wrapper_height(){
		// Set the visual wrapper to the same height as the window
		// $( '.layers-visuals-wrapper' ).css( 'height' , $(window).height() );
	}

	/**
	* 9 - Widget Focussing
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
	* 10 - Init 'Medium' editors
	*/

	layers_enqueue_init( function(){
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
	* 11 - Trigger input changes
	*/

	$.fn.layers_trigger_change = function() {

		// Trigger 'change' and 'blur' to reset the customizer
		$changed = $(this).trigger("change").trigger("blur");

		//var $widget_synced = $( document ).trigger( 'widget-synced', $(this).closest( '.control-section' ).find( '.widget:first' ) );

		// Reset 'show if' selectors;
		layers_init_show_if();
	};

	/**
	* 12 - Add Last Class to Elements
	*/

	layers_enqueue_init( function(){
		$('.layers-visuals-wrapper').each(function(){
				// "Hi Mom!"
				$that = $(this);

				if( $that.find( 'li' ).length > 3 ){
					$that.find( 'li' ).eq(-1).addClass( 'layers-last' );
					$that.find( 'li' ).eq(-2).addClass( 'layers-last' );
				}
		});
	});

	/**
	* 13 - Show/Hide linked elements
	*/

	// Instantiate the show/hide lookup
	layers_enqueue_init( function(){ layers_init_show_if(); } );

	function layers_init_show_if(){
		$('[data-show-if-selector]').each(function(){

			var $target_element = $(this);

			var $source_element_selector = $target_element.attr( 'data-show-if-selector' );

			layers_apply_show_if( $source_element_selector );

			$( document ).on( 'change', $source_element_selector, function(e){

				layers_apply_show_if( $source_element_selector );

			});

		});
	}

	function layers_apply_show_if( $source_element_selector_new ){

		$( '[data-show-if-selector="' + $source_element_selector_new + '"]' ).each(function(){

			var $target_element = $(this);

			var $target_element_value = $target_element.data( 'show-if-value' ).toString();

			var $source_element = $( $target_element.data( 'show-if-selector' ).toString() );

			if ( $source_element.attr('type') == 'checkbox' ) {
				$source_element_value = ( $source_element.is(':checked') ) ? 'true' : 'false' ;
			}
			else {
				$source_element_value = $source_element.val();
			}

			// Set the reveal animation type.
			var animation_type = 'none';
			if ( $target_element.hasClass('layers-customize-control') ){
				animation_type = 'slideDown';
			}

			// If is a Customize Control then hide the whole control.
			if ( $target_element.hasClass('layers-customize-control') ){
				$target_element = $target_element.parent('.customize-control');
			} else {
				$target_element = $target_element.parent('.layers-form-item');
			}

			if( $target_element_value.indexOf( $source_element_value ) > -1 ){

				if( animation_type == 'slideDown' ){
					$target_element.removeClass( 'layers-hide' );
					$target_element.slideDown( { duration: 550, easing: 'layersEaseInOut' } );
				}
				else{
					$target_element.removeClass( 'layers-hide' );
				}

			} else {

				if( animation_type == 'slideDown' ){
					$target_element.slideUp( { duration: 550, easing: 'layersEaseInOut', complete: function(){
						$target_element.addClass( 'layers-hide' );
					} } );
				}
				else{
					$target_element.addClass( 'layers-hide' );
				}

			}
		});

	}

	/**
	* 14 - Run Initialisations
	*/

	$layers_init_position = 0;

	layers_sequence_loader();

	function layers_sequence_loader(){
		setTimeout( function(){

			// Run current init function.
			$layers_init_array[ $layers_init_position ]();

			// Step to next point in init array
			$layers_init_position++;

			// If there are more elements in init array then continue to loop.
			if ( $layers_init_position < $layers_init_array.length ) layers_sequence_loader();

		}, 10 );
	}

	/**
	* 15 - Layers Custom Easing
	*
	* Extend jQuery easing with custom Layers easing function for UI animations - eg slideUp, SlideDown
	*/

	jQuery.extend( jQuery.easing, { layersEaseInOut: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	} });

});

