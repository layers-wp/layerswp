<?php
/**
 * Standard blog index page
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header();
do_action( 'layers_before_index' ); ?>
<div class="container content-main archive clearfix">
    <div class="grid">
        <?php get_sidebar( 'left' ); ?>
        <?php if (have_posts() ) : ?>
            <div id="post-list" <?php layers_center_column_class(); ?>>
                <?php while ( have_posts() ) : the_post();
                    global $post; ?>
                    <?php get_template_part( 'partials/content' , 'list' ); ?>
                <?php endwhile; // while has_post(); ?>
                <?php layers_pagination(); ?>
            </div>
        <?php endif; // if has_post() ?>

        <?php get_sidebar( 'right' ); ?>
    </div>
</div>
<?php do_action( 'layers_after_index' );
get_footer();