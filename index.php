<?php wp_head();

$mods = get_theme_mods();

echo '<pre>' . print_r( $mods , true ) . '</pre>';

dynamic_sidebar( 'obox-hatch-builder-home' );

wp_footer();