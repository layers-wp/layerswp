<?php get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<?php while( have_posts() ) : the_post(); ?>
			<div class="row">
	            <div class="column span-4">
					<?php hatch_bread_crumbs(); ?>

					<header class="section-title large">
						<h1 class="heading"><?php the_title(); ?></h1>
					</header>

					<div class="copy push-bottom-large">
						<?php the_content() ;?>
					</div>

					<?php hatch_post_meta( $post->ID ); ?>
				</div>
            	<div class="column span-7 pull-right sidebar">
					<?php if( has_post_thumbnail() ) { ?>
						<div class="thumbnail push-bottom">
							<?php echo the_post_thumbnail( 'full' ); ?>
						</div>
					<?php } // if has_post_thumbnail() ?>
					<div class="row">
						<div class="column span-3">
							<div class="thumbnail">
								<a href=""class="thumbnail-media">
									<img src="images/thumbnail.jpg" alt="Thumbnail" />
								</a>
							</div>
						</div>
						<div class="column span-3">
							<div class="thumbnail">
								<a href=""class="thumbnail-media">
									<img src="images/thumbnail.jpg" alt="Thumbnail" />
								</a>
							</div>
						</div>
						<div class="column span-3">
							<div class="thumbnail">
								<a href=""class="thumbnail-media">
									<img src="images/thumbnail.jpg" alt="Thumbnail" />
								</a>
							</div>
						</div>
						<div class="column span-3">
							<div class="thumbnail">
								<a href=""class="thumbnail-media">
									<img src="images/thumbnail.jpg" alt="Thumbnail" />
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; // while has_post(); ?>
	<?php endif; // if has_post() ?>
</section>

<?php get_footer(); ?>