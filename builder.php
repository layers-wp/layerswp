<?php /*
	Template Name: Page Builder
*/
get_header();
global $post;

$mods = get_theme_mods();
$options = get_option( 'hatch' );

// Dynamic Sidebar for this page
dynamic_sidebar( 'obox-hatch-builder-' . $post->ID );

get_footer();