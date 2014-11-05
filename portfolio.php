<?php
/**
 * Template Name: Portfolio
 *
 * The template for displaying portfolio posts
 *
 * @package Hatch
 * @since Hatch 1.0
 */

// Do the WP_Query
global $paged;
$query_args = array();
$query_args[ 'post_type' ] = 'jetpack-portfolio';
$query_args[ 'paged' ] = ( isset( $paged ) ) ? $paged : 0;
$portfolio_query = new WP_Query( $query_args );

$terms = get_terms( 'jetpack-portfolio-type' );

get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>

<section <?php post_class( 'push-top-large clearfix' ); ?>>
    <?php if( $portfolio_query->have_posts() ) { ?>
        <div class="row">
            <?php while( $portfolio_query->have_posts() ) {
                $portfolio_query->the_post();
                global $post; ?>
                <?php get_template_part( 'portfolio-list' ); ?>
            <?php }; // while have_posts ?>
        </div>
        <div class="row">
            <?php hatch_pagination( array( 'query' => $portfolio_query ) ); ?>
        </div>
    <?php }; // if have_posts ?>
</section>
<?php get_footer();