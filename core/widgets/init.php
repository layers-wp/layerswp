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

		// When switching to a child theme, preserve page builder pages
		add_action('switch_theme', array( $this , 'preserve_widgets' ) );

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
		add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );

		// Add a widget backup function

//		add_action( 'do_backup_sidebars_widgets' , array( $this, 'backup_sidebars_widgets' ) );
		add_action( 'customize_save', 'layers_backup_sidebars_widgets' , 50 );
		add_action( 'init', array( $this, 'register_backup_post_type' ) );

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

	public function register_builder_sidebar( $post_id = 0, $post_title = '' ) {
		register_sidebar( array(
			'id'		=> 'obox-layers-builder-' . $post_id,
			'name'		=> $post_title . __( ' Body' , 'layerswp' ),
			'before_widget'	=> '<aside id="%1$s" class="widget container push-bottom-medium %2$s">',
			'after_widget'	=> '</aside>',
			'before_title'	=> '<div class="section-title clearfix"><h4 class="heading">',
			'after_title'	=> '</h4></div>',
		) );
	}

	/**
	 * Port Widgets between Layers Parent theme and Child themes
	 */
	public function preserve_widgets( $theme ){
		global $sidebars_widgets;

		// If we are using a Layers theme, then let's make sure widgets are kept between our theme switch
		if( LAYERS_THEME_SLUG == basename( get_template_directory() ) || 'layerswp' == basename( get_template_directory() ) ){

			// Fetch the old theme and its theme mods
			$old_theme = get_option( 'theme_switched' );
			$old_theme_mods = get_option( 'theme_mods_' . $old_theme );

			// Update our 'new' theme with the widgets we have cultivated so nicely for our builder pages
			update_option( 'theme_mods_' . basename( get_stylesheet_directory() ) , $old_theme_mods );
			set_theme_mod( 'sidebars_widgets' , $old_theme_mods[ 'sidebars_widgets' ] );
		}
	}

	/**
	*  Widget Setting backup function
	*/
	/*
	public function set_backup_cron(){
		wp_schedule_single_event( time() + 60, 'do_backup_sidebars_widgets' );
	}
	*/
	public function register_backup_post_type(){
		global $sidebars_widgets;

		register_post_type( 'layers-backup', array(
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'supports' => array(
				'title',
				'revisions'
			),
			'labels' => array(
				'name' => _x( 'Backups', 'post type general name', 'layerswp' ),
				'singular_name' => _x( 'Backup', 'post type singular name', 'layerswp' ),
				'menu_name' => _x( 'Backups', 'admin menu', 'layerswp' ),
			)
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

		// Tiny MCE Initiator
		wp_register_script(
			LAYERS_THEME_SLUG . '-admin-tinymce' ,
			get_template_directory_uri() . '/core/widgets/js/tinymce.js' ,
			array(
				'editor',
				'word-count',
				'quicktags',
				'wplink',
				'wp-fullscreen'
			),
			LAYERS_VERSION,
			true
		);

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
				"layers_widget_params",
				array(
						'nonce' => wp_create_nonce( 'layers-widget-actions' )
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

function layers_backup_sidebars_widgets(){
	global $sidebars_widgets;

	$check_for_post = get_posts( 'post_type=layers-backup&posts_per_page=1&post_status=any' );

	$migrator = new Layers_Widget_Migrator();
	$get_layers_pages = layers_get_builder_pages( 500 );

	$page_raw_widget_data = array();

	foreach( $get_layers_pages as $page ){
		$export_data = $migrator->export_data( $page );

		if( !empty( $export_data ) ){
			$page_raw_widget_data[] = $export_data;
		}
	}

	$page_widget_data = array();
	$page_content = '';

	foreach( $get_layers_pages as $page ){
		$export_data = $migrator->page_widget_plain_data( $page );
		/*
		echo '<h3>' . $page->post_title . '</h3>';
		echo '<pre>';
		print_r( $export_data );
		echo '</pre>';
		*/

		if( !empty( $export_data ) ){
			$page_content .= '
			'. $page->post_title . ':';
			foreach( $export_data as $data ){
				$page_content .= '
				* ' . $data->name;
			}
		}
	}

	if( !empty( $check_for_post ) ){
		$post[ 'ID' ] = $check_for_post[0]->ID;
	}

	$post[ 'post_title' ] = __( 'Layers Backups' , 'layerswp' );
	$post[ 'post_type' ] = 'layers-backup';
	$post[ 'post_status' ] = 'publish';
	$post[ 'post_content' ] = trim( $page_content );
	$post[ 'post_excerpt' ] = serialize( $page_raw_widget_data );

	wp_insert_post( $post );
}
add_action( 'admin_init' , 'layers_backup_sidebars_widgets' );