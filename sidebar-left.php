<?php /**
* Maybe show the left sidebar
*/

$sidebar_class = apply_filters( 'layers_left_sidebar_class', array( 'column', 'pull-left',  'sidebar', ( layers_can_show_sidebar( 'right-sidebar' ) ? 'span-3' : 'span-4' ) ) );

layers_maybe_get_sidebar( 'left-sidebar', implode( ' ' , $sidebar_class ) );