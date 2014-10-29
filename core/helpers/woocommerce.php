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

add_action( 'woocommerce_before_shop_loop_item_title', 'hatch_woocommerce_product_thumbnail_wrap_open', 5, 2);
add_action( 'woocommerce_before_subcategory_title', 'hatch_woocommerce_product_thumbnail_wrap_open', 5, 2);

if (!function_exists('hatch_woocommerce_product_thumbnail_wrap_open')) {
    function hatch_woocommerce_product_thumbnail_wrap_open() {
        echo '<div class="img-wrap">';
    }
}

add_action( 'woocommerce_before_shop_loop_item_title', 'hatch_woocommerce_product_thumbnail_wrap_close', 15, 2);
add_action( 'woocommerce_before_subcategory_title', 'hatch_woocommerce_product_thumbnail_wrap_close', 15, 2);
if (!function_exists('hatch_woocommerce_product_thumbnail_wrap_close')) {
    function hatch_woocommerce_product_thumbnail_wrap_close() {
        echo '</div> <!--/.wrap-->';
    }
}

/**
* Displays up to 3 related products on product posts (determined by common category/tag)
*/
if (!function_exists('woocommerce_output_related_products')) {
    function woocommerce_output_related_products() {
        woocommerce_related_products( array(
            'posts_per_page' => 3,
            'columns' => 3
        )); // Display 3 products in rows of 3
    }
}

if (!function_exists('hatch_add_woocommerce_panels')) {
    function hatch_add_woocommerce_panels( $panels ){
        $panels['woocommerce'] = array(
                                        'title' => __( 'WooCommerce', HATCH_THEME_SLUG ),
                                        'priority' => 70
                                    );
        return $panels;
    }
    add_filter( 'hatch_customizer_panels' , 'hatch_add_woocommerce_panels', 50 );
}

if (!function_exists('hatch_add_woocommerce_sections')) {
    function hatch_add_woocommerce_sections( $sections ){

        $sections[ 'woocommerce' ] = array(
                                'layout' => array(
                                    'title' =>__( 'Shop Layouts' , HATCH_THEME_SLUG ),
                                )
                            );

        return $sections;
    }
    add_filter( 'hatch_customizer_sections' , 'hatch_add_woocommerce_sections', 50 );
}

if (!function_exists('hatch_add_woocommerce_controls')) {
    function hatch_add_woocommerce_controls( $controls ){

        $controls[ 'woocommerce-layout' ] = array(
                                'archive-sidebar' => array(
                                    'label' => 'Product List Page Sidebar',
                                    'type'     => 'select',
                                    'default' => '',
                                    'choices' => array(
                                        '' => __( 'Right (Default)' , HATCH_THEME_SLUG ),
                                        'left' => __( 'left' , HATCH_THEME_SLUG ),
                                        'none' => __( 'none' , HATCH_THEME_SLUG ),
                                    )
                                ), // layout,
                                'break-0' => array(
                                    'type'     => 'seperator'
                                ),
                                'single-product' => array(
                                    'label' => 'Single Product Page Layout',
                                    'type'     => 'select',
                                    'default' => '',
                                    'choices' => array(
                                        '' => __( 'Default' , HATCH_THEME_SLUG ),
                                        'special' => __( 'Large Header Image' , HATCH_THEME_SLUG )
                                    )
                                ), // layout,
                            );

        return $controls;
    }

    add_filter( 'hatch_customizer_controls' , 'hatch_add_woocommerce_controls', 50 );
}
