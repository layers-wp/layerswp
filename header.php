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
<div id="wrapper">
	<header id="header">
		<div class="container clearfix">
			<a href="" class="responsive-nav" id="dashboard-menu-toggle-button">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="logo">
				<h3><?php echo get_bloginfo('title'); ?></h3>
			</div>
			<nav class="nav nav-horizontal pull-right">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>
		</div>
	</header>