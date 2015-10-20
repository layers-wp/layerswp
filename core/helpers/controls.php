<?php

/**
 * Insert controls after specific controls in the config array - for use in the Widgets.
 *
 * @param    string $key           Key of the elemt that you want to insert-after.
 * @param    array $config         The existing config array to be modified.
 * @param    array $new_elements   Nested array containing new field elements.
 * @return   array                 The newly modified config array
 */
if( ! function_exists( 'layers_insert_config_elements_after' ) ) {
	function layers_insert_config_elements_after( $key, $config, $new_elements ) {
		
		if ( isset( $config[$key] ) ) {
			
			$offset = array_search( $key, array_keys( $config ) );
			
			$config =	array_slice( $config, 0, $offset, true ) +
						$new_elements +
    					array_slice( $config, $offset, count( $config ) - 1, true );
		}
		
		return $config;
	}
}
