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

	public $page;

	public $valid_page_slugs;

	public $options_panel_dir;

	/**
	*  Initiator
	*/
	public static function get_instance(){
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Layers_Onboarding_Ajax();
		}
		return self::$instance;
	}

	/**
	*  Constructor
	*/
	public function __construct() {

		// Exit on missing ABSPATH
		if ( ! defined( 'ABSPATH' ) ) exit;

		global $page;

		// Setup some folder variables
		$this->options_panel_dir = LAYERS_TEMPLATE_DIR . '/core/options-panel/';

		$this->set_valid_page_slugs();
	}

	public function init() {

		// Load template
		$this->body( $this->get_current_page() );

	}

	/**
	* Set a list of valid pages we can access via this method
	*/
	public function set_valid_page_slugs(){
		global $submenu;

		if( !isset( $submenu[ 'layers-dashboard' ] ) ) return;

		$page_list = $submenu[ 'layers-dashboard' ];

		$this->valid_page_slugs = array();

		foreach( $page_list as $sub_menu_page ){

			// Make sure that the slug is valid
			if( !isset( $sub_menu_page[2] ) ) continue;

			// Load up the valid pages
			$this->valid_page_slugs[] = $sub_menu_page[2];
		}
	}

	/**
	* Parse $_GET['page'] and get the current page template to load
	*/
	public function get_current_page(){

		// Make sure we have a 'page' query to look at
		if( ! isset( $_GET['page'] ) ) wp_die( __( 'No page argument has been set.' , 'layerswp' ) );

		// Set the current page if the 'page' query exists
		$current_page = $_GET['page'];

		// Check the current page against valid pages
		if( ! in_array( $current_page , $this->valid_page_slugs ) ) wp_die( __( 'Invalid page slug' , 'layerswp' ) );

		// Set the page slug if everything is kosher
		$page_slug = str_replace( 'layers-', '' , $current_page );

		// Sanitize the slug
		$page_slug = esc_attr( $page_slug );

		// Return the page slug
		return $page_slug;
	}

	/**
	* Complex Header with Menu
	*/
	public function header( $title = NULL, $excerpt = NULL ){

		if( isset( $_GET[ 'page' ] ) ) $current_page = $_GET[ 'page' ]; ?>
		<header class="layers-page-title layers-section-title layers-large layers-content-large layers-no-push-bottom">

				<?php _e( sprintf( '<a href="%s" class="layers-logo">Layers</a>', 'http://layerswp.com' ), 'layerswp' ); ?>
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
								<a href="<?php echo esc_url( $menu_details[ 'link' ] ); ?>">
									<?php echo esc_html( $menu_details[ 'label' ] ); ?>
								</a>
							</li>
						<?php }?>
						<?php if( !class_exists( 'Layers_Updater' ) ) { ?>
							<li>
								<?php _e( sprintf( '<a class="layers-get-updater" href="%s">Get the Layers Updater</a>', 'http://www.layerswp.com/download/layers-updater/' ) , 'layerswp' ); ?>
							</li>
						<?php } ?>
					</ul>
					<form class="layers-help-search" action="http://docs.layerswp.com" target="_blank" method="get">
						<input name="s" type="search" placeholder="Search Layers Help..." />
					</form>
				</nav>

		</header>
	<?php }

	/**
	* Header
	*/
	public function simple_header( $args = array() ){ ?>
		<header>
			<h1><?php echo esc_html( $vars['title'] ); ?></h1>
			<p><?php echo esc_html( $vars['intro'] ); ?></p>
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
	* Dashboard Notices
	*/
	public function notice( $good_or_bad = 'good', $message = FALSE, $classes = array() ){
		if( FALSE == $message ) return; ?>
		<div class="layers-status-notice layers-site-setup-completion layers-status-<?php echo $good_or_bad; ?> <?php echo implode( ' ' , $classes ); ?>">
			<h5 class="layers-status-notice-heading">
				<?php switch ( $good_or_bad ) {
					case 'good' :
						$icon = 'tick';
					break;
					case 'bad' :
						$icon = 'cross';
					break;
					default :
						$icon = 'display';
					break;
				} ?>
				<i class="icon-<?php echo $icon; ?>"></i>
				<span><?php echo $message; ?></span>
			</h5>
		</div>
	<?php }

	/**
	* Get Layers Regsitered Menus
	*/
	public function get_menu_pages(){

		$menu = apply_filters( 'layers_dashboard_header_links', array(
					'layers-dashboard' => array(
						'label' => 'Dashboard',
						'link' => admin_url( 'admin.php?page=layers-dashboard' ),
					),
					'layers-get-started' => array(
						'label' => 'Get Started',
						'link' => admin_url( 'admin.php?page=layers-get-started' ),
					),
					'layers-add-new-page' => array(
						'label' => 'Add New Page',
						'link' => admin_url( 'admin.php?page=layers-add-new-page' ),
					),
					'layers-pages' => array(
						'label' => 'Layers Pages',
						'link' => admin_url( 'edit.php?post_type=page&amp;filter=layers' ),
					),
				)
		);

		return $menu;
	}

	/**
	* Get Layers Setup Options
	*/

	public function site_setup_actions(){

		$site_setup_actions[ 'google-analytics' ] =  array(
			'label' => __( 'Google Analytics', 'layerswp' ),
			'excerpt' => __( 'Enter in your Google Analytics ID to enable website traffic reporting.', 'layerswp' ),
			'form' => array(
					'layers-header-google-id' => array(
							'type' => 'text',
							'name' => 'layers-header-google-id',
							'id' => 'layers-header-google-id',
							'placeholder' => __( 'UA-xxxxxx-xx', 'layerswp' ),
							'value' => layers_get_theme_mod( 'header-google-id' )
						)
				),
			'skip-action' => 'layers_site_setup_step_dismissal',
			'submit-action' => 'layers_onboarding_set_theme_mods',
			'submit-text' => __( 'Save', 'layerswp' )
		);

		$site_setup_actions[ 'copyright' ] = array(
			'label' => __( 'Copyright Text', 'layerswp' ),
			'form' => array(
					'layers-footer-copyright-text' => array(
							'type' => 'text',
							'name' => 'layers-footer-copyright-text',
							'id' => 'layers-footer-copyright-text',
							'placeholder' => __( 'Made at the tip of Africa. &copy;', 'layerswp' ),
							'value' => layers_get_theme_mod( 'footer-copyright-text' )
						)
				),
			'skip-action' => 'layers_site_setup_step_dismissal',
			'submit-action' => 'layers_onboarding_set_theme_mods',
			'submit-text' => __( 'Save', 'layerswp' )
		);

		if( 0 == count( get_posts( 'post_type=nav_menu_item' ) ) ) {
			$site_setup_actions[ 'menus' ] = array(
				'label' => __( 'Setup your website menu', 'layerswp' ),
				'excerpt' => __( sprintf( 'Navigation is a key element of setting up your website. Controly our menus here. For more information read our <a href="%s" target="_blank">help guide</a>.', 'http://docs.layerswp.com/doc/create-your-menus/' ), 'layerswp' ),
				'form' => array(
						'layers-menu-link' => array(
								'type' => 'button',
								'name' => 'layers-menu-link',
								'id' => 'layers-menu-link',
								'href' => admin_url( 'nav-menus.php' ),
								'target' => '_blank',
								'tag' => 'a',
								'class' => 'layers-button btn-primary',
								'label' => __( 'Setup Menus', 'layerswp' ),
							)
					),
				'skip-action' => 'layers_site_setup_step_dismissal'
			);
		}
		return apply_filters( 'layers_setup_actions' , $site_setup_actions );
	}

	public function enqueue_dashboard_scripts(){

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-dashboard' ,
			get_template_directory_uri() . '/core/assets/dashboard.js',
			array(
				'jquery',
			),
			LAYERS_VERSION
		); // Sticky-Kit

		wp_localize_script(
			LAYERS_THEME_SLUG . '-dashboard' ,
			"layers_dashboard_params",
			array(
				'layers_dashboard_feed_nonce' => wp_create_nonce( 'layers-dashboard-feed' ),
				'layers_dashboard_dismiss_setup_step_nonce' => wp_create_nonce( 'layers-dashboard-dismiss-setup-step' )
			)
		); // Onboarding ajax parameters

	}

}

/**
 * Add admin menu
 */

function layers_options_panel_menu(){

	$layers_options_panel = new Layers_Options_Panel();

	global $submenu;

	// dashboard Page
	$dashboard = add_menu_page(
		LAYERS_THEME_TITLE,
		LAYERS_THEME_TITLE,
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-dashboard',
		'layers_options_panel_ui',
		'none',
		3
	);

	add_action('admin_print_scripts-' . $dashboard, array( $layers_options_panel, 'enqueue_dashboard_scripts') );

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