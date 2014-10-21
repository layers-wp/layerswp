<?php  /**
 * Hatch Widget Class
 *
 * This file is used to register the base hatch widget Class
 *
 * @package Hatch
 * @since Hatch 1.0
 */

if( !class_exists( 'Hatch_Widget' ) ) {
	class Hatch_Widget extends WP_Widget {

		/**
		* Background Style Generator
		*
		* @param  	varchar		$widget_id 	Widget ID
		* @param  	array 		$values 	Background information
		*/

		function widget_styles( $widget_id = NULL , $type = 'background' , $args = array() ){

			// if there is no widget ID, then get outta here
			if( NULL == $widget_id ) return;

			// Get the generated CSS
			global $widget_css;

			$css = '';
			$input = $widget_id;

			if( empty( $args ) || ( !is_array( $args ) && '' == $args ) ) return;

			switch ( $type ) {

				case 'background' :

					if( isset( $args['color'] ) && '' != $args['color'] ){
						$css .= 'background-color: ' . $args['color'] . '; ';
					}

					if( isset( $args['repeat'] ) && '' != $args['repeat'] ){
						$css .= 'background-repeat: ' . $args['repeat'] . ';';
					}

					if( isset( $args['position'] ) && '' != $args['position'] ){
						$css .= 'background-position: ' . $args['position'] . ';';
					}

					if( isset( $args['stretch'] ) && '' != $args['stretch'] ){
						$css .= 'background-size: cover;';
					}

					if( isset( $args['fixed'] ) && '' != $args['fixed'] ){
						$css .= 'background-attachment: fixed;';
					}

					if( isset( $args['image'] ) && '' != $args['image'] ){
						$image = wp_get_attachment_image_src( $args['image'] , 'full' );
						$css.= 'background-image: url(\'' . $image[0] .'\');';
					}
				break;

				case 'color' :

					if( '' == $args[ 'color' ] ) return ;
					$css .= 'color: ' . $args[ 'color' ] . ';';

				break;

				case 'text-shadow' :

					if( '' == $args[ 'text-shadow' ] ) return ;
					$css .= 'text-shadow: 0px 0px 10px rgba(' . implode( ', ' , hex2rgb( $args[ 'text-shadow' ] ) ) . ', 0.75);';

				break;

			}

			$widget_css = '';
			if( isset( $args['selectors'] ) ) {
				foreach ( $args['selectors'] as $selector ) {
					$widget_css .= ' #' . $widget_id . ' ' . $selector . '{' . $css . '} ';
				}
			} else {
				$widget_css .= '  #' . $widget_id . '{' . $css . '} ';
			}
			wp_enqueue_style( HATCH_THEME_SLUG . '-custom-widget-styles', get_template_directory_uri() . '/css/widgets.css' );
			wp_add_inline_style( HATCH_THEME_SLUG . '-custom-widget-styles', $widget_css );

			return $widget_css;

		}

		/**
		* Check option with isset() and echo it out if it exists, if it does not exist, return false
		*
		* @param  	object		$widget_id 	Widget Object
		* @param  	varchar 	$option 	Widget option to check on
		* @param  	varchar 	$array_level_1 	Array level one to check for (optional)
		* @param  	varchar 	$array_level_2 	Array level two to check for (optional)
		* @return  	varchar 	false if not set, otherwise returns value
		*/

		function check_and_return( $widget = NULL , $option = NULL, $array_level_1 = NULL, $array_level_2 = NULL ){

			// If there is no widget object
			if( $widget == NULL ) return false;

			if( !isset( $widget->$option ) ){
				return false;
			} else {
				$widget_option = $widget->$option;
			}

			if( NULL != $array_level_1 ){
				if( !isset( $widget_option[ $array_level_1 ] ) ){
					return false;
				} elseif( '' != $widget_option[ $array_level_1 ] ){
					if( NULL != $array_level_2 ){
						if( !isset( $widget_option[ $array_level_1 ][ $array_level_2 ] ) ){
							return false;
						} elseif( '' != $widget_option[ $array_level_1 ][ $array_level_2 ] ) {
							return $widget_option[ $array_level_1 ][ $array_level_2 ];
						}
					} elseif( '' != $widget_option[ $array_level_1 ] )  {
						return $widget_option[ $array_level_1 ];
					}
				}
			} elseif( '' != $widget_option ){
				return $widget_option;
			}

		}

	}
}