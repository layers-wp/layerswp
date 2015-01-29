/**
 * Onboarding JS File
 *
 * This file contains all onboarding functions
 *
 * @package Layers
 * @since Layers 1.0
 *
 * Contents
 *
 * 1 - Slide Dot Selection
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

jQuery(function($) {

    $(document).on( 'click' , '.layers-onboard-slide .layers-button-well a.btn-primary' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Go to the next slide
        layers_next_onboarding_slide();

    });

    $(document).on( 'click' , '.layers-onboard-controllers a.btn-link.layers-button' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Go to the next slide
        layers_next_onboarding_slide();
    });

    $(document).on( 'click' , '.onboard-nav-dots a' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        $i = $that.index();

        layers_change_onboarding_slide( $i );
    });

    function layers_next_onboarding_slide(){
        $current = $( '.onboard-nav-dots a.dot-active').index();
        $next = (+$current+1);
        $max = $( '.onboard-nav-dots a' ).length;

        if( $next == $max ) return;

        layers_change_onboarding_slide( $next );
    }

    function layers_change_onboarding_slide( $i ){
        // Update anchor classes
        $( '.onboard-nav-dots a').eq( $i ).addClass( 'dot-active' ).siblings().removeClass( 'dot-active' );

        // Update slider classes
        $( '.layers-onboard-slide' ).eq( $i ).addClass( 'layers-onboard-slide-current' ).removeClass( 'layers-onboard-slide-inactive' ).siblings().removeClass( 'layers-onboard-slide-current' ).addClass( 'layers-onboard-slide-inactive' );
    }
});