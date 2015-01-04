<?php if ( !layers_get_theme_mod( 'header-layout-display-top-header' ) ) return;  ?>
<?php if ( has_nav_menu( LAYERS_THEME_SLUG . '-secondary-left' ) || has_nav_menu( LAYERS_THEME_SLUG . '-secondary-right' ) ) { ?>
    <div class="header-secondary content-small darken invert">
        <?php do_action( 'layers_before_header_secondary_inner' ); ?>
            <div class="container clearfix">
                <?php do_action( 'layers_before_header_secondary_left_nav' ); ?>
                <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-secondary-left' ,'container' => 'nav', 'container_class' => 'pull-left' , 'menu_class' => 'nav nav-horizontal', 'fallback_cb' => false )); ?>
                <?php do_action( 'layers_after_header_secondary_left_nav' ); ?>

                <?php do_action( 'layers_before_header_secondary_right_nav' ); ?>
                <?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-secondary-right' ,'container' => 'nav', 'container_class' => 'pull-right' , 'menu_class' => 'nav nav-horizontal', 'fallback_cb' => false )); ?>
                <?php do_action( 'layers_after_header_secondary_right_nav' ); ?>
            </div>
        <?php do_action( 'layers_after_header_secondary_inner' ); ?>
    </div>
<?php } // menus in use