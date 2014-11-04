<?php
/**
 * Template Name: Right Sidebar
 *
 * The template for displaying a full width page
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
    <div class="row">
        <article <?php hatch_center_column_class( $post->ID ); ?>>
            <?php if( have_posts() ) : ?>
                <?php while( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'partials/content', 'single' ); ?>
                <?php endwhile; // while has_post(); ?>
            <?php endif; // if has_post() ?>
        </article>
        <?php /**
        * Maybe show the left sidebar
        */
        hatch_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar' ); ?>
    </div>
</section>

<?php get_footer(); ?>