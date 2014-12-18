jQuery(document).ready(function($){
    $(document).on( 'click', '#hatch-import-wiget-page', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $that.parent().append("Be patient while we import the widget data and images.");

        var $page_data = {
                action: 'hatch_import_widgets',
                post_id: $that.data('post-id'),
                widget_data: $.parseJSON( $that.siblings( 'textarea' ).val() ),
                nonce: hatch_widget_params.nonce
            };

         jQuery.post(
            hatch_widget_params.ajaxurl,
            $page_data,
            function(data){
                console.log( data );
            }
        );

    });
    $(document).on( 'click', 'label[id^="hatch-generate-preset-layout-"]', function(e){
        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $id = $that.attr( 'for' );
        $title = $('#' + $id + '-title' ).val();
        $widget_data = $('#' + $id + '-widget_data' ).val();

        $( '.hatch-modal' ).find( '.hatch-media-image' ).html( $that.find('img') );

        $( '.hatch-modal' ).hide().removeClass( 'hatch-hide' ).fadeIn( 350 );
        $( '#adminmenu' ).fadeOut();


        $( '.hatch-progress' ).removeClass( 'zero complete' ).css('width' , 0);
        var $load_bar_percent = 0;

        $( '.hatch-progress' ).animate( {width: "100%"}, 8000 ).text( Math.round($load_bar_percent)+'%');

        $load_interval = setInterval( function(){
            if( $load_bar_percent < 100 ) {
                $load_bar_percent = +$load_bar_percent+5;
                $( '.hatch-progress' ).text( Math.round($load_bar_percent)+'%');
            } else {
                $( '.hatch-progress' ).text( 'Almost done!');
                clearInterval( $load_interval );
            }
        }, 400 );

        var $page_data = {
                action: 'hatch_create_builder_page_from_preset',
                post_title: $title,
                widget_data: $.parseJSON( $widget_data ),
                nonce: hatch_widget_params.nonce
            };

        jQuery.post(
            hatch_widget_params.ajaxurl,
            $page_data,
            function(data){
                console.log( data );
                clearInterval( $load_interval );

                $( '.hatch-progress' ).stop().css('width', '100%');
                $( '.hatch-progress' ).text( 'Redirecting to Visual Customizer');

                $results = $.parseJSON( data );
                setTimeout( function(){
                    window.location.assign( $results.customizer_location );
                }, 500 );
            }
        );
    });
});
