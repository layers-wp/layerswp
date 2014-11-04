<?php
/**
 * The template for displaying a single post
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<div class="row">

			<?php /**
			* Maybe show the left sidebar
			*/
			hatch_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar' ); ?>

			<?php while( have_posts() ) : the_post(); ?>
				<article <?php hatch_center_column_class( $post->ID ); ?>>
					<?php get_template_part( 'partials/content', 'single' ); ?>
				</article>
			<?php endwhile; // while has_post(); ?>

			<?php /**
			* Maybe show the right sidebar
			*/
			hatch_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar' ); ?>
		</div>
	<?php endif; // if has_post() ?>
</section>

<?php get_footer(); ?>