<?php
/**
 * This partial is used for displaying single post (or page) content
 *
 * @package Layers
 * @since Layers 1.0.0
 */

global $post, $layers_post_meta_to_display, $layers_page_title_shown; ?>
<?php if( !isset( $layers_page_title_shown ) ) { ?>
    <header class="section-title large">
        <?php if( 'post' == get_post_type() ) { ?>
            <?php layers_post_meta( get_the_ID(), array( 'date' ) , 'h5', 'meta-info' ); ?>
        <?php } // if post ?>
        <h1 class="heading"><?php the_title(); ?></h1>
    </header>
<?php } ?>
<?php // Layers Featured Media
echo layers_post_featured_media( array( 'postid' => get_the_ID(), 'wrap_class' => 'thumbnail push-bottom', 'size' => 'large' ) ); ?>
<?php if ( '' != get_the_content() ) { ?>
    <?php if( 'template-blank.php' != get_page_template_slug() ) { ?>
        <div class="story">
    <?php } ?>

        <?php the_content(); ?>
        <?php wp_link_pages( array(
            'link_before'   => '<span>',
            'link_after'    => '</span>',
            'before'        => '<p class="inner-post-pagination">' . __('<span>Pages:</span>', 'ocmx'),
            'after'     => '</p>'
        )); ?>

    <?php if( 'template-blank.php' != get_page_template_slug() ) { ?>
        </div>
    <?php } ?>
<?php } // '' != get_the_content() ?>

<?php /**
 * Only show post meta for posts
 */
if( 'post' == get_post_type() ) { ?>
    <?php layers_post_meta( get_the_ID() ); ?>
<?php } // if post ?>

<?php comments_template(); ?>
