<?php
/**
 * Standard blog index page
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>

<div class="container content-main archive clearfix">
    <?php get_sidebar( 'left' ); ?>

    <?php if( have_posts() ) : ?>
        <div <?php layers_center_column_class(); ?>>
            <?php while( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'partials/content' , 'list' ); ?>
            <?php endwhile; // while has_post(); ?>
            <?php the_posts_pagination(); ?>
        </div>
    <?php endif; // if has_post() ?>

    <?php get_sidebar( 'right' ); ?>
</div>
<?php get_footer();