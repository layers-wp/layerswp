<?php  /**
 * Layers API Class
 *
 * This file is used to run Layers / Obox API Calls
 *
 * @package Layers
 * @since Layers 1.0
 */
class Layers_API {


    const LAYERS_UPDATER_REMOTE_URL = 'vagrant.localhost/api/v1';

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

        // Add the administrator menu
        add_action( 'admin_menu' , array( $this, 'add_menu' ) , 70 );

        // Save API key
        add_action( 'init' , array( $this, 'save_api_key' ) );

        // Theme and Plugin Update Checkers
        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'transient_theme_updates' ) );
        add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'transient_plugin_updates' ) );

    }

    /**
    *  Add Updater Menu
    */

    public function add_menu(){

        // Backup Page
        add_submenu_page(
            LAYERS_THEME_SLUG . '-welcome',
            __( 'Update' , LAYERS_THEME_SLUG ),
            __( 'Update' , LAYERS_THEME_SLUG ),
            'manage_options',
            LAYERS_THEME_SLUG . '-register',
            'layers_options_panel_ui'
        );
    }

    /**
    *  Obox API Call
    */

    private function _do_api_call( $endpoint = 'verify', $apikey = NULL, $return_array = true ) {

        $updates = wp_remote_get(
            'http://' . self::LAYERS_UPDATER_REMOTE_URL . '/' . $endpoint . '?apikey=' . $apikey, //',
            array(
                'timeout' => 60,
                'httpversion' => '1.1'
                )
        );

        if( is_wp_error( $updates ) ) return NULL;

        $body_as_array = json_decode( $updates['body'], $return_array );

        return $body_as_array;
    }

    /**
    * Get Obox API key
    */

    private function _get_api_key(){

        global $layers_api_key;

        if( !isset( $layers_api_key ) ){
            $layers_api_key = get_option( 'layers_api_key' );
        }

        return $layers_api_key;
    }

    /**
    * Fetch available updates
    */

    private function _get_available_updates( $type = 'themes' ){

        // Get data
        $response = $this->_do_api_call( 'updates', $this->_get_api_key(), true );

        // If the response is not successful do nothing, just return; @TODO: Add a messaging system hook in
        if( NULL == $response ) return;

        // For themes return an array, for plugins return a StdObject
        if( 'themes' == $type ) {
            return json_decode( json_encode( $response['data'] ), true );
        } else {
            return json_decode( json_encode( $response['data'] ) );
        }
    }

    /**
    *  API key Saving
    */
    public function save_api_key(){

        if( isset( $_REQUEST[ '_wpnonce_layers_api_key' ] ) ){

            // Get the posted API key
            $apikey = $_POST[ 'layers_obox_api_key' ];

            // Get data
            $apicheck = $this->_do_api_call( 'verify', $apikey, true );

            if( false == $apicheck[ 'success' ] ){
                global $layers_regsiter_message;
                $layers_regsiter_message = $apicheck[ 'message' ];
                return;
            }

            if( ! wp_verify_nonce( $_REQUEST[ '_wpnonce_layers_api_key' ], 'layers_save_api_key' ) ) return;

            update_option( 'layers_api_key' , $apikey );
        }
    }

    /**
    *  Add available Theme Updates to the theme_updates transient
    */

    public function transient_theme_updates( $theme_data ) {
        // Get an array of existing themes
        $existing_themes = wp_get_themes();

        // Update API Data
        $data = $this->_get_available_updates();


        // Loop over plugins looking for the latest version
        if ( isset( $data[ 'themes' ] ) ) {

            foreach ( $data[ 'themes' ] AS $key => $t ) {

                // Be sure that we have this theme installed
                if( !array_key_exists( $key, $existing_themes ) ) continue;

                $theme_data->response[ $t['template'] ] = $t[ 'update' ];
            }
        }

        return $theme_data;
    } // transient_theme_updates

    /**
    * Get plugin slug as {plugin-folder}/{hook-file}
    */

    public function get_plugin_slug( $available_plugins, $plugin_slug_to_find ){

        foreach( $available_plugins as $slug => $details ){
            $plugin = explode( '/', $slug );
            $base = $plugin[0];
            if( !isset( $plugin[1] ) ) {
                $plugin_slug = $file;
                break;
            } else {
                $file = $plugin[1];

                if( $base == $plugin_slug_to_find ) {
                    $plugin_slug = $base . '/' . $file;
                    break;
                }
            }
        }

        return $plugin_slug;
    }

    /**
    *  Add available Plugin Updates to the plugin_updates transient
    */

   public function transient_plugin_updates( $plugin_data ) {

        // Check if we've already done this check
        if ( empty( $plugin_data->checked ) ) {
            //return $plugin_data;
        }
        // Update API Data
        $data = $this->_get_available_updates( 'plugins' );

        // Get all available plugins
        $available_plugins = get_plugins();

        // Loop over plugins looking for the latest version
        if ( isset( $data->plugins ) ) {

            foreach ( $data->plugins AS $key => $p ) {

                // Get the full plugin slug
                $plugin_slug = $this->get_plugin_slug( $available_plugins, $p->slug );

                // Make sure that we have this plugin installed
                if( !$plugin_slug ) continue;

                $plugin_data->response[ $plugin_slug ]->package = $p->update->package;
                $plugin_data->response[ $plugin_slug ]->new_version = $p->update->new_version;
                $plugin_data->response[ $plugin_slug ]->slug = $p->update->slug;
                $plugin_data->response[ $plugin_slug ]->url = $p->url;
                $plugin_data->response[ $plugin_slug ]->plugin = $plugin_slug;
            }

        }

        return $plugin_data;

    } // transient_theme_updates
}


if( !function_exists( 'layers_api_init' ) ) {
    // Instantiate Plugin
    function layers_api_init() {

        global $layers_updater;

        $layers_updater = new Layers_API();
        $layers_updater->init();

    } // layers_updater_init

    add_action( "after_setup_theme", "layers_api_init", 100 );
}