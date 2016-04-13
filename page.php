<?php
/**
 * The template for displaying a page
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>

<div <?php post_class( 'container content-main clearfix' ); ?>>
	<?php do_action('layers_before_page_loop'); ?>
    <div class="grid">
        <?php if( have_posts() ) : ?>
            <?php while( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php layers_center_column_class(); ?>>
                    <?php get_template_part( 'partials/content', 'single' ); ?>
                </article>
            <?php endwhile; // while has_post(); ?>
        <?php endif; // if has_post() ?>
    </div>
    <?php do_action('layers_after_page_loop'); ?>
</div>

<?php get_footer();