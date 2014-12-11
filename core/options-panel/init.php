<?php /**
 * Hatch Options Panel
 *
 * This file outputs the WP Pointer help popups around the site
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Options_Panel {

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
		$this->options_panel_dir = HATCH_TEMPLATE_DIR . '/core/options-panel/';

		// Setup the partial var
		$page =  str_replace( HATCH_THEME_SLUG . '-' , '', $_REQUEST[ 'page' ] );

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
		<footer>
		</footer>
	<?php }
}

/**
 * Add admin menu
 */

function hatch_options_panel_menu(){
	
	global $submenu, $menu;
	
	// Welcome Page
	add_menu_page(
			HATCH_THEME_TITLE,
			HATCH_THEME_TITLE,
			'manage_options',
			HATCH_THEME_SLUG . '-welcome',
			'hatch_options_panel_ui',
			'dashicons-smiley',
			3
	);

	// Welcome Page
	//add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	add_submenu_page(
			HATCH_THEME_SLUG . '-welcome',
			__( 'Backup' , HATCH_THEME_SLUG ),
			__( 'Backup' , HATCH_THEME_SLUG ),
			'manage_options',
			HATCH_THEME_SLUG . '-backup',
			'hatch_options_panel_ui'
	);
	
	// This modifies the Hatch submenu item - must be done here as $submenu
	// is only created if $submenu items are added using add_submenu_page
	$submenu[HATCH_THEME_SLUG . '-welcome'][0][0] = 'Welcome';
	
	// Hatch Pages
	
	// Move backup to the next menu position, to make room
	// @TODO: Revisit this as there could be a cleaner method
	$submenu[HATCH_THEME_SLUG . '-welcome'][2] = $submenu[HATCH_THEME_SLUG . '-welcome'][1];
	
	// Add submenu item.
	$submenu[HATCH_THEME_SLUG . '-welcome'][1] = array(
		__( 'Hatch Pages', HATCH_THEME_SLUG ),
		'manage_options',
		admin_url( "edit.php?post_type=page&filter=hatch" )
	);
	
}

add_action( 'admin_menu' , 'hatch_options_panel_menu' , 50 );

/**
*  Kicking this off with the 'ad' hook
*/

function hatch_options_panel_ui(){
	$hatch_options_panel = new Hatch_Options_Panel();
	$hatch_options_panel->init();
}

/**
 * Filter Hatch Pages in wp-admin Pages
 *
 * @TODO: think about moving this function to it own helpers/admin.php,
 * especially if more work is to be done on admin list.
 */

if ( ! function_exists( 'hatch_filter_admin_pages' ) ) {
	add_filter( 'pre_get_posts', 'hatch_filter_admin_pages' );
	
	function hatch_filter_admin_pages() {
		global $typenow;
		
		if ( 'page' == $typenow && isset($_GET['filter']) && $_GET['filter'] == 'hatch' ) {
			set_query_var(
				'meta_query',
				array(
					'relation' => 'AND',
					array(
						'key' => '_wp_page_template',
						'value' => HATCH_BUILDER_TEMPLATE,
					)
				)
			);
		}
	}
}