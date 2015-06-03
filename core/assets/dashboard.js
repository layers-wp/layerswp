/**
 * Dashboard JS file
 *
 * This file contains admin functions pertaining to the Layers Dashboard
 *
 * @package Layers
 * @since Layers 1.0.0
 *
 * Contents
 * 1.a - Site Setup Dismiss button
 * 1.b - Site Setup Save & proceed button
 * 1.c - Site Setup Completion Message
 * 2 - Dashboard Feeds
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery(function($) {

    /**
    * 1.a - Site Setup Dismiss button
    *
    * Used to Dismiss setup steps via the "Complete Your Site Setup" panel
    */

    $(document).on( 'click', '#layers-dashboard-page a[data-skip-action]', function(e){

        e.preventDefault();

        //Hi Mom!
        $that = $(this);

        $container = $that.closest( '.layers-dashboard-setup-form' );
        $form = $container.find( '.layers-content' );

        $action = $that.data( 'skip-action' );

        $container.hide().next().hide().removeClass( 'layers-hide' ).fadeIn( 250 );
        $container.remove();

        layers_check_dashboard_setup_completion();
    });

    /**
    * 1.b - Site Setup Save button
    *
    * Used to Save setup steps via the "Complete Your Site Setup" panel
    */

    $(document).on( 'click', '#layers-dashboard-page a[data-submit-action]', function(e){

        e.preventDefault();

        //Hi Mom!
        $that = $(this);

        $container = $that.closest( '.layers-dashboard-setup-form' );
        $form = $container.find( '.layers-content' );

        $data = $form.find( 'input, textarea, select' ).serialize();

        $action = $that.data( 'submit-action' );

        $.post(
                ajaxurl,
                {
                    action: $action,
                    setup_step_key: $that.data( 'setup-step-key' ),
                    data: $data,
                    layers_set_theme_mod_nonce: layers_onboarding_params.set_theme_mod_nonce

                },
                function(data){

                    $results = $.parseJSON( data );

                    $container.hide().next().hide().removeClass( 'layers-hide' ).fadeIn( 250 );
                    $container.remove();

                    layers_check_dashboard_setup_completion( true );
                }
            ); // $.post
    });

    /**
    * 1.c - Site Setup Completion Message
    */

    function layers_check_dashboard_setup_completion(){

        $that = $( '.layers-dashboard-setup-form' );

        if( 0 == $that.length ){
            $( '.layers-site-setup-panel' ).hide();
        }
    }

    /**
    * 2 - Dashboard Feeds
    */


    $( '[data-layers-feed]' ).each( function(){

        //Hi Mom!
        var $feed_container = $(this);

        $.post(
                ajaxurl,
                {
                    action: 'layers_dashboard_load_feed',
                    feed: $feed_container.data( 'layers-feed' ),
                    count: $feed_container.data( 'layers-feed-count' ),
                    layers_dashboard_feed_nonce: layers_dashboard_params.layers_dashboard_feed_nonce

                },
                function(data){

                    $results = $.parseJSON( data );

                    if( true == $results.success ){

                        $feed_container.find( '[data-loading]' ).remove();

                        $feed_container.prepend( $results.feed );
                    }
                }
            ); // $.post
    });

});

