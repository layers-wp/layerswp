<?php
/**
 * This partial is used for displaying empty page content
 *
 * @package Layers
 * @since Layers 1.0
 */ ?>
<header class="section-title large">
    <h1 class="heading"><?php _e( 'No posts found', LAYERS_THEME_SLUG ) ; ?></h1>
</header>
<div class="story">
    <p><?php _e( 'Use the search form below to find the page you\'re looking for:', LAYERS_THEME_SLUG ) ; ?></p>
    <form action="<?php home_url(); ?>" method="get" class="search-form">
        <input type="text" name="s" id="s" class="search" maxlength="50" placeholder="<?php esc_attr_e( 'Enter Text Here', 'gigawatt' ); ?>" />
        <input type="submit" class="search_button" value="<?php esc_attr_e( 'Search', 'gigawatt' ); ?>" />
    </form>
</div>