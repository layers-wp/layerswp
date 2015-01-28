<?php
/**
 * The template for displaying portfolio archives
 *
 * @package Layers
 * @since Layers 1.0
 */

// Do the WP_Query
global $paged;

$terms = get_terms( 'jetpack-portfolio-type' );

get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>


<section <?php post_class( 'push-top-large clearfix' ); ?>>
    <?php if( have_posts() ) { ?>
        <div class="row">
            <?php while( have_posts() ) {
                 the_post(); ?>
                <?php get_template_part( 'partials/portfolio-list' ); ?>
            <?php }; // while have_posts ?>
        </div>
        <div class="row">
            <?php layers_pagination( array() ); ?>
        </div>
    <?php }; // if have_posts ?>
</section>
<?php get_footer();