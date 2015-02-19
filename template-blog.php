<?php
/**
 * Template Name: Blog
 * The template for displaying post archives
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>
<?php get_template_part( 'partials/header' , 'page-title' ); ?>
<section <?php post_class( 'content-main archive clearfix' ); ?>>
	<?php get_sidebar( 'left' ); ?>

	<?php
		$args = array(
			"post_type" => "post",
			"paged" => $paged
		);

		$wp_query = new WP_Query($args);

		if( $wp_query->have_posts() ) : ?>
		<div <?php layers_center_column_class(); ?>>
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();
				global $post; ?>
				<?php get_template_part( 'partials/content' , 'list' ); ?>
			<?php endwhile; // while has_post(); ?>

			<?php the_posts_pagination(); ?>
		</div>
	<?php endif; // if has_post() ?>

	<?php get_sidebar( 'right' ); ?>
</section>
<?php get_footer();