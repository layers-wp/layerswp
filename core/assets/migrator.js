jQuery(document).ready(function($){

     var $title, $widget_data;

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

    $(document).on( 'click', '#layers-preset-layout-next-button a#layers-preset-cancel', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $( '.layers-modal' ).fadeOut();
        $( '#adminmenu' ).fadeIn();
    });

    $(document).on( 'click', '#layers-preset-layout-next-button a#layers-preset-proceed', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $( '.layers-load-bar' ).hide().removeClass( 'layers-hide' ).fadeIn( 750 );
        $( '#layers-preset-layout-next-button' ).addClass( 'layers-hide' );

        $( '.layers-progress' ).removeClass( 'zero complete' ).css('width' , 0);
        var $load_bar_percent = 0;

        $( '.layers-progress' ).animate( {width: "100%"}, 4500 );

        var $page_data = {
                action: 'layers_create_builder_page_from_preset',
                post_title: $( '#layers_preset_page_title' ).val(),
                widget_data: $.parseJSON( $widget_data ),
                nonce: layers_widget_params.nonce
            };

        jQuery.post(
            layers_widget_params.ajaxurl,
            $page_data,
            function(data){
                $results = $.parseJSON( data );

                $( '.layers-progress' ).stop().animate({width: "100%"} , 500 , function(e){
                    window.location.assign( $results.customizer_location );
                });
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

        // Show the Modal
        $( '.layers-modal' ).find( '.layers-media-image' ).html( $that.find('img') );
        $( '.layers-modal' ).hide().removeClass( 'layers-hide' ).fadeIn( 350 );
        $( '#adminmenu' ).fadeOut();

        $( '#layers_preset_page_title' ).val( $title );
    });
});
