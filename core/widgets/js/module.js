/**
* Content Widget JS file
*
* This file contains functions relating to the Content Widget
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Sortable items
 * 2 - Column Removal & Additions
 * 3 - Column Title Update
*/

jQuery(document).ready(function($){

	/**
	* 1 - Sortable items
	*/
	hatch_set_column_sorable();

	$(document).on ( 'widget-added' , function(){
		hatch_set_column_sorable();
	});

	function hatch_set_column_sorable(){

		var $module_lists = $( 'ul[id^="module_list_"]' );

		$module_lists.sortable({
			placeholder: "hatch-sortable-drop",
			handle: ".hatch-accordion-title",
			stop: function(e , li){
				// Module UL, looking up from our current target
				$moduleList = li.item.closest( 'ul' );

				// Modules <input>
				$moduleInput = $( '#module_ids_input_' + $moduleList.data( 'number' ) );

				// Apply new module order
				$module_guids = [];
				$moduleList.find( 'li.hatch-accordion-item' ).each(function(){
					$module_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$moduleInput.val( $module_guids.join() ).hatch_trigger_change();
			}
		});
	}

	/**
	* 2 - Column Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="module_list_"] .icon-trash' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation module
		var $remove_column = confirm( "Are you sure you want to remove this column?" );

		if( false === $remove_column ) return;

		// Module UL
		$moduleList = $( '#module_list_' + $that.data( 'number' ) );

		// Modules <input>
		$moduleInput = $( '#module_ids_input_' + $moduleList.data( 'number' ) );

		// Remove this banner
		$that.closest( '.hatch-accordion-item' ).remove();

		// Curate module IDs
		$module_guids = [];

		$moduleList.find( 'li.hatch-accordion-item' ).each(function(){
			$module_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$moduleInput.val( $module_guids.join() ).hatch_trigger_change();

		// Reset Sortable Items
		hatch_set_column_sorable();
	});

	$(document).on( 'click' , '.hatch-add-widget-module' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Create the list selector
		$moduleListId = '#module_list_' + $that.data( 'number' );

		// Module UL
		$moduleList = $( $moduleListId );

		// Modules <input>
		$moduleInput = $( '#module_ids_input_' + $moduleList.data( 'number' ) );

		// Serialize input data
		$serialized_inputs = [];
		$.each(
			$moduleList.find( 'li.hatch-accordion-item' ).last().find( 'textarea, input, select' ),
			function( i, input ){
				$serialized_inputs.push( $(input).serialize() );
		});

		$.post(
			hatch_widget_params.ajaxurl,
			{
				action: 'hatch_module_widget_actions',
				widget_action: 'add',
				id_base: $moduleList.data( 'id_base' ),
				instance: $serialized_inputs.join( '&' ),
				last_guid: $moduleList.find( 'li.hatch-accordion-item' ).last().data( 'guid' ),
				number: $moduleList.data( 'number' ),
				nonce: hatch_widget_params.nonce

			},
			function(data){

				// Append module HTML
				$( data ).insertBefore( $moduleListId + ' .hatch-add-widget-module' );

				// Append module IDs to the modules input
				$module_guids = [];
				$moduleList.find( 'li.hatch-accordion-item' ).each(function(){
					$module_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$moduleInput.val( $module_guids.join() ).hatch_trigger_change();

				// Trigger color selectors
				jQuery('.hatch-color-selector').wpColorPicker();
			}
		) // $.post

	});

	/**
	* 3 - Module Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="module_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the Title
		$string = ': ' + $that.val();

		// Update the accordian title
		$that.closest( '.hatch-accordion-item' ).find( 'span.hatch-detail' ).text( $string );

	});


}); //jQuery