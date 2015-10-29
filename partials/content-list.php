<?php
/**
 * This template is used for displaying posts in post lists
 *
 * @package Layers
 * @since Layers 1.0.0
 */

global $post, $layers_post_meta_to_display; ?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'push-bottom-large' ); ?>>
	<?php do_action('layers_before_list_post_title'); ?>
	<header class="section-title large">
		<?php do_action('layers_before_list_title'); ?>
		<h1 class="heading"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php do_action('layers_after_list_title'); ?>
	</header>
	<?php do_action('layers_after_list_post_title'); ?>

	<?php /**
	* Display the Featured Thumbnail
	*/
	echo layers_post_featured_media( array( 'postid' => get_the_ID(), 'wrap_class' => 'thumbnail push-bottom', 'size' => 'large' ) ); ?>

	<?php if( '' != get_the_excerpt() || '' != get_the_content() ) { ?>
		<?php do_action('layers_before_list_post_content'); ?>
		<?php do_action('layers_list_post_content'); ?>
		<?php do_action('layers_after_list_post_content'); ?>
	<?php } ?>

	<?php do_action('layers_before_list_post_meta'); ?>
		<?php /**
		* Display the Post Meta
		*/
		layers_post_meta( get_the_ID(), NULL, 'footer', 'meta-info push-bottom' ); ?>
	<?php do_action('layers_after_list_post_meta'); ?>

	<?php do_action('layers_before_list_read_more'); ?>
	<?php do_action('layers_list_read_more'); ?>
	<?php do_action('layers_after_list_read_more'); ?>
</article>