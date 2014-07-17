<?php /*
	Template Name: Page Builder
*/
wp_head();
global $post;

$mods = get_theme_mods();

echo '<pre>' . print_r( $mods , true ) . '</pre>';

dynamic_sidebar( 'obox-hatch-builder-' . $post->post_name );

wp_footer();