<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php get_sidebar( 'off-canvas'); ?>
	<?php do_action( 'layers_before_site_wrapper' ); ?>
	<div <?php layer_site_wrapper_class(); ?>>

		<?php do_action( 'layers_before_header' ); ?>

		<?php get_template_part( 'partials/header' , 'secondary' ); ?>

		<section <?php layers_header_class(); ?> >
			<?php do_action( 'layers_before_header_inner' ); ?>
			<div class="<?php if( 'layout-fullwidth' != layers_get_theme_mod( 'header-width' ) ) echo 'container'; ?> header-block">
				<?php if( 'header-logo-center' == layers_get_theme_mod( 'header-menu-layout' ) ) {
					get_template_part( 'partials/header' , 'centered' );
				} else {
					get_template_part( 'partials/header' , 'standard' );
				} // if centered header ?>
			</div>
			<?php do_action( 'layers_after_header_inner' ); ?>
		</section>

		<?php do_action( 'layers_after_header' ); ?>

		<section id="wrapper-content" <?php layers_wrapper_class( 'wrapper_content', 'wrapper-content' ); ?>>