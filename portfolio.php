<?php /*
	Template Name: Portfolio
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


<section <?php post_class( 'container push-top-large clearfix' ); ?>>
    <?php if( $portfolio_query->have_posts() ) { ?>
        <div class="row">
            <?php while( $portfolio_query->have_posts() ) {
                $portfolio_query->the_post();
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
            <?php hatch_pagination( array( 'query' => $portfolio_query ) ); ?>
        </div>
    <?php }; // if have_posts ?>
</section>
<?php get_footer();