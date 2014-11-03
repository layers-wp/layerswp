/**
* Admin JS file
*
* This file contains global admin functions
 *
 * @package Hatch
 * @since Hatch 1.0
 * Contents
 * 1 - Screen Height Matching
 * 2 - Container padding for header fixed
 * 3 - Widget Closing when clicking on the canvas
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
        $( '.full-screen' ).find( '.swiper-slide .overlay' ).css( 'height' , $(window).height() );
    }

    /**
    * 2 - Container padding for header fixed
    */
    $(window).on('load', function() {
        if( $( 'header' ).hasClass( 'header-fixed' ) ){
            //Add padding to the content container equal to the header height

            if( 0 !== $( '.title-container').length ){
                $selector = '.title-container';
            } else {
                $selector = '.container.content-main';
            }

            $( $selector ).css( 'paddingTop' , $('.header-site').height() );
        }
    });

    /**
    * 3 - Widget Closing when clicking on the canvas
    */
    $(document).on( 'click' , 'html, body'  , function(e){
        // Close widgets
        $(window.parent.document).find( '.control-panel-content .widget-rendered.expanded' ).removeClass( 'expanded' );
    });

}(jQuery));

