/**
 * Layers Masonry JS file
 *
 * All Masonry / Filtering / Isotope related functions are to be kept in this file
 */

var layers_isotope_settings = {};

(function ( $ ) {

    // These are the defaults.
    $.fn.layers_isotope = function( options ) {

        var settings = $.extend({
            // These are the defaults.
            gutter: 20,
            filter: '*'
        }, options );

        //this.isotope( options );
        
        // Function to deal with Masonary blocks loading broken - stacked on top from eachother
        
        // Helper function that gets passed circulary to setTimeout until successfull
        function layers_check_masonry_loaded( masonry_element ){
            
            // Set control check boolean
            loaded = true;
            
            // Find all the images in the Masonry
            var images_to_check = masonry_element.find('img');
            
            // Testing
            //console.log('--------- CHECK ---------');
            
            // Check each image to see if its meta-data is on the page (if it is reserving vertical height)
            images_to_check.each(function(){
                if( ! $(this).height() > 0 ){
                    loaded = false;
                    
                    // Testing
                    //console.log( ':( failed-check: ' + images_to_check.index( this ) );
                }
            });
            
            // Testing
            //loaded = false;
            
            if( ! loaded ) {
                
                // Add a loading gif to the masonry while hiding all
                // the elements until they are cheked again and all ready.
                if( ! masonry_element.find( '.masonry-loading' ).length ){
                    masonry_element.append('<div class="masonry-loading">&nbsp;</div>' );
                    masonry_element.find('.masonry-loading').stop(true).animate({ 'opacity': 1 });
                }
                
                // Restart the setTimeout, asigned to the current element incase of multiple masonrys on the page.
                $(this).data(
                    'masonry_timeout',
                    setTimeout(function(){
                        layers_check_masonry_loaded( masonry_element );
                    }, 300 )
                );
            }
            else{
                
                // Remove loader
                masonry_element.find('.masonry-loading').stop(true).animate({ 'opacity': 0 },function(){
                    masonry_element.remove( '.masonry-loading' );
                });
                
                // Render the Masonary now that it's ready.
                masonry_element.
                addClass('loaded').
                isotope( options );
                
                // Testing
                //console.log( ':) all good' );
            }
        }
        layers_check_masonry_loaded( $( this ) );
        
    };
}( jQuery ));

jQuery(function($){


    $('.layers-isotope-filter li').on( 'click' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Get term slug
        $filter = $that.data( 'filter' );

        // Set Isotope Container
        $isotope_container_id = $that.closest( '.layers-isotope-filter' ).data( 'isotope-container' );

        // Target the isotope container
        $isotope_container = $( '#' + $isotope_container_id );

        // Set whether or not Isotope is active
        if( 0 == $isotope_container.find('.list-masonry').length ){
            $isotope_disabled = true;
        } else {
            $isotope_disabled = false;
        }

        // Toggle active
        if( '' == $filter) {
            $final_filter = '*';
            $that.removeClass( 'active' ).siblings().removeClass('active');
            if( true == $isotope_disabled ){
                $isotope_container.find( '.layers-masonry-column' ).show();
            }
        } else {
            $final_filter = '.' + $filter;
            $that.toggleClass( 'active' ).siblings().removeClass('active');

            if( !$that.hasClass( 'active' ) ) {
                $final_filter = '*';
            }

            if( '*' == $final_filter ) {
                $isotope_container.find( '.layers-masonry-column' ).show();
            } else if( true == $isotope_disabled  ){
                $isotope_container.find( '.layers-masonry-column' ).hide();
                if( $that.hasClass( 'active' ) ){
                    $isotope_container.find( $final_filter ).show();
                }
            }
        }

        // Fetch the isotope options (setup in the relevant widget or plugin php file)
        var isotope_settings = layers_isotope_settings[ $isotope_container_id ][0];

        // Add Filter
        isotope_settings.filter = $final_filter;

        // Initiate Isotope
        $isotope_container.find('.list-masonry').layers_isotope( isotope_settings );
    });
});