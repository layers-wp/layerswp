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
				'label' => __( 'Price: Low to Ligh' , 'layerswp' ),
				'excerpt-label' => __( 'by least expensive' , 'layerswp' ),
			),
			'price-desc' => array(
				'label' => __( 'Price: High to Low' , 'layerswp' ),
				'excerpt-label' => __( 'by most expensive' , 'layerswp' ),
			),
			'trending-desc' => array(
				'label' => __( 'Trending Items' , 'layerswp' ),
				'excerpt-label' => __( 'by trending' , 'layerswp' ),
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

	public function get_product_list( $marketplace = 'layerswp' , $type = 'themes' ){

		if( 'layerswp' == $marketplace ) {
			$product_list = $this->get_layers_list( $type );
		} else {
			$product_list = $this->get_envato_list( $type );
		}

		//die( '<pre>' . print_r( $product_list, true ) . '</pre>' );

		if( is_wp_error( $product_list ) ) return $product_list;

		$response = $this->translate_list( $product_list );

		return json_decode( $response );

	}

	public function translate_list( $product_list = array() ){

		if( empty( $product_list ) ) return;

		$response = array();

		if( isset( $product_list->matches ) ){

			foreach( $product_list->matches as $p_key => $p_details ){

				$product = array();

				if( 'themeforest.net' == $p_details->site ){
					$site_key = 'tf';
				} else {
					$site_key = 'cc';
				}

				$envato_url = 'http://www.layerswp.com/go-envato/?id=' . esc_attr( $p_details->id ) . '&item=' . esc_attr( $p_details->name ). '&site=' . $site_key;

				$categories = explode( '/', $p_details->classification );

				$product[ 'id' ] = (int) $p_details->id;
				$product[ 'url' ] = esc_attr( $envato_url );
				$product[ 'name' ] = esc_attr( $p_details->name );
				$product[ 'description' ] = esc_attr( $p_details->description );
				$product[ 'tags' ] = strtolower( implode( ',', $p_details->tags ) );
				$product[ 'categories' ] = strtolower( implode( ',', $categories ) );
				$product[ 'slug' ] = sanitize_title( $p_details->name );
				$product[ 'updated' ] = strtotime( $p_details->updated_at );
				$product[ 'sales' ] = esc_attr( $p_details->number_of_sales );
				$product[ 'rating' ] = ( $p_details->rating->count > 0 ? ceil( $p_details->rating->rating ) : '' ) ;
				$product[ 'rating_count' ] = $p_details->rating->count;
				$product[ 'author' ] = $p_details->author_username;
				$product[ 'author_image' ] = $p_details->author_image;
				$product[ 'author_url' ] = $p_details->author_url;
				$product[ 'price' ] = (float) ($p_details->price_cents/100);
				$product[ 'trending' ] = ( isset( $p_details->trending ) && '1' == $p_details->trending ? 1 : 0 );
				$product[ 'demo_url' ] = ( isset( $p_details->previews->live_site->url ) ? $p_details->previews->live_site->url : '' );
				$product[ 'allow_demo' ] = FALSE;
				 /**
				* Get images and/or video
				**/
				$previews = $p_details->previews;

				if ( isset( $previews->icon_with_landscape_preview->landscape_url ) && strpos( $previews->icon_with_landscape_preview->landscape_url, '//' ) ) {
					$product[ 'is_img' ] = 1;
					$product[ 'media_src' ] = $previews->icon_with_landscape_preview->landscape_url ;
				} else if ( isset( $previews->icon_with_video_preview->landscape_url ) && strpos( $previews->icon_with_video_preview->landscape_url, '//' ) ) {
					$product[ 'is_img' ] = 1;
           			$product[ 'media_src' ] = $previews->icon_with_video_preview->landscape_url ;
				} else if ( isset( $previews->icon_with_video_preview->video_url ) && strpos( $previews->icon_with_video_preview->video_url, '//' ) ) {
					$product[ 'is_img' ] = 0;
					$product[ 'media_src' ] = $previews->icon_with_video_preview->video_url ;
				}

				$response[] = $product;
			}
		} else {
			foreach( $product_list as $p_key => $p_details ){

				$product = array();

				$utm = '?utm_source=marketplace&utm_medium=link&utm_term=' . $p_details->name . '&utm_campaign=Layers%20Marketplace';

				$demo_utm = '?utm_source=marketplace&utm_medium=preview&utm_term=' . $p_details->name . '&utm_campaign=Layers%20Marketplace%20Preview';

				if( isset( $p_details->sub_title ) && '' != $p_details->sub_title ){
					$p_name = $p_details->name . ' - ' . $p_details->sub_title;
				} else {
					$p_name = $p_details->name;
				}

				$product[ 'id' ] = (int) $p_details->id;
				$product[ 'name' ] = esc_attr( $p_name );
				$product[ 'short_description' ] = $p_details->short_description;
				$product[ 'description' ] = $p_details->description;
				$product[ 'url' ] = esc_attr( $p_details->permalink . $utm );
				$product[ 'slug' ] = sanitize_title( $p_details->slug );
				$product[ 'updated' ] = strtotime( $p_details->date_modified );
				$product[ 'sales' ] = 0;
				$product[ 'author' ] = 'Obox';
				$product[ 'author_image' ] = 'https://0.s3.envato.com/files/86093381/tf-avatar-2.jpg';
				$product[ 'author_url' ] = 'https://layerswp.com/';
				$product[ 'price' ] = (float) ($p_details->price);
				$product[ 'demo_url' ] = ( isset( $p_details->demo_url ) && '' != $p_details->demo_url ? $p_details->demo_url . $demo_utm : '' );
				$product[ 'allow_demo' ] = (bool) ( isset( $p_details->demo_url ) && '' != $p_details->demo_url ? 1 : 0 );
				$product[ 'trending' ] = 0;


				$tags = array();
				foreach( $p_details->tags as $p_tag_key => $p_tag_details ){
					$tags[] = $p_tag_details->slug;
				}
				$product[ 'tags' ] = strtolower( implode( ',', $tags ) );

				$categories = array();
				foreach( $p_details->categories as $p_cat_key => $p_cat_details ){
					$categories[] = $p_cat_details->slug;
				}
				$product[ 'categories' ] = strtolower( implode( ',', $categories ) );
				$product[ 'rating' ] = ( $p_details->rating_count > 0 ? ceil( $details->average_rating ) : '' ) ;
				$product[ 'rating_count' ] = $p_details->rating_count;

				 /**
				* Get images and/or video
				**/
				foreach( $p_details->images as $img_key => $img_detail ){
					$product[ 'is_img' ] = 1;
					$product[ 'media_src' ] = $img_detail->src;

					break;
				}

				$response[] = $product;
			}
		}

		return json_encode( $response );

	}

	public function get_layers_list( $p_type = 'themes' ){

		$product_types = array(
			'themes' => 83,
			'extensions' => 81
		);

		// &category=' . $product_types[ $p_type ]

		$cache_key = 'layers_wp_marketplace';

		if( FALSE !== get_transient( $cache_key ) ) {

			return json_decode( get_transient( $cache_key ) );
		}

		$api_call = wp_remote_get( 'https://www.layerswp.com/wp-json/wc/v1/products/?consumer_key=ck_850f668ddbad3705ecd10fe4f010dcc6e849a5ae&consumer_secret=cs_5c46a37a8890a4c2aa2af3c0226a6d489c6e7f70' );

		if( is_wp_error( $api_call ) ) {

			// Return an error if we have one
			return $api_call;
		} else {

			set_transient( $cache_key , wp_remote_retrieve_body( $api_call ), 60 );

			// If the call is successful, well then send back decoded JSON
			return json_decode( wp_remote_retrieve_body( $api_call ) );
		}
	}

	/**
	* Give us a list of available extensions
	*/
	public function get_envato_list( $p_type = 'themes' ){
		// Set the right end point to use
		$endpoint = 'discovery/search/search/item';

		// Specify a query string here we tell the API what search parameters to use
		switch( $p_type ){
			case 'stylekits' :
				$query_string = 'site=codecanyon.net&category=skins/layers-wp-style-kits';
				break;
			case 'extensions' :
				$query_string = 'site=codecanyon.net&compatible_with=Layers%20WP';
				break;
			default:
				$query_string = 'site=themeforest.net&compatible_with=Layers%20WP';
				break;
		}

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