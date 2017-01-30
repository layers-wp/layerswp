<?php /**
 * Customizer Default Settings File
 *
 * This file is used to setup the defaults used in the Layers customizer
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer_Defaults {

	public $prefix;

	public $config;

	private static $instance; // stores singleton class

    /**
    *  Get Instance creates a singleton class that's cached to stop duplicate instances
    */
    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    /**
    *  Construct empty on purpose
    */

    public function __construct() {}

    /**
    *  Init behaves like, and replaces, construct
    */

    public function init() {

		global $layers_customizer_defaults;

		// Setup prefix to use
		$this->prefix  = LAYERS_THEME_SLUG . '-';


		// Grab the customizer config
		$this->config = Layers_Customizer_Config::get_instance();

		foreach( $this->config->controls as $section_key => $controls ) {

			foreach( $controls as $control_key => $control_data ){

				// Set key to use for the default
				$setting_key = $this->prefix . $control_key;

				// Register default
				$this->register_control_defaults( $setting_key, $control_data[ 'type' ], ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) );
			}
		}

		$layers_customizer_defaults = apply_filters( 'layers_customizer_defaults', $layers_customizer_defaults );
	}

	/**
	* Register Control Defaults
	*/

	public function register_control_defaults( $key = NULL , $type = NULL, $value = NULL ){

		global $layers_customizer_defaults;

		if( !isset( $layers_customizer_defaults ) ) $layers_customizer_defaults = array();

		if( NULL != $key ){
			$layers_customizer_defaults[ $key ] = array(
					'value' => esc_attr( $value ),
					'type' =>$type
				);
		}
	}

}
/**
*  Kicking this off with the 'widgets_init' hook
*/
if( !function_exists( 'layers_set_customizer_defaults' ) ) {
	function layers_set_customizer_defaults(){

		$layers_customizer_defaults = Layers_Customizer_Defaults::get_instance();
	}
}
add_action( 'customize_register' , 'layers_set_customizer_defaults' );
add_action( 'wp', 'layers_set_customizer_defaults');
add_action( 'admin_init', 'layers_set_customizer_defaults');