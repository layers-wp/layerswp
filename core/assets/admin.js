/**
* Widget JS file
*
* This file contains global widget functions
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Media Uploaders
 * 1.a - Image Remove Button
 * 1.b - Image Upload Button
 * 1.c - General File Remove Button
 * 1.d - General File Upload Button
 * 2 -Background Selectors
 * 3 - Color Selectors
 * 4 - Sortable Columns
 * 5 - Tabs
 * 6 - Design Controller toggles
*/

jQuery(document).ready(function($) {

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
		$container.find('input').val('').trigger("change").trigger("blur");
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

			$container.children('.hatch-push-bottom').eq(0).append( $image );

			// Add 'Has Image' Class
			$container.addClass( 'hatch-has-image' );

			// Trigger change event
			$container.find('input').val( attachment.id ).trigger("change").trigger("blur");

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
		$that.siblings('input').val('').trigger("change");

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
			$that.siblings('input').val( attachment.id ).trigger("change").trigger("blur");

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
		$( $id + '-type' ).val( $type ).trigger("change");

		// Switch the selectors
		$that.addClass( 'active' );
		$that.siblings().removeClass( 'active' );

		// Switch the view
		$elements.find( '.hatch-content' ).eq( $index ).addClass('section-active');
		$elements.find( '.hatch-content' ).eq( $index ).siblings().removeClass('section-active');
	});

	/**
	* 3 - Color Selectors
	*/
	hatch_set_color_selectors();
	$(document).on ( 'mouseup' , '#available-widgets .widget-tpl' , function(){
		console.log( "mah" );
		jQuery('.hatch-color-selector').wpColorPicker(); // @TODO: Get the color picker to work on new elements
	} );

	function hatch_set_color_selectors(){
		jQuery('.color-field .wp-picker-container').remove();
		jQuery('.hatch-color-selector').wpColorPicker({
			change: function(event, ui){

				$(event.target).val( ui.color.toString() ).trigger( 'change' ).trigger("blur");
			}
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
		$tab_container.find( 'section' ).eq( $i ).slideDown().siblings().slideUp();
	});


	/**
	* 6 - Design Controller Toggles
	*/
	$( document ).on( 'click' , '.hatch-visuals-wrapper li.hatch-visuals-item .hatch-icon-wrapper' , function(e){
		e.preventDefault();
		// "Hi Mom"
		$that = $(this);

		// Toggle active state
		$that.parent().toggleClass( 'hatch-active' );

		// Close siblings
		$that.parent().siblings( '.hatch-visuals-item' ).removeClass( 'hatch-active' );
	})

});