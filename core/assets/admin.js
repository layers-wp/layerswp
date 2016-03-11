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
 * 2 - Layers Custom Easing
 * 3 - Media Uploaders
 * 3.a - Image Remove Button
 * 3.b - Image Upload Button
 * 3.c - General File Remove Button
 * 3.d - General File Upload Button
 * 4 - Background Selectors
 * 5 - Color Selectors
 * 6 - Sortable Columns
 * 7 - Tabs
 * 8 - Design Controller toggles
 * 9 - Widget Focussing
 * 10 - Trigger input changes
 * 11 - Add Last Class to Design Bar Elements
 * 12 - Show/Hide linked elements
 * 13 - Init RTE Editors
 * 14 - Custom Widget Initialization Events
 * 15 - Intercom checkbox
 * 16 - Widget Peek/hide to preview changes
 * 17 - Customizer Control - Range Slider
 * 18 - Reset to Default
 * 19 - Linking from one section/panel to another.
 * 20 - Init Tip-Tip
 * 21 - Linking-UX
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
	* Used to stagger the initialization of elements to avoid CPU freeze-ups.
	* Function adds individual initialization functions to a queue that is processed step by step with a slight break in between each step.
	*/

	var $layers_init_collection = [];

	var $queue_busy = false;

	function layers_enqueue_init( $function, $run_instantly ) {

		// If 'run_instantly' and is a function then execute now and bail immediately
		if( true === $run_instantly && 'function' == typeof $function ){
			$function();
			return false;
		}

		// Add to the queue
		$layers_init_collection.push( $function );

		// Always try to execute the queue
		layers_sequence_loader();
	}

	var $layers_init_timeout;

	function layers_sequence_loader(){

		// Bail if the queue is busy or empty
		if ( $queue_busy || $layers_init_collection.length <= 0 ) return;

		// Lock the queue while executing current step
		$queue_busy = true;

		// Get and remove the next item from the queue
		var $current_item = $layers_init_collection.shift();

		// Stagger the queue.
		$layers_init_timeout = setTimeout( function(){

			// Execute the current item, after checking it's is a function
			if ( 'function' == typeof $layers_init_collection[0] ){
				$current_item();
			}

			// Unlock the queue for the next check
			$queue_busy = false;

			// Loop around and check the queue again
			layers_sequence_loader();

		}, 10 );
	}

	/**
	* 2 - Layers Custom Easing
	*
	* Extend jQuery easing with custom Layers easing function for UI animations - eg slideUp, slideDown
	*/

	// easeInOutQuad
	/*jQuery.extend( jQuery.easing, { layersEaseInOut: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	}});*/

	// easeInOutQuint
    jQuery.extend( jQuery.easing, { layersEaseInOut: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
        return c/2*((t-=2)*t*t*t*t + 2) + b;
    }});

	/**
	* 3 - Media Uploaders
	*/

	// 3.a - Image Remove Button
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

	// 3.b - Image Upload Button
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
				class  : 'image-reveal',
				src    :  $attachment.url,
				height :  $attachment.height,
				width  : $attachment.width
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

	// 3.c - General File Remove Button
	$(document).on( 'click' , '.layers-file-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$that.siblings('span').text('');
		$that.siblings('input').val('').layers_trigger_change();
		$that.closest( '.layers-file-container' ).removeClass( 'layers-has-file' );

		$that.fadeOut();
		return false;
	});

	// 3.d - General File Upload Button
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

			$that.closest( '.layers-file-container' ).addClass( 'layers-has-file' );

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
	* 4 -Background Selectors
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
	* 5 - Color Selectors
	*/

	if ( $('#customize-preview, #customize-controls').length ) {

		// Customizer

		// Init interface in all except widgets on load
		layers_set_color_selectors( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

		// Init interface inside widgets and accordions
		$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
			// 'this' is the widget
			layers_set_color_selectors( $(this), true );
		});
	}
	else{

		// Admin Dashboard

		$( '.layers-color-selector').each( function( j, element ) {

			// Add each color-picker initialization to the queue
			layers_set_color_selector( $(element) );
		});
	}

	function layers_set_color_selectors( $element_s, $run_instantly ){

		// Loop through each of the element_s, that are groups to look inside of for elements to be initialized.
		$element_s.each( function( i, group ) {

			// Loop through each color-picker
			$(group).find( '.layers-color-selector').each( function( j, element ) {

				// Add each color-picker initialization to the queue
				layers_enqueue_init( function(){
					layers_set_color_selector( $(element) );
				}, $run_instantly );

			});
		});
	}

	function layers_set_color_selector( $element ){

		// Initialize the individual color-picker
		$element.wpColorPicker({
			change: function(event, ui){
				if( 'undefined' !== typeof event ){

					//Update the color input
					$(event.target).val( ui.color.toString() );

					// Debounce the color changes
					layers_debounce_color_input( event.target );
				}
			},
			clear: function(event) {
				if( 'undefined' !== typeof event ){

					// Debounce the reset change
					layers_debounce_color_input( jQuery(event.target).parent('.wp-picker-input-wrap').find('.wp-color-picker') );
				}
			},
			palettes: [ '#000000', '#FFFFFF', '#E2594E', '#F39C12', '#FFCD03', '#A2C661', '#009EEC', '#934F8C' ],
		});
	}

	// Debounce function for color changing.
	var layers_debounce_color_input = _.debounce( function( element ){
		$( element ).layers_trigger_change();
	}, 200, false );

	/**
	* 6 - Sortable Columns
	*/

	// Init interface in all except widgets on load
	layers_init_sortable_columns( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

	// Init interface inside widgets
	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){

		// Bail if no sortable
		if( $.sortable == undefined ) return;

		// 'this' is the widget
		layers_init_sortable_columns( $(this) );
	});

	function layers_init_sortable_columns( $element_s ){

		$element_s.each( function( i, group ) {

			$(group).find( '.layers-sortable').each( function( j, element ) {

				$(element).sortable({
					placeholder: "layers-sortable-drop"
				});
			});
		});
	}

	/**
	* 7 - Tabs
	*/
	$( document ).on( 'click' , '.l_admin-tabs li, .l_admin-tabs li a' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Get the Tab Index
		$i = $that.index();

		// Make this tab active
		$that.addClass( 'active' ).siblings().removeClass( 'active' );

		// Get the nearest tab containers
		$tab_nav = $that.closest( '.l_admin-nav-tabs' );
		$tab_container = $tab_nav.siblings('.l_admin-tab-content');

		// Show/Hide tabs
		$tab_container.find( 'section.layers-tab-content' ).eq( $i ).addClass('l_admin-show').removeClass('l_admin-hide').slideDown().siblings( 'section.l_admin-tab-content' ).addClass('l_admin-hide').removeClass('l_admin-show').slideUp();
	});


	/**
	* 8 - Design Controller toggles
	*/
	$( document ).on( 'click', function(e) {
		var eventTarget = $(e.target);

		// close any pop-ups that arent the target of the current click
		$('.widget .layers-visuals-item.layers-active' ).not( eventTarget.closest('.layers-visuals-item') ).removeClass( 'layers-active' );
	});

	$( document ).on( 'click' , '.widget ul.layers-visuals-wrapper > li.layers-visuals-item > a.layers-icon-wrapper' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.trigger( 'layers-design-bar-menu', $that );
		$that.parent( 'li.layers-visuals-item' ).toggleClass( 'layers-active' );

		// Close Siblings
		$that.parent( 'li.layers-visuals-item' ).siblings().not( $that.parent() ).removeClass( 'layers-active' );
	});

	$( document ).on( 'mousedown' , '.layers-select-icons label.layers-icon-wrapper' , function(e){

		// Cache elements.
		var $label = $(this);

		var $input = $('#' + $label.attr( 'for' ));

		// Get the input value
		var $value = $input.val();

		// Capture the closest fellow form items
		$form_items = $label.closest( '.layers-form-item' ).siblings( '.layers-form-item' ).length;
		if( 0 == $form_items ){
			$label.closest( '.layers-pop-menu-wrapper' ).siblings( '.layers-icon-wrapper' ).find( 'span[class^="icon-"]' ).attr( 'class', 'icon-' + $value );
		}

		// Toggle active state
		$label.trigger( 'layers-design-bar-menu', $label );

		// De-activate siblings
		$label.siblings( '.layers-icon-wrapper' ).removeClass( 'layers-active' );

		if ( 'checkbox' == $input.attr('type') ) {

			// Input is a 'checkbox' when there's only one single button - so make it toggle on/off.
			if ( $label.hasClass( 'layers-active' ) ) {
				$label.removeClass( 'layers-active' );
			}
			else {
				$label.addClass( 'layers-active' );
			}
		}
		else {

			// Input is a 'radio' when there's multiple buttons - so make them behave like radio.
			$label.addClass( 'layers-active' );
		}
	});

	$( document ).on( 'click' , '[id^="layers-customize"] .layers-visuals-item' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.trigger( 'layers-design-bar-menu', $that );
		$that.addClass( 'layers-active' );

		// Close siblings
		$that.siblings( '.layers-visuals-item' ).removeClass( 'layers-active' );

	});
	$( document ).on( 'layers-design-bar-menu', '.layers-visuals-item', function( e, menu_item ){
		$img = $(this).find( 'img[data-src]' );
		$img.each(function(){
			$(this).attr( 'src', $(this).data( 'src' ) );
		});
	});

	$( document ).on( 'click' , '.accordion-section-title' , function(e){
		// "Hi Mom"
		$that = $(this);

		var $related_accordion = $that.closest('.accordion-section').find('.accordion-section-content');

		// Toggle active state
		$related_accordion.trigger( 'layers-design-bar-menu', $that );
	});
	$( document ).on( 'layers-design-bar-menu', '.accordion-section-content', function( e, menu_item ){
		$img = $(this).find( 'img[data-src]' );
		$img.each(function(){
			$(this).attr( 'src', $(this).data( 'src' ) );
		});
	});

	/**
	* 9 - Widget Focussing
	*/

	$( document ).on( 'layers-widget-scroll' , '.widget' , function(e){
		// "Hi Mom"
		$that = $(this);

		if( !$that.hasClass( 'expanded' ) ){

			// Get the id of this widget
			$widget_id = $that.find( '.widget-id' ).val();

			// Focus on the active widget
			layers_widget_focus( $widget_id )
		}
	});

	function layers_widget_focus( $widget_id ){

		// Scroll to this widget
		$iframe = $( '#customize-preview iframe' ).contents();
		$widget = $iframe.find( '#' + $widget_id );

		// Check if the widget can be found - can't be found during widget-add
		if ( 0 < $widget.length ){
			$iframe.find('html, body').animate(
				{ scrollTop: $widget.offset().top },
				{ duration: 900, easing: 'layersEaseInOut' }
			);
		}
	}

	/**
	* 10 - Trigger input changes
	*/

	$.fn.layers_trigger_change = function() {

		// Trigger 'change' and 'blur' to reset the customizer
		$changed = $(this).trigger("change").trigger("blur");
	};

	/**
	* 11 - Add Last Class to Elements
	*/

	// Init interface in all except widgets on load
	layers_init_add_last_class( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

	// Init interface inside widgets
	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
		// 'this' is the widget
		layers_init_add_last_class( $(this), true );
	});

	function layers_init_add_last_class( $element_s, $run_instantly ){

		$element_s.each( function( i, group ) {

			$(group).find( '.layers-visuals-wrapper').each( function( j, element ) {

				layers_enqueue_init( function(){
					if( $(element).find( 'li' ).length > 4 ){
						$(element).find( 'li' ).eq(-1).addClass( 'layers-last' );
						$(element).find( 'li' ).eq(-2).addClass( 'layers-last' );
					}
				}, $run_instantly );
			});
		});
	}

	/**
	* 12 - Show/Hide linked elements
	*/

	if ( $('body.wp-customizer').length ) {
		// Customizer

			// Init interface in all except widgets on load
			layers_init_show_if( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

			// Init interface inside widgets
			$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
				// 'this' is the widget
				layers_init_show_if( $(this), true );
			});
	}
	else {
		// Not Customizer
		layers_init_show_if( $( 'body' ), true );
	}

	function layers_init_show_if( $element_s, $run_instantly ){

		$element_s.each( function( i, group ) {

			$(group).find( '[data-show-if-selector]').each( function( j, element ) {

				var $target_element = $(element);

				var $source_element_selector = $target_element.attr( 'data-show-if-selector' );

				layers_enqueue_init( function(){

					layers_apply_show_if( $source_element_selector );

					$( document ).on( 'change', $source_element_selector, function(e){
						layers_apply_show_if( $source_element_selector );
					});

				}, $run_instantly );
			});
		});
	}

	function layers_apply_show_if( $source_element_selector_new ){

		$( '[data-show-if-selector="' + $source_element_selector_new + '"]' ).each(function(){

			var $target_element = $(this);
			var $target_value   = $target_element.data( 'show-if-value' ).toString();
			var $source_element = $( $target_element.data( 'show-if-selector' ).toString() );
			var $operator       = $target_element.data( 'show-if-operator' );

			if ( $source_element.attr('type') == 'checkbox' ) {
				$source_element_value = ( $source_element.is(':checked') ) ? 'true' : 'false' ;
			}
			else {
				$source_element_value = $source_element.val();
			}

			if ( 'undefined' === typeof( $source_element_value ) ) {
				layers_show_if_display( 'hide', $target_element );
				return false;
			}

			// Apply the chosen Operator (default: ==)
			switch( $operator ) {

				case '!=':

					if ( $target_value.trim() != $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;

				case '!==':

					if ( $target_value.trim() !== $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;

				case '>':

					if ( $target_value.trim() > $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;

				case '<':

					if ( $target_value.trim() < $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;

				case '>=':

					if ( $target_value.trim() >= $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;

				case '<=':

					if ( $target_value.trim() <= $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;

				case '==':
				default:

					if ( $target_value.trim() == $source_element_value.trim() )
						layers_show_if_display( 'show', $target_element ); // Show
					else
						layers_show_if_display( 'hide', $target_element ); // Hide

					break;
			}

		});
	}

	function layers_show_if_display( $state, $target_element ) {

		// Calculate the reveal animation type.
		var animation_type = 'none';

		// Get the right target element depending on what kind of component this is (is Customize Control or Design-Bar item)
		if ( $target_element.hasClass('l_option-customize-control') ){

			// Target element is - Customize Control (entire control)
			$target_element = $target_element.parent('.customize-control');
			animation_type = 'slideDown';
		}
		else if ( $target_element.hasClass('layers-design-bar-form-item') ) {

			// Target element is - Design Bar (form-item)
			animation_type = 'slideDown';
		}

		if ( 'hide' == $state ) {

			// Hide
			if( animation_type == 'slideDown' ){
				$target_element.slideUp( { duration: 550, easing: 'layersEaseInOut', complete: function(){
					$target_element.addClass( 'l_admin-hide' );
				} } );
			}
			else{
				$target_element.addClass( 'l_admin-hide' );
			}
		}
		else {

			// Show
			if( animation_type == 'slideDown' ){
				$target_element.removeClass( 'l_admin-hide' );
				$target_element.slideDown( { duration: 550, easing: 'layersEaseInOut' } );
			}
			else{
				$target_element.removeClass( 'l_admin-hide' );
			}
		}
	}

	/**
	* 13 - Init RTE Editors
	*/

	// Init interface in all except widgets on load
	layers_init_editors( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

	// Init interface inside widgets
	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
		// 'this' is the widget
		layers_init_editors( $(this), true );
	});

	function layers_init_editors( $element_s, $run_instantly ){

		$element_s.each( function( i, group ) {

			$(group).find( '.layers-rte').each( function( j, element ) {

				// If I am already an RTE, do nothing
				if( $(element).siblings( '.froala-box' ).length > 0 ) {
					return true;
				}

				// Set the ID for this element
				var $id = $(element)[0].id;

				layers_enqueue_init( function(){

					layers_init_editor( $id );
				}, $run_instantly );
			});
		});
	}

	function layers_init_editor( $id ){

		var $editor = $( '#' + $id );

		if( $editor.hasClass( 'layers-rte' ) );

		var $editor_data = {
			allowScript: true,
			allowStyle: true,
			convertMailAddresses: true,
			inlineMode: false,
			initOnClick: false,
			imageButtons: [ 'removeImage' ],
			key: 'YWd1WDPTa1ZNRGe1OC1c1==',
			mediaManager: false,
			pasteImage: false,
			paragraphy: true,
			plainPaste: false,
			typingTimer: 1000,
			zIndex: 99,
		};

		if( $editor.data( 'allowed-buttons' ) ) {
			$editor_data.buttons = $editor.data( 'allowed-buttons' ).split(',');
		}

		if( $editor.data( 'allowed-tags' ) ) {
			if( '' !== $editor.data ){
				$editor_data.allowedTags = $editor.data( 'allowed-tags' ).split(',');
			}
		}

		// Editor events
		$editor.editable( $editor_data )
			.on('editable.contentChanged', function (e, editor) {
				$editor.layers_trigger_change();
			})
			.on('editable.focus', function (e, editor) {
				// Show toolbar on editor focus
				editor.$box.removeClass('froala-toolbar-hide');
			})
			.on('editable.blur', function (e, editor) {
				// siwtch to using click outside rather
				//editor.$box.addClass('froala-toolbar-hide');
			});

		// Fix for 'clear formatting' button not working - envokes sending change to customizer prev
		$(document).on( 'click', '.fr-bttn[data-cmd="removeFormat"]', function(){
			var $editor = $(this).closest('.layers-form-item').find('.layers-rte');
			_.defer( function(arguments) {
				$editor.editable('blur');
				$editor.editable('focus');
			});
		});

		// Add froala-toolbar-hide class to all editors parent box on startup, to hide toolbar
		$editor.data('fa.editable').$box.addClass('froala-toolbar-hide');
	}

	// Close editor toolbar on click outside active editor
	$(document).on( 'mousedown', function(){
		$('.froala-box:not(.froala-toolbar-hide)').each(function(){

			// If the editor is in HTML view then switch back.
			$rte_active_html_button = $(this).find( '.active[data-cmd="html"]' );
			$rte_textarea = $(this).siblings('textarea');
			if ( 0 < $rte_active_html_button.length && 0 < $rte_textarea.length ){
				//$rte_textarea.editable( 'exec', 'html' );
			}

			// Then hide the toolbar
			$(this).addClass('froala-toolbar-hide');
		});
	});
	$(document).on( 'mousedown', '.froala-box', function(e){
		$('.froala-box').not( $(this) ).addClass('froala-toolbar-hide');
		e.stopPropagation();
	});
	$(document).on( 'mousedown', '.froala-popup', function(e){
		e.stopPropagation();
	});

	/**
	* 14 - Custom Widget Initialization Events
	*
	* Dispense 'layers-interface-init' when:
	* 1. widget is focused first time
	* 2. accordion element is added inside widget
	* to allow for just-in-time init instead of massive bulk init.
	*/

	$( '.customize-control-widget_form .widget-top' ).click( function(e){

		// Attach 'click' event that we will re-order, in the next step, to occur
		// before WP click, so we can do things like Highlighting the Widget Title,
		// display 'LOADING' text, so in the case of a JS hang-up we have given the
		// user feedback so they know what is going on.

		var $widget_li = $(this).closest('.customize-control-widget_form');
		var $widget = $widget_li.find('.widget');

		layers_expand_widget( $widget_li, $widget, e );
	});

	$('.customize-control-widget_form .widget-top').each( function( index, element ){

		// Switch the order that the 'click' event occur so ours happens before WP
		if ( typeof $._data === 'function' ) $._data( element, 'events' ).click.reverse();
		else $( element ).data('events').click.reverse();
	});

	$( document ).on( 'expand collapse collapsed', '.customize-control-widget_form', function(e){

		var $widget_li = $(this);
		var $widget = $widget_li.find( '.widget' );

		if( 'expand' == e.type ){

			// duplicate call to 'layers_expand_widget' in-case 'click' is not triggered
			// eg 'shift-click' on widget in customizer-preview.
			layers_expand_widget( $widget_li, $widget, e );

			// Scroll only on expand.
			setTimeout(function() {
				$widget.trigger( 'layers-widget-scroll' );
			}, 200 );

			// Delay the removal of 'layers-loading' so it always displays for a definite length of time,
			// so the user is able to read it.
			setTimeout(function(){
				$widget_li.removeClass( 'layers-loading' );
			}, 1100 );

		} else if( 'collapse' == e.type ){

			$widget_li.removeClass('layers-focussed');

			// Used for animation of the widget closing
			$widget_li.addClass('layers-collapsing');

		} else if( 'collapsed' == e.type ){

			$widget_li.removeClass('layers-collapsing');

		}
	});

	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
		// Stop the event bubbling up the dom, so elements initialized inside widgets, don't re-init the parent widget.
		e.stopPropagation();
	});

	function layers_expand_widget( $widget_li, $widget, e ){

		// Instant user feedback
		$widget_li.addClass('layers-focussed');

		// Instantly remove other classes
		$('.layers-focussed').not( $widget_li ).removeClass('layers-focussed layers-loading');

		// Handle the first time Init of a widget.
		if ( !$widget_li.hasClass( 'layers-loading' ) && !$widget_li.hasClass( 'layers-initialized' ) ){

			$widget_li.addClass('layers-loading');
			$widget_li.addClass( 'layers-initialized' );

			if ( 'click' === e.type ) {
				// If event is 'click' it's our early invoked event so we can do things before all the WP things
				setTimeout(function(){
					$widget.trigger( 'layers-interface-init' );
				}, 50 );
			} else {
				// If event is 'expand' it's a WP invoked event that we use as backup if the 'click' was not used.
				// eg 'shift-click' on widget in customizer-preview
				$widget.trigger( 'layers-interface-init' );
			}
		}
	}

	/**
	* 15 - Intercom checkbox
	*/

	$(document).on( 'change', '#layers-enable-intercom', function(e){

		if( 'undefined' !== typeof Intercom ){
			if( !$(this).prop('checked') ){
				Intercom('shutdown');
			} else if( 'undefined' !== typeof window.intercomSettings ){
				Intercom('boot', window.intercomSettings );
			}
		}

	});

	/**
	 * 16 - Widget Peek/hide to preview changes
	 */

	// Init interface inside widgets and accordions
	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){

		// Add the peek buttons to all the Layers Widget actions.
		$(this).find('.widget-control-actions .alignleft').prepend('<span class="layers-widget-peek-button dashicons dashicons-visibility">');
		// $('<span class="layers-widget-peek-button dashicons dashicons-visibility">').insertBefore('.widget-control-actions br');
	});

	// Add the hover hiding of the Widget interface.
	$(document).on( 'mouseenter', '.layers-widget-peek-button', function(){ $(this).closest('.widget-inside').addClass('layers-peek-widget'); } );
	$(document).on( 'mouseleave', '.layers-widget-peek-button', function(){ $(this).closest('.widget-inside').removeClass('layers-peek-widget'); } );

	/**
	 * 17 - Customizer Control - Range Slider
	 */
	$( document ).on( 'input change', '.layers-column input[type="range"]', function( e ){
		// Push changes to the Number input.
		var $range_field = $(this);
		var $number_field = $(this).parent().parent().find('input[type="number"]');

		if ( $range_field.attr( 'placeholder' ) && $range_field.attr( 'placeholder' ) == $range_field.val() ) {
			// If the range-slider is moved and there's a placeholder set
			// and the slider stops on the placeholder value then empty
			// the number field so ntohing is applied.
			$number_field.val('');
		}
		else {
			// Set the number value to equal this range.
			$number_field.val( $range_field.val() );
		}

		layers_debounce_range_input( $number_field );
	});
	$( document ).on( 'input change', '.layers-column input[type="number"]', function( e ){
		// Push changes to the Range input.
		var $number_field = $(this);
		var $range_field = $(this).parent().parent().find('input[type="range"]');

		if ( '' == $number_field.val() && $range_field.attr( 'placeholder' ) ) {
			// If number field is emptied and there's a placeholder set then
			// set the range slider so it reflects the placeholder too.
			$range_field.val( $range_field.attr( 'placeholder' ) );
		}
		else {
			// Set the range to equal this number value.
			$range_field.val( $number_field.val() );
		}
	});
	var layers_debounce_range_input = _.debounce( function( element ){
		$( element ).layers_trigger_change();
	}, 550, false );

	/**
	 * 18 - Reset to Default
	 */
	$( document ).on( 'click', '.customize-control-default', function( e ){
		var $refresh_button = $(this);
		var $control_holder = $refresh_button.closest('.customize-control');
		var $default_value = $refresh_button.attr('data-default');

		var $field = $control_holder.find('input, select, textarea');

		if ( 'checkbox' == $field.eq(0).attr('type') ) {

			// Checkbox
			if ( ! $default_value || '' == $default_value ) $field.attr( 'checked', false );
			else $field.attr( 'checked', true );
			$field.eq(0).change();
		}
		else {
		//else if ( $field.eq(0).is('input') ) {

			// Input's, Textarea
			$field.val( $default_value );
			$field.eq(0).change();
		}
	});

	/**
	 * 19 - Linking from one section/panel to another.
	 *
	 * Use class `customizer-link` and href `#target-panel-or-section-id`
	 */
	$( document ).on( 'click', '.customizer-link', function( e ){

		$link              = $(this);
		$related_accordion = $( $link.attr('href') );

		// If there is a related panel ot section then open it.
		if ( $related_accordion.length ) {
			$related_accordion.children( 'h3.accordion-section-title' ).click();
		}

		return false;
	});

	/**
	* 20 - Init Tip-Tip
	*/

	if ( $('#customize-preview, #customize-controls').length ) {

		// Customizer

		// Init interface in all except widgets on load
		init_tip_tip( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

		// Init interface inside widgets
		$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
			// 'this' is the widget
			init_tip_tip( $(this), true );
		});
	}
	else{

		// Admin Dashboard

		init_tip_tip( $( document ) );
	}

	function init_tip_tip( $element_s, $run_instantly ){

		$element_s.each( function( i, group ) {

			$(group).find( '[data-tip]').each( function( j, element ) {

				// Tooltips
				$(element).layersTip({
					'attribute' : 'data-tip',
					'fadeIn' : 300,
					'fadeOut' : 300,
					'delay' : 200,
					'defaultPosition' : 'top',
					'edgeOffset' : 3,
					'maxWidth' : '300px'
					//'enter' : function() {
					//	//jQuery("#tiptip_holder").addClass("cx_tip_tip");
					//	jQuery("#tiptip_holder #tiptip_content").addClass('cx_tip_tip');
					//}
					//'keepAlive' : true,
					//'activation' : 'click'
				});

			});
		});
	}

	/**
	* 21 - Linking-UX
	*/

	// Init interface in all except widgets on load
	layers_init_form_collections( $( '#customize-theme-controls > ul > li.accordion-section' ).not( '#accordion-panel-widgets' ) );

	// Init interface inside widgets
	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){

		// 'this' is the widget
		layers_init_form_collections( $(this) );
	});

	function layers_init_form_collections( $element_s ){
		$element_s.each( function( i, group ) {

			/**
			 * Get the link-type inputs and convert them to layersSlct2.
			 */
			$(group).find( '.layers-widget-dynamic-linking-select').each( function( j, element ) {

				var initial_selection = {
					id   : $(element).val(),
					text : $(element).attr( 'data-display-text' ),
				};
				var placeholder = $(element).attr( 'placeholder' );

				var related_type_select = $(element).parents('.layers-form-collection').find('[id$="-link_type"]');

				$(element).layersSlct2({
					ajax: {
						url: ajaxurl,
						dataType: 'json',
						quietMillis: 250,
						data: function(term, page) {

							return {
								action    : 'layers_widget_linking_searches',
								link_type : related_type_select.val(),
								term      : term,
								page      : page,
								nonce     : layers_admin_params.nonce_layers_widget_linking,
							};
						},
						results: function(data, params) {

							return {
								results: data.results,
								more: data.more,
							};
						},
						cache: true
					},
					escapeMarkup: function(markup) {

						// let our custom formatter work
						return markup;
					},
					initSelection: function(element, callback) {

						callback( initial_selection );

						// Convert the value to a Name by doing reverse-lookup of the id. - Replaced this method with the ajax-free method above.
						/*
						var id = $(element).val();
						if (id !== "") {
							jQuery.ajax({
								type     : 'post',
								dataType : 'json',
								url      : ajaxurl,
								data     : {
									action    : 'layers_widget_linking_initial_selections',
									post_id   : id,
									link_type : related_type_select.val(),
									nonce     : layers_admin_params.nonce_layers_widget_linking,
								},
								success: function( data ) {
									callback({
										id: data.id,
										text: data.text
									});
								}
							});
						}
						*/
					},
					formatSelection: function(data) {

						return data.text;
					},
					containerCssClass: 'tpx-layersSlct2-container',
					dropdownCssClass: 'tpx-layersSlct2-drop',
					minimumInputLength: 1,
					width: '100%',
				});

				$(element).on('change', function(e) {
					$(element).attr( 'data-display-text', e.added.text ).trigger('layers_init_linking');
				})

			});

			/**
			 * Dynamic updating of the Linking-UX heading.
			 */
			$(group).find('.layers-form-collection').each( function( j, element ) {

				// Cache elements.
				var $collection_holder = $(element);
				var $collection_content = $collection_holder.find('.layers-form-collection-content');
				var $collection_heading = $collection_holder.find('.layers-form-collection-header');

				// Hide content part - like an accordion.
				$collection_content.hide();

				// Update the heading on change of any input/select.
				$(element).find('select, input').on( 'change keyup layers_init_linking', function(){

					// Get the link text.
					var link_text = $(element).find('[id$="-link_text"]').val();

					// Get the link type.
					var link_type = $(element).find('[id$="-link_type"]').val();

					// Get the link value.
					var link_input = $(element).find('[name$="link_type_' + link_type + ']"]');

					link_value = '';
					if ( 'custom' == link_type )
						link_value = link_input.val();
					else if ( 'post' == link_type )
						link_value = link_input.attr('data-display-text');

					// Compile the display content.
					var display_content = '';

					if ( '' != link_text )
						display_content += link_text + ' ';

					if ( '' != link_value )
						display_content  += '<i title="' + link_value + '">' + link_value + '</i> ';


					// If nothing is set then throw out &nbsp; to hold the space.
					if ( '' == display_content ) display_content = '&nbsp;';

					$collection_heading.html( display_content );
				});

				// Ping an intial update at the start.
				$(element).find('select, input').eq(0).trigger('layers_init_linking');
			});
		});
	}

	// Accordion-type panel of the Linking-UX
	$(document).on('click', '.layers-form-collection-header', function(){

		/**
		 * Show the current panel.
		 */
		$collection_holder = $(this).closest('.layers-form-collection');
		$collection_content = $collection_holder.find('.layers-form-collection-content');

		if ( $collection_holder.hasClass('closed') ) {
			$collection_holder.removeClass('closed');
			$collection_content.slideDown({ easing: 'layersEaseInOut', duration: 250 });
		}
		else{
			$collection_holder.addClass('closed');
			$collection_content.slideUp({ easing: 'layersEaseInOut', duration: 250 });
		}

		/**
		 * Hide the other panel (that are still showing)
		 */
		$other_collection_holders = $('.layers-form-collection:not(".closed")').not( $collection_holder );
		$other_collection_contents = $other_collection_holders.find('.layers-form-collection-content');

		$other_collection_holders.addClass('closed');
		$other_collection_contents.slideUp({ easing: 'layersEaseInOut', duration: 250 });
	});

});