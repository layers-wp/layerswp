<?php do_action( 'layers_before_header_nav' ); ?>
<div class="column span-5 text-right">
    <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => 'layers_menu_fallback' ) ); ?>
</div>

<div class="column span-2">
    <?php get_template_part( 'partials/header' , 'logo' ); ?>
</div>

<div class="column span-5 no-gutter">
    <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary-right' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => create_function('', 'echo "&nbsp";') ) ); ?>
    <a href="" class="responsive-nav"  data-toggle="#off-canvas-right" data-toggle-class="open">
        <span class="h-menu"></span>
    </a>
</div>
<?php do_action( 'layers_after_header_nav' ); ?>