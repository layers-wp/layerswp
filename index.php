<?php
/**
 * Standard blog index page
 *
 * @package Layers
 * @since Layers 1.0
 */

get_header(); ?>

<section <?php post_class( 'content-main archive clearfix' ); ?>>

    <?php /**
    * Maybe show the left sidebar
    */
    layers_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar' ); ?>

    <?php if( have_posts() ) : ?>
        <div <?php layers_center_column_class(); ?>>
            <?php while( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'partials/content' , 'list' ); ?>
            <?php endwhile; // while has_post(); ?>

            <?php the_posts_pagination(); ?>
        </div>
    <?php endif; // if has_post() ?>

    <?php /**
    * Maybe show the right sidebar
    */
    layers_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar' ); ?>
</section>
<?php get_footer();