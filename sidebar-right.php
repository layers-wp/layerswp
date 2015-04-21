<?php /**
* Maybe show the right sidebar
*/

$sidebar_class = apply_filters( 'layers_right_sidebar_class', array( 'column', 'pull-right',  'sidebar', 'no-gutter', ( layers_can_show_sidebar( 'left-sidebar' ) ? 'span-3' : 'span-4' ) ) );

layers_maybe_get_sidebar( 'right-sidebar', implode( ' ' , $sidebar_class ) );