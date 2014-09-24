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
						$css .= 'background-repeat: repeat;';
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

	}
}