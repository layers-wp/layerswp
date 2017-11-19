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

define( 'LAYERS_VERSION', '2.0.7' );
define( 'LAYERS_TEMPLATE_URI' , get_template_directory_uri() );
define( 'LAYERS_TEMPLATE_DIR' , get_template_directory() );
define( 'LAYERS_THEME_TITLE' , 'Layers' );
define( 'LAYERS_THEME_SLUG' , 'layers' );
define( 'LAYERS_BUILDER_TEMPLATE' , 'builder.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 1080; /* pixels */

/**
 * Adjust the content width when the full width page template is being used
 */
function layers_set_content_width() {
	global $content_width;

	$left_sidebar_active = layers_can_show_sidebar( 'left-sidebar' );
	$right_sidebar_active = layers_can_show_sidebar( 'right-sidebar' );

	if( is_page_template( LAYERS_BUILDER_TEMPLATE ) ) {
		$content_width = 1080;
	} else if( is_page_template( 'template-both-sidebar.php' ) ||
		is_page_template( 'template-left-sidebar.php' ) ||
		is_page_template( 'template-right-sidebar.php' ) ){
		$content_width = 660;
	} elseif ( is_page_template( 'template-blog.php' ) ) {
		$content_width = 1080;
	} elseif( $left_sidebar_active || $right_sidebar_active ){
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
 * Load Front-end helpers
 */
require_once get_template_directory() . '/core/helpers/color.php';
require_once get_template_directory() . '/core/helpers/controls.php';
require_once get_template_directory() . '/core/helpers/custom-fonts.php';
require_once get_template_directory() . '/core/helpers/extensions.php';
require_once get_template_directory() . '/core/helpers/post.php';
require_once get_template_directory() . '/core/helpers/post-types.php';
require_once get_template_directory() . '/core/helpers/sanitization.php';
require_once get_template_directory() . '/core/helpers/template.php';
require_once get_template_directory() . '/core/helpers/woocommerce.php';
if( !defined( 'LAYERS_DISABLE_INTERCOM' ) ){
	require_once get_template_directory() . '/core/helpers/intercom.php';
}

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
		 * Add Site Logo Support
		 */

		// Custom Site Logo
		if( !function_exists( 'the_custom_logo' ) ){
			$logo_support = 'site-logo';
		} else {
			$logo_support = 'custom-logo';
		}
		add_theme_support( $logo_support, array(
			'header-text' => array(
				'sitetitle',
				'tagline',
			),
			'flex-width' => true,
			'size' => 'large',
		) );

		// Automatic Feed Links
		add_theme_support( 'automatic-feed-links' );

		// Add support for excerpts in pages
		add_post_type_support( 'page', 'excerpt' );

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

			// Enable Intercom on activation
			if( FALSE === get_option( 'layers_enable_intercom' ) )
				update_option( 'layers_enable_intercom' , '1' );

			update_option( 'layers_welcome' , 1);

			wp_safe_redirect( admin_url('admin.php?page=' . LAYERS_THEME_SLUG . '-get-started'));
		}

		/**
		 * Add support for Partial Widget Refresh.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add theme support for WooCommerce Gallery
		 */
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

	} // function layers_setup
} // if !function layers_setup
add_action( 'after_setup_theme' , 'layers_setup', 100 );

/**
 * Port Widgets between Layers Parent theme and Child themes
 */
function layers_backup_site( $value ){
	$theme = wp_get_theme();

	$widget_data = $value[ 'data' ];
	if( isset( $widget_data[ 'wp_inactive_widgets' ] ) ) unset( $widget_data[ 'wp_inactive_widgets' ] );

	update_option( 'layers_tm_backup', get_theme_mods() );
	update_option( 'layers_wgt_backup', $widget_data );

	layers_backup_sidebars_widgets();
}
add_action( 'pre_set_theme_mod_sidebars_widgets' , 'layers_backup_site' );

