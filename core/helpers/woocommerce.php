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


/**
* Add a wrap around product images, this allows us way more freedom re: styling
*/

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_product_thumbnail_wrap_open', 5, 2);
add_action( 'woocommerce_before_subcategory_title', 'woocommerce_product_thumbnail_wrap_open', 5, 2);

if (!function_exists('woocommerce_product_thumbnail_wrap_open')) {
    function woocommerce_product_thumbnail_wrap_open() {
        echo '<div class="img-wrap">';
    }
}

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_product_thumbnail_wrap_close', 15, 2);
add_action( 'woocommerce_before_subcategory_title', 'woocommerce_product_thumbnail_wrap_close', 15, 2);
if (!function_exists('woocommerce_product_thumbnail_wrap_close')) {
    function woocommerce_product_thumbnail_wrap_close() {
        echo '</div> <!--/.wrap-->';
    }
}



/**
* Displays up to 3 related products on product posts (determined by common category/tag)
*/
function woocommerce_output_related_products() {
woocommerce_related_products( array(
        'posts_per_page' => 3,
        'columns' => 3
    )); // Display 3 products in rows of 3
}
