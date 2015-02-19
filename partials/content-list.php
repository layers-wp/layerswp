<?php
/**
 * This template is used for displaying posts in post lists
 *
 * @package Layers
 * @since Layers 1.0.0
 */

global $post, $layers_post_meta_to_display; ?>
<article class="push-bottom-large">
    <header class="section-title large">
        <h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    </header>
    <?php // Layers Featured Media
    echo layers_post_featured_media( array( 'postid' => get_the_ID(), 'wrap_class' => 'thumbnail push-bottom', 'size' => 'large' ) ); ?>
    <?php if( '' != get_the_excerpt() || '' != get_the_content() ) { ?>
        <div class="copy">
            <?php the_excerpt(); ?>
        </div>
    <?php } ?>
    <?php layers_post_meta( get_the_ID(), NULL, 'footer', 'meta-info push-bottom' ); ?>
    <p><a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read More' , 'layerswp' ); ?></a></p>
</article>