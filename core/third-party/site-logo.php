<?php if( !function_exists( 'site_logo_init' ) ) {
    function site_logo_init() {
    	// Only load our code if our theme declares support, and the standalone plugin is not activated.
    	if ( current_theme_supports( 'site-logo' ) && ! class_exists( 'Site_Logo', false ) ) {
    		// Load our class for namespacing.
    		require( dirname( __FILE__ ) . '/site-logo/inc/class-site-logo.php' );

    		// Load template tags.
    		require( dirname( __FILE__ ) . '/site-logo/inc/functions.php' );
    	}
    }
}
add_action( 'init', 'site_logo_init' );