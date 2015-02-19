/**
 * Onboarding JS File
 *
 * This file contains all onboarding functions
 *
 * @package Layers
 * @since Layers 1.0.0
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

    function layers_onboarding_load_anchors(){

        $anchor_count = $( '.layers-onboard-slide' ).length;

        for( $i = 0; $i < $anchor_count; $i++ ){

            $title = $( '.layers-onboard-slide' ).eq( $i ).find( '.layers-section-title h3' ).text();

            $anchor_template = $( '<a href="" />' );
            $anchor_template.addClass( 'layers-dot layers-tooltip' );
            if( 0 == $i ){
                $anchor_template.addClass( 'dot-active' );
            }

            $anchor_template.attr( 'title' , $title.trim() );

            $( '.onboard-nav-dots' ).append( $anchor_template );

        };
    }

    layers_onboarding_load_anchors();

    $(window).on( 'resize, load',function(){
        $( '.layers-template-selector' ).css( 'max-height', $( '#wpbody-content' ).height() - 150 );
    });

    $(document).on( 'click' , '.onbard-next-step' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        $form = $that.closest( '.layers-onboard-slide' );

        $progress_indicator = $form.find( '.layers-save-progress' );
        $progress_indicator_message = $progress_indicator.data( 'busy-message' )
        $progress_indicator.text( $progress_indicator_message ).hide().removeClass( 'layers-hide' ).fadeIn(150);

        $action = $form.find( 'input[name="action"]' ).val();

        if( 'layers_select_preset' == $action ) {

            $id = $( 'input[name="layes-preset-layout"]:checked' ).val();

            // No template selected
            if( ! $id ){ return false; }

            $title = $('#layers-preset-layout-' + $id + '-title' ).val();
            $widget_data = $('#layers-preset-layout-' + $id + '-widget_data' ).val();

            var $page_data = {
                action: 'layers_create_builder_page_from_preset',
                post_title: ( undefined == $( '#preset_page_title' ) ? false : $( '#preset_page_title' ).val() ),
                widget_data: $.parseJSON( $widget_data ),
                nonce: layers_widget_params.nonce
            };

            jQuery.post(
                layers_onboarding_params.ajaxurl,
                $page_data,
                function(data){

                    $results = $.parseJSON( data );

                    $form.find( '.layers-save-progress' ).text( onboardingi8n.step_done_message ).fadeOut(300);

                    setTimeout( function(){ window.location.assign( $results.customizer_location ); }, 350 );
                }
            );

        } else if( undefined !== $action ) {

            $data = $form.find( 'input, textarea, select' ).serialize();

            $.post(
                layers_onboarding_params.ajaxurl,
                {
                    action: $action,
                    data: $data,
                    nonce: layers_onboarding_params.nonce

                },
                function(data){

                    $results = $.parseJSON( data );
                    if( true == $results.success ) {
                        $form.find( '.layers-save-progress' ).text( onboardingi8n.step_done_message );

                        setTimeout( function(){
                            $form.find( '.layers-save-progress' ).hide();
                            layers_next_onboarding_slide()
                        }, 350 );
                    }

                }
            ) // $.post
        } else {
            // Go to the next slide
            layers_next_onboarding_slide();
        }

    });

    $(document).on( 'click' , '#layers-onboard-skip' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        // Go to the next slide
        layers_next_onboarding_slide();
    });

    $(document).on( 'click' , '#layers-onboard-anchors a' , function(e){
        e.preventDefault();

        // "Hi Mom"
        $that = $(this);

        $i = $that.index();

        layers_change_onboarding_slide( $i );
    });

    $( 'input[name="layes-preset-layout"]' ).on( 'change' , function(e){
        // "Hi Mom"
        $that = $(this);

        // Enable the button when preset seleted
        if( $( 'input[name="layes-preset-layout"]:checked' ).length ){
            $( '.layers-proceed-to-customizer' ).removeClass('disable');
        }
        else{
            $( '.layers-proceed-to-customizer' ).addClass('disable');
        }
    });

    function layers_next_onboarding_slide(){
        $current = $( '#layers-onboard-anchors a.dot-active').index();
        $next = (+$current+1);

        layers_change_onboarding_slide( $next );
    }

    function layers_change_onboarding_slide( $i ){

        $max = $( '.onboard-nav-dots a' ).length-1;

        if( $i == $max ) {
            $('#layers-onboard-skip').fadeOut();
        } else {
            $('#layers-onboard-skip').fadeIn();
        }

        if( $i > $max ) return;

        // Update anchor classes
        $( '#layers-onboard-anchors a').eq( $i ).addClass( 'dot-active' ).siblings().removeClass( 'dot-active' );

        // Update slider classes
        $( '.layers-onboard-slide' ).eq( $i ).addClass( 'layers-onboard-slide-current' ).removeClass( 'layers-onboard-slide-inactive' ).siblings().removeClass( 'layers-onboard-slide-current' ).addClass( 'layers-onboard-slide-inactive' );

        $( '.layers-onboard-slide' ).eq( $i ).find( 'input, select, textarea, .layers-image-upload-button' ).first().focus();
    }
});