function layers_resore_site(){
	global $layers_widgets;

	$theme = wp_get_theme();
	$layers_tm_backup = get_option( 'layers_tm_backup' );
	$layers_wgt_backup = get_option( 'layers_wgt_backup' );

	if( $layers_tm_backup ) {
		update_option( 'theme_mods_' . $theme->stylesheet, $layers_tm_backup );
		delete_option ( 'layers_tm_backup' );
	}

	// If the last theme was activated via the themes.php screen, use that backup
	if( $layers_wgt_backup ) {
		update_option( 'sidebars_widgets', $layers_wgt_backup );
		delete_option ( 'layers_wgt_backup' );

	// If a user used the customizer to preview the last theme before activating, look for widgets having been backed up via the theme_mods
	} elseif( get_theme_mod( 'sidebars_widgets' ) ){
		$layers_wgt_backup = get_theme_mod( 'sidebars_widgets' );
		if( isset( $layers_wgt_backup[ 'data' ] ) ) {
			update_option( 'sidebars_widgets', $layers_wgt_backup );
			remove_theme_mod( 'sidebars_widgets' );
		}
	}

}
add_action( 'after_switch_theme' , 'layers_resore_site', 50 );


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
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</aside>',
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
}
add_action( 'widgets_init' , 'layers_register_standard_sidebars' , 50 );

/**
*  Enqueue front end styles and scripts
*/
if( ! function_exists( 'layers_scripts' ) ) {
	function layers_scripts(){

		/**
		* Front end Scripts
		*/

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-plugins' ,
			get_template_directory_uri() . '/assets/js/plugins.js',
			array(
				'jquery',
			),
			LAYERS_VERSION
		); // Sticky-Kit

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-framework' ,
			get_template_directory_uri() . '/assets/js/layers.framework.js',
			array(
				'jquery',
			),
			LAYERS_VERSION
		); // Framework

		wp_localize_script( LAYERS_THEME_SLUG . '-framework', 'layers_script_settings', array(
			'header_sticky_breakpoint' => apply_filters( 'layers_sticky_header_breakpoint', 270 ),
		) );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		} // Comment reply script

		// Google Maps
		wp_register_script(
			LAYERS_THEME_SLUG . '-map-api',
			'//maps.googleapis.com/maps/api/js?key=' . layers_get_theme_mod( 'google-maps-api' )
		);
		wp_register_script(
			LAYERS_THEME_SLUG . '-map-trigger',
			get_template_directory_uri().'/core/widgets/js/maps.js',
			array( 'jquery' ),
			LAYERS_VERSION
		);

		/**
		* Front end Styles
		*/

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-framework' ,
			get_template_directory_uri() . '/assets/css/framework.css',
			array() ,
			LAYERS_VERSION
		);
		wp_style_add_data( 
			LAYERS_THEME_SLUG . '-framework' ,
			'rtl', 
			'replace' 
		); // Framework RTL

		// Commenting for now as we need to do add animation only to layers-pro
