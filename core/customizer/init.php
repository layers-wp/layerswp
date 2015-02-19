<?php /**
 * Customizer Initiation File
 *
 * This file is the source of the Customizer functionality in Layers.
 *
 * @package Layers
 * @since Layers 1.0.0
 */

class Layers_Customizer {

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
			require_once get_template_directory() . $controls_dir . 'heading.php';
			require_once get_template_directory() . $controls_dir . 'select.php';
			require_once get_template_directory() . $controls_dir . 'select-icons.php';
			require_once get_template_directory() . $controls_dir . 'select-images.php';
			require_once get_template_directory() . $controls_dir . 'seperator.php';
			require_once get_template_directory() . $controls_dir . 'font.php';
			require_once get_template_directory() . $controls_dir . 'color.php';
			require_once get_template_directory() . $controls_dir . 'checkbox.php';
			require_once get_template_directory() . $controls_dir . 'css.php';
			require_once get_template_directory() . $controls_dir . 'button.php';

			// If we are in a builder page, update the Widgets title
			$wp_customize->add_panel(
				'widgets', array(
					'priority' => 0,
					'title' => __('Edit Layout' , 'layerswp' ),
					'description' => $this->render_builder_page_dropdown() . __('Use this area to add widgets to your page, use the (Layers) widgets for the Body section.' , 'layerswp' ),
				)
			);

			// Enqueue Styles
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
			add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );

			// Render header actions button(s)
			add_action( 'customize_controls_print_footer_scripts' , array( $this, 'render_actions_buttons' ) );
		}
	}

	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){

		// Media Uploader required scripts
		wp_enqueue_media();

		// Customizer general
		wp_enqueue_script(
			LAYERS_THEME_SLUG . '-admin-customizer' ,
			get_template_directory_uri() . '/core/customizer/js/customizer.js' ,
			array(
				'backbone',
				'jquery',
				'wp-color-picker'
			),
			LAYERS_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script( LAYERS_THEME_SLUG . '-admin-customizer' , "layers_customizer_params", array(
									'ajaxurl' => admin_url( "admin-ajax.php" ) ,
									'nonce' => wp_create_nonce( 'layers-customizer-actions' ),
									'builder_page' => ( isset( $_GET[ 'layers-builder' ] ) ? TRUE : FALSE )
								)
							);
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){

		// Widget styles
		wp_register_style(
			LAYERS_THEME_SLUG . '-admin-customizer',
			get_template_directory_uri() . '/core/customizer/css/customizer.css',
			array(),
			LAYERS_VERSION
		);
		wp_enqueue_style( LAYERS_THEME_SLUG . '-admin-customizer' );
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

	function render_actions_buttons() { ?>

			<a class="customize-controls-layers-button customize-controls-layers-button-dashboard dashicons dashicons-plus layers-tooltip" href="<?php echo admin_url( 'admin.php?page=layers-add-new-page' ); ?>">
				<span class="layers-tooltip-text layers-tooltip-text-large"><?php _e( 'Add new Layers page' , 'layerswp' ) ?></span>
			</a>
			<a class="customize-controls-layers-button customize-controls-layers-button-preview icon-display layers-tooltip" href="#" target="_blank">
				<span class="layers-tooltip-text"><?php _e( 'Preview this page' , 'layerswp' ) ?></span>
			</a>

			<span class="layers-tooltip-text layers-tooltip-text-close layers-tooltip-text-tiny">
				<?php _e( 'Close' , 'layerswp' ) ?>
			</span>
			<span class="layers-tooltip-text layers-tooltip-text-back">
				<?php _e( 'Back to controls' , 'layerswp' ) ?>
			</span>

		<?php
	}

}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function layers_customizer_init(){
	$layers_widget = new Layers_Customizer();
	$layers_widget->init();
}
add_action( 'customize_register' , 'layers_customizer_init' , 50 );
add_action( 'init' , 'layers_customizer_init');