<?php
/**
 * The template for displaying a single portfolio post
 *
 * @package Layers
 * @since Layers 1.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main clearfix' ); ?>>
	<?php if( have_posts() ) : ?>
		<?php while( have_posts() ) : the_post(); ?>
			<div class="row">
				<div class="column span-4">
					<?php layers_bread_crumbs(); ?>

					<header class="section-title large">
						<h1 class="heading"><?php the_title(); ?></h1>
					</header>


					<!-- TODO: Wrap this in an if there's copy -->
					<div class="copy push-bottom-large">
						<?php the_content() ;?>
					</div>

					<?php layers_post_meta( get_the_ID() ); ?>
				</div>
				<div class="column span-7 pull-right sidebar">
					<?php // Layers Featured Media
					echo layers_post_featured_media( array( 'postid' => get_the_ID(), 'wrap_class' => 'thumbnail push-bottom', 'size' => 'full' ) ); ?>
					<?php $attachments = get_posts( array(
						'post_type' => 'attachment',
						'posts_per_page' => -1,
						'post_parent' => get_the_ID(),
						'exclude'     => get_post_thumbnail_id()
						) ); ?>

					<?php if ( $attachments ) { ?>
						<div class="row">
							<?php foreach ( $attachments as $attachment ) { ?>
								<div class="column span-3">
									<div class="thumbnail">
										<a href="<?php echo wp_get_attachment_url( $attachment->ID ); ?>">
											<?php echo wp_get_attachment_image( $attachment->ID, 'square-medium' ); ?>
										</a>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php endwhile; // while has_post(); ?>
	<?php endif; // if has_post() ?>
</section>

<?php get_footer(); ?>