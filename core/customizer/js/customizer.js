/**
* Customizer JS file
*
* This file contains global widget functions
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Page Builder Macro
 * 2 - Customizer UI enhancements
 * 3 - Better history states in customizer
*/

jQuery.noConflict();

jQuery(document).ready(function($) {

	/**
	 * 1 - Page Builder Macro
	 */

	if( true == hatch_customizer_params.builder_page ){
			$( '#accordion-panel-widgets .accordion-section-title' ).trigger( 'click' );
			//$( 'li[id*="accordion-section-sidebar-widgets-obox-hatch-builder"] .accordion-section-title' ).trigger( 'click' );
            $( '#accordion-panel-widgets .control-section .accordion-section-title' ).eq(0).trigger( 'click' );
	}
	
	/**
	 * 2 - Customizer UI enhancements
	 */
	
	var api = wp.customize,
		hatch_builder_pages_drop_down = '.hatch-customizer-pages-dropdown select';
		
	// Change the customizer url when the dropdown is changed.
	$(document).on('change', hatch_builder_pages_drop_down, function(){
		var new_preview_url = $(this).val();
		if ( new_preview_url != api.previewer.previewUrl() ){
			api.previewer.previewUrl( $(this).val() );
			hatch_update_customizer_interface();
			hatch_add_history_state();
		}
	});
	
	// Update the UI when customizer url changes
	// eg when an <a> in the preview window is clicked
	function hatch_update_customizer_interface() {
		//Update the dropdown
		if( $(hatch_builder_pages_drop_down + ' option[value="' + api.previewer.previewUrl() + '"]').length ){
			$(hatch_builder_pages_drop_down).val( api.previewer.previewUrl() );
		} else {
			$(hatch_builder_pages_drop_down).val( 'init' );
		}
		
		//Change the X close button
		$('.customize-controls-close').attr('href', api.previewer.previewUrl() );
	}
	
	// Listen for event when customizer url chnages
	function hatch_handle_customizer_talkback() {
		hatch_update_customizer_interface();
		hatch_add_history_state();
	}
	api.previewer.bind('url', hatch_handle_customizer_talkback);
	
	// Move the Hatch Dashboard button to it's correct placing - no hook available
	$('#customize-header-actions').append( $('.customize-controls-hatch-dashboard') );
	$('.customize-controls-hatch-dashboard').css({'display':'block', 'visibility':'visible'});
	
	/**
	 * 3 - Better history states in customizer
	 *
	 * TODO: Check WP bleeding edge versions for this functionality.
	 * https://core.trac.wordpress.org/ticket/28536
	 */
	
	// Add history state customizer changes
	function hatch_add_history_state(){
		// Update the browser URl so page can be refreshed
		if (window.history.pushState) {
			// Newer Browsers only (IE10+, Firefox3+, etc)
			var url = window.location.href.split('?')[0] + "?url=" + hatch_get_parameter_by_name('url', window.location) + "&hatch-builder=1";
			window.history.pushState({}, "", url);
		}
	}
	
	// Listen for changes in history state - eg push of the next/prev botton
	window.addEventListener('popstate', function(e){
		api.previewer.previewUrl( hatch_get_parameter_by_name('url', window.location) );
		hatch_update_customizer_interface();
	}, false);
	
	// Helper to get get query stings by param name - like query strings.
	function hatch_get_parameter_by_name(name, url) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
});