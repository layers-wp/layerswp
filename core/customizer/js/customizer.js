/**
* Customizer JS file
*
* This file contains global widget functions
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Page Builder Macro
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
});