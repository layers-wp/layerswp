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
		<footer class="layers-footer">
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
	add_theme_page(
		__( 'Layers - Home' , LAYERS_THEME_SLUG ),
		__( 'Layers - Home' , LAYERS_THEME_SLUG ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-welcome',
		'layers_options_panel_ui'
	);

	// Add Preset Pages
	add_theme_page(
		__( 'Layers - Add Page' , LAYERS_THEME_SLUG ),
		__( 'Layers - Add Page' , LAYERS_THEME_SLUG ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-preset-layouts',
		'layers_options_panel_ui'
	);

	// Layers Pages
	if( layers_get_builder_pages() ){
		// Only show if there are actually Layers pages.
		add_theme_page(
			__( 'Layers - All Pages', LAYERS_THEME_SLUG ),
			__( 'Layers - All Pages', LAYERS_THEME_SLUG ),
			'edit_theme_options',
			'edit.php?post_type=page&filter=layers'
		);
	}

	// Backup Page
	add_theme_page(
		__( 'Layers - Backup' , LAYERS_THEME_SLUG ),
		__( 'Layers - Backup' , LAYERS_THEME_SLUG ),
		'edit_theme_options',
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
