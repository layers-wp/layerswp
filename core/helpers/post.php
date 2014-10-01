<?php  /**
 * Post helper funtions
 *
 * This file is used to display post elements, from meta to media, to galleries, to in-post pagination, all post-related functions sit in this file.
 *
 * @package Hatch
 * @since Hatch 1.0
 */


/**
* Print post meta HTML
*
* @param    varchar         $post_id        ID of the post to use
* @param    array           $display        Configuration arguments. (date, author, categories, tags)
* @param    varchar         $wrapper        Type of html wrapper
* @param    varchar         $wrapper_class  Class of HTML wrapper
* @echo     string                          Post Meta HTML
*/

if( !function_exists( 'hatch_post_meta' ) ) {
    function hatch_post_meta( $post_id = NULL , $display = NULL, $wrapper = 'footer', $wrapper_class = 'meta-info' ) {
        // If there is no post ID specified, use the current post, does not affect post author, yet.
        if( NULL == $post_id ) {
            global $post;
            $post_id = $post->ID;
        }

        // If there are no items to display, return nothing
        if( NULL == $display ) $display = array( 'date', 'author', 'categories', 'tags' );

        foreach ( $display as $meta ) {
            switch ( $meta ) {
                case 'date' :
                    $meta_to_display[] = __( 'on ', HATCH_THEME_SLUG ) . get_the_time(  get_option( 'date_format' ) , $post_id );
                    break;
                case 'author' :
                    $meta_to_display[] = __( 'by ', HATCH_THEME_SLUG ) . hatch_get_the_author( $post_id );
                    break;
                case 'categories' :
                    $categories = '';

                    // Use different terms for different post types
                    if( 'post' == get_post_type( $post_id ) ){
                        $the_categories = get_the_category( $post_id );
                    } elseif( 'jetpack-portfolio' == get_post_type( $post_id ) ) {
                        $the_categories = get_the_terms( $post_id , 'jetpack-portfolio-type' );
                    }

                    // If there are no categories, skip to the next case
                    if( !$the_categories ) continue;

                    foreach ( $the_categories as $category ){
                        $categories .= ' <a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s", HATCH_THEME_SLUG ), $category->name ) ) . '">'.$category->name.'</a>';
                    }
                    $meta_to_display[] = __( 'in ', HATCH_THEME_SLUG ) . $categories;
                    break;
                case 'tags' :
                    $tags = '';

                    if( 'post' == get_post_type( $post_id ) ){
                        $the_tags = get_the_tags( $post_id );
                    } elseif( 'jetpack-portfolio' == get_post_type( $post_id ) ) {
                        $the_tags = get_the_terms( $post_id , 'jetpack-portfolio-tag' );
                    }

                    // If there are no tags, skip to the next case
                    if( !$the_tags ) continue;

                    foreach ( $the_tags as $tag ){
                        $tags[] = ' <a href="'.get_category_link( $tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts tagged %s", HATCH_THEME_SLUG ), $tag->name ) ) . '">'.$tag->name.'</a>';
                    }
                    $meta_to_display[] = __( 'tagged ', HATCH_THEME_SLUG ) . implode( __( ', ', HATCH_THEME_SLUG ), $tags );
                    break;
                break;
            } // switch meta
        } // foreach $display

        if( !empty( $meta_to_display ) ) {
            echo '<' . $wrapper . ( ( '' != $wrapper_class ) ? ' class="' . $wrapper_class .'"' : NULL ) . '>';
                echo '<p>';
                    echo __( 'Written ' , HATCH_THEME_SLUG ) . implode( ' ' , $meta_to_display );
                echo '</p>';
            echo '</' . $wrapper . '>';
        }
    }
} // hatch_post_meta

if ( ! function_exists( 'hatch_get_the_author' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function hatch_get_the_author() {
        return sprintf( __( '<a href="%1$s" title="%2$s" rel="author">%3$s</a>', HATCH_THEME_SLUG ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'the-writer' ), get_the_author() ) ),
            esc_attr( get_the_author() )
        );
    }
endif;