<?php /*
	Template Name: Portfolio
*/

// Do the WP_Query
global $paged;

$terms = get_terms( 'jetpack-portfolio-type' );

get_header(); ?>

<?php get_template_part( 'partials/header' , 'page-title' ); ?>


<section <?php post_class( 'container push-top-large clearfix' ); ?>>
    <?php if( $wp_query->have_posts() ) { ?>
        <div class="row">
            <?php while( $wp_query->have_posts() ) {
                $wp_query->the_post();
                global $post;  ?>
                <?php get_template_part( 'portfolio-list' ); ?>
            <?php }; // while have_posts ?>
        </div>
        <div class="row">
            <?php hatch_pagination( array() ); ?>
        </div>
    <?php }; // if have_posts ?>
</section>
<?php get_footer();