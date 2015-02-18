<?php
/**
 * The template for displaying a single post
 *
 * @package Layers
 * @since Layers 1.0
 */

get_header(); ?>

<section id="post-<?php the_ID(); ?>" <?php post_class( 'content-main clearfix' ); ?>>
    <div class="row">

        <?php get_sidebar( 'left' ); ?>

        <article <?php layers_center_column_class(); ?>>
            <?php get_template_part( 'partials/content', 'empty' ); ?>
        </article>

        <?php get_sidebar( 'right' ); ?>
    </div>
</section>

<?php get_footer(); ?>