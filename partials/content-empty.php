<?php
/**
 * This partial is used for displaying empty page content
 *
 * @package Layers
 * @since Layers 1.0.0
 */ ?>
<header class="section-title large">
    <h1 class="heading"><?php _e( 'No posts found' , 'layerswp' ) ; ?></h1>
</header>
<div class="story">
    <p><?php _e( 'Use the search form below to find the page you\'re looking for:' , 'layerswp' ) ; ?></p>
    <?php get_search_form(); ?>
</div>