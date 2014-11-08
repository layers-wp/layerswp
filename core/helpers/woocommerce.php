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

add_theme_support( 'woocommerce' );

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

/**
* Add WooCommerce Customizer Panels
*/
if (!function_exists('hatch_woocommerce_add_panels')) {
    function hatch_woocommerce_add_panels( $panels ){
        $panels['woocommerce'] = array(
                                        'title' => __( 'WooCommerce', HATCH_THEME_SLUG ),
                                        'priority' => 70
                                    );
        return $panels;
    }
    add_filter( 'hatch_customizer_panels' , 'hatch_woocommerce_add_panels', 50 );
}

/**
* Add WooCommerce Customizer Sections
*/
if (!function_exists('hatch_woocommerce_add_sections')) {
    function hatch_woocommerce_add_sections( $sections ){

        $sections[ 'woocommerce' ] = array(
                                'layout' => array(
                                    'title' =>__( 'Shop Layout' , HATCH_THEME_SLUG ),
                                )
                            );

        return $sections;
    }
    add_filter( 'hatch_customizer_sections' , 'hatch_woocommerce_add_sections', 50 );
}

/**
* Add WooCommerce Customizer Controls
*/
if (!function_exists('hatch_woocommerce_add_controls')) {
    function hatch_woocommerce_add_controls( $controls ){

        $controls[ 'woocommerce-layout' ] = array(
                                'label-sidebar-archive' => array(
                                    'type'  => 'heading',
                                    'label'    => __( 'Product List Sidebar(s)', HATCH_THEME_SLUG ),
                                    'description' => __( 'This option affects your shop page, product category & product tag pages.', HATCH_THEME_SLUG ),
                                ),
                                'archive-left-woocommerce-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Left Sidebar', HATCH_THEME_SLUG ),
                                    'default'   => FALSE,
                                ), // post-sidebar
                                'archive-right-woocommerce-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Right Sidebar', HATCH_THEME_SLUG ),
                                    'default'   => TRUE,
                                ), // post-sidebar
                                'break-' . rand() => array(
                                    'type'     => 'seperator'
                                ),
                                'label-sidebar-single' => array(
                                    'type'  => 'heading',
                                    'label'    => __( 'Single Product Sidebar(s)', HATCH_THEME_SLUG ),
                                    'description' => __( 'This option affects your single product pages.', HATCH_THEME_SLUG ),
                                ),
                                'single-left-woocommerce-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Left Sidebar', HATCH_THEME_SLUG ),
                                    'default'   => FALSE,
                                ), // post-sidebar
                                'single-right-woocommerce-sidebar' => array(
                                    'type'      => 'checkbox',
                                    'label'     => __( 'Show Right Sidebar', HATCH_THEME_SLUG ),
                                    'default'   => TRUE,
                                ), // post-sidebar
                            );

        return $controls;
    }

    add_filter( 'hatch_customizer_controls' , 'hatch_woocommerce_add_controls', 50 );
}

/**
* Register WooCommerce Sidebars
*/
if (!function_exists('hatch_woocommerce_add_sidebars')) {
    function hatch_woocommerce_add_sidebars(){

        register_sidebar( array(
            'id'        => HATCH_THEME_SLUG . '-left-woocommerce-sidebar',
            'name'      => __( 'Left Shop Sidebar' , HATCH_THEME_SLUG ),
            'description'   => __( '' , HATCH_THEME_SLUG ),
            'before_widget' => '<aside id="%1$s" class="content well push-bottom widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="section-nav-title">',
            'after_title'   => '</h4>',
        ) );
        register_sidebar( array(
            'id'        => HATCH_THEME_SLUG . '-right-woocommerce-sidebar',
            'name'      => __( 'Right Shop Sidebar' , HATCH_THEME_SLUG ),
            'description'   => __( '' , HATCH_THEME_SLUG ),
            'before_widget' => '<aside id="%1$s" class="content well push-bottom widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h5 class="section-nav-title">',
            'after_title'   => '</h4>',
        ) );
    }
    add_action( 'widgets_init' , 'hatch_woocommerce_add_sidebars', 45 );
}

