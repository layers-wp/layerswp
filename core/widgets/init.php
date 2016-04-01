<?php /**
 * Widget Initiation File
 *
 * This file is the source of the Widget functionality in Layers.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Widgets {

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

		global $wp_customize;

		// Setup some folder variables
		$widget_dir = '/core/widgets/';
		$module_dir = '/core/widgets/modules/';

		// Setup some defined variables to use in each widget
		define( 'LAYERS_WIDGET_WIDTH_TINY' , 500 );
		define( 'LAYERS_WIDGET_WIDTH_SMALL' , 660 );
		define( 'LAYERS_WIDGET_WIDTH_LARGE' , 980 );

		// Include ajax functions
		require_once get_template_directory() . $widget_dir . 'ajax.php';

		// Include necessary widgets
		require_once get_template_directory() . $module_dir . 'base.php'; // Basis of all Layers Widgets
		require_once get_template_directory() . $module_dir . 'contact.php';
		require_once get_template_directory() . $module_dir . 'content.php';
		require_once get_template_directory() . $module_dir . 'post.php';
		require_once get_template_directory() . $module_dir . 'slider.php';

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
		add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );

		//Backup widgets pre-theme switch
		add_action( 'pre_set_theme_mod_sidebars_widgets', 'layers_backup_sidebars_widgets' );

		// Add a widget backup function
		add_action( 'customize_save_after', 'layers_backup_sidebars_widgets' , 50 );
		add_action( 'delete_post', array( $this, 'clear_page_widgets' ), 0 );
		add_action( 'wp_restore_post_revision' , array( $this, 'restore_backup' ), 10, 2 );
		add_action( 'init', array( $this, 'check_for_revisions' ), 50 );


		if( !isset( $wp_customize ) && !( isset( $_REQUEST['action'] ) && ( 'restore' == $_REQUEST['action'] || 'customize_save' == $_REQUEST['action'] ) ) ){
			add_action( 'save_post', array( $this, 'save_revision_fields_on_save' ), 10, 2 );
		}

		add_filter( '_wp_post_revision_fields', array( $this, 'add_revision_fields' ), TRUE );
		add_filter( '_wp_post_revision_field_widget_order', array( $this, 'add_widget_order_field' ), 10, 2 );

		// Register Sidebars
		$this->register_sidebars();
		$this->register_dynamic_sidebars();
	}

	/**
	*  Register Sidebars
	*/

	public function register_sidebars(){
		global $wp_customize , $temp_sidebars;

		// Loop the Builder Pages and create their sidebars
		foreach( layers_get_builder_pages() as $page){
			$this->register_builder_sidebar( $page->ID, $page->post_title );
		}
	}

	/**
	*  Register Builder Sidebar Function
	*/

	public static function register_builder_sidebar( $post_id = 0, $post_title = '' ) {
		register_sidebar( array(
			'id'		=> 'obox-layers-builder-' . $post_id,
			'name'		=> $post_title . __( ' Body' , 'layerswp' ),
			'before_widget'	=> '<div id="%1$s" class="widget %2$s">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<div class="section-title clearfix"><h4 class="heading">',
			'after_title'	=> '</h4></div>',
		) );
	}

	/**
	 * Get Dynamic Widget Areas
	 */

	public function get_dynamic_sidebars(){

		// Set the widget ID to search for
		$dynamic_widget_id = 'layers-widget-sidebar';

		// Get registered sidebars
		$sidebars = get_option( 'sidebars_widgets');

		// Make sure side bars & widgets option is not empty
		if( empty( $sidebars ) ) return;

		// Get the Dynamic Sidebar Widgets in use
		$dynamic_widget_areas = get_option( 'widget_' . $dynamic_widget_id );

		// If there are no sidebars to register, return;
		if( empty( $dynamic_widget_areas ) ) return;

		$dynamic_sidebars = array();

		// Loop over the Dynamic Sidebar Widgets
		foreach ( $dynamic_widget_areas as $widget_key => $widget_area ){

			// Check if this widget is inside an inactive sidebar (in which case skip)
			if( !in_array( $dynamic_widget_id  . '-' . $widget_key , $sidebars[ 'wp_inactive_widgets'] ) ) {
				if( isset( $widget_area['sidebars'] ) ){
					foreach ( $widget_area['sidebars'] as $sidebar_key => $sidebar ){
						$sidebar_id = $dynamic_widget_id  .'-' . $widget_key . '-' . $sidebar_key;

						$dynamic_sidebars[] =  array(
								'id' => $sidebar_id,
								'title' => $sidebar[ 'title' ]
							);

					} // foreach $widget_area['modules']
				} // if isset $widget_area['modules']
			} // if !in_array( $dynamic_widget_id )
		} // foreach $dynamic_widget_areas

		return $dynamic_sidebars;
	}

	/**
	 * Create Dynamic Widget Areas
	 */

	public function register_dynamic_sidebars(){

		$dynamic_sidebars = $this->get_dynamic_sidebars();

		if( empty( $dynamic_sidebars ) ) return;

		foreach( $dynamic_sidebars as $dynamic_sidebar ){
			register_sidebar( array(
							'id'		=> $dynamic_sidebar[ 'id' ],
							'name'		=> $dynamic_sidebar[ 'title' ],
							'description'	=> __( 'Layers Builder section.' , 'layerswp' ),
							'before_widget'	=> '<aside id="%1$s" class="widget %2$s">',
							'after_widget'	=> '</aside>',
							'before_title'	=> '<h4 class="widget-title">',
							'after_title'	=> '</h4>',
						) );
		}

	}

	/**
	 * Clear page widgets (when deleting a post, to keep a clean db)
	 */

	public function clear_page_widgets( $post_id ){

		$layers_sidebar_key = 'obox-layers-builder-' . $post_id;

		$migrator = new Layers_Widget_Migrator();
		$migrator->clear_page_sidebars_widget( $layers_sidebar_key );
	}

	public function add_revision_fields( $fields ) {
		global $current_screen;

		if( !( is_object( $current_screen) && 'revision' == $current_screen->base && !isset( $_GET[ 'action' ] ) ) ) {
			$fields['post_content_filtered'] = __( 'Raw Page Data', 'layerswp' );
		}

		$new_fields = array();
		foreach( $fields as $f_key => $f_value ){
			if( $f_key == 'post_content' ){
				$new_fields['_layers_widget_order'] = __( 'Widget Order', 'layerswp' );
			}
			$new_fields[ $f_key ] = $f_value;
		}

		return $new_fields;
	}

	/**
	 * Add widget order meta field
	 */

	public function add_widget_order_field(  $value, $field ) {

		global $revision;
		if( is_object( $revision ) )
			return get_metadata( 'post', $revision->ID, '_layers_widget_order', true );
	}

	/**
	 * Add special revision meta fields when updating pages through Page > Edit
	 */

	function save_revision_fields_on_save( $post_id, $post ) {

		$parent_id = wp_is_post_revision( $post_id );

		if ( $parent_id ) {

			$parent  = get_post( $parent_id );

			$migrator = new Layers_Widget_Migrator();
			$export_data = $migrator->page_widget_data( $parent );

			if ( false !== $export_data )
				add_metadata( 'post', $post_id, '_layers_widget_order', $migrator->page_widgets_as_content( $export_data ) );
		}
	}

	/**
	 * Restore a Backup from the Layers Widget Revisions
	 */

	public function restore_backup( $post_id, $revision_id){

		$post = get_post( $post_id, OBJECT );

		if( 'page' == $post->post_type && LAYERS_BUILDER_TEMPLATE !== get_post_meta( $post_id, '_wp_page_template', true ) ) return;

		// Get the revision information
		$revision = get_post( $revision_id, OBJECT );

		$layers_migrator = new Layers_Widget_Migrator();

		$widget_data = $revision->post_content_filtered;

		if( is_wp_error( unserialize( $widget_data ) ) ) return;

		// Check for errors.
		if ( '' == $widget_data || is_wp_error( unserialize( $widget_data ) ) ) return;

		$widget_data_array = unserialize( $widget_data );


		// Check if our data is empty.
		if ( empty( $widget_data_array ) ) return;

		$import = $layers_migrator->import( unserialize( $widget_data ), TRUE, TRUE );

		// Update widget order on the post
		$widget_order  = get_metadata( 'post', $revision_id, '_layers_widget_order', true );

		$latest_revisions = wp_get_post_revisions( $post_id, array( 'post_type' => 'page' ) );
		$latest_revision = reset( $latest_revisions );


		if ( false !== $widget_order ) {
			add_metadata( 'post', $latest_revision->ID, '_layers_widget_order', $widget_order );
			update_post_meta( $post_id, '_layers_widget_order', $widget_order );
		}

	}

	public function check_for_revisions(){

		global $wp_customize;

		if( get_option( 'layers_init_revisions' ) ) return;

		// Get a list of the migrator
		$get_layers_pages = layers_get_builder_pages( 500 );

		if( empty( $get_layers_pages ) ) return;

		$revisions_exist = FALSE;

		// Loop through the builder pages spooling up the widget data each time
		foreach( $get_layers_pages as $page ){

			if( '' !== get_post_meta( $page->ID, '_layers_hash', true ) ) {
				$revisions_exist = TRUE;
			}
		}

		if( ! $revisions_exist ) {
			add_filter( '_wp_post_revision_fields', array( $this, 'add_revision_fields' ) );

			layers_backup_sidebars_widgets( TRUE );

			add_option( 'layers_init_revisions', TRUE );
		}
	}



	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){

		// Banner Widget
		wp_register_script(
			LAYERS_THEME_SLUG . '-admin-slider-widget' ,
			get_template_directory_uri() . '/core/widgets/js/slider.js' ,
			array(),
			LAYERS_VERSION,
			true
		);
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-slider-widget' , 'sliderwidgeti18n', array(
			'confirm_message' => __( 'Are you sure you want to remove this slide?' , 'layerswp' )
		) );

		// Content Widget
		wp_register_script(
			LAYERS_THEME_SLUG . '-admin-content-widget' ,
			get_template_directory_uri() . '/core/widgets/js/content.js' ,
			array(),
			LAYERS_VERSION,
			true
		);
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-content-widget' , 'contentwidgeti18n', array(
			'confirm_message' => __( 'Are you sure you want to remove this column?' , 'layerswp' )
		) );

		// Repeatable Widget
		wp_register_script(
			LAYERS_THEME_SLUG . '-admin-repeater-widget' ,
			get_template_directory_uri() . '/core/widgets/js/repeater.js' ,
			array(),
			LAYERS_VERSION,
			true
		);
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-repeater-widget' , 'contentwidgeti18n', array(
			'confirm_message' => __( 'Are you sure you want to remove this column?' , 'layerswp' )
		) );
		wp_enqueue_script( LAYERS_THEME_SLUG . '-admin-repeater-widget' );

		// Widget accordians
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-widgets' ,
			get_template_directory_uri() . '/core/widgets/js/widget-accordians.js' ,
			array(
				LAYERS_THEME_SLUG . '-admin-slider-widget',
				LAYERS_THEME_SLUG . '-admin-content-widget',
				'backbone',
				'jquery',
				'wp-color-picker',
				'media-upload'
			),
			LAYERS_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script(
			LAYERS_THEME_SLUG . '-admin-widgets' ,
			'layers_widget_params',
			array(
				'nonce' => wp_create_nonce( 'layers-widget-actions' ),
			)
		);
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){

		// Color Picker styles
		wp_enqueue_style( 'wp-color-picker' );
	}
}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function layers_widgets_init(){
	global $layers_widgets;
	$layers_widgets = new Layers_Widgets();
	$layers_widgets->init();
}
add_action( 'widgets_init' , 'layers_widgets_init' , 20 );

