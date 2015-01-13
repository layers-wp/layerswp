<?php  /**
 * Layers API Class
 *
 * This file is used to run Layers / Obox API Calls
 *
 * @package Layers
 * @since Layers 1.0
 */
class Layers_API {


    const LAYERS_API_REMOTE_URL = 'vagrant.localhost/api/v1';

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
    }

    /**
    *  Obox API Call
    */

    private function _do_api_call( $endpoint = 'verify', $apikey = NULL, $return_array = true ) {

        $api_param = ( NULL != '?apikey=' . $apikey ? $apikey : '' );

        $api_call = wp_remote_get(
            'http://' . self::LAYERS_API_REMOTE_URL . '/' . $endpoint . $api_param,
            array(
                    'timeout' => 60,
                    'httpversion' => '1.1'
                )
        );

        if( is_wp_error( $api_call ) ) return NULL;

        $body_as_array = json_decode( $api_call['body'], $return_array );

        return $body_as_array;
    }
}