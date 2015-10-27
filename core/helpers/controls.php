<?php
/**
 * Helper function to assist with modifying the Customizer Controls (add, remove, etc).
 *
 */

/**
 * Insert controls before specific controls in the config array.
 *
 * @param    string $key           Key of the elemt that you want to insert-before.
 * @param    array $config         The existing config array to be modified.
 * @param    array $new_elements   Nested array containing new field elements.
 * @return   array                 The newly modified config array
 */
if( ! function_exists( 'layers_insert_config_elements_before' ) ) {
	function layers_insert_config_elements_before( $key, $config, $new_elements ) {
		
		foreach ( $config as $group_key => $group_array ) {
			
			if ( isset( $group_array[$key] ) ) {
				
				$offset = ( array_search( $key, array_keys( $group_array ) ) );
				
				$group_array =	array_slice( $group_array, 0, $offset, true ) +
								$new_elements +
								array_slice( $group_array, $offset, count( $group_array ) - 1, true );
								
				$config[$group_key] = $group_array;
			}
		}
		
		return $config;
	}
}

/**
 * Insert controls after specific controls in the config array.
 *
 * @param    string $key           Key of the elemt that you want to insert-after.
 * @param    array $config         The existing config array to be modified.
 * @param    array $new_elements   Nested array containing new field elements.
 * @return   array                 The newly modified config array
 */
if( ! function_exists( 'layers_insert_config_elements_after' ) ) {
	function layers_insert_config_elements_after( $key, $config, $new_elements ) {
		
		foreach ( $config as $group_key => $group_array ) {
			
			if ( isset( $group_array[$key] ) ) {
				
				$offset = ( array_search( $key, array_keys( $group_array ) ) ) + 1;
				
				$group_array =	array_slice( $group_array, 0, $offset, true ) +
								$new_elements +
								array_slice( $group_array, $offset, count( $group_array ) - 1, true );
								
				$config[$group_key] = $group_array;
			}
		}
		
		return $config;
	}
}

/**
 * Insert controls after specific controls in the config array.
 *
 * @param    string $key           Key of the elemt that you want to insert-after.
 * @param    array $config         The existing config array to be modified.
 * @param    array $new_elements   Nested array containing new field elements.
 * @return   array                 The newly modified config array
 */
if( ! function_exists( 'layers_remove_config_element' ) ) {
	function layers_remove_config_element( $key, $config ) {
		
		foreach ( $config as $group_key => $group_array ) {
			
			if ( isset( $group_array[$key] ) ) {
				
				unset( $group_array[$key] );
								
				$config[$group_key] = $group_array;
			}
		}
		
		return $config;
	}
}
