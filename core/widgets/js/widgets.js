/**
* Widget JS file
*
* This file contains global widget functions
 *
 * @package Hatch
 * @since Hatch 1.0
*/

jQuery(document).ready(function($) {

	/**
	* Media Uploaders
	*/
	var file_frame;
	$(document).on( 'click' , '.hatch-image-uploader .hatch-image-remove' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$that.siblings('img').remove();
		$that.closest( '.hatch-image-uploader' ).removeClass( 'hatch-has-image' );
		$that.fadeOut();
		return false;
	});

	$(document).on( 'click' , '.hatch-image-uploader' , function(e){
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

			// Remove any old image
			$that.find('img').remove();

			// Fade in Remove button
			$that.find('.hatch-image-remove').fadeIn();

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

			$that.append( $image );

			// Add 'Has Image' Class
			$that.addClass( 'hatch-has-image' );

			// Trigger change event
			$that.find('input').val( attachment.id ).trigger("change");

			return;
		});

		// Finally, open the modal
		file_frame.open();
	});

	/**
	* Background Selectors
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
		$( $id + '-type' ).val( $type );

		// Switch the selectors
		$that.addClass( 'active' );
		$that.siblings().removeClass( 'active' );

		// Switch the view
		$elements.find( '.hatch-content' ).eq( $index ).addClass('section-active');
		$elements.find( '.hatch-content' ).eq( $index ).siblings().removeClass('section-active');
	});

	/**
	* Color Selectors
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

					$(event.target).val( ui.color.toString() ).trigger( 'change' );
				}
		});
	}

	/**
	* Sortable Columns
	*/
	hatch_set_sortable_cols();

	function hatch_set_sortable_cols(){
		$( '.hatch-sortable' ).sortable({
      			placeholder: "hatch-sortable-drop"
    		});
	}
});
