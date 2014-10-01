<article class="column span-7">
    <header class="section-title large">
        <?php if( 'post' == get_post_type() ) { ?>
            <h5 class="meta-info"><?php the_date(); ?></h5>
        <?php } // if post ?>
        <h1 class="heading"><?php the_title(); ?></h1>
    </header>
    <div class="story">
        <?php the_content(); ?>
    </div>
    <?php if( 'post' == get_post_type() ) { ?>
        <?php hatch_post_meta( $post->ID ); ?>
    <?php } // if post ?>

    <?php comments_template(); ?>
</article>