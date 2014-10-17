<?php get_template_part( 'partials/header' , 'logo' ); ?>

<?php do_action( 'hatch_before_header_nav' ); ?>
<?php wp_nav_menu( array( 'theme_location' => HATCH_THEME_SLUG . '-primary' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => false )); ?>
<?php do_action( 'hatch_after_header_nav' );