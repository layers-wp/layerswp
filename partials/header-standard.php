<?php get_template_part( 'partials/header' , 'logo' );

// Set Header Menu Layout
$header_menu_layout = layers_get_theme_mod( 'header-menu-layout');
if( 'header-sidebar' == $header_menu_layout ) {
	$nav_class = 'nav-vertical';
} else {
	$nav_class = 'nav-horizontal';
} ?>

<nav class="nav <?php echo esc_attr( $nav_class ); ?>">
    <?php do_action( 'layers_before_header_nav' ); ?>

    <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary' ,'container' => FALSE, 'fallback_cb' => 'layers_menu_fallback' )); ?>

    <?php do_action( 'layers_after_header_nav' ); ?>

    <?php get_template_part( 'partials/responsive' , 'nav-button' ); ?>

</nav>