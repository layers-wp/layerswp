<?php get_header(); ?>
<div class="title-container">
	<div class="title">
		<h3 class="header"><?php echo single_cat_title( '', false ); ?></h3>
		<?php
		// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<p class="excerpt">%s</p>', $term_description );
			endif;
		?>
	</div>
</div>
<section <?php post_class( 'container content-main archive clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<div class="column span-7">
			<?php while( have_posts() ) : the_post(); ?>
				<article class="row">
					<header class="section-title">
						<h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
						<h5 class="the-date"><?php the_date(); ?></h5>
					</header>
					<div class="row">
						<?php $content_class = 'span-12'; ?>
						<?php if( has_post_thumbnail() ) { ?>
							<div class="column span-4 thumbnail-media">
								<?php echo the_post_thumbnail( 'medium' ); ?>
							</div>
							<?php $content_class = 'span-8'; ?>
						<?php } // if has_post_thumbnail() ?>
						<div class="column <?php echo $content_class; ?>">
							<div class="copy">
								<?php the_excerpt(); ?>
								<a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read Post &rarr;' , HATCH_THEME_SLUG ); ?></a>
							</div>
						</div>
					</div>
				</article>
			<?php endwhile; // while has_post(); ?>
		</div>
	<?php endif; // if has_post() ?>
	<div class="column span-4 pull-right well content">
		<?php get_sidebar(); ?>
	</div>
</section>
<?php get_footer(); ?>