//        wp_enqueue_style(
//            LAYERS_THEME_SLUG . '-animate',
//            get_template_directory_uri() . '/assets/css/animate.css',
//            array(),
//            LAYERS_VERSION
//        ); // Animations

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-components',
			get_template_directory_uri() . '/assets/css/components.css',
			array(),
			LAYERS_VERSION
		); // Components

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-responsive',
			get_template_directory_uri() . '/assets/css/responsive.css',
			array(),
			LAYERS_VERSION
		); // Responsive
		wp_style_add_data( 
			LAYERS_THEME_SLUG . '-responsive',
			'rtl', 
			'replace' 
		); // Responsive RTL

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-icon-fonts',
			get_template_directory_uri() . '/assets/css/layers-icons.css',
			array(),
			LAYERS_VERSION
		); // Icon Font

		if( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-woocommerce',
				get_template_directory_uri() . '/assets/css/woocommerce.css',
				array(),
				LAYERS_VERSION
			); // Woocommerce
			wp_style_add_data( 
				LAYERS_THEME_SLUG . '-woocommerce',
				'rtl', 
				'replace' 
			); // Woocommerce RTL
		}

		if( is_admin_bar_showing() ) {
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-admin',
				get_template_directory_uri() . '/core/assets/icons.css',
				array(),
				LAYERS_VERSION
			); // Admin CSS
		}

		wp_register_style(
			LAYERS_THEME_SLUG . '-font-awesome',
			get_template_directory_uri() . '/core/assets/plugins/font-awesome/font-awesome.min.css',
			array(),
			LAYERS_VERSION
		); // Font Awesome


		// Swiper Slider
		wp_register_script(
			LAYERS_THEME_SLUG . '-slider-js',
			get_template_directory_uri() . '/core/widgets/js/swiper.js',
			array( 'jquery' ),
			LAYERS_VERSION
		);
		wp_register_style(
			LAYERS_THEME_SLUG . '-slider',
			get_template_directory_uri() . '/core/widgets/css/swiper.css',
			array(),
			LAYERS_VERSION
		);

		// Layers Masonry.
		wp_register_script(
			LAYERS_THEME_SLUG . '-layers-masonry-js',
			get_template_directory_uri() . '/assets/js/layers.masonry.js',
			array(
				'jquery',
				'masonry', // Wordpress Masonry
			),
			LAYERS_VERSION
		);

	}
}
add_action( 'wp_enqueue_scripts' , 'layers_scripts' );

