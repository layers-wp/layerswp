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
jQuery(window).load(function($) {

    /**
    * 1 - Screen Height Matching
    */

    $(window).resize(function(){
        hatch_match_to_screen_height();
    });

    hatch_match_to_screen_height();

    function hatch_match_to_screen_height(){
        $( '.full-screen' ).each(function(){
            $(this).css( 'height' , $(window).height() );
            $(this).find( '.swiper-slide' ).css( 'height' , $(window).height() );
        });
    }
}(jQuery));

