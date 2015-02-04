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

    function layers_onboarding_load_anchors(){

        $anchor_count = $( '.layers-onboard-slide' ).length;
        $anchor_template = '<a class="%class% %active-class%" href=""></a>'

        for( $i = 0; $i < $anchor_count; $i++ ){
            $a = $anchor_template.toString().replace( '%class%' , 'layers-dot' );
            $a = $a.toString().replace( '%active-class%' ,( 0 == $i ? 'dot-active' : '') );

            $( '.onboard-nav-dots' ).append( $a );

        };
    }

    layers_onboarding_load_anchors();

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
            $title = $('#layers-preset-layout-' + $id + '-title' ).val();
            $widget_data = $('#layers-preset-layout-' + $id + '-widget_data' ).val();

            var $page_data = {
                action: 'layers_create_builder_page_from_preset',
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

    function layers_next_onboarding_slide(){
        $current = $( '#layers-onboard-anchors a.dot-active').index();
        $next = (+$current+1);
        $max = $( '.onboard-nav-dots a' ).length;

        if( $next == $max ) return;

        layers_change_onboarding_slide( $next );
    }

    function layers_change_onboarding_slide( $i ){
        // Update anchor classes
        $( '#layers-onboard-anchors a').eq( $i ).addClass( 'dot-active' ).siblings().removeClass( 'dot-active' );

        // Update slider classes
        $( '.layers-onboard-slide' ).eq( $i ).addClass( 'layers-onboard-slide-current' ).removeClass( 'layers-onboard-slide-inactive' ).siblings().removeClass( 'layers-onboard-slide-current' ).addClass( 'layers-onboard-slide-inactive' );
    }
});