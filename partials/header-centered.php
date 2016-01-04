<?php
/**
 * This partial is used for displaying the centered header option
 *
 * @package Layers
 * @since Layers 1.0.0
 */ ?>
<div class="inline-left-nav">
	<nav class="nav nav-horizontal">
		<?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary' ,'container' => FALSE, 'fallback_cb' => 'layers_menu_fallback' )); ?>
	</nav>
</div>

<div class="inline-site-logo">
    <?php get_template_part( 'partials/header' , 'logo' ); ?>
</div>

<div class="inline-right-nav">
	<?php do_action( 'layers_before_header_nav' ); ?>
	<?php wp_nav_menu( array( 'theme_location' => LAYERS_THEME_SLUG . '-primary-right' ,'container' => 'nav', 'container_class' => 'nav nav-horizontal', 'fallback_cb' => create_function('', 'echo "&nbsp";') ) ); ?>
	<?php get_template_part( 'partials/responsive' , 'nav-button' ); ?>
	<?php do_action( 'layers_after_header_nav' ); ?>
</div>