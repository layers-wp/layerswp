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

    $(document).on( 'click' , '.onboard-nav-dots a' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        $that.addClass( 'dot-active' ).siblings().removeClass( 'dot-active' );

        $i = $that.index();

        $( '.layers-onboard-slide' ).eq( $i ).addClass( 'layers-slide-current' ).removeClass( 'layers-onboard-slide-inactive' ).siblings().removeClass( 'layers-slide-current' ).addClass( 'layers-onboard-slide-inactive' );

    });
});