<?php get_template_part( 'partials/header' , 'logo' ); ?>

<nav class="nav nav-horizontal">
    <?php do_action( 'layers_before_header_nav' ); ?>
    
    <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary' ,'container' => FALSE, 'fallback_cb' => 'layers_menu_fallback' )); ?>
    
    <?php get_template_part( 'partials/responsive' , 'nav-button' ); ?>
    
    <?php do_action( 'layers_after_header_nav' ); ?>
</nav>