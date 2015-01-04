<?php
/**
 * This template is used for displaying posts in post lists
 *
 * @package Layers
 * @since Layers 1.0
 */

global $post, $post_meta_to_display; ?>
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
    <?php if( '' != get_the_excerpt() || '' != get_the_content() ) { ?>
        <div class="copy">
            <?php the_excerpt(); ?>
        </div>
    <?php } ?>
    <?php layers_post_meta( $post->ID, NULL, 'footer', 'meta-info push-bottom' ); ?>
    <p><a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read More' , LAYERS_THEME_SLUG ); ?></a></p>
</article>