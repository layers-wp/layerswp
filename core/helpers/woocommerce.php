<?php /**
 * WooCommerce Filters & Hooks
 *
 * This file is used to modify any WooCommerce HTML and or CSS classes.
 *
 * @package Layers
 * @since Layers 1.0.0
 */


/**
* Remove Woocommerce Stylshee
*/
if ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
    define( 'WOOCOMMERCE_USE_CSS', false );
}

/**
* Add a wrap around product images, this allows us way more freedom re: styling
*/

add_action( 'woocommerce_before_shop_loop_item_title', 'layers_woocommerce_product_thumbnail_wrap_open', 5, 2);
add_action( 'woocommerce_before_subcategory_title', 'layers_woocommerce_product_thumbnail_wrap_open', 5, 2);

if (!function_exists('layers_woocommerce_product_thumbnail_wrap_open')) {
    function layers_woocommerce_product_thumbnail_wrap_open() {
        echo '<div class="img-wrap">';
    }
}

add_action( 'woocommerce_before_shop_loop_item_title', 'layers_woocommerce_product_thumbnail_wrap_close', 15, 2);
add_action( 'woocommerce_before_subcategory_title', 'layers_woocommerce_product_thumbnail_wrap_close', 15, 2);
if (!function_exists('layers_woocommerce_product_thumbnail_wrap_close')) {
    function layers_woocommerce_product_thumbnail_wrap_close() {
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


/**
* Filter Center Column Class in accordance to WooCommerce Layout Settings
*/
if (!function_exists('layers_woocommerce_center_column_class')) {
    function layers_woocommerce_center_column_class( $classes ){

        if( !function_exists( 'is_shop' ) ) {
            return $classes;
        } else {
            if( !is_shop() && !is_post_type_archive( 'product' ) && !is_singular( 'product' ) && !is_tax( 'product_cat' )  && !is_tax( 'product_tag' ) ) {
                return $classes;
            }
        }

        $left_sidebar_active = layers_can_show_sidebar( 'left-woocommerce-sidebar' );
        $right_sidebar_active = layers_can_show_sidebar( 'right-woocommerce-sidebar' );

        // Unset default classes
        foreach( $classes as $key => $this_class ){
            if( 'span-6' == $this_class ){
                unset( $classes[ $key ] );
            } else if( 'span-9' == $this_class ){
                unset( $classes[ $key ] );
            } else if( 'span-12' == $this_class ){
                unset( $classes[ $key ] );
            } else if( 'span-8' == $this_class ){
                unset( $classes[ $key ] );
            } else if( 'no-gutter' == $this_class ){
                unset( $classes[ $key ] );
            }
        }

        // Set post classes
        if( $left_sidebar_active && $right_sidebar_active ){
            $classes[] = 'span-6';
        } else if( $left_sidebar_active ){
            $classes[] = 'span-9';
        } else if( $right_sidebar_active ){
            $classes[] = 'span-9';
        } else {
            $classes[] = 'span-12';
        }

        // If there is a left sidebar and no right sidebar, add the no-gutter class
        if( $left_sidebar_active && !$right_sidebar_active ){
            $classes[] = 'no-gutter';
        }

        return $classes;

    }
}
add_filter( 'layers_center_column_class' , 'layers_woocommerce_center_column_class', 50 );

/**
* Filter Sidebar Display in accordance to WooCommerce Layout Settings
*/
if (!function_exists('layers_woocommerce_can_show_sidebar')) {
    function layers_woocommerce_can_show_sidebar( $can_show_sidebar, $sidebar ){

        if( is_post_type_archive( 'product' ) ){
            $can_show_sidebar = layers_get_theme_mod( 'archive-' . $sidebar );
        } elseif ( is_singular( 'product' ) ) {
            $can_show_sidebar = layers_get_theme_mod( 'single-' . $sidebar );
        }

        return $can_show_sidebar;

    }
}
add_filter( 'layers_can_show_sidebar' , 'layers_woocommerce_can_show_sidebar', 50, 2 );