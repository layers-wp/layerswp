<?php /**
 * Customizer Default Settings File
 *
 * This file is used to setup the defaults used in the Layers customizer
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer_Defaults {

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

        // Setup prefix to use
        $this->prefix  = LAYERS_THEME_SLUG . '-';

        // Grab the customizer config
        $this->config = new Layers_Customizer_Config();
        foreach( $this->config->controls() as $section_key => $controls ) {

            foreach( $controls as $control_key => $control_data ){

                // Set key to use for the default
                $setting_key = $this->prefix . $control_key;

                // Register default
                $this->register_control_defaults( $setting_key, $control_data[ 'type' ], ( isset( $control_data['default'] ) ? $control_data['default'] : NULL ) );
            }
        }

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

        return apply_filters( 'layers_customizer_defaults', $layers_customizer_defaults );
    }

}

/**
*  Kicking this off with the 'widgets_init' hook
*/
if( !function_exists( 'layers_set_customizer_defaults' ) ) {
    function layers_set_customizer_defaults(){
        $layers_customizer_defaults = new Layers_Customizer_Defaults();
        $layers_customizer_defaults->init();
    }
    add_action( 'customize_register' , 'layers_set_customizer_defaults' , 50 );
    add_action( 'wp' , 'layers_set_customizer_defaults');
} // if !layers_set_customizer_defaults
