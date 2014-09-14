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
		$customizer_dir = '/core/customizer/';
		$controls_dir = '/core/customizer/controls/';

		// Include widget control classes
		locate_template( $controls_dir . 'checkbox.php' , true );
		locate_template( $controls_dir . 'color.php' , true );
		locate_template( $controls_dir . 'image.php' , true );
		locate_template( $controls_dir . 'multi-check.php' , true );
		locate_template( $controls_dir . 'number.php' , true );
		locate_template( $controls_dir . 'radio.php' , true );
		locate_template( $controls_dir . 'select.php' , true );
		locate_template( $controls_dir . 'slider_ui.php' , true );
		locate_template( $controls_dir . 'text.php' , true );
		locate_template( $controls_dir . 'textarea.php' , true );
		locate_template( $controls_dir . 'upload.php' , true );

		// Include Config file(s)
		locate_template( $customizer_dir . 'config.php' , true );

		// Include The Panel and Section Registration Class
		locate_template( $customizer_dir . 'registration.php' , true );

		// If we are in a builder page, update the Widgets title
		if(
			isset( $_GET[ 'hatch-builder' ] )
			|| ( !isset( $_GET[ 'url' ] ) && 0 != get_option( 'page_on_front' )  && HATCH_BUILDER_TEMPLATE == get_post_meta ( get_option( 'page_on_front' ) , '_wp_page_template' , true ) )
		) {
			$wp_customize->add_panel(
				'widgets', array(
					'priority' => 10,
					'title' => __('Hatch: Page Builder', HATCH_THEME_SLUG ),
					'description' => __('Use this area to add widgets to your page, use the (Hatch) widgets for the Body section.', HATCH_THEME_SLUG )
				)
			);
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
		wp_localize_script( HATCH_THEME_SLUG . '-admin-customizer' , "hatch_customizer_params", array(
															'ajaxurl' => admin_url( "admin-ajax.php" ) ,
															'nonce' => wp_create_nonce( 'hatch-customizer-actions' ),
															'builder_page' => ( isset( $_GET[ 'hatch-builder' ] ) ? TRUE : FALSE )
														) );
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