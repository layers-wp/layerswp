<?php get_header(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<?php while( have_posts() ) : the_post(); ?>
			<?php if( has_post_thumbnail() ) { ?>
				<div class="row push-bottom">
					<?php echo the_post_thumbnail( 'full' ); ?>
				</div>
			<?php } // if has_post_thumbnail() ?>
			<header class="section-title">
				<h1 class="heading"><?php the_title(); ?></h1>
				<h5 class="the-date"><?php the_date(); ?></h5>
			</header>
			<div class="row">
				<div class="column span-7">
					<div class="copy">
						<?php the_content(); ?>
					</div>
				</div>
				<div class="column span-4 pull-right well content">
					<?php get_sidebar(); ?>
				</div>
			</div>
		<?php endwhile; // while has_post(); ?>
	<?php endif; // if has_post() ?>
</article>

<?php get_footer(); ?>