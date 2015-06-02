<?php
/**
 * The template for displaying a single post
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main clearfix' ); ?>>
	<?php do_action('layers_before_post_loop'); ?>
	<div class="row">

		<?php get_sidebar( 'left' ); ?>

		<?php if( have_posts() ) : ?>

			<?php while( have_posts() ) : the_post(); ?>
				<article <?php layers_center_column_class(); ?>>
					<?php get_template_part( 'partials/content', 'single' ); ?>
				</article>
			<?php endwhile; // while has_post(); ?>

		<?php endif; // if has_post() ?>

		<?php get_sidebar( 'right' ); ?>
	</div>
	<?php do_action('layers_after_post_loop'); ?>
</section>

<?php get_footer();