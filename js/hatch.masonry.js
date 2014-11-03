/**
 * Hatch Masonry JS file
 *
 * All Masonry / Filtering / Isotope related functions are to be kept in this file
 */

var hatch_isotope_settings = {};

(function ( $ ) {

    // These are the defaults.
    $.fn.hatch_isotope = function( options ) {

        var settings = $.extend({
            // These are the defaults.
            gutter: 20,
            filter: '*'
        }, options );

        this.isotope( options );

    };
}( jQuery ));

jQuery(function($){


    $('.hatch-isotope-filter li').on( 'click' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Get term slug
        $filter = $that.data( 'filter' );

        // Set Isotope Container
        $isotope_container_id = $that.closest( '.hatch-isotope-filter' ).data( 'isotope-container' );

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
                $isotope_container.find( '.hatch-masonry-column' ).show();
            }
        } else {
            $final_filter = '.' + $filter;
            $that.toggleClass( 'active' ).siblings().removeClass('active');

            if( true == $isotope_disabled ){
                $isotope_container.find( '.hatch-masonry-column' ).hide();
                if( $that.hasClass( 'active' ) ){
                    $isotope_container.find( $final_filter ).show();
                }
            }
        }

        // Fetch the isotope options (setup in the relevant widget or plugin php file)
        var isotope_settings = hatch_isotope_settings[ $isotope_container_id ][0];

        // Add Filter
        isotope_settings.filter = $final_filter;

        // Initiate Isotope
        $isotope_container.find('.list-masonry').hatch_isotope( isotope_settings );
    });
});