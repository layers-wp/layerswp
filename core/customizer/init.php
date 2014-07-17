<?php /**
 * Customizer Initiation File
 *
 * This file is the source of the Customizer functionality in Hatch.
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer {

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
		$customizer_dir = HATCH_TEMPLATE_DIR . '/core/customizer/';
		$controls_dir = HATCH_TEMPLATE_DIR . '/core/customizer/controls/';

		// Include widget control classes
		require $controls_dir . 'checkbox.php';
		require $controls_dir . 'color.php';
		require $controls_dir . 'image.php';
		require $controls_dir . 'multi-check.php';
		require $controls_dir . 'number.php';
		require $controls_dir . 'radio.php';
		require $controls_dir . 'select.php';
		require $controls_dir . 'slider_ui.php';
		require $controls_dir . 'text.php';
		require $controls_dir . 'textarea.php';
		require $controls_dir . 'upload.php';

		// Include Config file(s)
		require $customizer_dir . 'config.php';

		// Include The Panel and Section Registration Class
		require $customizer_dir . 'registration.php';

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
		add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );

	}

	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){

		// Customizer general
		wp_enqueue_script(
			HATCH_THEME_SLUG . '-admin-customizer' ,
			get_template_directory_uri() . '/core/customizer/js/customizer.js' ,
			array(
				'backbone',
				'jquery',
				'wp-color-picker'
			),
			HATCH_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script( HATCH_THEME_SLUG . '-admin-customizer' , "hatch_customizer_params", array( 'ajaxurl' => admin_url( "admin-ajax.php" ) , 'nonce' => wp_create_nonce( 'hatch-customizer-actions' ) ) );
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){

		// Widget styles
		wp_register_style(
			HATCH_THEME_SLUG . '-admin-customizer',
			get_template_directory_uri() . '/core/customizer/css/customizer.css',
			array(),
			HATCH_VERSION
		);
		wp_enqueue_style( HATCH_THEME_SLUG . '-admin-customizer' );
	}
}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function hatch_customizer_init(){
	$hatch_widget = new Hatch_Customizer();
	$hatch_widget->init();
}
add_action( 'customize_register' , 'hatch_customizer_init' , 10 );