<?php /**
* Maybe show the right sidebar
*/
$sidebar_class = ( layers_can_show_sidebar( 'left-sidebar' ) ? 'span-3' : 'span-4' );

layers_maybe_get_sidebar( 'right-sidebar', 'column pull-right sidebar no-gutter ' . $sidebar_class );