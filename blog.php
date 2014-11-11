<?php
/**
 * Template Name: Blog
 * The template for displaying post archives
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>
<?php get_template_part( 'partials/header' , 'page-title' ); ?>
<section <?php post_class( 'content-main archive clearfix' ); ?>>

	<?php /**
	* Maybe show the left sidebar
	*/
	hatch_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar span-3' ); ?>
	<?php 
		$args = array(
			"post_type" => "post", 
			"paged" => $paged
		);

		$wp_query = new WP_Query($args);	
			
		if( $wp_query->have_posts() ) : ?>
		<div <?php hatch_center_column_class(); ?>>
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
				global $post; ?>
				<?php get_template_part( 'partials/content' , 'list' ); ?>
			<?php endwhile; // while has_post(); ?>

			<?php hatch_pagination(); ?>
		</div>
	<?php endif; // if has_post() ?>

	<?php /**
			* Maybe show the right sidebar
			*/
			hatch_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar span-3 no-gutter' ); ?>
</section>
<?php get_footer(); ?>