/**
* Content Widget JS file
*
* This file contains functions relating to the Content Widget
 *
 * @package Layers
 * @since Layers 1.0.0
 * Contents
 * 1 - Sortable items
 * 2 - Item Removal
 * 3 - Item Addition
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

	$( document ).on( 'layers-interface-init', function( e, element ){
		layers_set_column_sortable( $(element) );
	});

	function layers_set_column_sortable( $element_s ){

		$element_s.find( 'ul.layers-accordions-sortable' ).each( function(){

			$that = $(this);

			$that.sortable({
				placeholder: "layers-sortable-drop",
				handle: ".layers-accordion-title",
				stop: function(e , li){

					// Get Elements
					$repeater_list = li.item.closest( 'ul' );
					$repeater_group = $repeater_list.parents('.layers-widget-repeater');
					$repeater_input = $repeater_group.find('.layers-repeater-input');

					// Apply new column order
					$item_guids = [];
					$repeater_list.find( 'li.layers-accordion-item' ).each(function(){
						$item_guids.push( $(this).data( 'guid' ) );
					});

					// Trigger change for ajax save
					$repeater_input.val( $item_guids.join() ).layers_trigger_change();
				}
			});
		});
	}

	/**
	* 2 - Item Removal
	*/
	$(document).on( 'click' , '.layers-widget-repeater .layers-icon-error' , function(e){

		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation column

		if( false === confirm( contentwidgeti18n.confirm_message ) ) return;

		// Get elements
		$repeater_delete_button = $(this);
		$repeater_item_row      = $repeater_delete_button.closest( '.layers-accordion-item' );
		$repeater_item_title    = $repeater_item_row.find('.layers-accordion-title');
		$repeater_group         = $repeater_delete_button.parents('.layers-widget-repeater');
		$repeater_list          = $repeater_group.find('.layers-accordions');
		$repeater_input         = $repeater_group.find('.layers-repeater-input');

		// Close the row first.
		$repeater_item_title.click();

		// Delay till the row closed.
		setTimeout(function() {

			$repeater_item_row.addClass('layers-accordion-item-remove');

			// Delay while the remove animation plays.
			setTimeout(function() {

				$repeater_item_row.animate({ height: 0, margin: 0 }, { duration: 150, complete: function() {

					// Remove this row completely now.
					$repeater_item_row.remove();

					// Curate column IDs
					$column_guids = [];

					$repeater_list.find( 'li.layers-accordion-item' ).each(function(){
						$column_guids.push( $(this).data( 'guid' ) );
					});

					// Trigger change for ajax save
					$repeater_input.val( $column_guids.join() ).layers_trigger_change();

					// Reset Sortable Items
					layers_set_column_sortable( $that );

				}});

			}, 700 );

		}, 500 );
	});

	/**
	* 3 - Item Adittion
	*/
	$(document).on( 'click' , '.layers-widget-repeater-add-item' , function(e){

		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Get elements
		$repeater_add_button = $(this);
		$repeater_group  = $repeater_add_button.parents('.layers-widget-repeater');
		$repeater_list   = $repeater_group.find('.layers-accordions');
		$repeater_input  = $repeater_group.find('.layers-repeater-input');
		$widget_form     = $repeater_add_button.parents('.widget-content');

		// Get data
		var data_repeater_type    = $repeater_group.attr( 'data-repeater-type' );
		var data_repeater_number  = $repeater_group.attr( 'data-repeater-number' );
		var data_repeater_class   = $repeater_group.attr( 'data-repeater-class' );
		var data_repeater_id_base = $repeater_group.attr( 'data-repeater-id-base' );

		// Add loading class
		$repeater_add_button.addClass('layers-loading-button');

		// Serialize input data
		$serialized_inputs = [];
		$.each(
			$repeater_list.find( 'li.layers-accordion-item' ).last().find( 'textarea, input, select' ),
			function( i, input ){
				$serialized_inputs.push( $(input).serialize() );
			}
		);

		// Serialize input data
		$serialized_instance_inputs = $widget_form.find( 'textarea, input, select, checkbox' ).serialize();

		$post_data = {
			action        : 'layers_widget_new_repeater_item',
			widget_action : 'add-item',
			item_type     : data_repeater_type,
			item_class    : data_repeater_class,
			instance      : $serialized_instance_inputs,
			id_base       : data_repeater_id_base,
			number        : data_repeater_number,
			nonce         : layers_widget_params.nonce,
		};

		$.post(
			ajaxurl,
			$post_data,
			function(data){

				// Set item
				$item = $(data);

				$item.find('.layers-accordion-section').hide();

				// Append item HTML
				$repeater_list.append($item);

				// Append item IDs to the items input
				$item_guids = [];
				$repeater_list.find( 'li.layers-accordion-item' ).each(function(){
					$item_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$repeater_input.val( $item_guids.join() ).layers_trigger_change();

				// Trigger interface init. will trigger init of elemnts eg colorpickers etc
				$( document ).trigger( 'layers-interface-init', $item );

				// Remove loading class
				$repeater_add_button.removeClass('layers-loading-button');

				// Add Open Class to item
				setTimeout( function(){
					$item.find('.layers-accordion-title').trigger('click');
				}, 300 );
			}
		) // $.post

	});



	/**
	* 3 - Module Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="column_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the string value
		$val = $that.val().toString().substr( 0 , 51 );

		// Set the Title
		$string = ': ' + ( $val.length > 50 ? $val + '...' : $val );

		// Update the accordian title
		$that.closest( '.layers-accordion-item' ).find( 'span.layers-detail' ).text( $string );

	});


}); //jQuery
