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
	<?php do_action( 'hatch_before_site_wrapper' ); ?>
	<section class="wrapper-site">
		<?php do_action( 'hatch_before_header' ); ?>
		<?php get_template_part( 'partials/header' , 'secondary' ); ?>
		<header <?php hatch_header_class(); ?>>
			<?php do_action( 'hatch_before_header_inner' ); ?>
			<div class="container content-vertical clearfix">

				<a href="" class="responsive-nav" id="dashboard-menu-toggle-button">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<?php get_template_part( 'partials/header' , 'logo' ); ?>

				<?php do_action( 'hatch_before_header_nav' ); ?>
				<?php wp_nav_menu( array( 'theme_location' => HATCH_THEME_SLUG . '-primary' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => false )); ?>
				<?php do_action( 'hatch_after_header_nav' ); ?>
			</div>
			<?php do_action( 'hatch_after_header_inner' ); ?>
		</header>
		<?php do_action( 'hatch_after_header' ); ?>