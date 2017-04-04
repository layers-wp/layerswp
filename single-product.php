<?php
/**
 * The template for displaying a single product
 *
 * @package Layers
 * @since Layers 1.0.0
 * @version     1.6.4
 */
get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>

<div id="post-<?php the_ID(); ?>" <?php post_class( 'content-main product' ); ?>>
	<div class="grid">
		<?php /**
		* Maybe show the left sidebar
		*/
		layers_maybe_get_sidebar( 'left-woocommerce-sidebar', implode( ' ', layers_get_wrapper_class( 'left_woocommerce_sidebar', 'column pull-left sidebar span-3' ) ) ); ?>

		<?php if( have_posts() ) : ?>
			<?php while( have_posts() ) : the_post(); ?>
				<?php global $product; $_product = $product; ?>
				<div <?php layers_center_column_class(); ?>>
					<div class="product-top clearfix">
						<?php do_action( 'woocommerce_before_single_product' ); ?>
						<div class="grid">

							<!-- Show the Images -->
							<div class="column product-images span-6 <?php echo ( 'advanced-layout-right' == layers_get_theme_mod( 'woocommerce-product-page-layout' ) ) ? 'pull-right no-gutter' : '' ?>">
								<?php do_action( 'woocommerce_before_single_product_summary' ); ?>
							</div>

							<!-- Show the Product Summary -->
							<div class="column purchase-options-container span-6">
								<?php do_action( 'woocommerce_single_product_summary' ); ?>
							</div>
						</div>
					</div>

					<?php do_action( 'woocommerce_after_single_product_summary' ); ?>
				</div>
			<?php endwhile; // while has_post(); ?>
		<?php endif; // if has_post() ?>

		<?php /**
		* Maybe show the right sidebar
		*/
		layers_maybe_get_sidebar( 'right-woocommerce-sidebar', implode( ' ', layers_get_wrapper_class( 'right_woocommerce_sidebar', 'column pull-right sidebar span-3 no-gutter' ) ) ); ?>
	</div><!-- /row -->
</div>

<?php get_footer();