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
		* @param  	varchar		$type 	Type of style to generate, background, color, text-shadow, border
		* @param  	array 		$args
		*
		* @return  	varchar 	$widget_css CSS to append to the inline widget styles that have been generated
		*/

		function widget_styles( $widget_id = NULL, $type = 'background' , $args = array() ){

			// If we have no target we cannot aim for anything
			if( NULL == $widget_id ) return;

			// Get the generated CSS
			global $widget_css;

			$css = '';


			if( empty( $args ) || ( !is_array( $args ) && '' == $args ) ) return;

			switch ( $type ) {

				case 'background' :

					// Set the background array
					$bg_args = $args['background'];

					if( isset( $bg_args['color'] ) && '' != $bg_args['color'] ){
						$css .= 'background-color: ' . $bg_args['color'] . '; ';
					}

					if( isset( $bg_args['repeat'] ) && '' != $bg_args['repeat'] ){
						$css .= 'background-repeat: ' . $bg_args['repeat'] . ';';
					}

					if( isset( $bg_args['position'] ) && '' != $bg_args['position'] ){
						$css .= 'background-position: ' . $bg_args['position'] . ';';
					}

					if( isset( $bg_args['stretch'] ) && '' != $bg_args['stretch'] ){
						$css .= 'background-size: cover;';
					}

					if( isset( $bg_args['fixed'] ) && '' != $bg_args['fixed'] ){
						$css .= 'background-attachment: fixed;';
					}

					if( isset( $bg_args['image'] ) && '' != $bg_args['image'] ){
						$image = wp_get_attachment_image_src( $bg_args['image'] , 'full' );
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
		* @param  	array		$widget 	Widget Object
		* @param  	varchar 	$option 	Widget option to check on
		* @param  	varchar 	$array_level_1 	Array level one to check for (optional)
		* @param  	varchar 	$array_level_2 	Array level two to check for (optional)
		* @return  	varchar 	false if not set, otherwise returns value
		*/

		function check_and_return( $widget = NULL , $option = NULL, $array_level_1 = NULL, $array_level_2 = NULL ){

			// If there is no widget object
			if( $widget == NULL ) return false;

			if( !isset( $widget[$option] ) ){
				return false;
			} else {
				$widget_option = $widget[$option];
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

		/**
		* Design Bar Class Instantiation, we'd rather have it done here than in each widget
		*
		* @return  	html 		Design bar HTML
		*/
		public function design_bar() {

			// Instantiate design bar
			$design_bar = new Hatch_Design_Controller();

			// Return design bar
			return $design_bar;

		}

		/**
		* Form Elements Class Instantiation, we'd rather have it done here than in each widget
		*
		* @return  	html 		Design bar HTML
		*/
		public function form_elements() {

			// Instantiate Widget Inputs
			$form_elements = new Hatch_Form_Elements();

			// Return design bar
			return $form_elements;

		}

		/**
		* Widget sub-module input name generation, for example see Slider and Content Widgets
		*
		* @param  	object 		$widget_details 	Widget object to use
		* @param  	varchar 	$level1 	Level 1 name
		* @param  	varchar 	$level2 	Level 2 name
	 	* @param 	string 		$field_name Field name
	 	* @return 	string 		Name attribute for $field_name
		*/
		function get_custom_field_name( $widget_details = NULL, $level1 = '' , $level2 = '', $field_name = '' ) {

			// If there is no widget object then ignore
			if( NULL == $widget_details ) return;

			$final_field_name = 'widget-' . $widget_details->id_base . '[' . $widget_details->number . ']';

			// Add first level of input string
			if( '' != $level1 ) $final_field_name .= '[' . $level1 . ']';

			// Add second level of input string
			if( '' != $level2 ) $final_field_name .= '[' . $level2 . ']';

			// Add field name
			if( '' != $field_name ) $final_field_name .= '[' . $field_name . ']';

			return $final_field_name;
		}

		/**
		* Widget sub-module input id generation, for example see Slider and Content Widgets
		*
		* @param  	object 		$widget_details 	Widget object to use
		* @param  	varchar 	$level1 	Level 1 name
		* @param  	varchar 	$level2 	Level 2 name
	 	* @param 	string 		$field_name Field name
	 	* @return 	string 		Name attribute for $field_name
		*/
		function get_custom_field_id( $widget_details = NULL, $level1 = '' , $level2 = '', $field_id = '' ) {

			// If there is no widget object then ignore
			if( NULL == $widget_details ) return;

			$final_field_id = 'widget-' . $widget_details->id_base . '-' . $widget_details->number;

			// Add first level of input string
			if( '' != $level1 ) $final_field_id .= '-' . $level1;

			// Add second level of input string
			if( '' != $level2 ) $final_field_id .= '-' . $level2;

			// Add field name
			if( '' != $field_id ) $final_field_id .= '-' . $field_id;

			return $final_field_id;
		}

	}
}