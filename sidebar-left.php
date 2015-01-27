<?php /**
* Maybe show the left sidebar
*/
$sidebar_class = ( layers_can_show_sidebar( 'right-sidebar' ) ? 'span-3' : 'span-4' );

layers_maybe_get_sidebar( 'left-sidebar', 'column pull-left sidebar ' . $sidebar_class );