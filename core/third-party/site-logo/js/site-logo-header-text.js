/* global site_logo_header_classes */
/**
 * JS for handling the "Display Header Text" setting's realtime preview.
 */
(function($){
	var api = wp.customize,
		$classes = site_logo_header_classes;

	api( 'site_logo_header_text', function( value ) {
		value.bind( function( to ) {
			if ( true === to ) {
				$( $classes ).show();
			} else {
				$( $classes ).hide();
			}
		});
	});
})(jQuery);