jQuery(document).ready(function($){
    $(document).on( 'click', '#layers-import-wiget-page', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $that.parent().append("Be patient while we import the widget data and images.");

        var $page_data = {
                action: 'layers_import_widgets',
                post_id: $that.data('post-id'),
                widget_data: $.parseJSON( $that.siblings( 'textarea' ).val() ),
                nonce: layers_widget_params.nonce
            };

         jQuery.post(
            layers_widget_params.ajaxurl,
            $page_data,
            function(data){
                console.log( data );
            }
        );

    });

    $(document).on( 'click', '#layers-preset-layout-next-button a', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        var $page_data = {
                action: 'layers_update_builder_page',
                post_id: $that.data( 'post_id' ),
                post_title: $( '#layers_preset_page_title' ).val(),
            };

        jQuery.post(
            layers_widget_params.ajaxurl,
            $page_data,
            function(data){
                window.location.assign( $that.data( 'location' ) );
            }
        );
    });

    $(document).on( 'click', '[id^="layers-generate-preset-layout-"]', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $id = $that.data( 'key' );

        $title = $('#' + $id + '-title' ).val();
        $widget_data = $('#' + $id + '-widget_data' ).val();

        $( '.layers-modal' ).find( '.layers-media-image' ).html( $that.find('img') );

        $( '.layers-modal' ).hide().removeClass( 'layers-hide' ).fadeIn( 350 );
        $( '#adminmenu' ).fadeOut();


        $( '.layers-progress' ).removeClass( 'zero complete' ).css('width' , 0);
        var $load_bar_percent = 0;

        $( '.layers-progress' ).animate( {width: "100%"}, 8000 ).text( Math.round($load_bar_percent)+'%');

        $load_interval = setInterval( function(){
            if( $load_bar_percent < 100 ) {
                $load_bar_percent = +$load_bar_percent+5;
                $( '.layers-progress' ).text( Math.round($load_bar_percent)+'%');
            } else {
                $( '.layers-progress' ).text( 'Almost done!');
                clearInterval( $load_interval );
            }
        }, 400 );

        $( '#layers_preset_page_title' ).val( $title );

        var $page_data = {
                action: 'layers_create_builder_page_from_preset',
                post_title: $title,
                widget_data: $.parseJSON( $widget_data ),
                nonce: layers_widget_params.nonce
            };

        jQuery.post(
            layers_widget_params.ajaxurl,
            $page_data,
            function(data){
                clearInterval( $load_interval );

                $( '.layers-progress' ).stop().css('width', '100%');
                $( '.layers-load-bar' ).hide();

                $( '#layers-preset-layout-next-button' ).hide().removeClass( 'layers-hide' ).fadeIn( 750 );


                $results = $.parseJSON( data );
                $next_btn = $( '#layers-preset-layout-next-button' ).find('a');
                $next_btn.attr( 'data-post_id', $results.post_id );
                $next_btn.attr( 'data-location', $results.customizer_location );
            }
        );
    });
});
