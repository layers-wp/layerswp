<?php get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<?php while( have_posts() ) : the_post(); ?>
			<div class="row">
				<article class="column span-7">
					<?php get_template_part( 'content-single' ); ?>
				</article>
                <div class="column span-4 pull-right sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php endwhile; // while has_post(); ?>
	<?php endif; // if has_post() ?>
</section>

<?php get_footer(); ?>