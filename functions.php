<?php
/**
 * @package Hatch
 */

/**
 * The current version of the theme. Use a random number for SCRIPT_DEBUG mode
 */
if ( defined( 'SCRIPT_DEBUG' ) && TRUE == SCRIPT_DEBUG ) {
	define( 'HATCH_VERSION', rand( 0 , 100 ) );
} else {
	define( 'HATCH_VERSION', '1.0' );
}
define( 'HATCH_TEMPLATE_URI' , get_template_directory_uri() );
define( 'HATCH_TEMPLATE_DIR' , get_template_directory() );
define( 'HATCH_THEME_SLUG' , 'obox-hatch' );
define( 'HATCH_BUILDER_TEMPLATE' , 'builder.php' );
define( 'OBOX_URL' , 'http://oboxthemes.com');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 660; /* pixels */


/**
 * Adjust the content width when the full width page template is being used
 */
function hatch_set_content_width() {
	global $content_width;

	if ( is_page_template( 'full-width.php' ) ) {
		$content_width = 1080;
	} elseif( is_singular() ) {
		$content_width = 660;
	}
}
add_action( 'template_redirect', 'hatch_set_content_width' );

/*
 * Third Party Scripts
 */
// require get_template_directory() . '/core/third_party/wp_editor.php';

/*
 * Load Widgets
 */
locate_template( '/core/widgets/init.php' , true );

/*
 * Load Customizer Support
 */
locate_template( '/core/customizer/init.php' , true );

/*
 * Load Custom Post Meta
 */
locate_template( '/core/meta/init.php' , true );

if( ! function_exists( 'hatch_setup' ) ) {
	function hatch_setup(){

		/**
		 * Add support for widgets inside the customizer
		 */
		add_theme_support('widget-customizer');

		/**
		 * Add support for featured images
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add support for the WP logo feature
		 */
		add_theme_support( 'site-logo', array(
			'header-text' => array(
				'sitetitle',
				'tagline',
			),
			'size' => 150,
		) );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', HATCH_THEME_SLUG )
		) );
	}
	add_action( 'init' , 'hatch_setup' );
}


/**
*  Enqueue styles and scripts
*/
function hatch_scripts(){

	// Front end Scripts

	// Swiper JS
	wp_enqueue_script(
		HATCH_THEME_SLUG . '-slider-js' ,
		get_template_directory_uri() . '/core/widgets/js/swiper.js',
		array(
			'jquery',
			'masonry'
		)
	);
	wp_register_style(
		HATCH_THEME_SLUG . '-slider-css',
		get_template_directory_uri() . '/core/widgets/css/swiper.css',
		array(),
		HATCH_VERSION
	);

	// Front end Styles
	wp_register_style(
		HATCH_THEME_SLUG . '-components-css',
		get_template_directory_uri() . '/css/components.css',
		array(),
		HATCH_VERSION
	);
	wp_enqueue_style(
		HATCH_THEME_SLUG . '-style' ,
		get_stylesheet_uri() ,
		array(
			HATCH_THEME_SLUG . '-components-css',
			HATCH_THEME_SLUG . '-slider-css'
		) ,
		HATCH_VERSION
	);

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts' , 'hatch_scripts' );