<?php  /**
 * Layers Intercom Class
 *
 * This file is used to run Layers / Obox API Calls
 *
 * @package Layers
 * @since Layers 1.2.6
 */

class Layers_Intercom {

	private static $instance;

	private $app_id = 'zcu2bmlm';

	private $secret_key = 'rhf7tY0Fux4E8Kqx6Vd6omvZBq3oFjDn2KIMgGso';

	function __construct(){

		global $wp_customize;

		if( '1' !== get_option( 'layers_enable_intercom' ) || isset( $wp_customize ) )
			return;

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );

		add_action( 'customize_controls_print_footer_scripts', array( $this, 'intercom_js' ) );
		add_action( 'admin_footer', array( $this, 'intercom_js' ) );

	}

	function admin_enqueue_scripts(){

		if( !is_admin() ) return;

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-intercom' ,
			get_template_directory_uri() . '/core/assets/intercom.js',
			array(
				'jquery',
			),
			LAYERS_VERSION
		); // Intercom JS

	}

	function intercom_js(){
		global $current_user, $wpdb, $wp_version, $wp_customize;

		// Don't load in the customizer, or if we're not logged in; don't even try it.
		if( !is_user_logged_in() || !is_admin() )
			return;

		// Get current user info
		get_currentuserinfo();

		/**
		 * Basic Intercom settings
		 */
		$json[ 'app_id' ] = $this->app_id;
		$json[ 'user_hash' ] = (string) hash_hmac(
			'sha256',
			$current_user->user_email,
			$this->secret_key
		);
		/**
		 * User centric data
		 */
		$json[ 'email' ] = (string) $current_user->user_email;
		$json[ 'name' ] = (string) $current_user->display_name;
		$json[ 'created_at' ] = strtotime( $current_user->user_registered );
		$json[ 'company' ] = strtotime( get_bloginfo( 'name' ) );


		/**
		 * Child theme information
		 */

		$this->theme = wp_get_theme();

		if( 'layerswp' != $this->theme->get( 'TextDomain' ) ){
			$json[ 'Theme' ] = (string) $this->theme->get( 'Name' );
			$json[ 'Theme Author' ] = (string) $this->theme->get( 'Author' );
			$json[ 'Theme Author URL' ] = (string) $this->theme->get( 'AuthorURI' );
		}

		/**
		 * Layers specific data
		 */

		$this->layers_theme = wp_get_theme( 'layerswp' );

		$json[ 'WordPress Version' ] = $wp_version;
		$json[ 'Layers Version' ] = $this->layers_theme->get( 'Version' );
		$json[ 'Layers Page Count' ] = (float) count( layers_get_builder_pages() );

		/**
		 * Website URL
		 */

		$json[ 'Website URL' ] = (string) get_home_url();

		/**
		 * Important plugins
		 */

		$json[ 'Easy Digital Downloads' ] = (bool) ( class_exists( 'Easy_Digital_Downloads' ) ? 1 : 0 );
		$json[ 'WooCommerce' ] = (bool) ( class_exists( 'WooCommerce' ) ? 1 : 0 );
		$json[ 'Layers Updater' ] = (bool) ( class_exists( 'Layers_Updater' ) || is_plugin_active_for_network( 'Layers_Updater') ? 1 : 0 );

		if( class_exists( 'Layers_DevKit' ) && defined( 'LAYERS_DEVKIT_VER' ) ) {
			$json[ 'DevKit' ] = LAYERS_DEVKIT_VER;
		}

		if( class_exists( 'Layers_ColorKit' ) && defined( 'LAYERS_COLORKIT_VER' ) ) {
			$json[ 'ColorKit' ] = LAYERS_COLORKIT_VER;
		}

		if( class_exists( 'Layers_WooCommerce' ) && defined( 'LAYERS_STOREKIT_VER' ) ) {
			$json[ 'StoreKit' ] = LAYERS_STOREKIT_VER;
		}

		if( class_exists( 'Layers_Pro' ) && defined( 'LAYERS_PRO_VER' ) ) {
			$json[ 'Layers Pro' ] = LAYERS_PRO_VER;
		}

		if( get_option( 'info_site_usage' ) ) {
			$json[ 'Site Category' ] = get_option( 'info_site_usage' );
		}

		$json[ 'Launchpad' ] = ( class_exists( 'apollo_launchpad' ) ? 1 : 0 );

		$launchpad = get_option( 'apollo_display_options' );
		if( isset( $launchpad['launchdate'] ) ){
			$json[ 'launched_at' ] = strtotime( $launchpad['launchdate'] );
		}

		// jsonify the settings
		$settings_json = json_encode( (object) $json, ( defined( 'JSON_PRETTY_PRINT' ) ? JSON_PRETTY_PRINT : TRUE ) ); ?>

		<script>window.intercomSettings = <?php echo $settings_json; ?>;</script>

		<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/<?php echo $this->app_id; ?>';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
	<?php }
}

/**
*  Kicking this off with the 'admin_init' hook
*/

function layers_intercom_init(){
	$layers_intercom = new Layers_Intercom;
}

add_action( 'admin_init', 'layers_intercom_init' );