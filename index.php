<?php
/**
 * Standard blog index page
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>
<section <?php post_class( 'container content-main archive clearfix' ); ?>>

    <?php /**
    * Maybe show the left sidebar
    */
    hatch_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar' ); ?>

    <?php if( have_posts() ) : ?>
        <div class="column span-7">
            <?php while( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'partials/content' , 'list' ); ?>
            <?php endwhile; // while has_post(); ?>
            <?php hatch_pagination(); ?>
        </div>
    <?php endif; // if has_post() ?>

    <?php /**
    * Maybe show the right sidebar
    */
    hatch_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar' ); ?>
</section>
<?php get_footer(); ?>