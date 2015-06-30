/**
* Content Widget JS file
*
* This file contains functions relating to the Content Widget
 *
 * @package Layers
 * @since Layers 1.0.0
 * Contents
 * 1 - Sortable items
 * 2 - Column Removal & Additions
 * 3 - Column Title Update
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

	$( document ).on( 'layers-interface-init', '.widget, .layers-accordions', function( e ){
		// 'this' is the widget
		layers_set_column_sortable( $(this) );
	});

	function layers_set_column_sortable( $element_s ){

		$element_s.find( 'ul[id^="column_list_"]' ).each( function(){

			$that = $(this);

			$that.sortable({
				placeholder: "layers-sortable-drop",
				handle: ".layers-accordion-title",
				stop: function(e , li){
					// Module UL, looking up from our current target
					$columnList = li.item.closest( 'ul' );

					// Modules <input>
					$columnInput = $( '#column_ids_input_' + $columnList.data( 'number' ) );

					// Apply new column order
					$column_guids = [];
					$columnList.find( 'li.layers-accordion-item' ).each(function(){
						$column_guids.push( $(this).data( 'guid' ) );
					});

					// Trigger change for ajax save
					$columnInput.val( $column_guids.join() ).layers_trigger_change();
				}
			});
		});
	}

	/**
	* 2 - Column Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="column_list_"] .icon-trash' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation column

		var $remove_column = confirm( contentwidgeti18n.confirm_message );

		if( false === $remove_column ) return;

		// Module UL
		$columnList = $( '#column_list_' + $that.data( 'number' ) );

		// Modules <input>
		$columnInput = $( '#column_ids_input_' + $columnList.data( 'number' ) );

		// Remove this banner
		$that.closest( '.layers-accordion-item' ).remove();

		// Curate column IDs
		$column_guids = [];

		$columnList.find( 'li.layers-accordion-item' ).each(function(){
			$column_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$columnInput.val( $column_guids.join() ).layers_trigger_change();

		// Reset Sortable Items
		layers_set_column_sortable( $that );
	});

	$(document).on( 'click' , '.layers-add-widget-column' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Add loading class
		$that.addClass('layers-loading-button');

		// Create the list selector
		$columnListId = '#column_list_' + $that.data( 'number' );

		// Module UL
		$columnList = $( $columnListId );

		// Modules <input>
		$columnInput = $( '#column_ids_input_' + $columnList.data( 'number' ) );

		// Serialize input data
		$serialized_inputs = [];
		$.each(
			$columnList.find( 'li.layers-accordion-item' ).last().find( 'textarea, input, select' ),
			function( i, input ){
				$serialized_inputs.push( $(input).serialize() );
		});

		$post_data = {
			action: 'layers_content_widget_actions',
			widget_action: 'add',
			id_base: $columnList.data( 'id_base' ),
			instance: $serialized_inputs.join( '&' ),
			last_guid: ( 0 !== $columnList.find( 'li.layers-accordion-item' ).length ) ? $columnList.find( 'li.layers-accordion-item' ).last().data( 'guid' ) : false,
			number: $columnList.data( 'number' ),
			nonce: layers_widget_params.nonce
		};

		$.post(
			ajaxurl,
			$post_data,
			function(data){

				// Set column
				$column = $(data);

				$column.find('.layers-accordion-section').hide();

				// Append column HTML
				$columnList.append($column);

				// Append column IDs to the columns input
				$column_guids = [];
				$columnList.find( 'li.layers-accordion-item' ).each(function(){
					$column_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$columnInput.val( $column_guids.join() ).layers_trigger_change();

				// Trigger interface init. will trigger init of elemnts eg colorpickers etc
				$column.trigger('layers-interface-init');
				
				// Remove loading class
				$that.removeClass('layers-loading-button');

				// Add Open Class to column
				setTimeout( function(){
					$column.find('.layers-accordion-title').trigger('click');
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
