/**
* Slider Widget JS file
*
* This file contains functions relating to the Slider Widget
 *
 * @package Layers
 * @since Layers 1.0.0
 * Contents
 * 1 - Sortable items
 * 2 - Slide Removal & Additions
 * 3 - Slide Title Update
 * 4 - Curreny Slide Focussing
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery(document).ready(function($){

	/**
	* 1 - Sortable items
	*/
	
	// Init interface inside widgets
	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
		// 'this' is the widget
		layers_set_slide_sortable( $(this) );
	});

	function layers_set_slide_sortable( $element_s ){
		
		$element_s.find( 'ul[id^="slide_list_"]' ).each( function(){
			
			$that = $(this);
			
			$that.sortable({
				placeholder: "layers-sortable-drop",
				handle: ".layers-accordion-title",
				stop: function(e , li){
					// Banner UL, looking up from our current target
					$slideList = li.item.closest( 'ul' );

					// Set focus slide
					$widget = li.item.closest( '.widget' );
					$slide_index = li.item.index();
					$slide_guid = li.item.data( 'guid' );
					layers_set_slide_index( $widget, $slide_index, $slide_guid );

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
				
		});
	}

	/**
	* 2 - Slide Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="slide_list_"] .icon-trash' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation module
		var $remove_slide = confirm( sliderwidgeti18n.confirm_message );

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
		
		// Reset Sortable Items
		layers_set_column_sortable( $that );
	});

	$(document).on( 'click' , '.layers-add-widget-slide' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);
		
		// Add loading class
		$that.addClass('layers-loading-button');

		// Create the list selector
		$slideListId = '#slide_list_' + $that.data( 'number' );

		// Banner UL
		$slideList = $( $slideListId );

		// Banners <input>
		$slideInput = $( '#slide_ids_input_' + $slideList.data( 'number' ) );

		// Serialize input data
		$serialized_inputs = [];
		$.each(
			$slideList.find( 'li.layers-accordion-item' ).last().find( 'textarea, input, select' ),
			function( i, input ){
				$serialized_inputs.push( $(input).serialize() );
		});

		$post_data ={
			action: 'layers_slider_widget_actions',
			widget_action: 'add',
			id_base: $slideList.data( 'id_base' ),
			instance: $serialized_inputs.join( '&' ),
			last_guid: ( 0 !== $slideList.find( 'li.layers-accordion-item' ).length ) ? $slideList.find( 'li.layers-accordion-item' ).last().data( 'guid' ) : false,
			number: $slideList.data( 'number' ),
			nonce: layers_widget_params.nonce
		};

		$.post(
			ajaxurl,
			$post_data,
			function(data){

				// Set slide
				$slide = $(data);
				
				$slide.find('.layers-accordion-section').hide();

				// Append module HTML
				$slideList.append($slide);

				// Append slide IDs to the slides input
				$slide_guids = [];
				$slideList.find( 'li.layers-accordion-item' ).each(function(){
					$slide_guids.push( $(this).data( 'guid' ) );
					$slide_index = $(this).index();
					$slide_guid = $(this).data( 'guid' );
				});

				// Set focus slide
				$widget = $slideList.closest( '.widget' );
				layers_set_slide_index( $widget, $slide_index, $slide_guid );

				// Trigger change for ajax save
				$slideInput.val( $slide_guids.join() ).layers_trigger_change();
				
				// Trigger interface init. will trigger init of elemnts eg colorpickers etc
				$slide.trigger('layers-interface-init');
				
				// Remove loading class
				$that.removeClass('layers-loading-button');
				
				// Add Open Class to column
				setTimeout( function(){
					$slide.find('.layers-accordion-title').trigger('click');
				}, 300 );
			}
		) // $.post
	});

	/**
	* 3 - Slide Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="slide_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the string value
		$val = $that.val().toString().substr( 0 , 51 );

		// Set the Title
		$string = ': ' + ( $val.length > 50 ? $val + '...' : $val );

		// Update the accordian title
		$that.closest( '.layers-accordion-item' ).find( 'span.layers-detail' ).text( $string );
	});

	/**
	* 4 - Curreny Slide Focussing
	*/
	$(document).on( 'focus click' , 'ul[id^="slide_list_"] li a.layers-accordion-title', function(e){

		// Set focus slide
		$widget = $(this).closest( '.widget' );
		$li = $(this).parent();

		if( undefined !== $li.data('guid') ){
			$slide_index = $li.index();
			$slide_guid = $li.data('guid');
			layers_set_slide_index( $widget, $slide_index, $slide_guid );
		}
	});

	function layers_set_slide_index( $widget, $slide_index, $slide_guid ){
		if( undefined !== $widget ){
			$widget.find( 'input[data-focus-slide="true"]' ).val( $slide_index );
		}
	}

}); //jQuery