if( !function_exists( 'layers_backup_sidebars_widgets' ) ) {
	function layers_backup_sidebars_widgets( $no_revisions = FALSE ){

		global $sidebars_widgets;

		// Get a list of the migrator
		$get_layers_pages = layers_get_builder_pages( 500 );

		// Loop through the builder pages spooling up the widget data each time
		$revisions = array();
		foreach( $get_layers_pages as $page ){

			$revisions[] = layers_backup_page_sidebars_widgets( $page );
		}

	}
}
add_action( 'layers_backup_sidebars_widgets', 'layers_backup_sidebars_widgets' );

if( !function_exists( 'layers_backup_page_sidebars_widgets' ) ) {
	function layers_backup_page_sidebars_widgets( $page = NULL, $no_revisions = FALSE ){

		// If the migrator class does not exist, then force load the migrator.php file
		if( !class_exists( 'Layers_Widget_Migrator' ) ) {
			require get_template_directory() . '/core/helpers/migrator.php';
		}

		// Prep the migrator
		$migrator = new Layers_Widget_Migrator();

		if( NULL == $page || !is_object( $page ) ) return;

		$raw_export_data = $migrator->export_data( $page );

		$export_data = $migrator->page_widget_data( $page );

		if( !empty( $export_data ) ){

			// Create a hash key so that we can know if this page is unique or not
			if( '' == get_post_meta( $page->ID, '_layers_hash', true ) ){
				$page_hash_key = 'layers_page_' . md5( $page->post_name . '-' . $page->ID );
				update_post_meta( $page->ID, '_layers_hash', $page_hash_key, false );
			} else {
				$page_hash_key = get_post_meta( $page->ID, '_layers_hash', true );
			}

			// Save the raw widget data
			$page_raw_widget_data = array(
				'post_id' => $page->ID,
				'post_hash' => $page_hash_key,
				'post_title' => esc_attr( $page->post_title ),
				'widget_data' => $raw_export_data
			);

			// Generate the post content
			$post = (array) $page;
			$post[ 'post_content_filtered' ] = serialize( $page_raw_widget_data );
			$post[ 'post_content' ] = layers_get_builder_page_content( $page->ID );

			// Update the backup post & get the revision ID
			$post_id = wp_update_post( $post );
			$revisions = wp_get_post_revisions( $page->ID, array( 'posts_per_page' => 1 ) );
			$latest_revision = reset( $revisions );

			// Add widget order field
			update_post_meta( $page->ID, '_layers_widget_order', $migrator->page_widgets_as_content( $export_data ), true );
			add_metadata( 'post', $latest_revision->ID, '_layers_widget_order', $migrator->page_widgets_as_content( $export_data ), true );

			$return = array(
				'post_id' => $post_id,
				'revision_id' => $latest_revision->ID
			);

			return $return;
		}
	}
}
function layers_check_for_preset_backup(){
	global $wp_customize;

	if( $wp_customize ){
		if( get_option( 'layers_cron_page_backup' ) ){

			$page_id = get_option( 'layers_cron_page_backup' );

			$page = get_post( $page_id );
			if( NULL == $page ) return;

			layers_backup_page_sidebars_widgets( $page );

			delete_option( 'layers_cron_page_backup' );
		}
	}
}
add_action( 'init', 'layers_check_for_preset_backup' );