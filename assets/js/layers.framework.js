/**
 * Layers JS file
 *
 * This file contains all theme JS functions, from height matching to button toggling
 *
 * @package Layers
 * @since Layers 1.0.0
 * Contents
 * 1 - Screen height matching
 * 2 - Container padding for header fixed
 * 3 - Widget closing when clicking on the canvas
 * 4 - Offsite sidebar Toggles
 * 5 - Sticky Header
 * 6 - FitVids
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
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
    $(window).on('load resize', function() {
        layers_apply_overlay_header_styles();
    });
    function layers_apply_overlay_header_styles() {

        // Get header.
        $header = $( '.header-site' );

        // Get content wrapper.
        $content_wrapper = $( '#wrapper-content' );

        if( $header.hasClass( 'header-overlay' ) ) {

            // Get first element.
            $first_element = $content_wrapper.children().eq(0);

            if( $first_element.hasClass( 'slide' ) ) {

                // First element is Slider.

                // Pad necessary element(s).
                $first_element.find('.swiper-slide .overlay').css({ 'paddingTop': $( $header ).height() }, { easing: 'layersEaseInOut', duration: 400 });
            }
            else if( $first_element.hasClass('title-container') ) {

                // First element is Title (eg WooCommerce).

                // Pad necessary element(s).
                $first_element.css({ 'paddingTop': $( $header ).height() }, { easing: 'layersEaseInOut', duration: 400 });
            }
            else{

                // Pad the site to compensate for overlay header.
                $content_wrapper.css( 'paddingTop', $( $header ).height() );
            }

        }
    }

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

    /**
    * 5 - Sticky Header
    */

    // Set site header element
    $header_sticky = $("header.header-sticky");

	// Handle scroll passsing the go-sticky position.
	$("body").waypoint({
		offset 	: -270,
		handler	: function(direction) {
			if ( 'down' == direction ) {

				// Sticky the header
				$header_sticky.stick_in_parent({
					parent: 'body'
				});

				// Clear previous timeout to avoid duplicates.
				clearTimeout( $header_sticky.data( 'timeout' ) );

				// Show header miliseconds later so we can css animate in.
				$header_sticky.data( 'timeout', setTimeout( function() {
					$header_sticky.addClass('is_stuck_show');
				}, '10' ) );
			}
		}
	});

	// Handle scroll ariving at page top.
	$("body").waypoint({
		offset 	: -1,
		handler	: function(direction) {
			if ( 'up' == direction ) {

				// Clear previous timeout to avoid late events.
				clearTimeout( $header_sticky.data( 'timeout' ) );

				// Detach the header
				$header_sticky.removeClass('is_stuck_show');
				$header_sticky.trigger("sticky_kit:detach");
			}
		}
	});

	/**
    * 6 - FitVids resposive video embeds.
    *
	* Target your .container, .wrapper, .post, etc.
    */
	
	$(".media-image, .thumbnail-media, .widget.slide .image-container").fitVids();

}(jQuery));
