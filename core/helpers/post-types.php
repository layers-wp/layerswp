<?php  /**
 * Layers Post Type Class
 *
 * This file is used for all in-theme post types that need to be registered
 *
 * @package Layers
 * @since Layers 1.0.0
 */
class Layers_Post_Types {

	private static $instance;

	public $post_types;
	public $taxonomies;

	/**
	*  Initiator
	*/

	public static function get_instance(){
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Layers_Post_Types();
		}
		return self::$instance;
	}

	/**
	*  Constructor
	*/

	public function __construct() {
	}

	public function init() {

		foreach ( $this->get_post_types() as $post_type_key => $post_type_details ) {

			/**
			* Register the post type
			*/
			register_post_type( $post_type_key, $post_type_details );
		}

		foreach( $this->get_taxonomies() as $post_type_key => $taxonomy_details ) {
			foreach( $taxonomy_details as $tax_key => $tax_details ){
				register_taxonomy( $tax_key, array( $post_type_key ), $tax_details );
			}
		}
	}

	public function get_post_types(){

		$this->post_types = array();

		return apply_filters( 'layers_post_types' , $this->post_types );
	}

	public function get_taxonomies(){

		$this->taxonomies = array();

		return apply_filters( 'layers_taxonomies' , $this->taxonomies );

	}
}

/**
*  Kicking this off with the 'init' hook
*/
if( !function_exists( 'layers_register_post_types' ) ) {
	function layers_register_post_types(){
		$layers_post_types = new Layers_Post_Types();
		$layers_post_types->init();
	}
}
add_action( 'init', 'layers_register_post_types' );
