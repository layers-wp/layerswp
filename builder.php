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
<?php } else {

	// Get the page layout
	$page_layout = get_post_meta( get_the_ID(), 'layers_page_layout' , true );

	switch( $page_layout ){
		case 'left-sidebar' :
			$show_left_sidebar = true;
			$show_right_sidebar = false;
			$center_col_cass = 'span-8';
			break;
		case 'right-sidebar' :
			$show_left_sidebar = false;
			$show_right_sidebar = true;
			$center_col_cass = 'span-8';
			break;
		case 'left-right-sidebar' :
			$show_left_sidebar = true;
			$show_right_sidebar = true;
			$center_col_cass = 'span-6';
			break;
		default:
			$show_left_sidebar = false;
			$show_right_sidebar = false;
			$center_col_cass = 'span-12';
			break;
	}
	if( $show_left_sidebar ) get_sidebar( 'left' ); ?>
	<div class="<?php echo $center_col_cass; ?>">
		<?php dynamic_sidebar( 'obox-layers-builder-' . $post->ID ); ?>
	</div>
	<?php if( $show_left_sidebar ) get_sidebar( 'right' );
}

do_action('after_layers_builder_widgets');

get_footer();