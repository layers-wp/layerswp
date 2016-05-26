<?php
/**
 * This partial is used for displaying the Site Header when in archive pages
 *
 * @package Layers
 * @since Layers 1.0.0
 */

global $layers_page_title_shown;

// Make sure $layers_page_title_shown exists before we check it.
if ( ! isset( $layers_page_title_shown ) ) $layers_page_title_shown = FALSE;

// Fetch the site title array
$details = layers_get_page_title();

if( ! $layers_page_title_shown && ! empty( $details ) ) {

	if( isset( $details[ 'title' ] ) || isset( $details[ 'excerpt' ] ) ) { ?>
		<div <?php layers_wrapper_class( 'title_container', 'title-container' ); ?>>
			<?php do_action('layers_before_header_page_title'); ?>
			<div class="title">
				<?php /**
				* Display Breadcrumbs
				*/
				layers_bread_crumbs();

				if( isset( $details[ 'title' ] ) && '' != $details[ 'title' ] ) { ?>
					<?php do_action('layers_before_title_heading'); ?>
					<h3 class="heading"><?php echo $details[ 'title' ]; ?></h3>
					<?php do_action('layers_after_title_heading'); ?>
				<?php } // if isset $title

				if( isset( $details[ 'excerpt' ] ) && '' != $details[ 'excerpt' ] ) { ?>
					<?php do_action('layers_before_title_excerpt'); ?>
					<div class="excerpt"><?php echo $details[ 'excerpt' ]; ?></div>
					<?php do_action('layers_after_title_excerpt'); ?>
				<?php } // if isset $excerpt ?>
			</div>
			<?php do_action('layers_after_header_page_title'); ?>
		</div>
	<?php }
	
	// Record that we have shown page title - to avoid double titles showing.
	$layers_page_title_shown = TRUE;
}