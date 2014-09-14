<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
	<link rel="icon" href="images/temp-ts-fav.png" type="image/png" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php do_action( 'hatch_before_site_wrapper' ); ?>
	<section class="wrapper-site">
		<?php do_action( 'hatch_before_header' ); ?>
		<header class="header-left">
			<?php do_action( 'hatch_before_header_inner' ); ?>
			<div class="container content-vertical clearfix">

				<a href="" class="responsive-nav" id="dashboard-menu-toggle-button">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<?php do_action( 'hatch_before_logo' ); ?>

				<div class="logo">
					<?php do_action( 'hatch_before_logo_inner' ); ?>

					<?php /**
					 * Display Site Logo
					 */
					if( function_exists( 'the_site_logo' ) ) the_site_logo(); ?>

					<h3 class="sitename"><?php echo get_bloginfo( 'title' ); ?></h3>
					<p class="tagline"><?php echo get_bloginfo( 'description' ); ?></p>

					<?php do_action( 'hatch_after_logo_inner' ); ?>
				</div>
				<?php do_action( 'hatch_after_logo' ); ?>

				<?php do_action( 'hatch_before_nav' ); ?>
				<nav>
					<?php wp_nav_menu( array( 'theme_location' => 'primary' , 'container_class' => 'nav nav-horizontal' )); ?>
				</nav>
				<?php do_action( 'hatch_after_nav' ); ?>
			</div>
			<?php do_action( 'hatch_after_header_inner' ); ?>
		</header>
		<?php do_action( 'hatch_after_header' ); ?>