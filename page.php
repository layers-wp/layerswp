<?php
/**
 * The template for displaying a page
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main clearfix' ); ?>>
    <div class="row">
        <?php if( have_posts() ) : ?>
            <?php while( have_posts() ) : the_post(); ?>
                <article <?php hatch_center_column_class(); ?>>
                    <?php get_template_part( 'partials/content', 'single' ); ?>
                </article>
            <?php endwhile; // while has_post(); ?>
        <?php endif; // if has_post() ?>
    </div>
</section>

<?php get_footer(); ?>