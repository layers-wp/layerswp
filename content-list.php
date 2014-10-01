<?php global $post, $post_meta_to_display; ?>
<article class="row">
    <header class="section-title large">
        <h1 class="heading"><?php the_title(); ?></h1>
    </header>
    <div class="row">
        <?php $content_class = 'span-12'; ?>
        <?php if( has_post_thumbnail() ) { ?>
            <div class="column span-4 thumbnail-media">
                <?php echo the_post_thumbnail( 'medium' ); ?>
            </div>
            <?php $content_class = 'span-8'; ?>
        <?php } // if has_post_thumbnail() ?>
        <div class="column <?php echo $content_class; ?>">
            <div class="copy">
                <?php the_excerpt(); ?>
                <?php hatch_post_meta( $post->ID ); ?>
                <a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read Post &rarr;' , HATCH_THEME_SLUG ); ?></a>
            </div>
        </div>
    </div>
</article>