/**
*  Enqueue Layers stylesheet last
*/
if( ! function_exists( 'layers_stylesheet' ) ) {
	function layers_stylesheet(){
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-style' ,
			get_stylesheet_uri(),
			array() ,
			LAYERS_VERSION
		);

		do_action( 'layers_enqueue_stylesheet' );
	}
}
add_action( 'wp_enqueue_scripts' , 'layers_stylesheet', 100 );
/**
*  Enqueue admin end styles and scripts
*/
if( ! function_exists( 'layers_admin_scripts' ) ) {
	function layers_admin_scripts(){
		global $pagenow, $wp_customize;

		/**
		 * Tip-Tip (renamed to layerTip )
		 */
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-tip-tip' ,
			get_template_directory_uri() . '/core/assets/plugins/tip-tip/jquery.tipTip.css',
			array(),
			LAYERS_VERSION
		);
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-tip-tip' ,
			get_template_directory_uri() . '/core/assets/plugins/tip-tip/jquery.tipTip.js',
			array( 'jquery' ),
			LAYERS_VERSION,
			true
		);

		/**
		 * LayersSlct2 (also enqueued by Storekit and WooCommerce).
		 */
		wp_enqueue_style(
			LAYERS_THEME_SLUG . 'select-2',
			get_template_directory_uri() . '/core/assets/plugins/select2/select-2.css',
			array(),
			LAYERS_VERSION
		);
		wp_enqueue_style(
			LAYERS_THEME_SLUG . 'select-2-skins',
			get_template_directory_uri() . '/core/assets/plugins/select2/select-2-skins.css',
			array(),
			LAYERS_VERSION
		);
		wp_enqueue_script(
			LAYERS_THEME_SLUG . 'select-2',
			get_template_directory_uri() . '/core/assets/plugins/select2/select-2.js',
			array( 'jquery' ),
			LAYERS_VERSION
		);

		/**
		 * FontAwesome
		 */
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin-font-awesome',
			get_template_directory_uri() . '/core/assets/plugins/font-awesome/font-awesome.min.css',
			array(),
			LAYERS_VERSION
		);


		/**
		 * Main Admin CSS's
		 */
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-global',
			get_template_directory_uri() . '/core/assets/layers-global.css',
			array(),
			LAYERS_VERSION
		);

		if ( isset( $wp_customize ) ) {

			/**
			 * Admin Customizer (only)
			 */
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-customizer',
				get_template_directory_uri() . '/core/assets/layers-customizer.css',
				array(),
				LAYERS_VERSION
			);
			wp_style_add_data( 
				LAYERS_THEME_SLUG . '-customizer',
				'rtl', 
				'replace' 
			);
		}
		else {

			/**
			 * Admin Dashboard (only)
			 */
			wp_enqueue_style(
				LAYERS_THEME_SLUG . '-admin',
				get_template_directory_uri() . '/core/assets/layers-admin.css',
				array(),
				LAYERS_VERSION
			);
			wp_style_add_data( 
				LAYERS_THEME_SLUG . '-admin',
				'rtl', 
				'replace' 
			);

		}


		/**
		 * Admin Editor
		 */
		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin-editor',
			get_template_directory_uri() . '/core/assets/plugins/froala/editor.css',
			array(),
			LAYERS_VERSION
		);
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-editor' ,
			get_template_directory_uri() . '/core/assets/plugins/froala/editor.min.js' ,
			array( 'jquery' ),
			LAYERS_VERSION,
			true
		);


		/**
		 * Admin Migrator
		 */
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
			'migratori18n',
			array(
				'loading_message' => __( 'Be patient while we import the widget data and images.' , 'layerswp' ),
				'complete_message' => __( 'Import Complete' , 'layerswp' ),
				'importing_message' => __( 'Importing Your Content' , 'layerswp' ),
				'duplicate_complete_message' => __( 'Edit Your New Page' , 'layerswp' )
			)
		);
		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-migrator',
			"layers_migrator_params",
			array(
					'duplicate_layout_nonce' => wp_create_nonce( 'layers-migrator-duplicate' ),
					'import_layout_nonce' => wp_create_nonce( 'layers-migrator-import' ),
					'preset_layout_nonce' => wp_create_nonce( 'layers-migrator-preset-layouts' ),
				)
		);


		/**
		 * Discover More Photos
		 */
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-media-views' ,
			get_template_directory_uri() . '/core/assets/media-views.js',
			array(
				'media-views'
			),
			LAYERS_VERSION
		);


		/**
		 * Admin Onboarding
		 */
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-onboarding' ,
			get_template_directory_uri() . '/core/assets/onboarding.js',
			array(
					'jquery'
				),
			LAYERS_VERSION,
			true
		);
		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-onboarding' ,
			"layers_onboarding_params",
			array(
				'preset_layout_nonce' => wp_create_nonce( 'layers-migrator-preset-layouts' ),
				'update_option_nonce' => wp_create_nonce( 'layers-onboarding-update-options' ),
				'set_theme_mod_nonce' => wp_create_nonce( 'layers-onboarding-set-theme-mods' ),
			)
		);
		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-onboarding' ,
			'onboardingi18n',
			array(
				'step_saving_message' => __( 'Saving...' , 'layerswp' ),
				'step_done_message' => __( 'Done!' , 'layerswp' )
			)
		);


		/**
		 * Admin JS
		 */
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
		);
		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin' ,
			'layers_admin_params',
			array(
				'backup_pages_nonce' => wp_create_nonce( 'layers-backup-pages' ),
				'backup_pages_success_message' => __('Your pages have been successfully backed up!', 'layerswp' ),
				'nonce_layers_widget_linking' => wp_create_nonce( 'nonce_layers_widget_linking' ),
			)
		);

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
		return str_replace( '<p', '<p class="excerpt"', $excerpt );
	}
} // layers_excerpt_class
add_filter( "the_excerpt", "layers_excerpt_class" );
add_filter( "get_the_excerpt", "layers_excerpt_class" );

function layers_pro_update_notice(){
	if( defined( 'LAYERS_PRO_VER' ) && version_compare( LAYERS_PRO_VER, '2.0.0', '<' ) ){ ?>
		<div class="updated is-dismissible notice">
			<p><?php echo sprintf( 'To make the most of Layers 2, it is recommended that you also update <strong>Layers Pro</strong> to version 2. <a href="%s" target="_blank">Click here</a> to read how you can update. All your settings will be retained.', 'http://docs.layerswp.com/doc/how-to-update-layers-exensions/' ); ?></p>
		</div>
	<?php }
}
add_action( 'admin_notices', 'layers_pro_update_notice' );