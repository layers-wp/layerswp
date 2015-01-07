/**
 * Layers JS file
 *
 * This file contains all theme JS functions, from height matching to button toggling
 *
 * @package Layers
 * @since Layers 1.0
 * Contents
 * 1 - Screen height matching
 * 2 - Container padding for header fixed
 * 3 - Widget closing when clicking on the canvas
 * 4 - Offsite sidebar Toggles
*/
jQuery(function($) {

    /**
    * 1 - Screen Height Matching
    */

    $(window).resize(function(){
        layers_match_to_screen_height();
    });

    layers_match_to_screen_height();

    function layers_match_to_screen_height(){
        $( '.full-screen' ).css( 'height' , $(window).height() );
        $( '.full-screen' ).find( '.swiper-slide .overlay' ).css( 'height' , $(window).height() );
    }

    /**
    * 2 - Container padding for header fixed
    */
    $(window).on('load', function() {
        if( $( 'header' ).hasClass( 'header-fixed' ) ){
            $selector = $( '#wrapper-content' );

            // Ignore the padding if the first widget is the slider
            if( $selector.find( '.widget' ).first().hasClass( 'slide' ) ) return;

            $selector.css( 'paddingTop' , $('.header-site').height() );
        }
    });

    /**
    * 3 - Widget Closing when clicking on the canvas
    */
    $(document).on( 'click' , 'html, body'  , function(e){
        // Close widgets
        $(window.parent.document).find( '.control-panel-content .widget-rendered.expanded' ).removeClass( 'expanded' );
    });

    /**
    * 4 - Offsite sidebar Toggles
    */
    $(document).on( 'click' , '[data-toggle^="#"]'  , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Setup target ID
        $target = $that.data( 'toggle' );

        // Toggle .open class
        $( $target ).toggleClass( $that.data( 'toggle-class' ) );

    });

}(jQuery));

