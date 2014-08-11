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
		global $wp_customize;

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

		// If we are in a builder page, update the Widgets title
		if(
			isset( $_GET[ 'hatch-builder' ] )
			|| ( !isset( $_GET[ 'url' ] ) && 0 != get_option( 'page_on_front' )  && HATCH_BUILDER_TEMPLATE == get_post_meta ( get_option( 'page_on_front' ) , '_wp_page_template' , true ) )
		) {
			$wp_customize->get_panel( 'widgets' )->title = __('Hatch: Page Builder', HATCH_THEME_SLUG );
			$wp_customize->get_panel( 'widgets' )->description = __('Use this area to add widgets to your page, use the (Hatch) widgets for the Body section.', HATCH_THEME_SLUG );
			// @TODO: Get rid of Warning: Creating default object from empty value in /Users/marc/Sites/obox.beta/wp-content/themes/hatch-theme/core/customizer/init.php on line 57
		}

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
add_action( 'customize_register' , 'hatch_customizer_init' , 50 );