<?php if( !function_exists( 'layers_site_logo_init' ) ) {
	function layers_site_logo_init() {
		// Only load our code if our theme declares support, and the standalone plugin is not activated.
		if ( current_theme_supports( 'site-logo' ) && ! class_exists( 'Site_Logo', false ) ) {

			// Load our class for namespacing.
			require_once( dirname( __FILE__ ) . '/site-logo/inc/class-site-logo.php' );

			// Load template tags.
			require_once( dirname( __FILE__ ) . '/site-logo/inc/functions.php' );

			// Load backwards-compatible template tags.
			require( dirname( __FILE__ ) . '/site-logo/inc/compat.php' );
		}
	}
}
add_action( 'init', 'layers_site_logo_init', 100 );
