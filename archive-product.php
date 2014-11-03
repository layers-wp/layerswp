<?php
/**
 * The template for displaying Woo Commerce products
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>

<div class="container sky basement clearfix">
    <div class="row">

        <?php  do_action('woocommerce_before_shop_loop'); ?>

        <?php if ( have_posts()) : ?>
            <section class="column span-12">
                <?php // Sub category listing
                woocommerce_product_subcategories(); ?>
                <ul class="products">
                    <?php while (have_posts()) :  the_post(); ?>
                            <?php woocommerce_get_template_part( 'content' , 'product' ); ?>
                    <?php endwhile; ?>
                </ul>

                <?php hatch_pagination(); ?>

                <?php woocommerce_product_loop_end(); ?>
            </section>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>