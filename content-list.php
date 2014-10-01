<?php global $post, $post_meta_to_display; ?>
<article class="push-bottom-large">
    <header class="section-title large">
        <h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    </header>
    <?php if( has_post_thumbnail() ) { ?>
        <div class="thumbnail push-bottom">
            <a href="<?php the_permalink(); ?>">
                <?php echo the_post_thumbnail( 'large' ); ?>
            </a>
        </div>
    <?php } // if has_post_thumbnail() ?>
    <div class="copy">
        <?php the_excerpt(); ?>
    </div>
    <?php hatch_post_meta( $post->ID, NULL, 'footer', 'meta-info push-bottom' ); ?>
    <p><a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read More' , HATCH_THEME_SLUG ); ?></a></p>
</article>