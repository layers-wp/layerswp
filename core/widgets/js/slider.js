/**
* Slider Widget JS file
*
* This file contains functions relating to the Slider Widget
 *
 * @package Layers
 * @since Layers 1.0
 * Contents
 * 1 - Sortable items
 * 2 - Slide Removal & Additions
 * 3 - Slide Title Update
*/

jQuery(document).ready(function($){

	/**
	* 1 - Sortable items
	*/
	layers_set_slide_sorable();

	$(document).on ( 'widget-added' , function(){
		layers_set_slide_sorable();
	});

	function layers_set_slide_sorable(){

		var $slide_lists = $( 'ul[id^="slide_list_"]' );

		$slide_lists.sortable({
			placeholder: "layers-sortable-drop",
			handle: ".layers-accordion-title",
			stop: function(e , li){
				// Banner UL, looking up from our current target
				$slideList = li.item.closest( 'ul' );

				// Banners <input>
				$slideInput = $( '#slide_ids_input_' + $slideList.data( 'number' ) );

				// Apply new slide order
				$slide_guids = [];
				$slideList.find( 'li.layers-accordion-item' ).each(function(){
					$slide_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$slideInput.val( $slide_guids.join() ).layers_trigger_change();
			}
		});
	};

	/**
	* 2 - Banner Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="slide_list_"] .icon-trash' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation module
		var $remove_slide = confirm( "Are you sure you want to remove this slide?" );

		if( false === $remove_slide ) return;

		// Banner UL
		$slideList = $( '#slide_list_' + $that.data( 'number' ) );

		// Banners <input>
		$slideInput = $( '#slide_ids_input_' + $slideList.data( 'number' ) );

		// Remove this slide
		$that.closest( '.layers-accordion-item' ).remove();

		// Curate slide IDs
		$slide_guids = [];

		$slideList.find( 'li.layers-accordion-item' ).each(function(){
			$slide_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$slideInput.val( $slide_guids.join() ).layers_trigger_change();
	});

	$(document).on( 'click' , '.layers-add-widget-slide' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Create the list selector
		$slideListId = '#slide_list_' + $that.data( 'number' );

		// Banner UL
		$slideList = $( $slideListId );

		// Banners <input>
		$slideInput = $( '#slide_ids_input_' + $slideList.data( 'number' ) );

		// Serialize input data
		$serialized_inputs = [];
		$.each(
			$slideList.find( 'li.layers-accordion-item' ).first().find( 'textarea, input, select' ),
			function( i, input ){
				$serialized_inputs.push( $(input).serialize() );
		});

		$.post(
			layers_widget_params.ajaxurl,
			{
				action: 'layers_slider_widget_actions',
				widget_action: 'add',
				id_base: $slideList.data( 'id_base' ),
				instance: $serialized_inputs.join( '&' ),
				last_guid: $slideList.find( 'li.layers-accordion-item' ).first().data( 'guid' ),
				number: $slideList.data( 'number' ),
				nonce: layers_widget_params.nonce

			},
			function(data){

				// Append module HTML
				$slideList.prepend( data );
				//$( data ).insertBefore( $slideListId + ' .layers-add-widget-slide' );

				// Append slide IDs to the slides input
				$slide_guids = [];
				$slideList.find( 'li.layers-accordion-item' ).each(function(){
					$slide_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$slideInput.val( $slide_guids.join() ).layers_trigger_change();

				// Trigger color selectors
				jQuery('.layers-color-selector').wpColorPicker();
			}
		) // $.post
	});

	/**
	* 3 - Banner Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="slide_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the Title
		$string = ': ' + $that.val();

		// Update the accordian title
		$that.closest( '.layers-accordion-item' ).find( 'span.layers-detail' ).text( $string );

	});

}); //jQuery