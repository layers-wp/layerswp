<?php /**
 * Customizer Initiation File
 *
 * This file is the source of the Customizer functionality in Layers.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer {

	private static $instance; // stores singleton class

    /**
    *  Get Instance creates a singleton class that's cached to stop duplicate instances
    */
    public static function get_instance() {
        if ( ! self::$instance ) {
            self::$instance = new self();
            self::$instance->init();
        }
        return self::$instance;
    }

    /**
    *  Construct empty on purpose
    */

    private function __construct() {}

    /**
    *  Init behaves like, and replaces, construct
    */

    public function init() {

		global $wp_customize;

		// Setup some folder variables
		$customizer_dir = '/core/customizer/';
		$controls_dir = '/core/customizer/controls/';

		// Include Config file(s)
		require_once get_template_directory() . $customizer_dir . 'config.php';
		// Include The Default Settings Class
		require_once get_template_directory() . $customizer_dir . 'defaults.php';

		if( isset( $wp_customize ) ) {
			
			// Include The Panel and Section Registration Class
			require_once get_template_directory() . $customizer_dir . 'registration.php';

			// Include control classes
			require_once get_template_directory() . $controls_dir . 'base.php';
			require_once get_template_directory() . $controls_dir . 'button.php';
			require_once get_template_directory() . $controls_dir . 'checkbox.php';
			require_once get_template_directory() . $controls_dir . 'code.php';
			require_once get_template_directory() . $controls_dir . 'color.php';
			require_once get_template_directory() . $controls_dir . 'font.php';
			require_once get_template_directory() . $controls_dir . 'heading.php';
			require_once get_template_directory() . $controls_dir . 'number.php';
			require_once get_template_directory() . $controls_dir . 'range.php';
			require_once get_template_directory() . $controls_dir . 'select.php';
			require_once get_template_directory() . $controls_dir . 'select-icons.php';
			require_once get_template_directory() . $controls_dir . 'select-images.php';
			require_once get_template_directory() . $controls_dir . 'seperator.php';
			require_once get_template_directory() . $controls_dir . 'rte.php';
			require_once get_template_directory() . $controls_dir . 'text.php';
			require_once get_template_directory() . $controls_dir . 'textarea.php';
			require_once get_template_directory() . $controls_dir . 'trbl.php';

			// Enqueue Styles
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
			add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );
			add_action( 'customize_preview_init', array( $this, 'customizer_preview_enqueue_scripts' ) );

			// Render layers customizer menu
			add_action( 'customize_controls_print_footer_scripts' , array( $this, 'render_customizer_menu' ) );
			
			// Advanced Active Callback functionality - disabled
			add_filter( 'customize_control_active', array( $this, 'customize_active_controls' ), 10, 2 );
		}
	}

	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){

		// Hover Intent
		wp_enqueue_script( 'hoverIntent' );

		// Media Uploader required scripts
		wp_enqueue_media();

		// Customizer general
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-customizer' ,
			get_template_directory_uri() . '/core/customizer/js/customizer.js' ,
			array(
				'customize-controls',
				'wp-color-picker'
			),
			LAYERS_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-customizer' , 'layers_customizer_params', array(
				'nonce' => wp_create_nonce( 'layers-customizer-actions' ),
				'builder_page' => ( isset( $_GET[ 'layers-builder' ] ) ? TRUE : FALSE ),
				'enable_deep_linking' => ( get_theme_mod( 'layers-dev-switch-customizer-state-record' ) ),
			)
		);
	}

	/**
	*  Enqueue Customizer Preview Scripts
	*/

	public function customizer_preview_enqueue_scripts(){

		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-customizer-preview',
			get_template_directory_uri() . '/core/customizer/js/customizer-preview.js',
			array( 'customize-preview-widgets' ),
			LAYERS_VERSION
		);

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin-customizer-preview',
			get_template_directory_uri() . '/core/customizer/css/customizer-preview.css',
			array(),
			LAYERS_VERSION
		);
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){

		wp_enqueue_style(
			LAYERS_THEME_SLUG . '-admin-customizer',
			get_template_directory_uri() . '/core/customizer/css/customizer.css',
			array(),
			LAYERS_VERSION
		);
	}

	/**
	*  Render the dropdown of builder pages in Customizer interface.
	*/

	public function render_builder_page_dropdown(){
		global $wp_customize;

		if(!$wp_customize) return;

		//Get builder pages.
		$layers_pages = layers_get_builder_pages();

		// Create builder pages dropdown.
		if( $layers_pages ){
			ob_start(); ?>
			<div class="layers-customizer-pages-dropdown">
				<select>
					<option value="init"><?php _e( 'Builder Pages:' , 'layerswp' ) ?></option>
					<?php foreach( $layers_pages as $page ) { ?>
						<?php // Page URL
						$edit_page_url = get_permalink( $page->ID ); ?>
						<option value="<?php echo esc_attr( $edit_page_url ); ?>"><?php echo $page->post_title ?></option>
					<?php } ?>
				</select>
			</div>
			<?php
			// Get the Drop Down HTML
			$drop_down = ob_get_clean();

			// Return the Drop Down
			return $drop_down;
		}
	}

	function render_customizer_menu() {
		?>
		<div id="customize-controls-layers-actions">

			<ul class="layers-customizer-nav">
				<li>
					<span class="customize-controls-layers-button customize-controls-layers-button-dashboard-main" title="<?php esc_html( _e( 'Layers Dashboard' , 'layerswp' ) ) ?>" href="<?php echo admin_url( 'admin.php?page=layers-add-new-page' ); ?>"></span>
					<ul>
						<?php
						// Construct the Layers Customizer Menu
						$layers_customizer_menu = array(
							'preview' => array(
								'text'			=> __( 'View this page' , 'layerswp' ),
								'link'			=> '#',
								'icon_class'	=> 'icon-display',
								'target'		=> '_blank',
							),
							'add-new-page' => array(
								'text'			=> __( 'Add new Layers page' , 'layerswp' ),
								'link'			=> admin_url( 'admin.php?page=layers-add-new-page' ),
								'icon_class'	=> 'dashicons dashicons-plus',
							),
							'dashboard' => array(
								'text'			=> __( 'Layers Dashboard' , 'layerswp' ),
								'link'			=> admin_url( 'admin.php?page=layers-dashboard' ),
								'icon_class'	=> 'layers-button-icon-dashboard',
							),
						);

						// Filter the Layers Customizer Menu
						$layers_customizer_menu = apply_filters( 'layers_customizer_menu', $layers_customizer_menu );

						// Render the Layers Customizer Menu
						foreach ( $layers_customizer_menu as $id => $args ) {

							$text = ( isset( $args['text'] ) && '' !== trim( $args['text'] ) ) ? esc_html( $args['text'] ) : '' ;
							$icon_class = ( isset( $args['icon_class'] ) && '' !== trim( $args['icon_class'] ) ) ? esc_attr( $args['icon_class'] ) : '' ;
							$href = ( isset( $args['link'] ) && '' !== trim( $args['link'] ) ) ? 'href="' . esc_url( $args['link'] ) . '"' : '' ;
							$target = ( isset( $args['target'] ) && '' !== trim( $args['target'] ) ) ? 'target="' . esc_attr( $args['target'] ) . '"' : '' ;
							?>
							<li>
								<a class="customize-controls-layers-button customize-controls-layers-button-<?php echo esc_attr( $id ); ?>" <?php echo $href; ?> <?php echo $target; ?> >
									<i class="<?php echo $icon_class ?>"></i><?php echo $text ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</li>
			</ul>

		</div>
		<?php
	}

	// Advanced Active Callback functionality - for Dev Switches
	function customize_active_controls( $arg1, $arg2 ) {
		
		if ( isset( $arg2->id ) && 0 === strpos( $arg2->id, 'layers-dev-switch' ) ) {
			return ( ( bool ) get_theme_mod( 'layers-dev-switch-active' ) );
		}
		
		return $arg1;
	}

}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function layers_customizer_init(){
	$layers_widget = Layers_Customizer::get_instance();
}
add_action( 'customize_register' , 'layers_customizer_init' , 50 );
add_action( 'init' , 'layers_customizer_init');