<?php /**
 * Layers Options Panel
 *
 * This file outputs the WP Pointer help popups around the site
 *
 * @package Layers
 * @since Layers 1.0
 */

class Layers_Options_Panel {

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
		$this->options_panel_dir = LAYERS_TEMPLATE_DIR . '/core/options-panel/';

		// Setup the partial var
		$page =  str_replace( LAYERS_THEME_SLUG . '-' , '', $_REQUEST[ 'page' ] );

		// Load template
		$this->body( $page );

	}

	/**
	* Header
	*/
	public function header( $args = array() ){

		// Turn $args into an object because it's nicer to use as a template
		$vars = (object) $args; ?>
		<header>
			<h1><?php echo esc_html( $vars->title ); ?></h1>
			<p><?php echo esc_html( $vars->intro ); ?></p>
		</header>
	<?php }

	/**
	* Body
	*/
	public function body( $partial = NULL ){

		if( NULL == $partial ) return;

		$this->load_partial( $partial );

	}

	private function load_partial( $partial = NULL ) {

		// Include Partials, we're using require so that inside the partial we can use $this to access the header and footer
		require $this->options_panel_dir . 'partials/' . $partial . '.php';
	}

	/**
	* Footer
	*/
	public function footer( $args = array() ){ ?>
		<footer class="layers-footer">
			<p>
				<?php _e( 'Layers is a product of <a href="http://oboxthemes.com/">Obox Themes</a>. For questions and feedback please <a href="mailto:david@obox.co.za">email David directly', LAYERS_THEME_SLUG ); ?></a>.
			</p>
		</footer>
	<?php }

	/**
	* Get Layers Regsitered Menus
	*/

	public function get_menu_pages(){
		global $submenu;

		if( isset( $submenu[ 'layers-dashboard' ] ) ) {
			foreach ( $submenu[ 'layers-dashboard' ] as $menu_key => $menu_details ) {
				$sub_menu[ 'label' ] = $menu_details[0];
				$sub_menu[ 'cap' ] = $menu_details[1];
				$sub_menu[ 'link' ] = ( strpos( $menu_details[2], '.php' ) ? admin_url( $menu_details[2] ) : admin_url( 'admin.php?page=' . $menu_details[2] ) );

				$menu[] = $sub_menu;
			}

			return $menu;
		}

		return NULL;
	}

}

/**
 * Add admin menu
 */

function layers_options_panel_menu(){

	global $submenu, $menu;

	// dashboard Page
	add_menu_page(
		LAYERS_THEME_TITLE,
		LAYERS_THEME_TITLE,
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-dashboard',
		'layers_options_panel_ui',
		'none',
		3
	);

	// Get Started
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Get Started' , LAYERS_THEME_SLUG ),
		__( 'Get Started' , LAYERS_THEME_SLUG ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-get-started',
		'layers_options_panel_ui'
	);

	// Add Preset Pages
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Add New Page' , LAYERS_THEME_SLUG ),
		__( 'Add New Page' , LAYERS_THEME_SLUG ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-add-new-page',
		'layers_options_panel_ui'
	);

	// Layers Pages
	if( layers_get_builder_pages() ){
		// Only show if there are actually Layers pages.
		add_submenu_page(
			LAYERS_THEME_SLUG . '-dashboard',
			__( 'Layers Pages', LAYERS_THEME_SLUG ),
			__( 'Layers Pages', LAYERS_THEME_SLUG ),
			'edit_theme_options',
			'edit.php?post_type=page&filter=layers'
		);
	}

	// Customize
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Customize', LAYERS_THEME_SLUG ),
		__( 'Customize', LAYERS_THEME_SLUG ),
		'edit_theme_options',
		'customize.php'
	);

	// Backup Page
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Backup' , LAYERS_THEME_SLUG ),
		__( 'Backup' , LAYERS_THEME_SLUG ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-backup',
		'layers_options_panel_ui'
	);

	// This modifies the Layers submenu item - must be done here as $submenu
	// is only created if $submenu items are added using add_submenu_page
	$submenu[LAYERS_THEME_SLUG . '-dashboard'][0][0] = __( 'Dashboard' , LAYERS_THEME_SLUG );
}

add_action( 'admin_menu' , 'layers_options_panel_menu' , 50 );

/**
*  Kicking this off with the 'ad' hook
*/

function layers_options_panel_ui(){
	$layers_options_panel = new Layers_Options_Panel();
	$layers_options_panel->init();
}

function layers_load_options_panel_ajax(){
	// Include ajax functions
	require_once LAYERS_TEMPLATE_DIR . '/core/options-panel/ajax.php';

    $onboarding_ajax = new Layers_Onboarding_Ajax();
    $onboarding_ajax->init();
}

add_action( 'init' , 'layers_load_options_panel_ajax' );