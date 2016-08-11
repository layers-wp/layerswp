<?php
/**
 * This partial is used for displaying single post (or page) content
 *
 * @package Layers
 * @since Layers 1.0.0
 */

global $post, $layers_post_meta_to_display, $layers_page_title_shown;

// Make sure $layers_page_title_shown exists before we check it.
if ( ! isset( $layers_page_title_shown ) ) $layers_page_title_shown = FALSE;

do_action('layers_before_single_post');

if ( ! $layers_page_title_shown ) { ?>
	<?php do_action('layers_before_single_post_title'); ?>
	<header class="section-title large">
		<?php if( 'post' == get_post_type() ) { ?>
			<?php do_action('layers_before_single_title_meta'); ?>
				<?php /**
				* Display the Post Date only
				*/
				layers_post_meta( get_the_ID(), array( 'date' ) , 'h5', 'meta-info' ); ?>
			<?php do_action('layers_after_single_title_meta'); ?>
		<?php } // if post ?>
		<?php do_action('layers_before_single_title'); ?>
			<h1 class="heading"><?php the_title(); ?></h1>
		<?php do_action('layers_after_single_title'); ?>
	</header>
	<?php do_action('layers_after_single_post_title'); ?>
	<?php
	
	// Record that we have shown page title - to avoid double titles showing.
	$layers_page_title_shown = TRUE;
}

/**
* Display the Featured Thumbnail
*/
echo layers_post_featured_media( array( 'postid' => get_the_ID(), 'wrap_class' => 'thumbnail push-bottom', 'size' => 'large' ) );

if ( '' != get_the_content() ) { ?>
	<?php do_action('layers_before_single_content'); ?>

	<?php if( 'template-blank.php' != get_page_template_slug() ) { ?>
		<div class="story">
	<?php } ?>

	<?php /**
	* Display the Content
	*/
	the_content(); ?>

	<?php /**
	* Display In-Post Pagination
	*/
	wp_link_pages( array(
		'link_before'   => '<span>',
		'link_after'    => '</span>',
		'before'        => '<p class="inner-post-pagination">' . __('<span>Pages:</span>', 'layerswp'),
		'after'     => '</p>'
	)); ?>

	<?php if( 'template-blank.php' != get_page_template_slug() ) { ?>
		</div>
	<?php } ?>

	<?php do_action('layers_after_single_content'); ?>
<?php } // '' != get_the_content()

/**
 * Only show post meta for posts
 */
if( 'post' == get_post_type() ) {
	/**
	* Display the Post Meta
	*/
	layers_post_meta( get_the_ID() );
} // if post

/**
* Display the Post Comments
*/
comments_template();

do_action('layers_after_single_post');