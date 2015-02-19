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

		// Register Sidebars
		$this->register_sidebars();
		$this->register_dynamic_sidebars();
	}

	/**
	*  Register Sidebars
	*/

	public function register_sidebars(){
		global $wp_customize , $temp_sidebars;

		// Fetch Builder Pages
		$pages = get_pages(array(
			'post_status' => 'publish,draft,private',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'builder.php',
			'parent' => -1
		));

		// Loop the Builder Pages and create their sidebars
		foreach($pages as $page){
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
			set_theme_mod( 'sidebars_widgets' , $old_theme_mods[ 'sidebars_widgets' ] );
		}
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
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-slider-widget' , 'sliderwidgeti8n', array(
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
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-content-widget' , 'contentwidgeti8n', array(
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
						'ajaxurl' => admin_url( "admin-ajax.php" ) ,
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