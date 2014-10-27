<?php
/**
 * Standard blog index page
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header(); ?>
<section <?php post_class( 'container content-main archive clearfix' ); ?>>
    <?php if( have_posts() ) : ?>
        <div class="column span-7">
            <?php while( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'content' , 'list' ); ?>
            <?php endwhile; // while has_post(); ?>
            <?php hatch_pagination(); ?>
        </div>
    <?php endif; // if has_post() ?>

    <div class="column span-4 pull-right well sidebar">
        <?php get_sidebar(); ?>
    </div>
</section>
<?php get_footer(); ?>