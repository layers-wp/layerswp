/**
* Customizer JS file
*
* This file contains global widget functions
 *
 * @package Layers
 * @since Layers 1.0
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

	if( true == layers_customizer_params.builder_page ){
		// Jump into the Widget editor block on Layers Page - DISABLED
		//$( 'li[id*="accordion-section-sidebar-widgets-obox-layers-builder"] .accordion-section-title' ).trigger( 'click' );
	}

	/**
	 * 2 - Customizer UI enhancements
	 */

	var layers_builder_pages_drop_down = '.layers-customizer-pages-dropdown select',
		layers_previous_page_url;

	// Helper to get current url
	// provide default_url fix for when no querystring 'url' exists,
	// which happens when coming from Appearance > Customizer
	var default_url = wp.customize.previewer.previewUrl();
	function layers_get_customizer_url() {
		if( layers_get_parameter_by_name('url', window.location) ){
			return layers_get_parameter_by_name('url', window.location);
		}
		else {
			return default_url;
		}
	}

	// Helper to get query stings by param name - like query strings.
	function layers_get_parameter_by_name(name, url) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	// Change the customizer url when the dropdown is changed.
	$(document).on('change', layers_builder_pages_drop_down, function(){
		var new_preview_url = $(this).val();
		if ( new_preview_url != wp.customize.previewer.previewUrl() ){
			wp.customize.previewer.previewUrl( $(this).val() );
			layers_add_history_state();
			layers_update_customizer_interface();
		}
	});

	// Update the UI when customizer url changes
	// eg when an <a> in the preview window is clicked
	function layers_update_customizer_interface() {
		//Update the dropdown
		if( $(layers_builder_pages_drop_down + ' option[value="' + wp.customize.previewer.previewUrl() + '"]').length ){
			$(layers_builder_pages_drop_down).val( wp.customize.previewer.previewUrl() );
		} else {
			$(layers_builder_pages_drop_down).val( 'init' );
		}

		// Change the 'X' close button
		$('.customize-controls-close').attr('href', wp.customize.previewer.previewUrl() );

		// Change the 'Preview Page' button
		$('.customize-controls-layers-button-preview').attr('href', layers_get_customizer_url() );

	}
	layers_update_customizer_interface();

	// Listen for event when customizer url chnages
	function layers_handle_customizer_talkback() {
		layers_add_history_state();
		layers_update_customizer_interface();
	}
	wp.customize.previewer.bind('url', layers_handle_customizer_talkback);

	// Move the Layers Dashboard button to it's correct placing - no hook available
	$('#customize-header-actions').append( $('.customize-controls-layers-button-dashboard, .customize-controls-layers-button-preview') );
	$('.customize-controls-layers-button-dashboard, .customize-controls-layers-button-preview').css({ 'display':'block', 'visibility':'visible' });

	// Jump to control - during testing only (must comment for launch).
	//$('#accordion-section-layers-footer-customization').children('.accordion-section-title').click();
	//$('#accordion-section-layers-header-layout').children('.accordion-section-title').click();

	/**
	 * 3 - Better history states in customizer
	 *
	 * TODO: Check WP bleeding edge versions for this functionality.
	 * https://core.trac.wordpress.org/ticket/28536
	 */

	// Add history state customizer changes
	function layers_add_history_state(){
		// Update the browser URl so page can be refreshed
		if (window.history.pushState) {
			// Newer Browsers only (IE10+, Firefox3+, etc)
			var url = window.location.href.split('?')[0] + "?url=" + wp.customize.previewer.previewUrl() + "&layers-builder=1";
			window.history.pushState({}, "", url);
		}
	}

	// Listen for changes in history state - eg push of the next/prev botton
	window.addEventListener('popstate', function(e){
		wp.customize.previewer.previewUrl( layers_get_customizer_url() );
		layers_update_customizer_interface();
	}, false);



});