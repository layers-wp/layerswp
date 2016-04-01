<?php
/**
 * This partial is used for displaying the Site Title and Logo
 *
 * @package Layers
 * @since Layers 1.0.0
 */

do_action( 'layers_before_logo' ); ?>
<div class="logo">
	<?php do_action( 'layers_before_logo_inner' ); ?>

	<?php /**
	* Display Site Logo
	*/
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	} elseif( function_exists( 'jetpack_the_site_logo' ) ) {
		jetpack_the_site_logo();
	}

	if('blank' != get_theme_mod('header_textcolor') ) { ?>
		<div class="site-description">
			<?php do_action( 'layers_before_site_description' ); ?>
			<h3 class="sitename sitetitle"><a href="<?php echo home_url(); ?>"><?php echo get_bloginfo( 'title' ); ?></a></h3>
			<p class="tagline"><?php echo get_bloginfo( 'description' ); ?></p>
			<?php do_action( 'layers_after_site_description' ); ?>
		</div>
	<?php }

	do_action( 'layers_after_logo_inner' ); ?>
</div>
<?php do_action( 'layers_after_logo' );