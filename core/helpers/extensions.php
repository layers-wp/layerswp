<?php  /**
 * Extension helper funtions
 *
 * This file is used to add functionality related to extensions, for example adding templates, registering extensions, etc.
 *
 * @package Hatch
 * @since Hatch 1.0
 */

/**
* Extension template files
*
* Provides a way for extention developers to add their own template files, for example for WooCommerce, adding single-product.php inside of an extension as opposed to a child theme
*
* @param    varchar         $        Type of html wrapper
*/
if ( !function_exists('hatch_add_template_locations') ) {
    function hatch_get_template_locations(){

        $template_locations = array();

        return apply_filters( 'hatch_template_locations' , $template_locations );
    }
} // hatch_add_template_locations

if ( !function_exists('hatch_load_templates') ) {
    function hatch_load_template( $template ){

        // Get registered template locations
        $template_locations = hatch_get_template_locations();

        // Get the base name of the file to look for
        $template = basename( $template );

        // Check if a custom template exists in the theme folder, if not, load the plugin template file
        if ( $theme_file = locate_template(  $template ) ) {
            $file = $theme_file;
        } elseif( !empty( $template_locations ) ) {

            // Loop through the registered template locations
            foreach( $template_locations as $location ){

                // Piece together the ful url
                $file =  $location . '/' . $template;

                // If this template file exists, we're game
                if( file_exists( $file ) ) return $file;
            }
        }

        return apply_filters( 'hatch_template_' . $template, $file );

    }

    add_filter( 'template_include', 'hatch_load_template', 99 );
} // hatch_add_template_locations



