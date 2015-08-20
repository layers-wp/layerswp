<?php
/**
 * Template Name: Right Sidebar
 *
 * The template for displaying a full width page
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
    <div class="row">
        <article <?php layers_center_column_class(); ?>>
            <?php if( have_posts() ) : ?>
                <?php while( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'partials/content', 'single' ); ?>
                <?php endwhile; // while has_post(); ?>
            <?php endif; // if has_post() ?>
        </article>

        <?php get_sidebar( 'right' ); ?>
    </div>
</section>

<?php get_footer();