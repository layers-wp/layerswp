/**
 * Admin Intercom JS file
 *
 * This file contains functions to work with Intercom
 *
 * @package Layers
 * @since Layers 1.2.6
 *
 * 1 - trackEvent jQuery function
 * 2 - Fringe Events
 *
 */

jQuery(function ( $ ) {

	/**
	* 1 - trackEvent jQuery function
	*
	* Used to trigger an event and send it to Intercom with (string) event_name & extra (object) meta_data
	*/

	$.fn.layers_intercom_event = function( event_name, meta_data ) {

		if( undefined == meta_data ) meta_data = {};

		var tracked_event = Intercom( 'trackEvent', event_name, meta_data );
	};

	/**
	* 2 - Fringe Events
	*
	* Used to trigger events that aren't localized to a specific function
	*/

	$(document).on( 'click', 'a[href^="http://bit.ly/"]', function(){
		
		$(document).layers_intercom_event( 'clicked bitly link', {
			"Link Title": $(this).text(),
			"Link URL": $(this).attr( 'href' ),
		});
	});

	$(document).on( 'click', 'a[href^="http://themeforest.net/"], a[href^="http://codecanyon.net/"]', function(){
		
		$(document).layers_intercom_event( 'clicked envato link', {
			"Item": $(this).attr( 'data-item' ),
			"Price": $(this).attr( 'data-price' ),
			"Item URL": $(this).attr( 'href' ),
		});
	});

	$(document).on( 'click', '.layers-get-updater', function(){

		$(document).layers_intercom_event( 'clicked layers updater link' );
	});
	
});