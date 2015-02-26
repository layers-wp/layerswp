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

			add_action( 'wp_ajax_layers_onboarding_update_options', array( $this, 'update_options' ) );

		}

		public function update_options(){

			if( !check_ajax_referer( 'layers-onboarding-update-options', 'layers_onboarding_update_nonce', false ) ) die( 'You threw a Nonce exception' ); // Nonce

			// Parse our input data
			parse_str(
				urldecode( stripslashes( $_POST[ 'data' ] ) ),
				$data
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

						if( !is_wp_error( $get_attachment ) && FALSE != $get_attachment ) {

							$site_logo_array = array(
									'id' => $clean_option_value,
									'sizes' => $sizes,
									'url' => $get_attachment[0]
								);

							update_option( $option_key, $site_logo_array );

							die( json_encode( array( 'success' => true, 'message' => __( 'Logo updated' , 'layerswp' ) ) ) );

						} else {

							die( json_encode( array( 'success' => false, 'message' => __( 'There was an error when updating your logo.' , 'layerswp' ) ) ) );

						}

						break;
					default :
						update_option( $option_key, $clean_option_value );

						die( json_encode( array( 'success' => true, 'message' => __( 'Option updated' , 'layerswp' ) ) ) );
					break;

				}
			}
		}
	}
} // if class_exists