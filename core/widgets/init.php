<?php /**
 * Widget Initiation File
 *
 * This file is the source of the Widget functionality in Hatch.
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Widgets {

	private static $instance;

	/**
	*  Initiator
	*/

	public static function init(){
		return self::$instance;
	}

	/**
	*  Constructor
	*/

	public function __construct() {

		// Setup some folder variables
		$widget_dir = HATCH_TEMPLATE_DIR . '/core/widgets/';
		$module_dir = HATCH_TEMPLATE_DIR . '/core/widgets/modules/';

		// Include widget form item class
		require $widget_dir . 'form-elements.php';

		// Include ajax functions
		require $widget_dir . 'ajax.php';

		// Include necessary widgets
		require $module_dir . 'banner.php';
		require $module_dir . 'contact.php';
		require $module_dir . 'framework.php';
		require $module_dir . 'html.php';
		require $module_dir . 'module.php';
		require $module_dir . 'portfolio.php';
		require $module_dir . 'services.php';
		require $module_dir . 'social.php';
		require $module_dir . 'team.php';

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
		add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );

		// Register Sidebars
		$this->register_sidebars();
	}

	/**
	*  Register Sidebars
	*/

	public function register_sidebars(){
		// Fetch Builder Pages
		$pages = get_pages(array(
			'meta_key' => '_wp_page_template',
			'meta_value' => 'builder.php'
		));

		// Loop the Builder Pages and create their sidebars
		foreach($pages as $page){
			register_sidebar( array(
				'id'		=> 'obox-hatch-builder-' . $page->post_name,
				'name'		=> $page->post_title . __( ' Body' , HATCH_THEME_SLUG ),
				'description'	=> __( '' , HATCH_THEME_SLUG ),
				'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
				'after_widget'	=> '</aside>',
				'before_title'	=> '<h4 class="widget-title">',
				'after_title'	=> '</h4>',
			) );
		}
	}

	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){

		// Widget accordians
		wp_register_script(
			HATCH_THEME_SLUG . '-admin-widgets-accordians' ,
			get_template_directory_uri() . '/core/widgets/js/widget-accordians.js' ,
			array(),
			HATCH_VERSION,
			true
		);

		// Banner Widget
		wp_register_script(
			HATCH_THEME_SLUG . '-admin-widgets-banners' ,
			get_template_directory_uri() . '/core/widgets/js/banner.js' ,
			array(),
			HATCH_VERSION,
			true
		);

		// Module Widget
		wp_register_script(
			HATCH_THEME_SLUG . '-admin-widgets-modules' ,
			get_template_directory_uri() . '/core/widgets/js/module.js' ,
			array(),
			HATCH_VERSION,
			true
		);

		// Tiny MCE Initiator
		wp_register_script(
			HATCH_THEME_SLUG . '-admin-widgets-tinymce' ,
			get_template_directory_uri() . '/core/widgets/js/tinymce.js' ,
			array(
				'editor',
				'word-count',
				'quicktags',
				'wplink',
				'wp-fullscreen',
				'media-upload'
			),
			HATCH_VERSION,
			true
		);


		// Contact Widget
		wp_enqueue_script( HATCH_THEME_SLUG . " -map-api","http://maps.googleapis.com/maps/api/js?sensor=false");
		wp_register_script(
			HATCH_THEME_SLUG . '-admin-widgets-maps' ,
			get_template_directory_uri() . '/core/widgets/js/maps.js' ,
			array(),
			HATCH_VERSION,
			true
		);

		// Widget general
		wp_enqueue_script(
			HATCH_THEME_SLUG . '-admin-widgets' ,
			get_template_directory_uri() . '/core/widgets/js/widgets.js' ,
			array(
				HATCH_THEME_SLUG . '-admin-widgets-accordians',
				HATCH_THEME_SLUG . '-admin-widgets-banners',
				HATCH_THEME_SLUG . '-admin-widgets-modules',
				HATCH_THEME_SLUG . '-admin-widgets-maps',
				'backbone',
				'jquery',
				'wp-color-picker'
			),
			HATCH_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script( HATCH_THEME_SLUG . '-admin-widgets' , "hatch_widget_params", array( 'ajaxurl' => admin_url( "admin-ajax.php" ) , 'nonce' => wp_create_nonce( 'hatch-widget-actions' ) ) );
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){

		// Widget styles
		wp_register_style(
			HATCH_THEME_SLUG . '-admin-widgets',
			get_template_directory_uri() . '/core/widgets/css/widgets.css',
			array(),
			HATCH_VERSION
		);
		wp_enqueue_style( HATCH_THEME_SLUG . '-admin-widgets' );

		// Color Picker styles
		wp_enqueue_style( 'wp-color-picker' );
	}
}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function hatch_widgets_init(){
	$hatch_widget = new Hatch_Widgets();
	$hatch_widget->init();
}
add_action( 'widgets_init' , 'hatch_widgets_init' , 10 );