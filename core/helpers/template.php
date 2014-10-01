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
* @param    varchar         $wrapper        Type of html wrapper
* @param    varchar         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/

if( !function_exists( 'hatch_bread_crumbs' ) ) {
    function hatch_bread_crumbs( $wrapper = 'nav', $wrapper_class = 'bread-crumbs' ) { ?>
        <<?php echo $wrapper; ?> class="<?php echo $wrapper_class; ?>">
            <ul>
                <?php /* Home */ ?>
                <li><a href="<?php echo home_url(); ?>"><?php _e('Home',HATCH_THEME_SLUG); ?></a></li>

                <?php

                /* Base Page
                    - Shop
                    - Search
                    - Post type parent page
                */
                if( is_search() ) { ?>
                    <li> / </li>
                    <li><?php _e('Search',HATCH_THEME_SLUG); ?></li>
                <?php } elseif( function_exists('is_shop') && ( is_post_type_archive( 'product' ) || ( get_post_type() == "product") ) ) { ?>
                    <li> / </li>
                    <?php if( function_exists( 'woocommerce_get_page_id' )  && '' != woocommerce_get_page_id('shop') ) { ?>
                        <?php $shop_page = get_post( woocommerce_get_page_id('shop') ); ?>
                        <li><a href="<?php echo get_permalink( $shop_page->ID ); ?>"><?php echo $shop_page->post_title; ?></a></li>
                    <?php } else { ?>
                        <li><a href=""><?php _e( 'Shop' , HATCH_THEME_SLUG ); ?></li>
                    <?php }
                } elseif( is_post_type_archive() || is_singular() || is_tax() ) {

                    // Get the post type object
                    $post_type = get_post_type_object( get_post_type() );

                    // Check if we have the relevant information we need to query the page
                    if( !empty( $post_type ) && isset( $post_type->labels->slug ) ) {

                        // Query template
                        $parentpage = get_template_link( $post_type->labels->slug .".php");

                        // Display page if it has been found
                        if( !empty( $parentpage ) ) { ?>
                            <li> / </li>
                            <li><a href="<?php echo get_permalink($parentpage->ID); ?>"><?php echo $parentpage->post_title; ?></a></li>
                        <?php }
                    };

                }

                /* Categories, Taxonomies & Parent Pages

                    - Page parents
                    - Category & Taxonomy parents
                    - Category for current post
                    - Taxonomy for current post
                */

                if( is_page() ) {

                    // Start with this page's parent ID
                    $parent_id = $post->post_parent;

                    // Loop through parent pages and grab their IDs
                    while( $parent_id ) {
                        $page = get_page($parent_id);
                        $parent_pages[] = $page->ID;
                        $parent_id = $page->post_parent;
                    }

                    // If there are parent pages, output them
                    if( isset( $parent_pages ) && is_array($parent_pages) ) {
                        $parent_pages = array_reverse($parent_pages);
                        foreach ( $parent_pages as $page_id ) { ?>
                            <!-- Parent page title -->
                            <li> / </li>
                            <li><a href="<?php echo get_permalink( $page_id ); ?>"><?php echo get_the_title( $page_id ); ?></a></li>
                        <?php }
                    }

                } elseif( is_category() || is_tax() ) {

                    // Get the taxonomy object
                    if( is_category() ) {
                        $category_title = single_cat_title( "", false );
                        $category_id = get_cat_ID( $category_title );
                        $category_object = get_category( $category_id );
                        $term = $category_object->slug;
                        $taxonomy = 'category';
                    } else {
                        $term = get_query_var('term' );
                        $taxonomy = get_query_var( 'taxonomy' );
                    }

                    $term = get_term_by( 'slug', $term , $taxonomy );

                    // Start with this terms's parent ID
                    $parent_id = $term->parent;

                    // Loop through parent terms and grab their IDs
                    while( $parent_id ) {
                        $cat = get_term_by( 'id' , $parent_id , $taxonomy );
                        $parent_terms[] = $cat->term_id;
                        $parent_id = $cat->parent;
                    }

                    // If there are parent terms, output them
                    if( isset( $parent_terms ) && is_array($parent_terms) ) {
                        $parent_terms = array_reverse($parent_terms);

                        foreach ( $parent_terms as $term_id ) {
                            $term = get_term_by( 'id' , $term_id , $taxonomy ); ?>

                            <li> / </li>
                            <li><a href="<?php echo get_term_link( $term_id , $taxonomy ); ?>"><?php echo $term->name; ?></a></li>

                        <?php }
                    }

                } elseif ( is_single() && get_post_type() == 'post' ) {

                    // Get all post categories but use the first one in the array
                    $category_array = get_the_category();

                    foreach ( $category_array as $category ) { ?>

                        <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                        <li><a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo get_cat_name( $category->term_id ); ?></a></li>

                    <?php }

                } elseif( is_singular() ) {

                    // Get the post type object
                    $post_type = get_post_type_object( get_post_type() );

                    // If this is a product, make sure we're using the right term slug
                    if( is_post_type_archive( 'product' ) || ( get_post_type() == "product" ) ) {
                        $taxonomy = 'product_cat';
                    } elseif( !empty( $post_type ) && isset( $post_type->labels->slug ) ) {
                        $taxonomy = $post_type->labels->slug . '-category';
                    };

                    if( isset( $taxonomy ) && !is_wp_error( $taxonomy ) ) {
                        // Get the terms
                        $terms = get_the_terms( $post->ID, $taxonomy );

                        // If this term is legal, proceed
                        if( is_array( $terms ) ) {

                            // Loop over the terms for this post
                            foreach ( $terms as $term ) { ?>

                                <li> / </li>
                                <li><a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>"><?php echo $term->name; ?></a></li>

                            <?php }
                        }
                    }
                } ?>

                <?php /* Current Page / Post / Post Type

                    - Page / Page / Post type title
                    - Search term
                    - Curreny Taxonomy
                    - Current Tag
                    - Current Category
                */

                if( is_singular() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span></li>

                <?php } elseif ( is_search() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current">"<?php the_search_query(); ?>"</span></li>

                <?php } elseif( is_tax() ) {

                    // Get this term's details
                    $term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) ); ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><?php echo $term->name; ?></span></li>

                <?php  } elseif( is_tag() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><?php echo single_tag_title(); ?></span></li>

                <?php } elseif( is_category() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><?php echo single_cat_title(); ?></span></li>

                <?php } elseif ( is_archive() && is_month() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><?php echo get_the_date( 'F Y' ); ?></span></li>

                <?php } elseif ( is_archive() && is_year() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><?php echo get_the_date( 'Y' ); ?></span></li>

                <?php } elseif ( is_archive() && is_author() ) { ?>

                    <li><?php _e( '/' , HATCH_THEME_SLUG ); ?></li>
                    <li><span class="current"><?php echo get_the_author(); ?></span></li>

                <?php } ?>
            </ul>
        </<?php echo $wrapper; ?>>
    <?php }
} // hatch_post_meta

