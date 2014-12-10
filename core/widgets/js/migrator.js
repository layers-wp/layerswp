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
                $results = $.parseJSON( data );
                console.log( $results );
                window.location.assign( $results.customizer_location );
            }
        );
    });
});
