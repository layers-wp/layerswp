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

        // $this->get_theme_info();

        // Remove theme's reliance on the WordPress updater
        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'remove_org_reliance' ) );
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

    public function remove_org_reliance( $theme_data ) {

        $theme_info = $this->get_theme_info();

        unset( $theme_data->response[ 'layers' ] );
        unset( $theme_data->checked[ 'layers' ] );

        return $theme_data;
    } // remove_org_reliance
}

if( !function_exists( 'layers_api_init' ) ) {
    // Instantiate API Calls
    function layers_api_init() {
        $layer_updater = new Layers_API();
        $layer_updater->init();
    } // layer_updater_init

    add_action( "after_setup_theme", "layers_api_init", 100 );
}