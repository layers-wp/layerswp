<?php
/**
 * The template for displaying the 404 page
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header(); ?>

<section class="post content-main clearfix container">
    <div class="row">

        <?php get_sidebar( 'left' ); ?>

        <article <?php layers_center_column_class(); ?>>
            <?php get_template_part( 'partials/content', 'empty' ); ?>
        </article>

        <?php get_sidebar( 'right' ); ?>
    </div>
</section>

<?php get_footer();