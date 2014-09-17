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

			switch ( $type ) {

				case 'background' :

					if( isset( $args['color'] ) ){
						$css .= 'background-color: ' . $args['color'] . '; ';
					}

					if( isset( $args['tile'] ) ){
						$css .= 'background-repeat: repeat;';
					}

					if( isset( $args['stretch'] ) ){
						$css .= 'background-size: cover;';
					}

					if( isset( $args['fixed'] ) ){
						$css .= 'background-attachment: fixed;';
					}

					if( isset( $args['image'] ) && $args['image'] != '' ){
						$image = wp_get_attachment_image_src( $args['image'] , 'full' );
						$css.= 'background-image: url(\'' . $image[0] .'\');';
					}
				break;

				case 'color' :

					$css .= 'color: ' . $input . ';';

				break;

			}

			$widget_css = '';
			if( isset( $args['selectors'] ) ) {
				foreach ( $args['selectors'] as $selector ) {
					$widget_css .= ' section#' . $widget_id . ' ' . $selector . '{' . $css . '} ';
				}
			} else {
				$widget_css .= '  section#' . $widget_id . '{' . $css . '} ';
			}

			wp_enqueue_style( HATCH_THEME_SLUG . '-custom-widget-styles', get_template_directory_uri() . '/css/widgets.css' );
			wp_add_inline_style( HATCH_THEME_SLUG . '-custom-widget-styles', $widget_css );

			return $css;

		}

	}
}