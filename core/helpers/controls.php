<?php

/**
 * ??
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
