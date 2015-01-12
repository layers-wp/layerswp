<?php
/**
 * @package Layers
 */

$current = get_site_transient( 'update_themes' );
// '<!-- <pre>' . print_r( $current, true ) . '</pre> -->';
/**
* Add define Layers constants to be used around Layers themes, plugins etc.
*/

/**
 * The current version of the theme. Use a random number for SCRIPT_DEBUG mode
 */
if ( defined( 'SCRIPT_DEBUG' ) && TRUE == SCRIPT_DEBUG ) {
	define( 'LAYERS_VERSION', rand( 0 , 100 ) );
} else {
	define( 'LAYERS_VERSION', 'beta-0.1' );
}

define( 'LAYERS_TEMPLATE_URI' , get_template_directory_uri() );
define( 'LAYERS_TEMPLATE_DIR' , get_template_directory() );
define( 'LAYERS_THEME_TITLE' , 'Layers' );
define( 'LAYERS_THEME_SLUG' , 'layers' );
define( 'LAYERS_BUILDER_TEMPLATE' , 'builder.php' );
define( 'OBOX_URL' , 'http://oboxthemes.com');

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
locate_template( '/core/third-party/hex-to-rgb.php' , true );
locate_template( '/core/third-party/site-logo.php' , true );

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
 * Load Widgets
 */
locate_template( '/core/widgets/init.php' , true );

/*
 * Load Front-end helpers
 */
locate_template( '/core/helpers/post.php' , true );
locate_template( '/core/helpers/template.php' , true );
locate_template( '/core/helpers/extensions.php' , true );


/*
 * Load Admin-specific files
 */
if( is_admin() ){
	// Include form item class
	locate_template( '/core/helpers/forms.php' , true );

	// Include design bar class
	locate_template( '/core/helpers/design-bar.php' , true );

	// Include pointers class
	locate_template( '/core/helpers/pointers.php' , true );

	// Include API class
	locate_template( '/core/helpers/api.php' , true );

	// Include widget export/import class
	locate_template( '/core/helpers/migrator.php' , true );

	//Load Options Panel
	locate_template( '/core/options-panel/init.php' , true );

}

if( ! function_exists( 'layers_setup' ) ) {
	function layers_setup(){
		global $pagenow;

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
		add_image_size( 'square-large', 960, 960, true );
		add_image_size( 'portrait-large', 720, 960, true );
		add_image_size( 'landscape-large', 960, 720, true );

		// Set Medium Image Sizes
		add_image_size( 'square-medium', 480, 480, true );
		add_image_size( 'portrait-medium', 340, 480, true );
		add_image_size( 'landscape-medium', 480, 340, true );

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
			LAYERS_THEME_SLUG . '-secondary-left' => __( 'Top Left Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-secondary-right' => __( 'Top Right Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-primary' => __( 'Header Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-primary-right' => __( 'Right Header Menu', LAYERS_THEME_SLUG ),
			LAYERS_THEME_SLUG . '-footer' => __( 'Footer Menu', LAYERS_THEME_SLUG ),

		) );

		/**
		 * Add support for Jetpack Portfolio
		 */
		add_theme_support( 'jetpack-portfolio' );


		/**
		* Welcome Redirect
		*/
		if( isset($_GET["activated"]) && $pagenow = "themes.php") {
			update_option( 'layers_welcome' , 1);

			wp_redirect(admin_url('admin.php?page=' . LAYERS_THEME_SLUG . '-welcome'));
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
			'name'		=> __( 'Pop Out Sidebar' , LAYERS_THEME_SLUG ),
			'description'	=> __( '' , LAYERS_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-left-sidebar',
			'name'		=> __( 'Left Sidebar' , LAYERS_THEME_SLUG ),
			'description'	=> __( '' , LAYERS_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> LAYERS_THEME_SLUG . '-right-sidebar',
			'name'		=> __( 'Right Sidebar' , LAYERS_THEME_SLUG ),
			'description'	=> __( '' , LAYERS_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom widget %2$s">',
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
				'name'		=> __( 'Footer ' . $footer , LAYERS_THEME_SLUG ),
				'description'	=> __( '' , LAYERS_THEME_SLUG ),
				'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</section>',
				'before_title'	=> '<h5 class="section-nav-title">',
				'after_title'	=> '</h5>',
			) );
		} // for footers
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

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-isotope-js' ,
			get_template_directory_uri() . '/assets/js/isotope.js',
			array(
				'jquery',
			)
		); // Isotope

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-layers-masonry-js' ,
			get_template_directory_uri() . '/assets/js/layers.masonry.js',
			array(
				'jquery'
			)
		); // Layers Masonry Function


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

		/**
		* Front end Styles
		*/

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-style' ,
			get_stylesheet_uri() ,
			array() ,
			LAYERS_VERSION
		);

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-colors',
			get_template_directory_uri() . '/assets/css/colors.css',
			array(),
			LAYERS_VERSION
		); // Colors

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-typography',
			get_template_directory_uri() . '/assets/css/typography.css',
			array(),
			LAYERS_VERSION
		); // Typography

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
<<<<<<< HEAD
			HATCH_THEME_SLUG . '-colors',
			get_template_directory_uri() . '/css/colors.css',
			array(),
			HATCH_VERSION
		); // Colors
		wp_enqueue_style(
			HATCH_THEME_SLUG . '-typography',
			get_template_directory_uri() . '/css/typography.css',
			array(),
			HATCH_VERSION
		); // Typography
		wp_enqueue_style(
			HATCH_THEME_SLUG . '-icon-font',
			get_template_directory_uri() . '/css/obox-icons.css',
=======
			LAYERS_THEME_SLUG . '-icon-fonts',
			get_template_directory_uri() . '/assets/css/layers-icons.css',
>>>>>>> c2983a518fb9ef4eb8d1a1d2ebcbd79f2d1374c5
			array(),
			LAYERS_VERSION
		); // Icon Font

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin',
			get_template_directory_uri() . '/core/assets/admin.css',
			array('admin-bar'),
			LAYERS_VERSION
		); // Admin CSS - depending on admin-bar loaded

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
		); // Admin CSS

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-editor' ,
			get_template_directory_uri() . '/core/assets/editor.min.js' ,
			array( 'jquery' ),
			LAYERS_VERSION,
			true
		);

        // Migrator
        wp_enqueue_script(
            LAYERS_THEME_SLUG . '-admin-migrator' ,
            get_template_directory_uri() . '/core/assets/migrator.js' ,
            array(),
            LAYERS_VERSION,
            true
        );

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin' ,
			get_template_directory_uri() . '/core/assets/admin.js',
			array(
				'jquery',
				'jquery-ui-sortable',
				'wp-color-picker'
			),
			LAYERS_VERSION,
			true
		); // Admin JS


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

/**
*  Adjust the site title for static front pages
*/
if( !function_exists( 'layers_site_title' ) ) {
	function layers_site_title( $title ) {
		global $paged, $page;

		if( !isset( $sep ) ) $sep = '|';

		if ( is_feed() )
			return $title;

		// Add the site name.
		$title .= get_bloginfo( 'name' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );

		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

		return $title;
	}
	add_filter( "wp_title", "layers_site_title" );
} // layers_site_title
