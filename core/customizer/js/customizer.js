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
			$( '#accordion-section-sidebar-widgets-obox-hatch-builder-home .accordion-section-title' ).trigger( 'click' );
	}
});