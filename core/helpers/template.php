<?php  /**
 * Template helper funtions
 *
 * This file is used to display general template elements, such as breadcrumbs, site-wide pagination,  etc.
 *
 * @package Hatch
 * @since Hatch 1.0
 */


/**
* Print breadcrumbs
*
* @echo     string                          Post Meta HTML
*/

if( !function_exists( 'hatch_bread_crumbs' ) ) {
    function hatch_bread_crumbs( $wrapper = 'nav', $wrapper_class = 'bread-crumbs' ) { ?>
        <<?php echo $wrapper; ?> class="<?php echo $wrapper_class; ?>">
            <ul>
                <li><a href="">Home</a></li>
                <li>/</li>
                <li><a href="">Dashboard</a></li>
                <li>/</li>
                <li>Portfolio</li>
            </ul>
        </<?php echo $wrapper; ?>>
    <?php }
} // hatch_post_meta
