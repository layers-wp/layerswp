<?php  /**
 * Sanitization helper funtions
 *
 * These functions are extra functions which are needed to add sanitization to Layers
 *
 * @package Layers
 * @since Layers 1.0.0
 */

/**
* Checkbox sanitization
*/
if( !function_exists( 'layers_sanitize_checkbox') ) {
	function layers_sanitize_checkbox( $value ){
		if ( $value ) {
			return '1';
		} else {
			return false;
		}
	}
} // layers_sanitize_checkbox

/**
* Number sanitization
*/
if( !function_exists( 'layers_sanitize_number') ) {
	function layers_sanitize_number( $value = FALSE ){

		if ( !is_numeric( $value ) ) {
			return '';
		} else {
			return intval( $value );
		}
	}
} // layers_sanitize_number

/**
* JS sanitization
*
* The customizer does not like single quotes, while esc_js does not like double quotes
*
*/
if( !function_exists( 'layers_sanitize_js') ) {
	function layers_sanitize_js( $value = FALSE ){

		$safe_text = _wp_specialchars( $value , ENT_QUOTES );
		$safe_text = preg_replace( '/&#(x)?0*(?(1)27|39);?/i', '"', stripslashes( $safe_text ) );
		$safe_text = str_replace( "\r", '', $safe_text );
		$safe_text = str_replace( "\n", '\\n', addslashes( $safe_text ) );

		return trim( $safe_text );
	}
} // layers_sanitize_js

