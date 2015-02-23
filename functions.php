<?php
/**
 * @package Layers
 */

/**
* Add define Layers constants to be used around Layers themes, plugins etc.
*/

/**
 * The current version of the theme. Use a random number for SCRIPT_DEBUG mode
 */
define( 'LAYERS_VERSION', '1.0.3' );
define( 'LAYERS_TEMPLATE_URI' , get_template_directory_uri() );
define( 'LAYERS_TEMPLATE_DIR' , get_template_directory() );
define( 'LAYERS_THEME_TITLE' , 'Layers' );
define( 'LAYERS_THEME_SLUG' , 'layers' );
define( 'LAYERS_BUILDER_TEMPLATE' , 'builder.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 660; /* pixels */


/**
 * Adjust the content width when the full width page template is being used
 */
function layers_set_content_width() {
	global $content_width;

	if ( is_page_template( 'full-width.php' ) ) {
		$content_width = 1080;
	} elseif( is_singular() ) {
		$content_width = 660;
	}
}
add_action( 'template_redirect', 'layers_set_content_width' );

/*
 * Third Party Scripts
 */
require_once get_template_directory() . '/core/third-party/site-logo.php';

/*
 * Load Widgets
 */
require_once get_template_directory() . '/core/widgets/init.php';

/*
 * Load Customizer Support
 */
require_once get_template_directory() . '/core/customizer/init.php';

/*
 * Load Custom Post Meta
 */
require_once get_template_directory() . '/core/meta/init.php';

/*
 * Load Widgets
 */
require_once get_template_directory() . '/core/widgets/init.php';

/*
 * Load Front-end helpers
 */
require_once get_template_directory() . '/core/helpers/custom-fonts.php';
require_once get_template_directory() . '/core/helpers/extensions.php';
require_once get_template_directory() . '/core/helpers/post.php';
require_once get_template_directory() . '/core/helpers/post-types.php';
require_once get_template_directory() . '/core/helpers/template.php';
require_once get_template_directory() . '/core/helpers/woocommerce.php';

/*
 * Load Admin-specific files
 */
if( is_admin() ){
	// Include form item class
	require_once get_template_directory() . '/core/helpers/forms.php';

	// Include design bar class
	require_once get_template_directory() . '/core/helpers/design-bar.php';

	// Include API class
	require_once get_template_directory() . '/core/helpers/api.php';

	// Include widget export/import class
	require_once get_template_directory() . '/core/helpers/migrator.php';

	//Load Options Panel
	require_once get_template_directory() . '/core/options-panel/init.php';

}

if( ! function_exists( 'layers_setup' ) ) {
	function layers_setup(){
		global $pagenow;

		/**
		 * Add support for HTML5
		 */
		add_theme_support('html5');
		/**
		 * Add support for Title Tags
		 */
		add_theme_support('title-tag');

		/**
		 * Add support for widgets inside the customizer
		 */
		add_theme_support('widget-customizer');

		/**
		 * Add support for WooCommerce
		 */
		add_theme_support( 'woocommerce' );

		/**
		 * Add support for featured images
		 */
		add_theme_support( 'post-thumbnails' );

		// Set Large Image Sizes
		add_image_size( 'layers-square-large', 1000, 1000, true );
		add_image_size( 'layers-portrait-large', 720, 1000, true );
		add_image_size( 'layers-landscape-large', 1000, 720, true );

		// Set Medium Image Sizes
		add_image_size( 'layers-square-medium', 480, 480, true );
		add_image_size( 'layers-portrait-medium', 340, 480, true );
		add_image_size( 'layers-landscape-medium', 480, 340, true );

		/**
		 * Add text domain
		 */

		load_theme_textdomain('layerswp', get_template_directory() . '/languages');

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
		 * Register nav menus
		 */
		register_nav_menus( array(
			LAYERS_THEME_SLUG . '-secondary-left' => __( 'Top Left Menu' , 'layerswp' ),
			LAYERS_THEME_SLUG . '-secondary-right' => __( 'Top Right Menu' , 'layerswp' ),
			LAYERS_THEME_SLUG . '-primary' => __( 'Header Menu' , 'layerswp' ),
			LAYERS_THEME_SLUG . '-primary-right' => __( 'Right Header Menu' , 'layerswp' ),
			LAYERS_THEME_SLUG . '-footer' => __( 'Footer Menu' , 'layerswp' ),

		) );

		/**
		* Welcome Redirect
		*/
		if( isset($_GET["activated"]) && $pagenow = "themes.php" ) { //&& '' == get_option( 'layers_welcome' )

			update_option( 'layers_welcome' , 1);

			wp_safe_redirect( admin_url('admin.php?page=' . LAYERS_THEME_SLUG . '-get-started'));
		}

	} // function layers_setup
	add_action( 'after_setup_theme' , 'layers_setup', 10 );
} // if !function layers_setup

/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'layers_register_standard_sidebars' ) ) {
	function layers_register_standard_sidebars(){
		/**
		 * Register Standard Sidebars
		 */
		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-off-canvas-sidebar',
			'name'		=> __( 'Mobile Sidebar' , 'layerswp' ),
			'description'	=> __( 'This sidebar will only appear on mobile devices.' , 'layerswp' ),
			'before_widget'	=> '<aside id="%1$s" class="content widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-left-sidebar',
			'name'		=> __( 'Left Sidebar' , 'layerswp' ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom-large widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-right-sidebar',
			'name'		=> __( 'Right Sidebar' , 'layerswp' ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom-large widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		/**
		 * Register Footer Sidebars
		 */
		for( $footer = 1; $footer < 5; $footer++ ) {
			register_sidebar( array(
				'id'		=> LAYERS_THEME_SLUG . '-footer-' . $footer,
				'name'		=> __( 'Footer ', 'layerswp' ) . $footer,
				'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</section>',
				'before_title'	=> '<h5 class="section-nav-title">',
				'after_title'	=> '</h5>',
			) );
		} // for footers

		/**
		 * Register WooCommerce Sidebars
		 */
		if( class_exists( 'WooCommerce' ) ) {
			register_sidebar( array(
				'id'        => LAYERS_THEME_SLUG . '-left-woocommerce-sidebar',
				'name'      => __( 'Left Shop Sidebar' , 'layerswp' ),
				'description'   => __( '' , 'layerswp' ),
				'before_widget' => '<aside id="%1$s" class="content well push-bottom-large widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h5 class="section-nav-title">',
				'after_title'   => '</h5>',
			) );
			register_sidebar( array(
				'id'        => LAYERS_THEME_SLUG . '-right-woocommerce-sidebar',
				'name'      => __( 'Right Shop Sidebar' , 'layerswp' ),
				'description'   => __( '' , 'layerswp' ),
				'before_widget' => '<aside id="%1$s" class="content well push-bottom-large widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h5 class="section-nav-title">',
				'after_title'   => '</h5>',
			) );
		}
	}
	add_action( 'widgets_init' , 'layers_register_standard_sidebars' , 50 );
}

/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'layers_scripts' ) ) {
	function layers_scripts(){

		/**
		* Front end Scripts
		*/
		if( !is_admin() ) {
			wp_enqueue_script(
				LAYERS_THEME_SLUG . '-plugins-js' ,
				get_template_directory_uri() . '/assets/js/plugins.js',
				array(
					'jquery',
				)
			); // Sticky-Kit

			wp_enqueue_script(
				LAYERS_THEME_SLUG . '-framework-js' ,
				get_template_directory_uri() . '/assets/js/layers.framework.js',
				array(
					'jquery',
				),
				LAYERS_VERSION,
				true
			); // Framework


			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			} // Comment reply script
		}

		/**
		* Front end Styles
		*/

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-framework' ,
			get_template_directory_uri() . '/assets/css/framework.css',
			array() ,
			LAYERS_VERSION
		);

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-typography',
			get_template_directory_uri() . '/assets/css/typography.css',
			array(),
			LAYERS_VERSION
		); // Typography

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-colors',
			get_template_directory_uri() . '/assets/css/colors.css',
			array(),
			LAYERS_VERSION
		); // Colors

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-components',
			get_template_directory_uri() . '/assets/css/components.css',
			array(),
			LAYERS_VERSION
		); // Compontents

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-responsive',
			get_template_directory_uri() . '/assets/css/responsive.css',
			array(),
			LAYERS_VERSION
		); // Responsive

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-icon-fonts',
			get_template_directory_uri() . '/assets/css/layers-icons.css',
			array(),
			LAYERS_VERSION
		); // Icon Font

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-style' ,
			get_stylesheet_uri(),
			array() ,
			LAYERS_VERSION
		);

		if( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-woocommerce',
				get_template_directory_uri() . '/assets/css/woocommerce.css',
				array(),
				LAYERS_VERSION
			); // Woocommerce
		}

		if( is_admin_bar_showing() ) {
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-admin',
				get_template_directory_uri() . '/core/assets/icons.css',
				array(),
				LAYERS_VERSION
			); // Admin CSS
		}

	}
}
add_action( 'wp_enqueue_scripts' , 'layers_scripts' );

