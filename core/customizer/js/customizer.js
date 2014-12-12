/**
* Customizer JS file
*
* This file contains global widget functions
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Page Builder Macro
 * 2 - Page Builder Pages Drop-Down
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
	 * 2 - Page Builder Pages Drop-Down
	 */
	
	var api = wp.customize,
		hatch_builder_pages = '.hatch-customizer-pages-dropdown select';
		
	// Change the previewUrl when the dropdown is changed.
	$(document).on('change', hatch_builder_pages, function(){
		var new_preview_url = $(this).val();
		if ( new_preview_url != api.previewer.previewUrl() ){
			api.previewer.previewUrl( $(this).val() );
		}
	});
	
	// Change the previewUrl when a <a> in the preview window is clicked.
	api.previewer.bind('url', function(){
		if( $(hatch_builder_pages + ' option[value="' + this.previewUrl() + '"]').length ){
			$(hatch_builder_pages).val( this.previewUrl() );
		} else {
			$(hatch_builder_pages).val( 'init' );
		}
	});
	
});