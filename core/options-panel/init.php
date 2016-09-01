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

		global $pagenow, $wp_customize;

		// Setup some folder variables
		$this->options_panel_dir = LAYERS_TEMPLATE_DIR . '/core/options-panel/';

		$this->set_valid_page_slugs();

		add_action( 'wp_dashboard_setup', array( &$this, 'layers_add_dashboard_widgets' ) );

		if( !defined( 'LAYERS_DISABLE_MARKETPLACE' ) ){
			add_filter( 'media_upload_tabs', array( &$this, 'upload_upsell_media_tab' ) );
			add_action( 'media_upload_upsell_media', array( &$this, 'upload_upsell_media_form' ) );
			add_action( 'print_media_templates', array( &$this, 'upload_upsell_media_template' ) );
		}
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

		// Layers Marketplace is on it's own top level menu, so we have to shimmy it in
		$this->valid_page_slugs[] = 'layers-marketplace';
		$this->valid_page_slugs[] = 'layers-envato-marketplace';
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
	public function marketplace_header( $title = NULL, $excerpt = NULL, $marketplace = 'layerswp' ){

		$api = new Layers_API();

		if( isset( $_GET[ 'type' ] ) ) $type = $_GET[ 'type' ]; else $type = 'themes' ?>
		<header class="l_admin-page-title l_admin-section-title l_admin-large l_admin-content l_admin-no-push-bottom">

			<?php _e( sprintf( '<a href="%s" class="l_admin-logo">Layers</a>', 'http://layerswp.com' ), 'layerswp' ); ?>

			<?php if( isset( $title ) ) { ?>
				<h2 class="l_admin-heading" id="layers-options-header">
					<?php echo esc_html( $title ); ?>
					<span class="l_admin-small">
					<?php if( 'envato' == $marketplace ){ ?>
							<?php _e( sprintf( 'Powered by <a href="%s">Envato</a>', 'http://www.themeforest.net/?ref=obox' ), 'layerswp' ); ?>
					<?php } else { ?>
							<?php _e( sprintf( 'Powered by <a href="%s">Layers</a>', 'https://www.layerswp.com' ), 'layerswp' ); ?>
					<?php } ?>
					</span>
				</h2>
			<?php } ?>

			<?php if( isset( $excerpt ) ) { ?>
				<p class="l_admin-excerpt"><?php echo $excerpt; ?></p>
			<?php } ?>
		</header>
	<?php }

	/**
	* Complex Header with Menu
	*/
	public function header( $title = NULL, $excerpt = NULL ){

		if( isset( $_GET[ 'page' ] ) ) $current_page = $_GET[ 'page' ]; ?>
		<header class="l_admin-page-title l_admin-section-title l_admin-large l_admin-content l_admin-no-push-bottom">

				<?php _e( sprintf( '<a href="%s" class="l_admin-logo">Layers</a>', 'http://layerswp.com' ), 'layerswp' ); ?>
				<?php if( isset( $title ) ) { ?>
					<h2 class="l_admin-heading" id="layers-options-header"><?php echo esc_html( $title ); ?></h2>
				<?php } ?>

				<?php if( isset( $excerpt ) ) { ?>
					<p class="l_admin-excerpt"><?php echo esc_html( $excerpt ); ?></p>
				<?php } ?>

				<nav class="l_admin-nav-horizontal l_admin-dashboard-nav">
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
								<?php _e( sprintf( '<a class="l_admin-get-updater l_admin-button btn-primary" href="%s">Get the Layers Updater</a>', 'http://www.layerswp.com/download/layers-updater/' ) , 'layerswp' ); ?>
							</li>
						<?php } ?>
					</ul>
					<form class="l_admin-help-search" action="http://docs.layerswp.com" target="_blank" method="get">
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
	public function upload_upsell_media_template(){
		$this->body( 'discover-more-photos' );
	}

	function upload_upsell_media_tab($tabs) {
		$tabs['upsell_media'] = __( 'Discover More' , 'layerswp' );
		return $tabs;
	}

	// call the new tab with wp_iframe
	function upload_upsell_media_form() {
		wp_iframe( array( &$this, 'upload_upsell_media_template' ) );
	}

	/**
	* Footer
	*/
	public function footer( $args = array() ){ ?>
		<footer class="l_admin-footer">
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
		<div class="l_admin-status-notice l_admin-site-setup-completion l_admin-status-<?php echo $good_or_bad; ?> <?php echo implode( ' ' , $classes ); ?>">
			<h5 class="l_admin-status-notice-heading">
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
					'layers-marketplace' => array(
						'label' => 'Layers Add Ons',
						'link' => admin_url( 'admin.php?page=layers-marketplace' ),
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
								'class' => 'button button-primary',
								'label' => __( 'Setup Menus', 'layerswp' ),
							)
					),
				'skip-action' => 'layers_site_setup_step_dismissal'
			);
		}
		return apply_filters( 'layers_setup_actions' , $site_setup_actions );
	}

	public function layers_add_dashboard_widgets(){
		if( !defined( 'LAYERS_DISABLE_MARKETPLACE' ) ){
			wp_add_dashboard_widget(
				'layers-addons',
				__( 'Layers Themes &amp; Extensions', 'layerswp' ),
				array( &$this, 'layers_dashboard_widget' ),
				NULL,
				array(
					'type' => 'addons'
				)
			);
		}

		if( !class_exists( 'Layers_WooCommerce' ) && class_exists( 'WooCommerce' )  ) {
			wp_add_dashboard_widget(
				'layers-storekit',
				__( 'Upgrade WooCommerce with StoreKit', 'layerswp' ),
				array( &$this, 'layers_dashboard_widget' ),
				NULL,
				array(
					'type' => 'upsell-storekit'
				)
			);

		}

		if( !class_exists( 'Layers_Pro' ) ) {
			wp_add_dashboard_widget(
				'layers-pro',
				__( 'Get Even More with Layers Pro', 'layerswp' ),
				array( &$this, 'layers_dashboard_widget' ),
				NULL,
				array(
					'type' => 'upsell-layers-pro'
				)
			);

		}
	}

	function layers_dashboard_widget( $var, $args ){ ?>
		<div class="l_admin-wp-dashboard-panel">
			<?php if( 'addons' == $args[ 'args' ][ 'type' ] ) { ?>
				<div class="l_admin-section-title l_admin-tiny">
					<p class="l_admin-excerpt">
						<?php _e( 'Looking for a theme or plugin to achieve something unique with your website?
							Browse the Layers Add Ons and take your site to the next level.' , 'layerswp' ); ?>
					</p>
				</div>
				<div class="l_admin-button-well">
					<a href="<?php echo admin_url( 'admin.php?page=layers-marketplace' ); ?>" class="button button-primary">
						<?php _e( 'Themes &amp; Extensions' , 'layerswp' ); ?>
					</a>
				</div>
			<?php } ?>
			<?php if( 'upsell-layers-pro' == $args[ 'args' ][ 'type' ] ) { ?>
				<div class="l_admin-section-title l_admin-tiny l_admin-no-push-bottom">
					<div class="l_admin-media l_admin-image-left">
						<div class="l_admin-media-image l_admin-small">
							<img src="<?php echo get_template_directory_uri(); ?>/core/assets/images/thumb-layers-pro.png" alt="LayersPro" />
						</div>
						<div class="l_admin-media-body">
							<div class="l_admin-excerpt">
								<p><?php _e( 'Layers Pro unlocks customizability in the Layers framework.' , 'layerswp' ); ?></p>
								<ul class="l_admin-ticks-wp">
									<li><?php _e( 'Make the logo bigger' , 'layerswp' ); ?></li>
									<li><?php _e( 'Add video backgrounds' , 'layerswp' ); ?></li>
									<li><?php _e( 'Add parallax backgrounds' , 'layerswp' ); ?></li>
									<li><?php _e( 'Add a header background image' , 'layerswp' ); ?></li>
									<li><?php _e( 'Full button styling control' , 'layerswp' ); ?></li>
									<li><?php _e( 'New customization controls' , 'layerswp' ); ?></li>
									<li><?php _e( 'Get more control over your blog' , 'layerswp' ); ?></li>
									<li><?php _e( '4 new widgets' , 'layerswp' ); ?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="l_admin-button-well">
					<a href="https://www.layerswp.com/layers-pro/?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=WP%20Dashboard" target="_blank" class="button button-primary">
						<?php _e( 'Get Layers Pro' , 'layerswp' ); ?>
					</a>
					<a href="http://www.layerswp.com/layers-pro/?utm_source=layers%20theme&utm_medium=link&utm_campaign=Layers%20Pro%20Upsell&utm_content=WP%20Dashboard" target="_blank" class="button btn-link"><?php _e( 'Find Out More' , 'layerswp' ); ?></a>
				</div>
			<?php } ?>
			<?php if( 'upsell-storekit' == $args[ 'args' ][ 'type' ] ) { ?>
				<div class="l_admin-section-title l_admin-tiny l_admin-no-push-bottom">
					<div class="l_admin-media l_admin-image-left">
						<div class="l_admin-media-image l_admin-small">
							<img src="<?php echo get_template_directory_uri(); ?>/core/assets/images/thumb-storekit.png" alt="StoreKit" />
						</div>
						<div class="l_admin-media-body">
							<h3 class="l_admin-heading"><?php _e( 'Boost your sales with StoreKit!' , 'layerswp' ); ?></h3>
							<div class="l_admin-excerpt">
								<p><?php _e( 'Supercharge your WooCommerce store with the StoreKit plugin for Layers' , 'layerswp' ); ?></p>
								<ul class="l_admin-ticks-wp">
									<li><?php _e( 'Unique Product Slider' , 'layerswp' ); ?></li>
									<li><?php _e( 'Product List Widget' , 'layerswp' ); ?></li>
									<li><?php _e( 'Product Categories Widget' , 'layerswp' ); ?></li>
									<li><?php _e( 'Product Page Customization' , 'layerswp' ); ?></li>
									<li><?php _e( 'Shop Page Customization' , 'layerswp' ); ?></li>
									<li><?php _e( 'Menu Cart Customization' , 'layerswp' ); ?></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="l_admin-button-well">
					<a href="http://codecanyon.net/item/storekit-woocommerce-for-layers/11223808?ref=obox&utm_source=layers%20theme&utm_medium=link&utm_campaign=StoreKit%20Upsell&utm_content=Dashboard" target="_blank" class="button button-primary">
						<?php _e( 'Get StoreKit Now!' , 'layerswp' ); ?>
					</a>
				</div>
			<?php } ?>
		</div>
	<?php }

	public function enqueue_dashboard_scripts(){

		wp_enqueue_script( 'accordion' );

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-plugins-js'
		);
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

	public function enqueue_marketplace_scripts(){

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-marketplace' ,
			get_template_directory_uri() . '/core/assets/marketplace.js',
			array(
				'jquery',
			),
			LAYERS_VERSION
		); // Sticky-Kit

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

	// Add Preset Pages
	$add_new_page = add_submenu_page(
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
		$layers_pages = add_submenu_page(
			LAYERS_THEME_SLUG . '-dashboard',
			__( 'Layers Pages' , 'layerswp' ),
			__( 'Layers Pages' , 'layerswp' ),
			'edit_theme_options',
			'edit.php?post_type=page&filter=layers'
		);
	}

	// Customize
	$customize = add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Customize' , 'layerswp' ),
		__( 'Customize' , 'layerswp' ),
		'edit_theme_options',
		'customize.php'
	);

	// Get Started
	$get_started = add_submenu_page(
		LAYERS_THEME_SLUG . '-dashboard',
		__( 'Setup' , 'layerswp' ),
		__( 'Setup' , 'layerswp' ),
		'edit_theme_options',
		LAYERS_THEME_SLUG . '-get-started',
		'layers_options_panel_ui'
	);

	// This modifies the Layers submenu item - must be done here as $submenu
	// is only created if $submenu items are added using add_submenu_page
	if( isset( $submenu[ 'layers-dashboard' ] ) ) {
		$submenu[LAYERS_THEME_SLUG . '-dashboard'][0][0] = __( 'Dashboard' , 'layerswp' );
	}

	// Marketplace
	if( !defined( 'LAYERS_DISABLE_MARKETPLACE' ) ){
		// dashboard Page
		$marketplace = add_menu_page(
			__( 'Add Ons' , 'layerswp' ),
			__( 'Add Ons' , 'layerswp' ),
			'edit_theme_options',
			LAYERS_THEME_SLUG . '-marketplace',
			'layers_options_panel_ui',
			'none',
			4
		);

		add_action('admin_print_scripts-' . $marketplace, array( $layers_options_panel, 'enqueue_marketplace_scripts') );

		$marketplace_envato = add_submenu_page(
			LAYERS_THEME_SLUG . '-marketplace',
			__( 'Envato Marketplace' , 'layerswp' ),
			__( 'Envato Marketplace' , 'layerswp' ),
			'edit_theme_options',
			LAYERS_THEME_SLUG . '-envato-marketplace',
			'layers_options_panel_ui'
		);

		add_action('admin_print_scripts-' . $marketplace_envato, array( $layers_options_panel, 'enqueue_marketplace_scripts') );

		// This modifies the Layers submenu item - must be done here as $submenu
		// is only created if $submenu items are added using add_submenu_page

		if( isset( $submenu[ 'layers-marketplace' ] ) ) {
			$submenu[LAYERS_THEME_SLUG . '-marketplace'][0][0] = __( 'Official' , 'layerswp' );
		}

	}
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