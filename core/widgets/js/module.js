jQuery(document).ready(function($){

	/**
	* Column Selector
	*/
	$( document ).on( 'change' , 'input[id*="_module_columns"]' , function(){
		// "Hi Mom"
		$that = $(this);

		// Get the module column container ID
		$list = $that.data( 'module_list' );

		// Get the container object
		$moduleList = $($list);

		$moduleList.removeClass( 'hatch-columns-1 hatch-columns-2 hatch-columns-3 hatch-columns-4 hatch-columns-5');
		$moduleList.addClass( 'hatch-' + $that.val() );
	});

	/**
	* Sortable columns
	*/
	$(document).on( 'click' , '.widget-tpl' , function(){ hatch_set_sortable_module(); });

	hatch_set_sortable_module();

	$( document ).on( 'sort' , 'div[id^="module_list_"]' , function( e, ui ){
		ui.placeholder.css('height', ui.item[0].offsetHeight );
	});

	function hatch_set_sortable_module(){
		var textareaID;
		$( 'div[id^="module_list_"]' ).sortable({
			placeholder: "hatch-sortable-drop hatch-column hatch-span class",
			start: function(e , li){
	 			textareaID = $(li.item).find('.wp-editor-area').attr('id');
				try { tinyMCE.execCommand('mceRemoveControl', false, textareaID); } catch( err ){ console.log( err ); }
			},
			stop: function(e , div){

				// Banner UL, looking up from our current target
				$moduleList = div.item.closest( 'div[id^="module_list_"]' );

				// Modules <input>
				$moduleInput = $( '#module_ids_input_' + $moduleList.data( 'number' ) );

				// Apply new module order & classes
				$module_col_count = 0;
				$module_guids = [];
				$moduleList.find( 'div.hatch-column' ).each(function(){

					// Add GUID order to the input
					$module_guids.push( $(this).data( 'guid' ) );

					// Column classes
					$module_col_count++;
					$(this).removeClass( 'hatch-span-position-1 hatch-span-position-2 hatch-span-position-3 hatch-span-position-4' );
					$(this).addClass( 'hatch-span-position-' + $module_col_count );
				});

				// Trigger change for ajax save
				$moduleInput.val( $module_guids.join() ).trigger("change");

				// Make sure tinyMCE works
				try {
					console.log( textareaID );
					tinyMCE.execCommand('mceAddControl', false, textareaID );

				} catch(e){}
			}
		});
	}

}); //jQuery