<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="icon" href="images/temp-ts-fav.png" type="image/png" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php get_sidebar( 'off-canvas'); ?>
	<?php do_action( 'layers_before_site_wrapper' ); ?>
	<section class="wrapper-site">

		<?php do_action( 'layers_before_header' ); ?>

		<?php get_template_part( 'partials/header' , 'secondary' ); ?>
		
		<?php
		// Apply customizer header settings.
		if( layers_get_theme_mod( 'header-layout-background-color' ) ){
			layers_inline_styles( 'nothing', 'color', array( 'color' => '#333' ) ); // Temp Fix
			wp_add_inline_style( LAYERS_THEME_SLUG . '-inline-styles', '.header-fixed { background-color: rgba(' . implode( ', ' , hex2rgb( layers_get_theme_mod( 'header-layout-background-color' ) ) ) . ', 0.3); }' );
		}
		?>
		
		<header <?php layers_header_class(); ?> >
			<?php do_action( 'layers_before_header_inner' ); ?>
			<div class="<?php if( 'layout-fullwidth' != layers_get_theme_mod( 'header-layout-width' ) ) echo 'container'; ?> clearfix">
				<?php if( 'header-logo-center' == layers_get_theme_mod( 'header-layout-layout' ) ) { ?>
					<?php get_template_part( 'partials/header' , 'centered' ); ?>
				<?php } else { ?>
					<?php get_template_part( 'partials/header' , 'standard' ); ?>
				<?php } // if centered header ?>
			</div>
			<?php do_action( 'layers_after_header_inner' ); ?>
		</header>

		<?php do_action( 'layers_after_header' ); ?>

		<section id="wrapper-content" class="wrapper-content">