<?php
/**
 * Template Name: Page Builder
 *
 * This template is used for displaying the Hatch page builder
 *
 * @package Hatch
 * @since Hatch 1.0
 */

get_header();
global $post;

$mods = get_theme_mods();
$options = get_option( 'hatch' );

// Dynamic Sidebar for this page
dynamic_sidebar( 'obox-hatch-builder-' . $post->ID );

get_footer();