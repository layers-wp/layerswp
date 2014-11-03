/**
 * Hatch Masonry JS file
 *
 * All Masonry / Filtering / Isotope related functions are to be kept in this file
 */

var hatch_isotope_settings = {};

(function ( $ ) {

    // These are the defaults.
    $.fn.hatch_masonry = function( options ) {

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

        // Toggle active
        if( '' == $filter) {
            $final_filter = '*';
            $that.removeClass( 'active' ).siblings().removeClass('active');
        } else {
            $final_filter = '.' + $filter;
            $that.toggleClass( 'active' ).siblings().removeClass('active');
        }

        // Set Isotope Container
        $isotope_container_id = $that.closest( '.hatch-isotope-filter' ).data( 'isotope-container' );

        $isotop_container = $( '#' + $isotope_container_id );

        var isotope_settings = hatch_isotope_settings[ $isotope_container_id ][0];

        // Add Filter
        isotope_settings.filter = $final_filter;

        // Initiate Isotope
        $isotop_container.find('.list-masonry').hatch_masonry( isotope_settings );
    });
});