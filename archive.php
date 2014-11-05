<?php
/**
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
	hatch_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar span-4' ); ?>

	<?php if( have_posts() ) : ?>
		<div <?php hatch_center_column_class(); ?>>
			<?php while( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'partials/content' , 'list' ); ?>
			<?php endwhile; // while has_post(); ?>

			<?php hatch_pagination(); ?>
		</div>
	<?php endif; // if has_post() ?>

	<?php /**
	* Maybe show the right sidebar
	*/
	hatch_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar span-4 no-gutter' ); ?>
</section>
<?php get_footer(); ?>