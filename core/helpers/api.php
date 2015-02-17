<?php  /**
 * Layers API Class
 *
 * This file is used to run Layers / Obox API Calls
 *
 * @package Layers
 * @since Layers 1.0
 */
class Layers_API {

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

        // Nothing to see here

    }

    /**
    * Give us a list of available extensions
    */
    public function get_extension_list(){

        $extension_list = array(
                'layers-woocommerce' => array(
                        'title' => __( 'WooCommerce for Layers', LAYERS_THEME_SLUG ),
                        'description' => __( 'Adds an advanced product widget, product slider and multiple page layouts.', LAYERS_THEME_SLUG ),
                        'available' => false,
                        'date' => NULL,
                        'price' => NULL,
                    ),
                'layers-showcase' => array(
                        'title' => __( 'Showcase for Layers', LAYERS_THEME_SLUG ),
                        'description' => __( 'List your portfolio items with relevant meta such as client, web url and project role.', LAYERS_THEME_SLUG ),
                        'available' => false,
                        'date' => NULL,
                        'price' => NULL,
                    ),

            );

        return apply_filters( 'layers_extension_list' , $extension_list );
    }

    public function get_theme_info(){

        $this->theme = wp_get_theme( LAYERS_THEME_SLUG );

        // Put together some variables to sort out
        $gitslug = $this->theme->get( 'GitHub Theme URI' );
        $owner_repo = $gitslug;
        $owner_repo = trim( $owner_repo, '/' );
        $owner_repo = explode( '/', $owner_repo );

        $theme[ 'git_slug' ] = $gitslug;
        $theme[ 'owner' ] = $owner_repo[0];
        if( isset( $owner_repo[1] ) ) $theme[ 'repo' ] = $owner_repo[1];
        $theme[ 'name' ] = $this->theme->get( 'Name' );
        $theme[ 'local_version' ] = strtolower( $this->theme->get( 'Version' ) );

        return $theme;

    }
}

if( !function_exists( 'layers_api_init' ) ) {
    // Instantiate API Calls
    function layers_api_init() {
        $layer_updater = new Layers_API();
        $layer_updater->init();
    } // layer_updater_init

    add_action( "after_setup_theme", "layers_api_init", 100 );
}