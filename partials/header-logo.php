<?php do_action( 'hatch_before_logo' ); ?>
<div class="logo">
    <?php do_action( 'hatch_before_logo_inner' ); ?>

    <?php /**
     * Display Site Logo
     */

    if( function_exists( 'the_site_logo' ) ) the_site_logo(); ?>
    <?php if('blank' != get_theme_mod('header_textcolor') ) { ?>
        <div class="site-description">
            <h3 class="sitename"><a href="<?php home_url(); ?>"><?php echo get_bloginfo( 'title' ); ?></a></h3>
            <p class="tagline"><?php echo get_bloginfo( 'description' ); ?></p>
        </div>
    <?php } ?>

    <?php do_action( 'hatch_after_logo_inner' ); ?>
</div>
<?php do_action( 'hatch_after_logo' ); ?>