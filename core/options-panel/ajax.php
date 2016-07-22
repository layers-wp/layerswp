<?php  /**
 * Widget Ajax
 *
 * This file is used to fetch, using Ajax, and display different parts of the layers widgets
 *
 * @package Layers
 * @since Layers 1.0.0
 */

if( !class_exists( 'Layers_Onboarding_Ajax' ) ) {

	class Layers_Onboarding_Ajax {

		private static $instance;

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
		}

		public function init() {
			add_action( 'wp_ajax_layers_update_intercom', array( $this, 'update_intercom' ) );
			add_action( 'wp_ajax_layers_onboarding_update_options', array( $this, 'update_options' ) );
			add_action( 'wp_ajax_layers_onboarding_create_pages', array( $this, 'create_pages' ) );
			add_action( 'wp_ajax_layers_onboarding_set_theme_mods', array( $this, 'set_theme_mods' ) );
			add_action( 'wp_ajax_layers_site_setup_step_dismissal', array( $this, 'dismiss_setup_step' ) );
			add_action( 'wp_ajax_layers_dashboard_load_feed', array( $this, 'load_feed' ) );


		}

		public function load_feed(){

			if( !check_ajax_referer( 'layers-dashboard-feed', 'layers_dashboard_feed_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			$type = ( isset( $_POST[ 'feed' ] ) ? $_POST[ 'feed' ] : 'news' );
			$count = ( isset( $_POST[ 'count' ] ) ? $_POST[ 'count' ] : 5 );

			if( NULL == $type ) die( json_encode( array( 'success' => false, 'message' => __( 'No feed specified' , 'layerswp' ) ) ) );

			if( 'news' == $type ) {
				$feed_url = 'http://blog.oboxthemes.com/tag/layers/feed/';
			} else if( 'docs' == $type ) {
				$feed_url = 'http://docs.layerswp.com/keywords/layers-dashboard/feed/';
			}

			$feed = fetch_feed( $feed_url );

			if( is_wp_error( $feed ) ) {
				return false;
			} else {
				$feed_items = $feed->get_items( 0, $count );

				ob_start();

				foreach( $feed_items as $item ){ ?>
					<?php if( 'news' == $type ) { ?>
						<div class="l_admin-column l_admin-span-3 l_admin-panel">
							<div class="l_admin-content">
								<div class="l_admin-section-title l_admin-tiny">
									<h4 class="l_admin-heading"><a href="<?php echo $item->get_permalink(); ?>"><?php echo esc_attr( $item->get_title() ); ?></a></h4>
								</div>
								<div class="l_admin-excerpt">
									<?php echo $item->get_description(); ?>
								</div>
							</div>
							<div class="l_admin-button-well">
								<a href="<?php echo $item->get_permalink(); ?>" class="button" target="_blank">
									<?php _e( 'Continue Reading' , 'layerswp' ); ?>
								</a>
							</div>
						</div>
					<?php } else if( 'docs' == $type ) { ?>
						<li>
							<a class="l_admin-page-list-title" target="_blank" href="<?php echo $item->get_permalink(); ?>"><?php echo esc_attr( $item->get_title() ); ?></a>
						</li>
					<?php } ?>
				<?php }

				$feed_html = trim( ob_get_clean() );

				die( json_encode( array( 'success' => true, 'feed' => $feed_html ) ) );
			}

		}

		public function dismiss_setup_step( $step_key = NULL, $skip_nonce = FALSE, $send_json = TRUE ){

			if( !$skip_nonce && !check_ajax_referer( 'layers-dashboard-dismiss-setup-step', 'layers_dashboard_dismiss_setup_step_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce


			if( NULL == $step_key ) {
				if( isset( $_POST[ 'setup_step_key' ] ) ) {
					$step_key = $_POST[ 'setup_step_key' ];
				}
			}

			if( NULL == $step_key ) die( json_encode( array( 'success' => false, 'message' => __( 'No setup step defined' , 'layerswp' ) ) ) );

			$dismissed_setup_steps = get_option( 'layers_dismissed_setup_steps' );

			$dismissed_setup_steps[] = $step_key;

			update_option( 'layers_dismissed_setup_steps', $dismissed_setup_steps );

			if( $send_json ) {
				die( json_encode( array( 'success' => true, 'message' => __( 'Setup step dismissed' , 'layerswp' ) ) ) );
			}
		}

		public function set_theme_mods(){

			if( !check_ajax_referer( 'layers-onboarding-set-theme-mods', 'layers_set_theme_mod_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			// Parse our input data
			parse_str(
				urldecode( stripslashes( $_POST[ 'data' ] ) ),
				$data
			);

			if( isset( $_POST[ 'setup_step_key' ] ) ) {
				$this->dismiss_setup_step( $_POST[ 'setup_step_key' ], TRUE, FALSE );
			}

			foreach ( $data as $option_key => $option_value ) {

				$clean_option_value = esc_attr( stripslashes( $option_value ) );

				switch ( $option_key ) {
					default :
						set_theme_mod( $option_key, $clean_option_value );

						die( json_encode( array( 'success' => true, 'message' => __( 'Theme Mod updated' , 'layerswp' ) ) ) );
					break;
				}
			}

		}

		public function update_intercom() {

			if( !check_ajax_referer( 'layers-onboarding-update-options', 'layers_onboarding_update_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			// Parse our input data
			parse_str(
				urldecode( stripslashes( $_POST[ 'data' ] ) ),
				$data
			);

			if( isset( $data[ 'username' ] ) ){
				global $current_user;

				$user = new stdClass();
				$user->ID = (int) get_current_user_id();
				$user->display_name = $data[ 'username' ];

				wp_update_user( $user ) ;
			}
			if( isset( $data[ 'layers_intercom' ] ) ){
				update_option( 'layers_enable_intercom' , '1' );
			} else{
				update_option( 'layers_enable_intercom' , '0' );
			}

			die( json_encode( array( 'success' => true, 'message' => __( 'Intercom Updated' , 'layerswp' ) ) ) );

		}

		public function update_options(){

			if( !check_ajax_referer( 'layers-onboarding-update-options', 'layers_onboarding_update_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			// Parse our input data
			parse_str(
				urldecode( stripslashes( $_POST[ 'data' ] ) ),
				$data
			);

			$return_message = array(
				'success' => true,
				'message' => __( 'Done!' , 'layerswp' ),
			);

			foreach ( $data as $option_key => $option_value ) {

				$clean_option_value = esc_attr( stripslashes( $option_value ) );

				switch ( $option_key ) {

					case 'site_logo' :

						if( '' == $clean_option_value || '0' == $clean_option_value ) die( json_encode( array( 'success' => true, 'message' => __( 'No Logo uploaded' , 'layerswp' ) ) ) );

						$get_attachment = wp_get_attachment_image_src( $clean_option_value );

						// Get an array of all registered image sizes.
						$intermediate = get_intermediate_image_sizes();
						$sizes = array();

						// Have we got anything fun to work with?
						if ( is_array( $intermediate ) && ! empty( $intermediate ) ) {
							foreach ( $intermediate as $key => $size ) {
								// If the size isn't already in the $sizes array, add it.
								if ( ! array_key_exists( $size, $sizes ) ) {
									$image_info = wp_get_attachment_image_src( $get_attachment[0], $size );

									$size_info[ 'url' ] = $image_info[0];
									$size_info[ 'width' ] = $image_info[1];
									$size_info[ 'height' ] = $image_info[2];

									$sizes[ $size ] =  $size_info;
								}
							}
						}

						if( ! is_wp_error( $get_attachment ) && FALSE != $get_attachment ) {

							$site_logo_array = array(
									'id' => $clean_option_value,
									'sizes' => $sizes,
									'url' => $get_attachment[0]
								);

							if( !function_exists( 'the_custom_logo' ) ){
								update_option( $option_key, $site_logo_array );
							} else {
								set_theme_mod( 'custom_logo' , $clean_option_value );
							}

							$return_message = array(
								'success' => true,
								'message' => __( 'Logo updated' , 'layerswp' ),
							);

						} else {

							$return_message = array(
								'success' => false,
								'message' => __( 'There was an error when updating your logo.' , 'layerswp' ),
							);

						}

						break;

					case 'site_color' :

						$header_color = $clean_option_value;
						$accent_color = layers_adjust_brightness( $clean_option_value, -50, TRUE );
						$footer_color = '#2b2b2b';

						set_theme_mod( 'layers-header-background-color', $header_color );
						set_theme_mod( 'layers-site-accent-color', $accent_color );
						set_theme_mod( 'layers-footer-background-color', $footer_color );

						$return_message = array(
							'success' => true,
							'message' => __( 'Option updated' , 'layerswp' ),
						);

						break;

					default :

						update_option( $option_key, $clean_option_value );

						$return_message = array(
							'success' => true,
							'message' => __( 'Option updated' , 'layerswp' ),
						);

						break;
				}
			}

			die( json_encode( $return_message ) );

		}

		public function create_pages(){

			if( ! check_ajax_referer( 'layers-onboarding-update-options', 'layers_onboarding_update_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			// Parse our input data
			parse_str(
				urldecode( stripslashes( $_POST[ 'data' ] ) ),
				$data
			);

			$return_message = array(
				'success' => true,
				'message' => __( 'Done!' , 'layerswp' ),
			);

			foreach ( $data as $option_key => $option_value ) {

				$clean_option_value = esc_attr( stripslashes( $option_value ) );

				switch ( $option_key ) {

					case 'create-page-blog' :

						// Blog page does't yet exists so create it.
						$page = array(
							'post_type' => 'page',
							'post_status' => 'publish',
							'post_title' => 'Blog',
						);

						$existing_page = get_posts( array(
							's' => 'Blog',
							'post_type' => 'page',
							'post_status' => get_post_stati(),
							'meta_query' => array(
								array(
									'key' => '_wp_page_template',
									'value' => 'template-blog.php',
								)
							)
						) );

						if ( empty( $existing_page ) ) {

							// Blog page does't yet exists so create it.
							$pageid = wp_insert_post( $page );
							update_post_meta( $pageid , '_wp_page_template', 'template-blog.php' );
						}
						else {

							$page['ID'] = $existing_page[0]->ID;

							// Blog page exists so make sure it's published.
							$pageid = wp_update_post( $page );
						}

						$return_message = array(
							'success' => true,
							'message' => __( 'Page Created' , 'layerswp' ),
						);

						break;

					default :

						break;
				}
			}

			die( json_encode( $return_message ) );
		}

	}
} // if class_exists