/**
* Filter Center Column Class in accordance to WooCommerce Layout Settings
*/
if (!function_exists('hatch_woocommerce_center_column_class')) {
    function hatch_woocommerce_center_column_class( $classes ){

        if( !function_exists( 'is_shop' ) ) {
            return $classes;
        } else {
            if( !is_shop() && !is_post_type_archive( 'product' ) && !is_singular( 'product' ) && !is_tax( 'product_cat' ) ) {
                return $classes;
            }
        }

        $left_sidebar_active = ( hatch_can_show_sidebar( 'left-woocommerce-sidebar' ) ? is_active_sidebar( HATCH_THEME_SLUG . '-left-woocommerce-sidebar' ) : FALSE );
        $right_sidebar_active = ( hatch_can_show_sidebar( 'right-woocommerce-sidebar' ) ? is_active_sidebar( HATCH_THEME_SLUG . '-right-woocommerce-sidebar' ) : FALSE );

        // Unset default classes
        foreach( $classes as $key => $this_class ){
            if( 'span-6' == $this_class ){
                unset( $classes[ $key ] );
            } else if( 'span-9' == $this_class ){
                unset( $classes[ $key ] );
            } else if( 'span-12' == $this_class ){
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
    add_filter( 'hatch_center_column_class' , 'hatch_woocommerce_center_column_class', 50 );
}

/**
* Filter Sidebar Display in accordance to WooCommerce Layout Settings
*/
if (!function_exists('hatch_woocommerce_can_show_sidebar')) {
    function hatch_woocommerce_can_show_sidebar( $can_show_sidebar, $sidebar ){

        if( is_post_type_archive( 'product' ) ){
            $can_show_sidebar = hatch_get_theme_mod( 'woocommerce-layout-archive-' . $sidebar );
        } elseif ( is_singular( 'product' ) ) {
            $can_show_sidebar = hatch_get_theme_mod( 'woocommerce-layout-single-' . $sidebar );
        }

        return $can_show_sidebar;

    }
    add_filter( 'hatch_can_show_sidebar' , 'hatch_woocommerce_can_show_sidebar', 50, 2 );
}

/**
* Enqueue WooCommerce CSS
*/
if (!function_exists('hatch_woocommerce_register_scripts')) {
    function hatch_woocommerce_register_scripts(){
        wp_enqueue_style(
            HATCH_THEME_SLUG . '-woocommerce',
            get_template_directory_uri() . '/css/woocommerce.css',
            array(),
            HATCH_VERSION
        ); // Responsive
    }
    add_action( 'init' , 'hatch_woocommerce_register_scripts' );
}
/**
* Register WooCommerce Widgets
*/
if (!function_exists('hatch_woocommerce_register_widgets')) {
    function hatch_woocommerce_register_widgets(){
       locate_template( 'core/widgets/modules/product.php' , true );
    };
    add_action( 'widgets_init' , 'hatch_woocommerce_register_widgets' , 30 );
}


/**
* Register WooCommerce Widgets
*/
if (!function_exists('hatch_woocommerce_cart_button')) {
    function hatch_woocommerce_cart_button(){
        global $woocommerce;
        if( !$woocommerce ) return; ?>
        <div class="header-cart" data-toggle="#off-canvas-top" data-toggle-class="open">
            <span class="cart-total">(<?php echo $woocommerce->cart->get_cart_subtotal(); ?>)</span>
            <a class="icon-cart"><?php _e( 'Cart' , HATCH_THEME_SLUG ); ?></a>
        </div>
    <?php };
}

add_action( 'hatch_after_header_nav' , 'hatch_woocommerce_cart_button' , 30 );
