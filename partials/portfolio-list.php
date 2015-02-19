<?php
/**
 * This partial is used to display portfolio list content
 *
 * @package Layers
 * @since Layers 1.0.0
 */

global $post; ?>
<article class="column span-4 thumbnail with-overlay">
    <?php // Layers Featured Media
    echo layers_post_featured_media( array( 'postid' => get_the_ID(), 'wrap_class' => 'thumbnail push-bottom', 'size' => 'full' ) ); ?>

    <div class="thumbnail-body">
        <div class="overlay">
            <header class="article-title">
                <h4 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            </header>
            <?php if( '' != get_the_excerpt() || '' != get_the_content() ) { ?>
                <div class="copy">
                    <?php the_excerpt(); ?>
                </div>
            <?php } ?>
            <a href="<?php the_permalink(); ?>" class="button"><?php _e( 'View Project' , 'layerswp' ); ?></a>
        </div>
    </div>
</article>