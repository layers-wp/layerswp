<?php  /**
 * Layers API Class
 *
 * This file is used to run Layers / Obox API Calls
 *
 * @package Layers
 * @since Layers 1.0.0
 */
class Layers_API {

	private static $instance;

	private static $type;

	public $sort_options;

	const ENVATO_API_URL = 'https://api.envato.com/v1/';

	/**
	*  Initiator
	*/

	public static function get_instance(){
		if ( ! isset( self::$instance ) ) {
			  self::$instance = new Layers_API();
		}
		return self::$instance;
	}

	/**
	*  Constructor
	*/

	public function __construct() {

		// hook add_query_vars function into query_vars
		add_filter('query_vars', array( $this, 'add_query_vars' ) );

	}

	function add_query_vars($vars) {
		$vars[] = "type";
		return $vars;
	}

	public function get_auth_token( $method = 'basic' ){
		if( 'basic' == $method ) {
			$token = 'LNjwlQxdcf95fzYWXYF8XqNlnUrofwDU';
		}
		return $token;
	}

	public function get_sort_options(){

		$this->sort_options = array(
			'updated-desc' => array(
				'label' => __( 'Last Updated' , 'layerswp' ),
				'excerpt-label' => __( 'by last updated' , 'layerswp' ),
			),
			'id-desc' => array(
				'label' => __( 'Newest to Oldest' , 'layerswp' ),
				'excerpt-label' => __( 'by release date' , 'layerswp' ),
			),
			'name-asc' => array(
				'label' => __( 'Item Name A - Z' , 'layerswp' ),
				'excerpt-label' => __( 'alphabetically' , 'layerswp' ),
			),
			'sales-desc' => array(
				'label' => __( 'Best Sellers' , 'layerswp' ),
				'excerpt-label' => __( 'by highest sales' , 'layerswp' ),
			),
			'rating-desc' => array(
				'label' => __( 'Best Rated' , 'layerswp' ),
				'excerpt-label' => __( 'by highest rating' , 'layerswp' ),
			),
			'price-asc' => array(
				'label' => __( 'Price: Low to Ligh' ),
				'excerpt-label' => __( 'by least expensive' ),
			),
			'price-desc' => array(
				'label' => __( 'Price: High to Low' ),
				'excerpt-label' => __( 'by most expensive' ),
			),
			'trending-desc' => array(
				'label' => __( 'Trending Items' , 'layerswp' ),
				'excerpt-label' => __( 'by trending' ),
			),
		);

		return $this->sort_options;
	}

	private function do_envato_api_call( $endpoint = 'market/total-items.json', $query_string = NULL , $method = 'get', $timeout = 5 ){

		$default_query_string = 'page_size=100&sort_by=updated&sort_direction=desc';

		$query_string = ( $query_string ? '?' . $query_string . '&' . $default_query_string : '?' . $default_query_string );

		// Set the remote URL
		$remote_url = self::ENVATO_API_URL . $endpoint . $query_string;

		// Set the query transient key
		$cache_key = 'lmp_' . $query_string;

		// Quick cache dumper
		$dump_cache = 0;
		if( 1 == $dump_cache ) delete_transient( $cache_key );

		// Return a cached version of the query if we have one
		if( FALSE !== get_transient( $cache_key ) ) {
			return get_transient( $cache_key );
		}

		// Set the Auth token for our query
		$remote_args = array(
				'timeout' => $timeout,
				'headers' => array(
					'Authorization' => 'Bearer ' . $this->get_auth_token()
				)
			);

		// Choose a method
		if( 'get' == $method ) {
			$remote_query = wp_remote_get( $remote_url, $remote_args );
		} else {
			$remote_query = wp_remote_post( $remote_url, $remote_args );
		}

		if( is_wp_error( $remote_query ) ){

			// If there's an error, we handle it on the front end so just return it
			return $remote_query;

		} else if( isset( $remote_query[ 'response' ][ 'code' ] ) && 200 == $remote_query[ 'response' ][ 'code' ] ) {

			// Cache a successful query
			set_transient( $cache_key , wp_remote_retrieve_body( $remote_query ), 60 );

			return wp_remote_retrieve_body( $remote_query );
		} else {

			// If the response code isn't right, throw an error
			return new WP_Error( __( 'Error' , 'layerswp' ) , __( 'Something broke and we can\'t load the stream' , 'layerswp' ) );
		}
	}

	/**
	* Give us a list of available extensions
	*/
	public function get_stylekit_list(){
		// Set the right end point to use
		$endpoint = 'discovery/search/search/item';

		// Specify a query string here we tell the API what search parameters to use
		$query_string = 'site=codecanyon.net&category=skins/layers-wp-style-kits';

		// Do the API call
		$api_call = $this->do_envato_api_call( $endpoint, $query_string, 'get' );

		if( is_wp_error( $api_call ) ) {

			// Return an error if we have one
			return $api_call;
		} else {

			// If the call is successful, well then send back decoded JSON
			return json_decode( $api_call );
		}
	}

	public function get_theme_list(){
		$endpoint = 'discovery/search/search/item';

		// Specify a query string here we tell the API what search parameters to use
		$query_string = 'site=themeforest.net&compatible_with=Layers%20WP';

		// Do the API call
		$api_call = $this->do_envato_api_call( $endpoint, $query_string, 'get' );

		if( is_wp_error( $api_call ) ) {

			// Return an error if we have one
			return $api_call;
		} else {

			// If the call is successful, well then send back decoded JSON
			return json_decode( $api_call );
		}
	}

	/**
	* Give us a list of available extensions
	*/
	public function get_extension_list(){
		$endpoint = 'discovery/search/search/item';

		// Specify a query string here we tell the API what search parameters to use
		$query_string = 'site=codecanyon.net&compatible_with=Layers%20WP';

		// Do the API call
		$api_call = $this->do_envato_api_call( $endpoint, $query_string, 'get' );

		if( is_wp_error( $api_call ) ) {

			// Return an error if we have one
			return $api_call;
		} else {

			// If the call is successful, well then send back decoded JSON
			return json_decode( $api_call );
		}
	}
	public function get_popular( $site = 'themeforest' ){
		$endpoint = 'market/popular:' . $site . '.json';

		// Do the API call
		$api_call = $this->do_envato_api_call( $endpoint, '', 'get', 2 );

		if( is_wp_error( $api_call ) ) {

			// Return an error if we have one
			return $api_call;
		} else {

			// If the call is successful, well then send back decoded JSON
			return json_decode( $api_call );
		}

	}
}