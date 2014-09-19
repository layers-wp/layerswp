jQuery(document).ready(function($){
	/**
	* Sortable items
	*/

	$( 'ul[id^="module_list_"]' ).sortable({
		placeholder: "hatch-sortable-drop",
		stop: function(e , li){
			// Banner UL, looking up from our current target
			$moduleList = li.item.closest( 'ul' );

			// Banners <input>
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

}); //jQuery