jQuery(document).ready(function($){
    $(document).on( 'click', '#hatch-import-wiget-page', function(e){

        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $that.parent().append("Be patient while we import the widget data and images.");

        $.post(
            hatch_widget_params.ajaxurl,
            {
                action: 'hatch_import_widgets',
                post_id: $that.data('post-id'),
                widget_data: $.parseJSON( $that.siblings( 'textarea' ).val() ),
                nonce: hatch_widget_params.nonce
            },
            function(data){
                console.log( "Result: " );
                console.log( data );
            }
        );
    });
});