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
	var $custom_meta;

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
		$meta_dir = '/core/meta/';

		// Include widget control classes

		// Include Config file(s)
		locate_template( $meta_dir . 'config.php' , true );


		// Instantiate meta config class
		$meta_config = new Hatch_Meta_Config();

		// Get post meta
		$this->custom_meta = $meta_config->meta_data();

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) , 50 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_print_styles' ) , 50 );

		// Page Builder Button
		add_action( 'edit_form_after_title', array( $this , 'page_builder_button' ) );
		add_action( 'wp_ajax_update_page_builder_meta' , array( $this , 'update_page_builder_meta' ) );

		// Custom Fields
		add_action( 'admin_menu', array( $this , 'register_post_meta' ) );
		add_action( 'save_post', array( $this , 'save_post_meta' ) );
		add_action( 'publish_post', array( $this , 'save_post_meta' ) );
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
		if ( 'post.php' === $pagenow &&  ( HATCH_BUILDER_TEMPLATE == basename( get_page_template() ) ) ) : ?>
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

		// Get the Post ID
		$post_id = $_POST['id'];

		if( isset($_POST[ 'template' ] ) && 'builder.php' == $_POST[ 'template' ] ){
			update_post_meta( $post_id , '_wp_page_template', $_POST[ 'template' ] );
		} else {
			delete_post_meta( $post_id , '_wp_page_template' );
		}
		die();
	}

	/**
	* Custom Meta Register
	*/

	public function register_post_meta(){
		// If we have not published the post, don't set a post ID
		if( isset( $_REQUEST[ 'post' ] ) ) {
			$post_id = $_REQUEST[ 'post' ];
		} else {
			$post_id = NULL;
		}

		// Loop over the custom meta
		foreach( $this->custom_meta as $meta_index => $custom_meta ){

			// If there is Post Meta,  register the metabox
			if( isset( $this->custom_meta[ $meta_index ] ) ){

				if( post_type_exists( $meta_index ) ) {
					$post_type = $meta_index;
					$callback_args = array(
						'meta_index' =>$meta_index
					);
				} else {
					// Set the post type
					$post_type = 'page';

					// Get the page template
					$page_template = get_post_meta( $post_id, '_wp_page_template' , true );

					// If there is no page template set, just return
					if( '' == $page_template ) return;
					// Now check to see that we've selected the right page template
					if( $meta_index != $page_template) return;

					$callback_args = array(
						'meta_index' => $meta_index
					);
				}

				add_meta_box(
						HATCH_THEME_SLUG . '-' . $meta_index, // Slug
						$custom_meta[ 'title' ], // Title
						array( $this , 'display_post_meta' ) , // Interface
						$post_type , // Post Type
						$custom_meta[ 'position' ], // Position
						'high', // Priority
						$callback_args // Callback args
					);
			}
		}
	}

	/**
	* Custom Meta Interface
	*/

	public function display_post_meta( $post , $callback_args ){

		// Get post type
		$post_type = get_post_type( $post->ID );

		// Post Meta Value
		$post_meta = get_post_meta( $post->ID, HATCH_THEME_SLUG . '-' . $post_type . '-meta' , true );

		// Debug
		// echo '<pre>' . print_r( $post_meta , true ) . '</pre>';

		// Set the meta index ie. the array we will loop over for our options
		$meta_index =$callback_args[ 'args' ][ 'meta_index' ];

		// Instantiate form elements
		$form_elements = new Hatch_Form_Elements();

		// If there is Post Meta, loop over the tabs.
		if( isset( $this->custom_meta[ $meta_index ] ) ){ ?>
			<div class="hatch-nav hatch-nav-tabs">
				<ul class="hatch-tabs">
					<?php foreach( $this->custom_meta[ $meta_index ]['custom-meta'] as $key => $meta_option ){ ?>
						<li <?php if( !isset( $inactive ) ) echo 'class="active"'; ?>><a href="#"><?php echo $meta_option[ 'title' ]; ?></a></li>
						<?php $inactive=1; ?>
					<?php } // foreach $this->custom_meta[ $post_type ]['custom-meta']  ?>
				</ul>
			</div>
			<div class="hatch-tab-content">
				<?php foreach( $this->custom_meta[ $meta_index ]['custom-meta'] as $key => $meta_option ){ ?>
					<section class="hatch-accordion-section hatch-content <?php if( isset( $hide_tab ) ) echo 'hatch-hide'; ?> customize-control"> <?php // @TODO: Remove .customizer-control class ?>
						<div class="hatch-row clearfix">
							<?php if( isset( $meta_option[ 'elements' ] ) ) { ?>
								<fieldset>
									<?php foreach( $meta_option[ 'elements' ] as $input_key => $input ) { ?>
										<p class="hatch-form-item">
											<label><?php echo $input[ 'label' ]; ?></label>
											<?php  echo $form_elements->input(
												array(
													'type' => $input[ 'type' ],
													'name' => HATCH_THEME_SLUG . '-' . $post_type . '[' . $input_key . ']',
													'id' => $input_key ,
													'default' => ( isset( $input[ 'default' ] ) ) ? $input[ 'default' ] : NULL ,
													'placeholder' => ( isset( $input[ 'placeholder' ] ) ) ? $input[ 'placeholder' ] : NULL ,
													'value' => ( isset( $post_meta[ $input_key ] ) ) ? $post_meta[ $input_key ] : ( ( isset( $input[ 'default' ] ) ) ? $input[ 'default' ] : NULL ), // Check for a value, then check for a default, then finally settle on NULL
													'options' =>  ( isset( $input[ 'options' ] ) ) ? $input[ 'options' ] : NULL,
													'class' => 'hatch-' . $input[ 'type' ]

												)
											); ?>
										</p>
									<?php } // foreach $meta_option[ 'elements' ] ?>
								</fieldset>
							<?php } // if $meta_option[ 'elements' ] ?>
						</div>
					</section>
					<?php $hide_tab = 1; ?>
				<?php } // foreach $this->custom_meta[ $post_type ]['custom-meta'] ?>
			</div>
			<?php wp_nonce_field( HATCH_THEME_SLUG . '-post-meta' , '_wp_nonce_' . HATCH_THEME_SLUG ); ?>
		<?php } // if $this->custom_meta[ $post_type ] ?>
	<?php }

	/**
	* Custom Meta Interface
	*/

	public function save_post_meta( $post_id ){
		global $post;

		// Get post type
		$post_type = get_post_type( $post_id );

		// Verify our nonce
		$nonce = $_REQUEST[ '_wp_nonce_' . HATCH_THEME_SLUG ];

		// Form key
		$form_key = HATCH_THEME_SLUG . '-' . $post_type;

		if ( wp_verify_nonce( $nonce, HATCH_THEME_SLUG . '-post-meta' ) ) {
			if( isset( $_REQUEST[ $form_key ] ) ) {
				update_post_meta( $post_id, HATCH_THEME_SLUG . '-' . $post_type . '-meta' , $_REQUEST[ $form_key ] );
			} // if isset( $this->custom_meta[ $post_type ] )
		} // if nonce
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