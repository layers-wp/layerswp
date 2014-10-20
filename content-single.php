<article class="column span-7">
    <header class="section-title large">
        <?php if( 'post' == get_post_type() ) { ?>
            <h5 class="meta-info"><?php the_date(); ?></h5>
        <?php } // if post ?>
        <h1 class="heading"><?php the_title(); ?></h1>
    </header>
    <div class="thumbnail push-bottom"><?php echo the_post_thumbnail( 'large' ); ?></div>
    <div class="story">
        <?php the_content(); ?>
        <?php wp_link_pages( array(
            'link_before'   => '<span>',
            'link_after'    => '</span>',
            'before'        => '<p class="inner-post-pagination">' . __('<span>Pages:</span>', 'ocmx'),
            'after'     => '</p>'
        )); ?>
    </div>
    <?php if( 'post' == get_post_type() ) { ?>
        <?php hatch_post_meta( $post->ID ); ?>
    <?php } // if post ?>

    <?php comments_template(); ?>
</article>