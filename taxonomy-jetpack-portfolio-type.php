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
                global $post; ?>
                <article class="column span-4 thumbnail">
                    <?php if( has_post_thumbnail() ) { ?>
                        <div class="thumbnail-media">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'square-large' );  ?>
                            </a>
                        </div>
                    <?php } // if post thumbnail ?>
                    <div class="thumbnail-body">
                        <div class="overlay">
                            <header class="article-title">
                                <h4 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </header>
                            <?php echo '<p class="excerpt">' . get_the_excerpt() . '</p>'; ?>
                            <a href="<?php the_permalink(); ?>" class="button"><?php _e( 'View Project' , HATCH_THEME_SLUG ); ?></a>
                        </div>
                    </div>
                </article>
            <?php }; // while have_posts ?>
        </div>
        <div class="row">
            <?php hatch_pagination( array() ); ?>
        </div>
    <?php }; // if have_posts ?>
</section>
<?php get_footer();