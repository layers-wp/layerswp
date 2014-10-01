<?php do_action( 'hatch_before_logo' ); ?>
<div class="logo">
    <?php do_action( 'hatch_before_logo_inner' ); ?>

    <?php /**
     * Display Site Logo
     */
    if( function_exists( 'the_site_logo' ) ) the_site_logo(); ?>
    <div class="site-description">
        <h3 class="sitename"><?php echo get_bloginfo( 'title' ); ?></h3>
        <p class="tagline"><?php echo get_bloginfo( 'description' ); ?></p>
    </div>

    <?php do_action( 'hatch_after_logo_inner' ); ?>
</div>
<?php do_action( 'hatch_after_logo' ); ?>