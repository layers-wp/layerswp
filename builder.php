<?php
/**
 * Template Name: Layers Template
 *
 * This template is used for displaying the Layers page builder
 *
 * @package Layers
 * @since Layers 1.0.0
 */

get_header();
global $post;

do_action('before_layers_builder_widgets');
if ( post_password_required() ) { ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'content-main clearfix' ); ?>>
		<?php do_action('layers_before_post_loop'); ?>
		<div class="grid">
			<?php do_action('layers_before_private_post'); ?>
			<div class="story">
				<?php echo get_the_password_form(); ?>
			</div>
			<?php do_action('layers_after_private_post'); ?>
		</div>
		<?php do_action('layers_after_post_loop'); ?>
	</div>
<?php } else { ?>
	<div id="<?php echo 'obox-layers-builder-' . $post->ID; ?>">
		<?php dynamic_sidebar( 'obox-layers-builder-' . $post->ID ); ?>
	</div>
<?php }

do_action('after_layers_builder_widgets');

get_footer();