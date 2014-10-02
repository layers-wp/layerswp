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
define( 'HATCH_THEME_TITLE' , 'Hatch' );
define( 'HATCH_THEME_SLUG' , 'hatch' );
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
locate_template( '/core/third_party/site-logo/site-logo.php' , true );
locate_template( '/core/third_party/hex-to-rgb.php' , true );

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

/*
 * Load Options Panel
 */
locate_template( '/core/options-panel/init.php' , true );

/*
 * Load Front-end helpers
 */
locate_template( '/core/helpers/post.php' , true );
locate_template( '/core/helpers/template.php' , true );

/*
 * Load Admin-specific files
 */
if( is_admin() ){
	// Include form item class
	locate_template( '/core/helpers/forms.php' , true );

	// Include pointers class
	locate_template( '/core/helpers/pointers.php' , true );
}

if( ! function_exists( 'hatch_setup' ) ) {
	function hatch_setup(){
		global $pagenow;

		/**
		 * Add support for widgets inside the customizer
		 */
		add_theme_support('widget-customizer');

		/**
		 * Add support for featured images
		 */
		add_theme_support( 'post-thumbnails' );

		// Set Large Image Sizes
		add_image_size( 'square-large', 960, 960, true );
		add_image_size( 'portrait-large', 720, 960, true );
		add_image_size( 'landscape-large', 960, 720, true );

		// Set Medium Image Sizes
		add_image_size( 'square-medium', 480, 480, true );
		add_image_size( 'portrait-medium', 360, 480, true );
		add_image_size( 'landscape-medium', 480, 360, true );

		/**
		 * Add theme support
		 */

		// Custom Site Logo
		add_theme_support( 'site-logo', array(
			'header-text' => array(
				'sitetitle',
				'tagline',
			),
			'size' => 'medium',
		) );

		// Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );

		/**
		 * This theme uses wp_nav_menu() in one location.
		 */
		register_nav_menus( array(
			HATCH_THEME_SLUG . '-secondary-left' => __( 'Top Left Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-secondary-right' => __( 'Top Right Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-primary' => __( 'Primary Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-footer' => __( 'Footer Menu', HATCH_THEME_SLUG ),

		) );

		/**
		 * Add support for Jetpack Portfolio
		 */
		add_theme_support( 'jetpack-portfolio' );

		/**
		 * Register Standard Sidebar
		  */
		register_sidebar( array(
			'id'		=> HATCH_THEME_SLUG . '-sidebar',
			'name'		=> __( ' Sidebar' , HATCH_THEME_SLUG ),
			'description'	=> __( '' , HATCH_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h4>',
		) );

		/**
		 * Register Footer Sidebars
		 */
		for( $footer = 1; $footer < 5; $footer++ ) {
			register_sidebar( array(
				'id'		=> HATCH_THEME_SLUG . '-footer-' . $footer,
				'name'		=> __( 'Footer ' . $footer , HATCH_THEME_SLUG ),
				'description'	=> __( '' , HATCH_THEME_SLUG ),
				'before_widget'	=> '<section id="%1$s" class="column span-3 %2$s">',
				'after_widget'	=> '</section>',
				'before_title'	=> '<h5 class="section-nav-title">',
				'after_title'	=> '</h5>',
			) );
		} // for footers

		/**
		* Welcome Redirect
		*/
		if( isset($_GET["activated"]) && $pagenow = "themes.php") {
			update_option( 'hatch_welcome' , 1);
			$find_builder_page = new WP_Query( array( 'post_type' => 'page' , 'meta_key' => '_wp_page_template', 'meta_value' => HATCH_BUILDER_TEMPLATE ) );
			if( false == $find_builder_page->have_posts() ){
				$page['post_type']    = 'page';
				$page['post_title']   = 'Builder Page';
				$pageid = wp_insert_post ($page);
				if ($pageid != 0) {
					update_post_meta( $pageid , '_wp_page_template', HATCH_BUILDER_TEMPLATE );
				}
			}
			wp_redirect(admin_url('admin.php?page=' . HATCH_THEME_SLUG . '-welcome'));
		}

	}
	add_action( 'init' , 'hatch_setup', 10 );
}


/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'hatch_scripts' ) ) {
	function hatch_scripts(){

		/**
		* Front end Scripts
		*/

		wp_enqueue_script(
			HATCH_THEME_SLUG . '-slider-js' ,
			get_template_directory_uri() . '/core/widgets/js/swiper.js',
			array(
				'jquery',
				'masonry'
			)
		); // Slider

		wp_enqueue_script(
			HATCH_THEME_SLUG . '-framework-js' ,
			get_template_directory_uri() . '/js/framework.js',
			array(
				'jquery'
			)
		); // Framework


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		} // Comment reply script

		/**
		* Front end Styles
		*/
		wp_register_style(
			HATCH_THEME_SLUG . '-slider-css',
			get_template_directory_uri() . '/core/widgets/css/swiper.css',
			array(),
			HATCH_VERSION
		); // Slider

		wp_register_style(
			HATCH_THEME_SLUG . '-components-css',
			get_template_directory_uri() . '/css/components.css',
			array(),
			HATCH_VERSION
		); // Compontents

		wp_enqueue_style(
			HATCH_THEME_SLUG . '-style' ,
			get_stylesheet_uri() ,
			array(
				HATCH_THEME_SLUG . '-components-css',
				HATCH_THEME_SLUG . '-slider-css'
			) ,
			HATCH_VERSION
		);
		wp_register_style(
			HATCH_THEME_SLUG . '-slider-css',
			get_template_directory_uri() . '/core/widgets/css/swiper.css',
			array(),
			HATCH_VERSION
		); // Main
	}
}
add_action( 'wp_enqueue_scripts' , 'hatch_scripts' );


/**
*  Enqueue admin end styles and scripts
*/
if( ! function_exists( 'hatch_admin_scripts' ) ) {
	function hatch_admin_scripts(){
		wp_enqueue_style(
			HATCH_THEME_SLUG . '-admin',
			get_template_directory_uri() . '/core/assets/admin.css',
			array(),
			HATCH_VERSION
		); // Admin CSS

		wp_enqueue_style(
			HATCH_THEME_SLUG . '-admin-editor',
			get_template_directory_uri() . '/core/assets/editor.min.css',
			array(),
			HATCH_VERSION
		); // Admin CSS

		wp_enqueue_script(
			HATCH_THEME_SLUG . '-admin-editor' ,
			get_template_directory_uri() . '/core/assets/editor.min.js' ,
			array( 'jquery' ),
			HATCH_VERSION,
			true
		);

		wp_enqueue_script(
			HATCH_THEME_SLUG . '-admin' ,
			get_template_directory_uri() . '/core/assets/admin.js',
			array(
				'jquery',
				'jquery-ui-sortable',
				'wp-color-picker'
			),
			HATCH_VERSION,
			true
		); // Admin JS


	}
}

add_action( 'customize_controls_print_footer_scripts' , 'hatch_admin_scripts' );
add_action( 'admin_enqueue_scripts' , 'hatch_admin_scripts' );

/**
*  Make sure that all excerpts have class="excerpt"
*/
if( !function_exists( 'hatch_excerpt_class' ) ) {
	function hatch_excerpt_class( $excerpt ) {
	    return str_replace('<p', '<p class="excerpt"', $excerpt);
	}
	add_filter( "the_excerpt", "hatch_excerpt_class" );
	add_filter( "get_the_excerpt", "hatch_excerpt_class" );
} // hatch_excerpt_class