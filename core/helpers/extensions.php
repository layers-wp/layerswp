<?php  /**
 * Extension helper funtions
 *
 * This file is used to add functionality related to extensions, for example adding templates, registering extensions, etc.
 *
 * @package Layers
 * @since Layers 1.0
 */

/**
* Get template file locations
*
* Provides a way for extention developers to add their own template files, for example for WooCommerce, adding single-product.php inside of an extension as opposed to a child theme
*
*/
if ( !function_exists('layers_add_template_locations') ) {
    function layers_get_template_locations(){

        $template_locations = array();

        return apply_filters( 'layers_template_locations' , $template_locations );
    }
} // layers_add_template_locations


/**
* Load Template Files
*
* This function filters load_template() and fetchs the relevant Layers template from which ever plugin has specified it
*
* @param    varchar         $        Type of html wrapper
*/
if ( !function_exists('layers_load_templates') ) {
    function layers_load_template( $template ){

        // Get registered template locations
        $template_locations = layers_get_template_locations();

        // Get the base name of the file to look for
        $template_slug = basename( $template );

        // Set the default file
        $file = $template;

        // Check if a custom template exists in the theme folder, if not, load the plugin template file
        if ( $theme_file = locate_template(  $template_slug ) ) {
            $file = $theme_file;
        } elseif( !empty( $template_locations ) ) {

            // Loop through the registered template locations
            foreach( $template_locations as $location ){

                // Piece together the ful url
                $extension_file =  $location . '/' . $template_slug;

                // If this template file exists, we're game
                if( file_exists( $extension_file ) ) {
                    $file = $extension_file;
                    break;
                }
            }
        }

        return apply_filters( 'layers_template_' . $template, $file );

    }

    add_filter( 'template_include', 'layers_load_template', 99 );
} // layers_add_template_locations