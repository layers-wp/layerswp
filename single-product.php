<?php
/**
 * The template for displaying a single product
 *
 * @package Hatch
 * @since Hatch 1.0
 */
get_header(); ?>


<section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main container product' ); ?>>
    <?php if( have_posts() ) : ?>
        <?php while( have_posts() ) : the_post(); ?>
            <?php global $product; $_product = $product; ?>
            <div class="row">
                <div class="product-top clearfix">
                    <!-- Show the Images -->
                    <div class="column span-6 product-images">
                        <div class="images">
                            <?php do_action( 'woocommerce_before_single_product_summary', $post, $_product ); ?>
                        </div>
                    </div>
                    <!-- Show the Product Summary -->
                    <div class="column span-4 purchase-options-container">
                        <?php do_action( 'woocommerce_single_product_summary', $post, $_product ); ?>
                    </div>
                </div>

                <?php do_action( 'woocommerce_after_single_product_summary', $post, isset($_product) ); ?>
            </div>
        <?php endwhile; // while has_post(); ?>
    <?php endif; // if has_post() ?>
</section>

<?php get_footer(); ?>