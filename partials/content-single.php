<?php
/**
 * This partial is used for displaying single post (or page) content
 *
 * @package Hatch
 * @since Hatch 1.0
 */

global $post, $post_meta_to_display, $page_title_shown; ?>
<?php if( !isset( $page_title_shown ) ) { ?>
    <header class="section-title large">
        <?php if( 'post' == get_post_type() ) { ?>
            <h5 class="meta-info"><?php the_date(); ?></h5>
        <?php } // if post ?>
        <h1 class="heading"><?php the_title(); ?></h1>
    </header>
<?php } ?>
<?php if( has_post_thumbnail() ) { ?>
    <div class="thumbnail push-bottom"><?php echo the_post_thumbnail( 'large' ); ?></div>
<?php } // if has_post_thumbnail() ?>
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
    <?php hatch_post_meta( $post->ID ); ?>
<?php } // if post ?>

<?php comments_template(); ?>
