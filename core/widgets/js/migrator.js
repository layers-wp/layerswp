jQuery(document).ready(function($){
    $(document).on( 'click', '#hatch-import-wiget-page', function(e){

        e.preventDefault();

        // "Hi Mom!"
        $that = $(this);

        $.post(
            hatch_widget_params.ajaxurl,
            {
                action: 'hatch_import_widgets',
                post_id: $that.data('post-id'),
                widget_data: $.parseJSON( $that.siblings( 'textarea' ).val() ),
                nonce: hatch_widget_params.nonce
            },
            function(data){
              alert( "Imported! Hopefully :/" );
            }
        );
    });
});