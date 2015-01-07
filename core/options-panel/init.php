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
			<h1><?php echo $vars->title; ?></h1>
			<p><?php echo $vars->intro; ?></p>
		</header>
	<?php }

	/**
	* Body
	*/
	public function body( $partial = NULL ){

		if( NULL == $partial ) return;

		// Include Partials, we're using require so that inside the partial we can use $this to access the header and footer
		require $this->options_panel_dir . 'partials/' . $partial . '.php';

	}

	/**
	* Footer
	*/
	public function footer( $args = array() ){ ?>
		<footer class="layers-row layers-content">
			<p>
				<?php _e( 'Layers is a product of <a href="http://oboxthemes.com/">Obox Themes</a>. For questions and feedback please <a href="mailto:david@obox.co.za">email David directly', LAYERS_THEME_SLUG ); ?></a>.
			</p>
		</footer>
	<?php }
}

/**
 * Add admin menu
 */

function layers_options_panel_menu(){

	global $submenu, $menu;

	// Welcome Page
	add_menu_page(
		LAYERS_THEME_TITLE,
		LAYERS_THEME_TITLE,
		'manage_options',
		LAYERS_THEME_SLUG . '-welcome',
		'layers_options_panel_ui',
		'none',
		3
	);
	
	// Add Preset Pages
	add_submenu_page(
		LAYERS_THEME_SLUG . '-welcome',
		__( 'Add New Layers Page' , LAYERS_THEME_SLUG ),
		__( 'Add New Layers Page' , LAYERS_THEME_SLUG ),
		'manage_options',
		LAYERS_THEME_SLUG . '-preset-layouts',
		'layers_options_panel_ui'
	);

	// Layers Pages
	if( layers_get_builder_pages() ){
		// Only show if there are actually Layers pages.
		add_submenu_page(
			LAYERS_THEME_SLUG . '-welcome',
			__( 'Layers Pages', LAYERS_THEME_SLUG ),
			__( 'Layers Pages', LAYERS_THEME_SLUG ),
			'manage_options',
			"edit.php?post_type=page&filter=layers"
		);
	}

	// Backup Page
	add_submenu_page(
		LAYERS_THEME_SLUG . '-welcome',
		__( 'Backup' , LAYERS_THEME_SLUG ),
		__( 'Backup' , LAYERS_THEME_SLUG ),
		'manage_options',
		LAYERS_THEME_SLUG . '-backup',
		'layers_options_panel_ui'
	);

	// This modifies the Layers submenu item - must be done here as $submenu
	// is only created if $submenu items are added using add_submenu_page
	$submenu[LAYERS_THEME_SLUG . '-welcome'][0][0] = 'Welcome';
}

add_action( 'admin_menu' , 'layers_options_panel_menu' , 50 );

/**
*  Kicking this off with the 'ad' hook
*/

function layers_options_panel_ui(){
	$layers_options_panel = new Layers_Options_Panel();
	$layers_options_panel->init();
}
