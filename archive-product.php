<?php
/**
 * The template for displaying Woo Commerce products
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>

<section class="<?php if( 'layout-fullwidth' != hatch_get_theme_mod( 'content-layout-layout' ) ) echo 'container'; ?> clearfix content-main">

        <?php /**
        * Maybe show the left sidebar
        */
        hatch_maybe_get_sidebar( 'left-woocommerce-sidebar', 'column pull-left sidebar span-3' ); ?>

        <?php if ( have_posts()) : ?>
            <section <?php hatch_center_column_class(); ?>>
        
                <div class="row push-bottom woocommerce-result-count-container">
                    <?php  do_action('woocommerce_before_shop_loop'); ?>
                </div>

                <?php // Sub category listing
                woocommerce_product_subcategories(); ?>

                <ul class="products row">
                    <?php while (have_posts()) :  the_post(); ?>
                            <?php woocommerce_get_template_part( 'content' , 'product' ); ?>
                    <?php endwhile; ?>
                </ul>

                <?php hatch_pagination(); ?>

                <?php woocommerce_product_loop_end(); ?>

            </section>
        <?php endif; ?>

        <?php /**
        * Maybe show the right sidebar
        */
        hatch_maybe_get_sidebar( 'right-woocommerce-sidebar', 'column pull-right sidebar span-3 no-gutter' ); ?>
</section>
<?php get_footer(); ?>