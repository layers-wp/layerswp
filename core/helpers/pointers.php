<?php /**
 * WP Pointer Class File
 *
 * This file outputs the WP Pointer help popups around the site
 *
 * @package Layers
 * @since Layers 1.0
 */

class Layers_Pointers {

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
		$pointer_dir = '/core/helpers/';

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 10 );
	}

	/**
	*  Config
	*/

	public function config(  $pointers = array() ){

		$pointers = array(
			'accordion-panel-widgets' => array(
					'selector' 	=> '#accordion-panel-widgets',
					'position'	=>  array(
									'edge' => 'left', // bottom / top/ right / left
									'align' => 'right' // left / center / right
								),
					'title'		=> __( 'Build Your Page' , 'layers' ),
					'content'	=> __( 'Use the (' . LAYERS_THEME_TITLE . ') widgets  to build a beautiful, dynamic page.' , 'layers' ),
				),
		);

		return apply_filters( 'layers_pointer_settings', $pointers );
	}

	/**
	*  Enqueue Pointer Scripts & Styles in a single function, as there's not a lot to enqueue
	*/

	public function admin_enqueue_scripts(){

		// Enqueue the pointer styles straight up
		wp_enqueue_style( 'wp-pointer' );

		// Register and enqueue the pointer script
		wp_register_script(
			LAYERS_THEME_SLUG . '-admin-pointers' ,
			get_template_directory_uri() . '/core/helpers/js/layers-pointers.js' ,
			array(
				'wp-pointer'
			),
			LAYERS_VERSION,
			true
		);

		// Get pointers
		$get_pointers = $this->config();

		// If there are no pointers then let's exit this function
		if( empty( $get_pointers ) ) return;

		// Get dismissed pointers
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

		// Set pointer object
		$use_pointers = array();

		// Loop through pointers
		foreach ( $get_pointers as $pointer_index => $pointer_object ){
			if ( ! in_array( $pointer_index , $dismissed ) ) {
				$use_pointers[ $pointer_index ] = $pointer_object;
			}
		};

		wp_enqueue_script( LAYERS_THEME_SLUG . '-admin-pointers' );
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-pointers' , "layers_pointers", $use_pointers );

	}
}


/**
*  Kicking this off with the 'ad' hook
*/

function layers_pointers_init(){
	$layers_pointers = new Layers_Pointers();
	$layers_pointers->init();
}


add_action( 'admin_init' , 'layers_pointers_init' , 50 );