<?php global $post, $post_meta_to_display; ?>
<article class="row">
    <header class="section-title">
        <h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <?php if( 'post' == get_post_type() && !empty( $post_meta_to_display ) ) hatch_post_meta( $post->ID, $post_meta_to_display );?>
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
                <a href="<?php the_permalink(); ?>" class="button"><?php _e( 'Read Post &rarr;' , HATCH_THEME_SLUG ); ?></a>
            </div>
        </div>
    </div>
</article>