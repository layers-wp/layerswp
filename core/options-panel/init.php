<?php /**
 * Layers Options Panel
 *
 * This file outputs the WP Pointer help popups around the site
 *
 * @package Layers
 * @since Layers 1.0.0
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
	* Complex Header with Menu
	*/
	public function header( $title = NULL, $excerpt = NULL ){

		if( isset( $_GET[ 'page' ] ) ) $current_page = $_GET[ 'page' ]; ?>
		<header class="layers-page-title layers-section-title layers-large layers-content-large layers-no-push-bottom">
			<div class="layers-container">
				<?php _e( sprintf( '<a href="%s" class="layers-logo">Layers</a>', 'http://layerswp.com' ), 'layerswp' ); ?>
				<?php if( !class_exists( 'Layers_Updater' ) ) { ?>
					<span class="layers-pull-right layers-content">
						<?php _e( sprintf( '<a class="layers-button btn-link" href="%s">Get the Layers Updater</a>', 'http://www.layerswp.com/download/layers-updater/' ) , 'layerswp' ); ?>
					</span>
				<?php } ?>
				<?php if( isset( $title ) ) { ?>
					<h2 class="layers-heading" id="layers-options-header"><?php echo esc_html( $title ); ?></h2>
				<?php } ?>
				<?php if( isset( $excerpt ) ) { ?>
					<p class="layers-excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php } ?>
				<nav class="layers-nav-horizontal layers-dashboard-nav">
					<ul>
						<?php foreach( $this->get_menu_pages()  as $menu_key => $menu_details ) { ?>
							<li <?php if( isset( $current_page ) && strpos( $menu_details[ 'link' ],  $current_page ) ) { ?>class="active"<?php } ?>>
								<a href="<?php echo $menu_details[ 'link' ]; ?>">
									<?php echo $menu_details[ 'label' ]; ?>
								</a>
							</li>
						<?php }?>
					</ul>
				</nav>

			</div>
		</header>
	<?php }

	/**
	* Header
	*/
	public function simple_header( $args = array() ){

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
				<?php _e( sprintf( 'Layers is a product of <a href="%1$s">Obox Themes</a>. For questions and feedback please <a href="%2$s">Visit our Help site</a>', 'http://oboxthemes.com/', 'http://docs.layerswp.com') , 'layerswp' ); ?>
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
		__( 'Get Started' , 'layerswp' ),
		__( 'Get Started' , 'layerswp' ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-get-started',
		'layers_options_panel_ui'
	);

	// Add Preset Pages
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Add New Page' , 'layerswp' ),
		__( 'Add New Page' , 'layerswp' ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-add-new-page',
		'layers_options_panel_ui'
	);

	// Layers Pages
	if( layers_get_builder_pages() ){
		// Only show if there are actually Layers pages.
		add_submenu_page(
			LAYERS_THEME_SLUG . '-dashboard',
			__( 'Layers Pages' , 'layerswp' ),
			__( 'Layers Pages' , 'layerswp' ),
			'edit_theme_options',
			'edit.php?post_type=page&filter=layers'
		);
	}

	// Customize
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Customize' , 'layerswp' ),
		__( 'Customize' , 'layerswp' ),
		'edit_theme_options',
		'customize.php'
	);

	// Backup Page
	add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Backup' , 'layerswp' ),
		__( 'Backup' , 'layerswp' ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-backup',
		'layers_options_panel_ui'
	);

	// This modifies the Layers submenu item - must be done here as $submenu
	// is only created if $submenu items are added using add_submenu_page
	$submenu[LAYERS_THEME_SLUG . '-dashboard'][0][0] = __( 'Dashboard' , 'layerswp' );
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