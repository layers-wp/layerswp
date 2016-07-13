<?php  /**
 * Extension helper funtions
 *
 * This file is used to add functionality related to extensions, for example adding templates, registering extensions, etc.
 *
 * @package Layers
 * @since Layers 1.0.0
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
* @param    string $template template file to search for
*/
if ( !function_exists( 'layers_load_templates' ) ) {
	function layers_load_template( $template ){

		// Get registered template locations
		$template_locations = layers_get_template_locations();

		// Get the base name of the file to look for
		$template_slug = basename( $template );

		// Set the default file
		$file = $template;

		// Check if a custom template exists in the theme folder, if not, load the plugin template file
		if( !empty( $template_locations ) ) {

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
		} elseif ( $theme_file = locate_template(  $template_slug ) ) {
			$file = $theme_file;
		}

		return apply_filters( 'layers_template_' . $template, $file );

	}
} // layers_add_template_locations
add_filter( 'template_include', 'layers_load_template', 99 );


/**
* Locate Plugin Templates
*
* We fire this on the single_template && taxonomy_template filters, why? So that we can make sure that the plugin you are running has its templates added to the load_template() search
*
* @param array $template Array of templates we are looking for (eg. single.php)
* @param boolean $load Whether or not to load the template file right away
* @param boolean $require_once Trigger require once
*/
if ( !function_exists( 'layers_locate_plugin_templates' ) ) {
	function layers_locate_plugin_templates( $template_names, $load = false, $require_once = true ) {
		if ( !is_array($template_names) )
			return '';

		$located = '';

		// Get registered template locations
		$template_locations = layers_get_template_locations();

		foreach ( $template_names as $template_name ) {
			if ( !$template_name )
				continue;

			if ( file_exists( get_stylesheet_directory() . '/' . $template_name)) {
				$located = get_stylesheet_directory() . '/' . $template_name;
				break;

			} else if ( file_exists( get_template_directory() . '/' . $template_name) ) {
				$located = get_template_directory() . '/' . $template_name;
				break;

			} elseif( !empty( $template_locations ) ) {

				// Loop through the registered template locations
				foreach( $template_locations as $location ){

					// Piece together the ful url
					$extension_file =  $location . '/' . $template_name;

					// If this template file exists, we're game
					if( file_exists( $extension_file ) ) {
						$located = $extension_file;
						return $located;
					}
				}
			}
		}

		if ( $load && '' != $located )
			load_template( $located, $require_once );

		return $located;
	}
} // layers_locate_plugin_templates

/**
* Get Custom Author Template
*
* This force-adds our custom post type templates to the list of templates to search for, eg. author-portfolio.php
*
* @param string $template Name of the template file we're looking for
*/
if ( !function_exists( 'layers_get_custom_author_template' ) ) {
	function layers_get_custom_author_template($template) {
		global $wp_query;
		$object = $wp_query->get_queried_object();

		if ( !in_array( $object->name,  layers_get_standard_wp_post_types() ) ) {
			$templates = array( 'author.php');
			$template = layers_locate_plugin_templates($templates);
		}

		// return apply_filters('author_template', $template);
		return $template;
	}
} // layers_get_custom_author_template
add_filter( 'author_template', 'layers_get_custom_author_template' );
/**
* Get Custom Archive Template
*
* This force-adds our custom post type templates to the list of templates to search for, eg. archive-portfolio.php
*
* @param string $template Name of the template file we're looking for
*/
if ( !function_exists( 'layers_get_custom_archive_template' ) ) {
	function layers_get_custom_archive_template($template) {
		global $wp_query;
		$object = $wp_query->get_queried_object();

		if ( is_object( $object ) && !in_array( $object->name, layers_get_standard_wp_post_types() ) ) {
			$templates = array('archive-' . $object->name . '.php', 'archive.php');
			$template = layers_locate_plugin_templates($templates);
		}

		// return apply_filters('archive_template', $template);
		return $template;
	}
} // layers_get_custom_archive_template
add_filter( 'archive_template', 'layers_get_custom_archive_template' );

/**
* Get Custom Single Template
*
* This force-adds our custom post type templates to the list of templates to search for, eg. single-portfolio.php
*
* @param string $template Name of the template file we're looking for
*/
if ( !function_exists( 'layers_get_custom_single_template' ) ) {
	function layers_get_custom_single_template($template) {
		global $wp_query;
		$object = $wp_query->get_queried_object();

		if ( !in_array( $object->post_type,  layers_get_standard_wp_post_types() ) ) {
			$templates = array('single-' . $object->post_type . '.php', 'single.php');
			$template = layers_locate_plugin_templates($templates);
		}

		// return apply_filters('single_template', $template);
		return $template;
	}
} // layers_get_custom_single_template
add_filter( 'single_template', 'layers_get_custom_single_template' );

/**
* Get Custom Taxonomy Template
*
* This force-adds our custom taxonomy templates to the list of templates to search for, eg. taxonomy-portfolio-categry.php
*
* @param string $template Name of the template file we're looking for
*/

if ( !function_exists( 'layers_get_custom_taxonomy_template' ) ) {
	function layers_get_custom_taxonomy_template($template) {

		// Setup the taxonomy we're looking for
		$taxonomy = get_query_var('taxonomy');

		if ( !in_array( $taxonomy, layers_get_standard_wp_taxonomies() ) ) {
			$term = get_query_var('term');

			$templates = array();
			if ( $taxonomy && $term )
					$templates[] = "taxonomy-$taxonomy-$term.php";
			if ( $taxonomy )
					$templates[] = "taxonomy-$taxonomy.php";

			$templates[] = "taxonomy.php";
			$template = layers_locate_plugin_templates($templates);
		}
		// return apply_filters('taxonomy_template', $template);
		return $template;
	}
} // layers_get_custom_taxonomy_template
add_filter( 'taxonomy_template', 'layers_get_custom_taxonomy_template' );

//@TODO: Cleanup this code
if( !function_exists( 'layers_get_plugins') ) {
	function layers_get_plugins(){
		$active_plugins = wp_get_active_and_valid_plugins();
		$layers_plugins = array();
		foreach ( (array) $active_plugins as $plugin_key ) {
			$plugin_data = get_plugin_data( $plugin_key );

			if( isset( $plugin_data[ 'Layers Plugin' ] ) && 'true' == strtolower( $plugin_data[ 'Layers Plugin' ] ) ){
				$layers_plugins[ $plugin_key ] = $plugin_data;
			}
		}

		return $layers_plugins;
	}
} // layers_get_plugins

if( !function_exists( 'layers_plugin_headers') ) {
	function layers_plugin_headers( $extra_headers ) {
		$extra_headers[] = 'Layers Plugin';
		$extra_headers[] = 'Layers Required Version';
		return $extra_headers;
	}
} // layers_get_plugins
add_filter( 'extra_plugin_headers', 'layers_plugin_headers' );