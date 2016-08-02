/**
 * Layers Masonry JS file
 *
 * All Masonry / Filtering related functions are to be kept in this file
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

(function ( $ ) {

    // These are the defaults.
    $.fn.layers_masonry = function( options ) {

		// "Hi Mom"
        $that = $(this);

        // Bail if there are no masonry elements bening passsed in.
        if ( $that.length == 0 ) return ;

        // Masonry options.
        var settings = $.extend({
            // These are the defaults.
            gutter: 20
        }, options );

        /*
        * Deal with Masonary blocks loading broken - stacked on top from eachother.
        */

        // Show a loading graphic if there's a delay in loading of images.
        $that.data(
            'masonry_timeout',
            setTimeout( function() {

                return;

                // Add a loading gif to the masonry while hiding all
                // the elements until they are cheked again and all ready.
                if( ! $that.find( '.masonry-loading' ).length ){
                    $that.append('<div class="masonry-loading">&nbsp;</div>' );
                    $that.find('.masonry-loading').stop(true).animate({ 'opacity': 1 });
                }

            }, 300 )
        );

        // Start a imagesLoaded check when all the contained images have loaded.
        $that.imagesLoaded( function( el ) {

            $that = $( el.elements );

            // Clear the loading graphic display.
            clearTimeout( $that.data( 'masonry_timeout') );

            // Remove loader when loaded.
            $that.find('.masonry-loading').stop(true).animate({ 'opacity': 0 },function(){
                $that.remove( '.masonry-loading' );
            });

            // Add class when loaded.
            $that.addClass('loaded');

            // Init Masonry.
            $that.masonry( settings );
        });

    };
}( jQuery ));

jQuery(function($){

    $('.layers-masonry-filter li').on( 'click' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Get term slug
        $filter = $that.data( 'filter' );

        // Set Masonry Container
        $masonry_container_id = $that.closest( '.layers-masonry-filter' ).data( 'masonry-container' );

        // Target the masonry container
        $masonry_container = $( '#' + $masonry_container_id );
        
        // Get the main Masonry Grid element.
        $masonry_grid = $masonry_container.find('.list-masonry .grid');
        if ( 0 == $masonry_grid.length ) $masonry_grid = $masonry_container.find('.list-masonry');

        // Set whether is Masonry or not
        $is_masonry = ( 0 != $masonry_grid.length );

        if( '' == $filter) {
            // Toggle button
            $that.removeClass( 'active' ).siblings().removeClass('active');

            // Prep filter selector
            $final_filter = '*';

        } else {
            // Toggle button
            $that.toggleClass( 'active' ).siblings().removeClass('active');

            // Prep filter selector
            $final_filter = '.' + $filter;
            if( ! $that.hasClass( 'active' ) ) {
                $final_filter = '*';
            }
        }

        // Hide items
        $masonry_container.find( '.layers-masonry-column' ).not( $final_filter ).removeClass('active').addClass( 'hide' );

        // Show items
        $masonry_container.find( '.layers-masonry-column' ).filter( $final_filter ).addClass('active').removeClass( 'hide' );

        // Relayout if Masonry
        if( $is_masonry ){
            $masonry_grid.masonry( 'layout' );
        }
    });
});