/**
* Print pagination
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @param    varchar         $wrapper        Type of html wrapper
* @param    varchar         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/
if( !function_exists( 'hatch_pagination' ) ) {
    function hatch_pagination( $args = NULL , $wrapper = 'div', $wrapper_class = 'pagination' ) {

        // Set up some globals
        global $wp_query, $paged;

        // Get the current page
        if( empty($paged ) ) $paged = 1;

        // Set a large number for the 'base' argument
        $big = 99999;

        // Get the correct post query
        if( !isset( $args[ 'query' ] ) ){
            $use_query = $wp_query;
        } else {
            $use_query = $args[ 'query' ];
        } ?>

        <<?php echo $wrapper; ?> class="<?php echo $wrapper_class; ?>">
            <?php echo paginate_links( array(
                'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
                'prev_next' => true,
                'mid_size' => ( isset( $args[ 'range' ] ) ? $args[ 'range' ] : 3 ) ,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
                'type' => 'list',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $use_query->max_num_pages
            ) ); ?>
        </<?php echo $wrapper; ?>>
    <?php }
} // hatch_pagination

/**
* Get Page Title
*
* Returns an array including the title and excerpt used across the site
*
* @param    array           $args           Arguments for this function, including 'query', 'range'
* @echo     array           $title_array    Section Title & Excerpt
*/
if( !function_exists( 'hatch_get_page_title' ) ) {
    function hatch_get_page_title() {

        // Setup return
        $title_array = array();

        if(!is_page() && get_query_var('term' ) != '' ) {
            $term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) );
            $title_array['title'] = $term->name;
            if ( !empty( $term->description) ) $title_array['excerpt'] = $term->description;
        } elseif(!empty($parentpage) && !is_search()) {
            $parentpage = get_template_link(get_post_type().".php");
            $title_array['title'] = $parentpage->post_title;
            if($parentpage->post_excerpt != '') $title_array['excerpt'] = $parentpage->post_excerpt;
        } elseif( ( get_post_type() == "post" && is_category() ) || is_search() ) {
            $title_array['title' ] = wp_title( '', false);
            $title_array['excerpt'] = category_description();
        } elseif(get_post_type() == "post" && is_single()) {
            $category = get_the_category();
            $title_array['title' ] = $category[0]->cat_name;
            $title_array['excerpt'] = category_description();
        } else {
            while ( have_posts() ) { the_post();
                $title_array['title' ] = get_the_title();
                if( $post->post_excerpt != "") $title_array['excerpt'] = strip_tags( get_the_excerpt() );
            };
        }

        return apply_filters( 'hatch_page_title' , $title_array );
    }
}
