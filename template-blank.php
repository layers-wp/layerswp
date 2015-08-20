<?php
/**
 * Template Name: Blank Page
 *
 * The template for displaying a full width, unstyled page
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'container content-main clearfix' ); ?>>
    <?php if( have_posts() ) : ?>
        <?php while( have_posts() ) : the_post(); ?>
            <div class="row">
                <article class="column span-12">
                    <?php get_template_part( 'partials/content', 'single' ); ?>
                </article>
            </div>
        <?php endwhile; // while has_post(); ?>
    <?php endif; // if has_post() ?>
</section>

<?php get_footer();