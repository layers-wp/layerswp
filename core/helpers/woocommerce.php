<?php  /**
 * WooCommerce helper funtions
 *
 * This file is used to modify any WooCommerce related filtes, hooks & modifiers
 *
 * @package Hatch
 * @since Hatch 1.0
 */

/**
*  Disable WooCommerce styling
*/
if ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
    define( 'WOOCOMMERCE_USE_CSS', false );
}
