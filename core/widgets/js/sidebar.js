jQuery(document).ready(function($){
	/**
	* Sortable items
	*/

	$( 'ul[id^="sidebar_list_"]' ).sortable({
		placeholder: "hatch-sortable-drop",
		handle: ".hatch-accordion-title",
		stop: function(e , li){
			// Module UL, looking up from our current target
			$sidebarList = li.item.closest( 'ul' );

			// Modules <input>
			$sidebarInput = $( '#sidebar_ids_input_' + $sidebarList.data( 'number' ) );

			// Apply new sidebar order
			$sidebar_guids = [];
			$sidebarList.find( 'li.hatch-accordion-item' ).each(function(){
				$sidebar_guids.push( $(this).data( 'guid' ) );
			});

			// Trigger change for ajax save
			$sidebarInput.val( $sidebar_guids.join() ).hatch_trigger_change();
		}
	});

	/**
	* Module Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="sidebar_list_"] .icon-trash' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Confirmation message @TODO: Make JS confirmation sidebar
		$remove_slide = confirm( "Are you sure you want to remove this column?" );
		if( false == $remove_slide ) return;


		// Module UL
		$sidebarList = $( '#sidebar_list_' + $that.data( 'number' ) );

		// Modules <input>
		$sidebarInput = $( '#sidebar_ids_input_' + $sidebarList.data( 'number' ) );

		// Remove this sidebar
		$that.closest( '.hatch-accordion-item' ).remove();

		// Curate sidebar IDs
		$sidebar_guids = [];

		$sidebarList.find( 'li.hatch-accordion-item' ).each(function(){
			$sidebar_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$sidebarInput.val( $sidebar_guids.join() ).hatch_trigger_change();

	});

	$(document).on( 'click' , '.hatch-add-widget-sidebar' , function(e){
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
			hatch_widget_params.ajaxurl,
			{
				action: 'hatch_sidebar_widget_actions',
				widget_action: 'add',
				id_base: $sidebarList.data( 'id_base' ),
				number: $sidebarList.data( 'number' ),
				nonce: hatch_widget_params.nonce

			},
			function(data){
				// Append sidebar HTML
				$( data ).insertBefore( $sidebarListId + ' .hatch-add-widget-sidebar' );

				// Append sidebar IDs to the sidebars input
				$sidebar_guids = [];
				$sidebarList.find( 'li.hatch-accordion-item' ).each(function(){
					$sidebar_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$sidebarInput.val( $sidebar_guids.join() ).hatch_trigger_change();

				// Trigger color selectors
				jQuery('.hatch-color-selector').wpColorPicker();
			}
		) // $.post
	});

	/**
	* Module Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="sidebar_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the Title
		$string = ': ' + $that.val();

		// Update the accordian title
		$that.closest( '.hatch-accordion-item' ).find( 'span.hatch-detail' ).text( $string );

	});


}); //jQuery