<?php do_action( 'layers_before_logo' ); ?>
<div class="logo">
    <?php do_action( 'layers_before_logo_inner' ); ?>

    <?php /**
     * Display Site Logo
     */
    if ( function_exists( 'jetpack_the_site_logo' ) ) jetpack_the_site_logo(); ?>

    <?php if('blank' != get_theme_mod('header_textcolor') ) { ?>
        <div class="site-description">
            <h3 class="sitename sitetitle"><a href="<?php echo home_url(); ?>"><?php echo get_bloginfo( 'title' ); ?></a></h3>
            <p class="tagline"><?php echo get_bloginfo( 'description' ); ?></p>
        </div>
    <?php } ?>

    <?php do_action( 'layers_after_logo_inner' ); ?>
</div>
<?php do_action( 'layers_after_logo' ); ?>