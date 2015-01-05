/**
 * Dynamic Sidebar Widget JS file
 *
 * This file contains functions relating to the Dynamic Sidebar Widget
 *
 * @package Layers
 * @since Layers 1.0
 * Contents
 * 1 - Sortable items
 * 2 - Sidebar Removal & Additions
 * 3 - Sidebar Title Update
*/

jQuery(document).ready(function($){

	/**
	* 1 - Sortable items
	*/
	layers_set_column_sorable();

	$(document).on ( 'widget-added' , function(){
		layers_set_column_sorable();
	});

	function layers_set_column_sorable(){

		var $sidebar_lists = $( 'ul[id^="sidebar_list_"]' );

		$sidebar_lists.sortable({
			placeholder: "layers-sortable-drop",
			handle: ".layers-accordion-title",
			stop: function(e , li){
				// Module UL, looking up from our current target
				$sidebarList = li.item.closest( 'ul' );

				// Modules <input>
				$sidebarInput = $( '#sidebar_ids_input_' + $sidebarList.data( 'number' ) );

				// Apply new sidebar order
				$sidebar_guids = [];
				$sidebarList.find( 'li.layers-accordion-item' ).each(function(){
					$sidebar_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$sidebarInput.val( $sidebar_guids.join() ).layers_trigger_change();
			}
		});
	}

	/**
	* 2 - Sidebar Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="sidebar_list_"] .icon-trash' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation sidebar
		var $remove_column = confirm( "Are you sure you want to remove this column?" );

		if( false == $remove_column ) return;


		// Module UL
		$sidebarList = $( '#sidebar_list_' + $that.data( 'number' ) );

		// Modules <input>
		$sidebarInput = $( '#sidebar_ids_input_' + $sidebarList.data( 'number' ) );

		// Remove this sidebar
		$that.closest( '.layers-accordion-item' ).remove();

		// Curate sidebar IDs
		$sidebar_guids = [];

		$sidebarList.find( 'li.layers-accordion-item' ).each(function(){
			$sidebar_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$sidebarInput.val( $sidebar_guids.join() ).layers_trigger_change();

	});

	$(document).on( 'click' , '.layers-add-widget-sidebar' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Create the list selector
		$sidebarListId = '#sidebar_list_' + $that.data( 'number' );

		// Module UL
		$sidebarList = $( $sidebarListId );

		// Modules <input>
		$sidebarInput = $( '#sidebar_ids_input_' + $sidebarList.data( 'number' ) );

		$.post(
			layers_widget_params.ajaxurl,
			{
				action: 'layers_sidebar_widget_actions',
				widget_action: 'add',
				id_base: $sidebarList.data( 'id_base' ),
				number: $sidebarList.data( 'number' ),
				nonce: layers_widget_params.nonce

			},
			function(data){
				// Append sidebar HTML
				$( data ).insertBefore( $sidebarListId + ' .layers-add-widget-sidebar' );

				// Append sidebar IDs to the sidebars input
				$sidebar_guids = [];
				$sidebarList.find( 'li.layers-accordion-item' ).each(function(){
					$sidebar_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$sidebarInput.val( $sidebar_guids.join() ).layers_trigger_change();

				// Trigger color selectors
				jQuery('.layers-color-selector').wpColorPicker();
			}
		) // $.post
	});

	/**
	* 3 - Sidebar Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="sidebar_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the Title
		$string = ': ' + $that.val();

		// Update the accordian title
		$that.closest( '.layers-accordion-item' ).find( 'span.layers-detail' ).text( $string );

	});


}); //jQuery