/**
*  Enqueue admin end styles and scripts
*/
if( ! function_exists( 'layers_admin_scripts' ) ) {
	function layers_admin_scripts(){
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin',
			get_template_directory_uri() . '/core/assets/admin.css',
			array(),
			LAYERS_VERSION
		); // Admin CSS

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin-editor',
			get_template_directory_uri() . '/core/assets/editor.min.css',
			array(),
			LAYERS_VERSION
		); // Inline Editor

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-editor' ,
			get_template_directory_uri() . '/core/assets/editor.min.js' ,
			array( 'jquery' ),
			LAYERS_VERSION,
			true
		); // Inline Editor

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-migrator' ,
			get_template_directory_uri() . '/core/assets/migrator.js' ,
			array(
				'media-upload'
			),
			LAYERS_VERSION,
			true
		);
		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-migrator',
			'migratori8n',
			array(
				'loading_message' => __( 'Be patient while we import the widget data and images.' , 'layerswp' ),
				'complete_message' => __( 'Import Complete' , 'layerswp' ),
				'importing_message' => __( 'Importing Your Content' , 'layerswp' ),
				'duplicate_complete_message' => __( 'Edit Your New Page' , 'layerswp' )
			)
		);// Migrator

		// Onboarding Process
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-onboarding' ,
			get_template_directory_uri() . '/core/assets/onboarding.js',
			array(
					'jquery'
				),
			LAYERS_VERSION,
			true
		); // Onboarding JS

		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-onboarding' ,
			"layers_onboarding_params",
			array(
				'ajaxurl' => admin_url( "admin-ajax.php" ) ,
				'nonce' => wp_create_nonce( 'layers-onboarding-actions' )
			)
		); // Onboarding ajax parameters

		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-onboarding' ,
			'onboardingi8n',
			array(
				'step_saving_message' => __( 'Saving...' , 'layerswp' ),
				'step_done_message' => __( 'Done!' , 'layerswp' )
			)
		); // Onboarding localization

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin' ,
			get_template_directory_uri() . '/core/assets/admin.js',
			array(
				'jquery',
				'jquery-ui-sortable',
				'wp-color-picker',
			),
			LAYERS_VERSION,
			true
		); // Admin JS

		wp_enqueue_media();

	}
}

add_action( 'customize_controls_print_footer_scripts' , 'layers_admin_scripts' );
add_action( 'admin_enqueue_scripts' , 'layers_admin_scripts' );

/**
*  Make sure that all excerpts have class="excerpt"
*/
if( !function_exists( 'layers_excerpt_class' ) ) {
	function layers_excerpt_class( $excerpt ) {
		return str_replace('<p', '<p class="excerpt"', $excerpt);
	}
	add_filter( "the_excerpt", "layers_excerpt_class" );
	add_filter( "get_the_excerpt", "layers_excerpt_class" );
} // layers_excerpt_class