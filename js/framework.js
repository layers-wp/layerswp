/**
* Admin JS file
*
* This file contains global admin functions
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Screen Height Matching
*/
jQuery(function($) {

    /**
    * 1 - Screen Height Matching
    */

    $(window).resize(function(){
        hatch_match_to_screen_height();
    });

    hatch_match_to_screen_height();

    function hatch_match_to_screen_height(){
        $( '.full-screen' ).css( 'height' , $(window).height() );
        $( '.full-screen' ).find( '.swiper-slide' ).css( 'height' , $(window).height() );
    }
}(jQuery));

