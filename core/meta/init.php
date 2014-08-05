<?php /**
 * Post & Page Meta Initiation File
 *
 * This file is the source of the Custom Meta in the Hatch theme
 *
 * @package Hatch
 * @since Hatch 1.0
 */

class Hatch_Custom_Meta {

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
		$meta_dir = HATCH_TEMPLATE_DIR . '/core/meta/';

		// Include widget control classes

		// Include Config file(s)
		require $meta_dir . 'config.php';

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );
		add_action( 'customize_controls_print_styles' , array( $this, 'admin_print_styles' ) );

		// Page Builder Button
		add_action( 'edit_form_after_title', array( $this , 'page_builder_button' ) );
		add_action( 'wp_ajax_update_page_builder_meta' , array( $this , 'update_page_builder_meta' ) );

	}

	/**
	*  Enqueue Widget Scripts
	*/

	public function admin_enqueue_scripts(){

		// Customizer general
		wp_enqueue_script(
			HATCH_THEME_SLUG . '-admin-meta' ,
			get_template_directory_uri() . '/core/meta/js/meta.js' ,
			array(
				'backbone',
				'jquery',
				'wp-color-picker'
			),
			HATCH_VERSION,
			true
		);

		// Localize Scripts
		wp_localize_script( HATCH_THEME_SLUG . '-admin-meta' , "hatch_meta_params", array( 'ajaxurl' => admin_url( "admin-ajax.php" ) , 'nonce' => wp_create_nonce( 'hatch-customizer-actions' ) ) );
	}

	/**
	*  Enqueue Widget Styles
	*/

	public function admin_print_styles(){
		global $pagenow;
		if ( 'post.php' === $pagenow &&  ( 'builder.php' == basename( get_page_template() ) ) ) : ?>
			<style> #postdivrich { display: none; }</style>
		<?php endif; ?>
	<?php }

	/**
	* Page Builder Button
	*/

	public function page_builder_button(){
		global $post;

		// This button is only used for pages
		if ( !in_array( $post->post_type, array( 'page' ) ) || 'publish' != get_post_status() ) return;

		// Check if we're using the builder for this page
		$is_builder_used = ( 'builder.php' == basename( get_page_template() ) ) ? true : false;

		printf( '<div id="hatch_toggle_builder" class="updated below-h2">
				<p>%1$s</p>
				<a href="%2$s" class="button button-primary button-large  %3$s">%4$s</a>
			</div>',
			'Use the Hatch Page Builder to create your page', // %1
			admin_url() . 'customize.php?url=' . esc_url( get_the_permalink() ) . '&hatch-builder=1', // %2
			( true == $is_builder_used ? '' : 'hide' ), // %3
			__( 'Build Your Page', HATCH_THEME_SLUG ) // %4
		);
	}

	/**
	* Page Builder Meta Update
	*/
	public function update_page_builder_meta(){
		$post_id = $_POST['id'];
		if( isset($_POST[ 'template' ] ) && 'builder.php' == $_POST[ 'template' ] ){
			update_post_meta( $post_id , '_wp_page_template', $_POST[ 'template' ] );
		} else {
			delete_post_meta( $post_id , '_wp_page_template' );
		}
		die();
	}
}

/**
*  Kicking this off with the 'widgets_init' hook
*/

function hatch_custom_meta_init(){
	$hatch_widget = new Hatch_Custom_Meta();
	$hatch_widget->init();
}
add_action( 'init' , 'hatch_custom_meta_init' , 10 );