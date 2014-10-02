<?php global $post; ?>
<article class="column span-4 thumbnail with-overlay">
    <?php if( has_post_thumbnail() ) { ?>
        <div class="thumbnail-media">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'landscape-medium' );  ?>
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