<?php
/**
 * Template Name: Page Builder
 *
 * This template is used for displaying the Layers page builder
 *
 * @package Layers
 * @since Layers 1.0
 */

get_header();
global $post;

$mods = get_theme_mods();
$options = get_option( 'layers' );

// Dynamic Sidebar for this page
dynamic_sidebar( 'obox-layers-builder-' . $post->ID );

get_footer();