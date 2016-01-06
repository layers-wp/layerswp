<?php
/**
 * Color helper funtions
 *
 * This file has helper function to do with rendering colors.
 *
 * @package Layers
 * @since Layers 1.1.1
 */

/**
 * Convert hex value to rgb array.
 *
 * @param	string	$hex
 * @return	array	implode(",", $rgb); returns the rgb values separated by commas
 */

if(!function_exists('layers_hex2rgb') ) {
	function layers_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);

	   return $rgb; // returns an array with the rgb values
	}
}

if ( ! function_exists( 'layers_hex_darker' ) ) {
	/**
	 * Hex darker color function.
	 *
	 * @param mixed $color
	 * @param int $factor (default: 30)
	 * @return string
	 */
	function layers_hex_darker( $color, $factor = 30 ) {
		$base  = layers_hex2rgb( $color );
		$color = '#';
		foreach ( $base as $k => $v ) {
			$amount      = $v / 100;
			$amount      = round( $amount * $factor );
			$new_decimal = $v - $amount;
			$new_hex_component = dechex( $new_decimal );
			if ( strlen( $new_hex_component ) < 2 ) {
				$new_hex_component = "0" . $new_hex_component;
			}
			$color .= $new_hex_component;
		}
		return $color;
	}
}

/**
 * Hex lighter color function.
 *
 * @param mixed $color
 * @param int $factor (default: 30)
 * @return string
 */
if ( ! function_exists( 'layers_hex_lighter' ) ) {
	function layers_hex_lighter( $color, $factor = 30 ) {
		
		$base  = layers_hex2rgb( $color );
		$color = '#';
		foreach ( $base as $k => $v ) {
			$amount      = 255 - $v;
			$amount      = $amount / 100;
			$amount      = round( $amount * $factor );
			$new_decimal = $v + $amount;
			$new_hex_component = dechex( $new_decimal );
			if ( strlen( $new_hex_component ) < 2 ) {
				$new_hex_component = "0" . $new_hex_component;
			}
			$color .= $new_hex_component;
		}
		return $color;
	}
}

/**
 * Adjust Brightness color function.
 *
 * @param    mixed    $color
 * @param    int      $steps (default: 50) can be + or - for brighter or dimmer (max 255).
 * @param    bool     $loop_back specify whether to loop back arround if the resulting color is black or white.
 * @return   string   hex color
 */
if ( ! function_exists( 'layers_adjust_brightness' ) ) {
	function layers_adjust_brightness( $color, $steps = 50, $loop_back = false ) {
		
		$mod_steps = max( -255, min( 255, $steps ) );

        $mod_color = str_replace( '#', '', $color );
        if ( strlen( $mod_color ) == 3 ) {
            $mod_color = str_repeat( substr( $mod_color, 0, 1 ), 2 ) . str_repeat( substr( $mod_color, 1, 1 ), 2 ) . str_repeat( substr( $mod_color, 2, 1), 2 );
        }

        $mod_color_parts = str_split( $mod_color, 2 );
        $return = '#';

        foreach ( $mod_color_parts as $mod_color ) {
            $mod_color = hexdec( $mod_color );
            $mod_color = max( 0, min( 255, $mod_color + $mod_steps ) );
            $return .= str_pad( dechex( $mod_color ), 2, '0', STR_PAD_LEFT );
        }
        
        if ( ( '#000000' == $return || '#ffffff' == $return ) && $loop_back ) {
        	$return = layers_adjust_brightness( $color, - ( $steps ) );
        }

        return $return;
	}
}

/**
 * If the color that will be retuend is too light, then make it darker
 * Used sepecially for auto hover colors
 *
 * @param  string  $color
 * @param  string  $factor (default: 30)
 * @return string
 */
if ( ! function_exists( 'layers_too_light_then_dark' ) ) {
	function layers_too_light_then_dark( $color, $factor = 30 ) {
		if ( '#ffffff' == layers_hex_lighter( $color, 96 ) ) {
			$color = layers_hex_darker( $color, $factor / 3 );
		}
		else {
			$color = layers_hex_lighter( $color, $factor );
		}
		return $color;
	}
}

/**
 * Detect if we should use a light or dark color on a background color
 *
 * @param mixed $color
 * @param string $dark (default: '#000000')
 * @param string $light (default: '#FFFFFF')
 * @return string
 */
if ( ! function_exists( 'layers_light_or_dark' ) ) {
	function layers_light_or_dark( $color, $dark = '#000000', $light = '#FFFFFF' ) {

		$hex = str_replace( '#', '', $color );

		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );

		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

		return $brightness > 155 ? $dark : $light;
	}
}

/**
 * Detect if a color is light or dark
 *
 * @param string $color hex color eg #666666
 * @return string 'light' | 'dark'
 */
if ( ! function_exists( 'layers_is_light_or_dark' ) ) {
	function layers_is_light_or_dark( $color ) {

		if ( FALSE === strpos( $color, '#' ) ){
			// Not a color
			return NULL;
		}

		$hex = str_replace( '#', '', $color );

		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );

		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

		return ( $brightness > 155 ) ? 'light' : 'dark' ;
	}
}

/**
 * Detect if a $color is light/dark then return the appropraite color.
 *
 * @param   string   $color      hex color eg #666666
 * @param   string   $if_dark    The color to be returned if passed $color is dark
 * @param   string   $if_light   The color to be returned if passed $color is light
 * @return  string   hex color eg #666666
 */
if ( ! function_exists( 'layers_get_light_or_dark' ) ) {
	function layers_get_light_or_dark( $color, $if_dark, $if_light ) {

		if ( 'dark' == layers_is_light_or_dark( $color ) ) {
			return $if_light;
		}
		elseif ( 'light' == layers_is_light_or_dark( $color ) ) {
			return $if_dark;
		}
	}
}

/**
 * Takes compares one color to another and tells if is lighter
 *
 * @param  string $color            hex color string
 * @param  string $compare_to_color hex color string
 * @return boolean
 */
if ( ! function_exists( 'layers_is_lighter' ) ) {
	function layers_is_lighter( $color, $compare_to_color ) {

		$color_brigntness            = layers_get_brightness( $color );
		$compare_to_color_brigntness = layers_get_brightness( $color );

		return ( $color > $compare_to_color );
	}
}

/**
 * Takes compares one color to another and tells if is darker
 *
 * @param  string $color            hex color string
 * @param  string $compare_to_color hex color string
 * @return boolean
 */
if ( ! function_exists( 'layers_is_darker' ) ) {
	function layers_is_darker( $color, $factor = 50 ) {

		$color_brigntness            = layers_get_brightness( $color );
		$compare_to_color_brigntness = layers_get_brightness( $color );

		return ( $color < $compare_to_color );
	}
}

/**
 * Takes a color and returns it's brigtness between 0 and 255.
 *
 * @param  string $color hex color string
 * @return string        brigtness 0-255
 */
if ( ! function_exists( 'layers_get_brightness' ) ) {
	function layers_get_brightness( $color ) {

		$hex = str_replace( '#', '', $color );

		$c_r = hexdec( substr( $hex, 0, 2 ) );
		$c_g = hexdec( substr( $hex, 2, 2 ) );
		$c_b = hexdec( substr( $hex, 4, 2 ) );

		$brightness = ( ( $c_r * 299 ) + ( $c_g * 587 ) + ( $c_b * 114 ) ) / 1000;

		return $brightness;
	}
}
