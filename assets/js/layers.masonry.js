/**
 * Layers Masonry JS file
 *
 * All Masonry / Filtering related functions are to be kept in this file.
 */

var layers_masonry_settings = {};

(function ( $ ) {
    
    // These are the defaults.
    $.fn.layers_masonry = function( options ) {
		
		// "Hi Mom"
        $that = $(this);
        
        // Masonry options.
        var settings = $.extend({
            // These are the defaults.
            gutter: 20
        }, options );
        
        /*
        * Deal with Masonary blocks loading broken - stacked on top from eachother.
        */
        
        // Start a timeout check if there is a delay in image loading.
        $that.data(
            'masonry_timeout',
            setTimeout(function(){
                
                // Add a loading gif to the masonry while hiding all
                // the elements until they are cheked again and all ready.
                if( ! $that.find( '.masonry-loading' ).length ){
                    $that.append('<div class="masonry-loading">&nbsp;</div>' );
                    $that.find('.masonry-loading').stop(true).animate({ 'opacity': 1 });
                }
                
            }, 300 )
        );
        
        // Start a imagesLoaded check when all the contained images have loaded.
        $that.imagesLoaded( function() {
            
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

        // Set whether or not Masonry is active
        if( 0 == $masonry_container.find('.list-masonry').length ){
            $masonry_disabled = true;
        } else {
            $masonry_disabled = false;
        }

        // Toggle active
        if( '' == $filter) {
            $final_filter = '*';
            $that.removeClass( 'active' ).siblings().removeClass('active');
            if( true == $masonry_disabled ){
                $masonry_container.find( '.layers-masonry-column' ).show();
            }
        } else {
            $final_filter = '.' + $filter;
            $that.toggleClass( 'active' ).siblings().removeClass('active');

            if( !$that.hasClass( 'active' ) ) {
                $final_filter = '*';
            }

            if( '*' == $final_filter ) {
                $masonry_container.find( '.layers-masonry-column' ).show();
            } else if( true == $masonry_disabled  ){
                $masonry_container.find( '.layers-masonry-column' ).hide();
                if( $that.hasClass( 'active' ) ){
                    $masonry_container.find( $final_filter ).show();
                }
            }
        }

        // Fetch the masonry options (setup in the relevant widget or plugin php file)
        var masonry_settings = layers_masonry_settings[ $masonry_container_id ][0];

        // Add Filter
        masonry_settings.filter = $final_filter;

        // Initiate Masonry
        $masonry_container.find('.list-masonry').layers_masonry( masonry_settings );
    });
});