<?php /**
 * Customizer Initiation File
 *
 * This file is the source of the Customizer functionality in Hatch.
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Customizer {

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

		// Include control classes
		locate_template( $controls_dir . 'heading.php' , true );
		locate_template( $controls_dir . 'select-icons.php' , true );
		locate_template( $controls_dir . 'select-images.php' , true );
		locate_template( $controls_dir . 'seperator.php' , true );

		// Include Config file(s)
		locate_template( $customizer_dir . 'config.php' , true );

		// Include The Panel and Section Registration Class
		locate_template( $customizer_dir . 'registration.php' , true );

		// If we are in a builder page, update the Widgets title
		if(
			isset( $_GET[ 'hatch-builder' ] )
			|| ( 0 != get_option( 'page_on_front' )  && HATCH_BUILDER_TEMPLATE == get_post_meta ( get_option( 'page_on_front' ) , '_wp_page_template' , true ) )
		) {
			$wp_customize->add_panel(
				'widgets', array(
					'priority' => 10,
					'title' => __('Hatch: Page Builder', HATCH_THEME_SLUG ),
					'description' => $this->render_builder_page_dropdown() . __('Use this area to add widgets to your page, use the (Hatch) widgets for the Body section.', HATCH_THEME_SLUG ),
				)
			);
		}

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
		add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );
		
		// Render header actions button(s)
		add_action( 'customize_controls_print_footer_scripts' , array( $this, 'render_actions_buttons' ) );
	}

	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){
		
		// Media Uploader required scripts
		wp_enqueue_media();

		// Customizer general
		wp_enqueue_script(
			HATCH_THEME_SLUG . '-admin-customizer' ,
			get_template_directory_uri() . '/core/customizer/js/customizer.js' ,
			array(
				'backbone',
				'jquery',
				'wp-color-picker'
			),
			HATCH_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script( HATCH_THEME_SLUG . '-admin-customizer' , "hatch_customizer_params", array(
									'ajaxurl' => admin_url( "admin-ajax.php" ) ,
									'nonce' => wp_create_nonce( 'hatch-customizer-actions' ),
									'builder_page' => ( isset( $_GET[ 'hatch-builder' ] ) ? TRUE : FALSE )
								)
							);
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){

		// Widget styles
		wp_register_style(
			HATCH_THEME_SLUG . '-admin-customizer',
			get_template_directory_uri() . '/core/customizer/css/customizer.css',
			array(),
			HATCH_VERSION
		);
		wp_enqueue_style( HATCH_THEME_SLUG . '-admin-customizer' );
	}

	/**
	*  Render the dropdown of builder pages in Customizer interface.
	*/

	public function render_builder_page_dropdown(){
		global $wp_customize;

		if(!$wp_customize) return;

		//Get builder pages.
		$hatch_pages = hatch_get_builder_pages();

		// Create builder pages dropdown.
		if( $hatch_pages ){
			ob_start();
			
			// Get the base of the customizer URL
			$customizer_url = explode( 'customize.php?', $_SERVER['REQUEST_URI'] );
			
			$current_page_url = "";
			
			// Check if there is a query string
			if ( isset( $customizer_url[1] ) ) {
				
				// Parse the URL
				parse_str( $customizer_url[1], $customizer_url_portions );
				
				// Check if there is query string 'url'
				if( isset( $customizer_url_portions[ 'url' ] ) ) {
					$current_page_url = $customizer_url_portions[ 'url' ];
				}
				
			} ?>
			<div class="hatch-customizer-pages-dropdown">
				<select>
					<option value="init"><?php _e( 'Builder Pages:', HATCH_THEME_SLUG ) ?></option>
					<?php foreach( $hatch_pages as $page ) { ?>
						<?php // Page URL
						$edit_page_url = get_permalink( $page->ID ); ?>

						<option value="<?php echo esc_attr( $edit_page_url ); ?>" <?php echo ( $edit_page_url == $current_page_url ) ? 'selected="selected"' : '' ; ?> ><?php echo $page->post_title ?></option>
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
	
	function render_actions_buttons () {
		$hatch_url = admin_url( 'admin.php?page=' . HATCH_THEME_SLUG . '-welcome' );
		?>
		<a class="customize-controls-hatch-dashboard dashicons dashicons-smiley" title="<?php esc_attr( _e( 'Hatch Dashboard', HATCH_THEME_SLUG ) ); ?>" href="<?php echo $hatch_url ?>"></a>
		<?php
	}

}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function hatch_customizer_init(){
	$hatch_widget = new Hatch_Customizer();
	$hatch_widget->init();
}
add_action( 'customize_register' , 'hatch_customizer_init' , 50 );