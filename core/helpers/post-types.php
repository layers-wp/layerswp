<?php  /**
 * Layers Post Type Class
 *
 * This file is used for all in-theme post types that need to be registered
 *
 * @package Layers
 * @since Layers 1.0
 */
class Layers_Post_Types {

	private static $instance;

	public $post_types;
	public $taxonomies;

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

		$this->post_types = array(
			'portfolio' => array(
				'description' => __( 'Portfolio Items', LAYERS_THEME_SLUG ),
				'labels' => array(
					'name'               => esc_html__( 'Projects', LAYERS_THEME_SLUG ),
					'singular_name'      => esc_html__( 'Project', LAYERS_THEME_SLUG ),
					'menu_name'          => esc_html__( 'Portfolio', LAYERS_THEME_SLUG ),
					'all_items'          => esc_html__( 'All Projects', LAYERS_THEME_SLUG ),
					'add_new'            => esc_html__( 'Add New', LAYERS_THEME_SLUG ),
					'add_new_item'       => esc_html__( 'Add New Project', LAYERS_THEME_SLUG ),
					'edit_item'          => esc_html__( 'Edit Project', LAYERS_THEME_SLUG ),
					'new_item'           => esc_html__( 'New Project', LAYERS_THEME_SLUG ),
					'view_item'          => esc_html__( 'View Project', LAYERS_THEME_SLUG ),
					'search_items'       => esc_html__( 'Search Projects', LAYERS_THEME_SLUG ),
					'not_found'          => esc_html__( 'No Projects found', LAYERS_THEME_SLUG ),
					'not_found_in_trash' => esc_html__( 'No Projects found in Trash', LAYERS_THEME_SLUG ),
				),
				'supports' => array(
					'title',
					'editor',
					'thumbnail',
					'comments',
					'publicize',
					'wpcom-markdown',
				),
				'rewrite' => array(
					'slug'       => 'portfolio',
					'with_front' => false,
					'feeds'      => true,
					'pages'      => true,
				),
				'public'          => true,
				'show_ui'         => true,
				'menu_position'   => 20,                    // below Pages
				'menu_icon'       => 'dashicons-portfolio', // 3.8+ dashicon option
				'capability_type' => 'page',
				'map_meta_cap'    => true,
				'taxonomies'      => array( 'portfolio-category', 'portfolio-tag' ),
				'has_archive'     => true,
				'query_var'       => 'portfolio',
			)
		);

		return apply_filters( 'layers_post_types' , $this->post_types );
	}

	public function get_taxonomies(){

		$this->taxonomies = array(
				'portfolio' => array(
					'portfolio-category' => array(
						'name' => __( 'Project Categories', LAYERS_THEME_SLUG ),
						'hierarchical' => true
					),
					'portfolio-tag' => array(
						'name' => __( 'Project Tags', LAYERS_THEME_SLUG ),
						'hierarchical' => false
					)
				)
			);

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
	add_action( 'init', 'layers_register_post_types' );
}