/**
 * Layers JS file
 *
 * This file contains all theme JS functions, from height matching to button toggling
 *
 * @package Layers
 * @since Layers 1.0.0
 * Contents
 * 1 - Container padding on first widgets for header fixed
 * 2 - Offsite sidebar Toggles
 * 3 - Sticky Header
 * 4 - FitVids
 * 5 - Layers Custom Easing
 * 6 - Swiper Height Matching Functions
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
jQuery(function($) {

	/**
	* 1 - Container padding on first widgets for header fixed
	*/
	$(window).on('load', function() {
		layers_apply_overlay_header_styles();
	});

	/**
	* 2 - Offsite sidebar Toggles
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
	* 3 - Sticky Header
	*/

	// Set site header element
	$header_sticky = $("section.header-sticky");

	// Handle scroll passsing the go-sticky position.
	$("body").waypoint({
		offset 	: - layers_script_settings.header_sticky_breakpoint,
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
	* 4 - FitVids resposive video embeds.
	*
	* Target your .container, .wrapper, .post, etc.
	*/

	$(".media-image, .thumbnail-media, .widget.slide .image-container, .post .thumbnail").fitVids();

	/**
	* 5 - Layers Custom Easing
	*
	* Extend jQuery easing with custom Layers easing function for UI animations - eg slideUp, slideDown
	*/

	// easeInOutQuad
	jQuery.extend( jQuery.easing, { layersEaseInOut: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	}});

}(jQuery));

/**
* 6 - Swiper Height Matching Functions
*
*/

function layers_swiper_resize( s ){

	// Find the highest slide, and set the Swiper container to that height.
	var height = 0;
	s.slides.each(function( key, slide ){

		var slide_height = jQuery(slide).find( '.container' ).outerHeight();
		if ( jQuery(slide).find( '.content' ).outerHeight() ) slide_height += jQuery(slide).find( '.content' ).outerHeight();
		if ( jQuery(slide).find( '.content' ).height() ) slide_height -= jQuery(slide).find( '.content' ).height();

		if( height < slide_height ){
			height = slide_height;
		}
	});
	s.container.css({ height: height+'px' });
}

/**
 * 8 - Container padding on first widgets for header fixed - helper function.
 */
var $first_element;
function layers_apply_overlay_header_styles() {

	// Get header.
	$header = jQuery( '.header-site' );
	$header_height = $header.outerHeight();

	// Get content wrapper.
	$content_wrapper = jQuery( '#wrapper-content' );

	if( $header.hasClass( 'header-overlay' ) ) {

		// Get first element.
		if( ! $first_element ) $first_element = $content_wrapper.children().eq(0);

		if( $first_element.hasClass( 'slide' ) && !$first_element.hasClass( '.full-screen' ) ) {

			/*
			// Reset previous incase this is being re-aplied due to window resize.
			$first_element.find('.swiper-slide > .content' ).css('padding-top', '' );

			$first_element_height = $first_element.outerHeight();

			var padding_top = $first_element.find('.swiper-slide > .content' ).eq(0).css('padding-top').replace('px', '');
			padding_top = ( '' != padding_top ) ? parseInt( padding_top ) : 0 ;

			// First element is Slider Widget.
			// $first_element.css( 'height', ( $header_height + $first_element_height ) );
			// $first_element.find('.swiper-slide' ).css( 'height', ( $header_height + $first_element_height ) );
			$first_element.css( 'height', ( $first_element_height - $header_height ) );
			*/

			jQuery('body').addClass( 'header-overlay-no-push' );
		}
		else if( $first_element.hasClass('title-container') ) {

			// Reset previous incase this is being re-aplied due to window resize.
			$first_element.css('padding-top', '' );

			var padding_top = $first_element.css('padding-top').replace('px', '');
			padding_top = ( '' != padding_top ) ? parseInt( padding_top ) : 0 ;

			// First element is Title (eg WooCommerce).
			$first_element.css({ 'paddingTop': $header_height + padding_top });
			jQuery('body').addClass( 'header-overlay-no-push' );
		}
		else{

			// Reset previous incase this is being re-aplied due to window resize.
			$content_wrapper.css('padding-top', '' );

			var padding_top = $content_wrapper.css('padding-top').replace('px', '');
			padding_top = ( '' != padding_top ) ? parseInt( padding_top ) : 0 ;

			// Pad the site to compensate for overlay header.
			$content_wrapper.css( 'paddingTop', $header_height + padding_top );
		}

	}
}
