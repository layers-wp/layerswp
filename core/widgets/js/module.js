jQuery(document).ready(function($){
	/**
	* Sortable items
	*/

	$( 'ul[id^="module_list_"]' ).sortable({
		placeholder: "hatch-sortable-drop",
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
			$moduleInput.val( $module_guids.join() ).trigger("change");
		}
	});

	/**
	* Module Removal & Additions
	*/

	$(document).on( 'click' , 'ul[id^="module_list_"] .icon-cross' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Confirmation message @TODO: Make JS confirmation module
		$remove_slide = confirm( "Are you sure you want to remove this column?" );
		if( false == $remove_slide ) return;


		// Module UL
		$moduleList = $( '#module_list_' + $that.data( 'number' ) );

		// Modules <input>
		$moduleInput = $( '#module_ids_input_' + $moduleList.data( 'number' ) );

		// Remove this module
		$that.closest( '.hatch-accordion-item' ).remove();

		// Curate module IDs
		$module_guids = [];

		$moduleList.find( 'li.hatch-accordion-item' ).each(function(){
			$module_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$moduleInput.val( $module_guids.join() ).trigger("change");

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

		$.post(
			hatch_widget_params.ajaxurl,
			{
				action: 'hatch_module_widget_actions',
				widget_action: 'add',
				id_base: $moduleList.data( 'id_base' ),
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
				$moduleInput.val( $module_guids.join() ).trigger("change");

				// Trigger color selectors
				jQuery('.hatch-color-selector').wpColorPicker();
			}
		) // $.post
	});

	/**
	* Module Title Update
	*/

	$(document).on( 'keyup' , 'ul[id^="module_list_"] input[id*="-title"]' , function(e){

		// "Hi Mom"
		$that = $(this);

		// Set the Title
		$string = ': ' + $that.val();

		// Update the accordian title
		$that.closest( '.hatch-accordian-item' ).find( 'span.hatch-detail' ).html( $new_title );

	});

}); //jQuery