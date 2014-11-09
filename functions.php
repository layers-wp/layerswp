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
locate_template( '/core/helpers/woocommerce.php' , true );

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

	// Include widget export/import class
	locate_template( '/core/widgets/migrator.php' , true );
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
		 * Register nav menus
		 */
		register_nav_menus( array(
			HATCH_THEME_SLUG . '-secondary-left' => __( 'Top Left Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-secondary-right' => __( 'Top Right Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-primary' => __( 'Header Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-primary-right' => __( 'Right Header Menu', HATCH_THEME_SLUG ),
			HATCH_THEME_SLUG . '-footer' => __( 'Footer Menu', HATCH_THEME_SLUG ),

		) );

		/**
		 * Add support for Jetpack Portfolio
		 */
		add_theme_support( 'jetpack-portfolio' );


		/**
		* Welcome Redirect
		*/
		if( isset($_GET["activated"]) && $pagenow = "themes.php") {
			update_option( 'hatch_welcome' , 1);
			$find_builder_page = new WP_Query( array( 'post_type' => 'page' , 'meta_key' => '_wp_page_template', 'meta_value' => HATCH_BUILDER_TEMPLATE ) );
			if( false == $find_builder_page->have_posts() ){
				$page['post_type']    = 'page';
				$page['post_status']  = 'publish';
				$page['post_title']   = 'Builder Page';
				$pageid = wp_insert_post ($page);
				if ($pageid != 0) {
					update_post_meta( $pageid , '_wp_page_template', HATCH_BUILDER_TEMPLATE );
				}
			}
			wp_redirect(admin_url('admin.php?page=' . HATCH_THEME_SLUG . '-welcome'));
		}

	} // function hatch_setup
	add_action( 'after_setup_theme' , 'hatch_setup', 10 );
} // if !function hatch_setup

/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'hatch_register_standard_sidebars' ) ) {
	function hatch_register_standard_sidebars(){
		/**
		 * Register Standard Sidebars
		 */
		register_sidebar( array(
			'id'		=> HATCH_THEME_SLUG . '-off-canvas-sidebar',
			'name'		=> __( 'Pop Out Sidebar' , HATCH_THEME_SLUG ),
			'description'	=> __( '' , HATCH_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> HATCH_THEME_SLUG . '-left-sidebar',
			'name'		=> __( 'Left Sidebar' , HATCH_THEME_SLUG ),
			'description'	=> __( '' , HATCH_THEME_SLUG ),
			'before_widget'	=> '<aside id="%1$s" class="content well push-bottom widget %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<h5 class="section-nav-title">',
			'after_title'	=> '</h5>',
		) );

		register_sidebar( array(
			'id'		=> HATCH_THEME_SLUG . '-right-sidebar',
			'name'		=> __( 'Right Sidebar' , HATCH_THEME_SLUG ),
			'description'	=> __( '' , HATCH_THEME_SLUG ),
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
				'id'		=> HATCH_THEME_SLUG . '-footer-' . $footer,
				'name'		=> __( 'Footer ' . $footer , HATCH_THEME_SLUG ),
				'description'	=> __( '' , HATCH_THEME_SLUG ),
				'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</section>',
				'before_title'	=> '<h5 class="section-nav-title">',
				'after_title'	=> '</h5>',
			) );
		} // for footers
	}
	add_action( 'widgets_init' , 'hatch_register_standard_sidebars' , 50 );
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
			HATCH_THEME_SLUG . '-isotope-js' ,
			get_template_directory_uri() . '/js/isotope.js',
			array(
				'jquery',
			)
		); // Isotope

		wp_enqueue_script(
			HATCH_THEME_SLUG . '-hatch-masonry-js' ,
			get_template_directory_uri() . '/js/hatch.masonry.js',
			array(
				'jquery'
			)
		); // Hatch Masonry Function


		wp_enqueue_script(
			HATCH_THEME_SLUG . '-framework-js' ,
			get_template_directory_uri() . '/js/hatch.framework.js',
			array(
				'jquery',
			),
			HATCH_VERSION,
			true
		); // Framework


		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		} // Comment reply script

		/**
		* Front end Styles
		*/
		wp_register_style(
			HATCH_THEME_SLUG . '-slider',
			get_template_directory_uri() . '/core/widgets/css/swiper.css',
			array(),
			HATCH_VERSION
		); // Slider

		wp_register_style(
			HATCH_THEME_SLUG . '-components',
			get_template_directory_uri() . '/css/components.css',
			array(),
			HATCH_VERSION
		); // Compontents

		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( HATCH_THEME_SLUG . '-roboto-font', $protocol . '://fonts.googleapis.com/css?family=Roboto:400,400italic,500,700,700italic,900' );
		wp_enqueue_style( HATCH_THEME_SLUG . '-open-sans-font', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' );

		wp_enqueue_style(
			HATCH_THEME_SLUG . '-style' ,
			get_stylesheet_uri() ,
			array(
				HATCH_THEME_SLUG . '-components',
				HATCH_THEME_SLUG . '-slider',
			) ,
			HATCH_VERSION
		);
		wp_enqueue_style(
			HATCH_THEME_SLUG . '-responsive',
			get_template_directory_uri() . '/css/responsive.css',
			array(),
			HATCH_VERSION
		); // Responsive

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

/**
*  Adjust the site title for static front pages
*/
if( !function_exists( 'hatch_site_title' ) ) {
	function hatch_site_title( $title ) {
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
	add_filter( "wp_title", "hatch_site_title" );
} // hatch_site_title