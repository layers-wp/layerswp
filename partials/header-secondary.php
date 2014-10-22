<?php if ( !hatch_get_theme_mod( 'header-layout-display-top-header' ) ) return;  ?>
<?php if ( has_nav_menu( HATCH_THEME_SLUG . '-secondary-left' ) || has_nav_menu( HATCH_THEME_SLUG . '-secondary-right' ) ) { ?>
    <div class="header-secondary content-small darken invert">
        <?php do_action( 'hatch_before_header_secondary_inner' ); ?>
            <div class="container clearfix">
                <?php do_action( 'hatch_before_header_secondary_left_nav' ); ?>
                <?php wp_nav_menu( array( 'theme_location' => HATCH_THEME_SLUG . '-secondary-left' ,'container' => 'nav', 'container_class' => 'pull-left' , 'menu_class' => 'nav nav-horizontal')); ?>
                <?php do_action( 'hatch_after_header_secondary_left_nav' ); ?>

                <?php do_action( 'hatch_before_header_secondary_right_nav' ); ?>
                <?php wp_nav_menu( array( 'theme_location' => HATCH_THEME_SLUG . '-secondary-right' ,'container' => 'nav', 'container_class' => 'pull-right' , 'menu_class' => 'nav nav-horizontal' )); ?>
                <?php do_action( 'hatch_after_header_secondary_right_nav' ); ?>
            </div>
        <?php do_action( 'hatch_after_header_secondary_inner' ); ?>
    </div>
<?php } // menus in use