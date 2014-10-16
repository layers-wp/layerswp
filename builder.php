<?php /*
	Template Name: Page Builder
*/
get_header();
global $post;

$mods = get_theme_mods();
$options = get_option( 'hatch' );

// Dynamic Sidebar for this page
dynamic_sidebar( 'obox-hatch-builder-' . $post->post_name );

echo '<!-- <pre>MODS ' . print_r( $mods , true ) . '</pre> -->';
echo '<!-- <pre>OPTIONS ' . print_r( $options , true ) . '</pre> -->';

get_footer();