<?php
/**
 * Template Name: Left Sidebar
 *
 * The template for displaying a full width page
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main clearfix' ); ?>>
    <div class="row">

        <?php /**
        * Maybe show the left sidebar
        */
        hatch_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar span-3' ); ?>

        <article <?php hatch_center_column_class(); ?>>
            <?php if( have_posts() ) : ?>
                <?php while( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'partials/content', 'single' ); ?>
                <?php endwhile; // while has_post(); ?>
            <?php endif; // if has_post() ?>
        </article>
    </div>
</section>

<?php get_footer(); ?>