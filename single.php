<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<?php while( have_posts() ) : the_post(); ?>
			<?php if( has_post_thumbnail() ) { ?>
				<div class="row push-bottom">
					<?php echo the_post_thumbnail( 'full' ); ?>
				</div>
			<?php } // if has_post_thumbnail() ?>
			<div class="row">
				<div class="column span-7">
					<header class="section-title large">
						<h5 class="meta-info"><?php the_date(); ?></h5>
						<h1 class="heading"><?php the_title(); ?></h1>
					</header>
					<div class="story">
						<?php the_content(); ?>
					</div>
					<?php hatch_post_meta( $post->ID ); ?>
				</div>
                <div class="column span-4 pull-right sidebar">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php endwhile; // while has_post(); ?>
	<?php endif; // if has_post() ?>
</article>

<?php get_footer(); ?>