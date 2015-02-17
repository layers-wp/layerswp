<div class="column inline-left-nav">
    <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => 'layers_menu_fallback' ) ); ?>
</div>

<div class="column inline-right-nav">
	<?php do_action( 'layers_before_header_nav' ); ?>
    <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary-right' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => create_function('', 'echo "&nbsp";') ) ); ?>
    <?php get_template_part( 'partials/responsive' , 'nav-button' ); ?>
    <?php do_action( 'layers_after_header_nav' ); ?>
</div>

<div class="column inline-site-logo">
    <?php get_template_part( 'partials/header' , 'logo' ); ?>
</div>