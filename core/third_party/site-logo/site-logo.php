<?php
/*
 * Plugin Name: Site Logo
 * Plugin URI: http://wordpress.com
 * Description: Add a logo to your WordPress site. Set it once, and all themes that support it will display it automatically.
 * Author: Automattic
 * Version: 1.0
 * Author URI: http://wordpress.com
 * License: GPL2 or later
 * Text Domain: site-logo
 * Domain Path: /languages/
 */

/**
 * Activate the Site Logo plugin.
 *
 * @uses current_theme_supports()
 * @since 1.0
 */

if( ! function_exists( 'site_logo_init' ) ) {
	function site_logo_init() {
		// Only load our code if our theme declares support for site logos.
		if ( current_theme_supports( 'site-logo' ) ) {

			// Load our class for namespacing.
			locate_template( '/core/third_party/site-logo/inc/class-site-logo.php' , true );

			// Load template tags.
			locate_template( '/core/third_party/site-logo/inc/functions.php' , true );
		}
	}
}
add_action( 'init', 'site_logo_init', 50 );