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

