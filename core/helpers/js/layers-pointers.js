jQuery(document).ready(function($){

    // Loop over the pointer object
    $.each( layers_pointers , function( pointer_index , layers_pointer ){

        // Select the element and apply the pointer() function
        $( layers_pointer.selector ).pointer({
            content: '<h3>' + layers_pointer.title + '</h3>' + '<p>' + layers_pointer.content + '</p>',
            open: function( target , pointer_object ){
                /**
                * We have to hack the z-index to make sure the pointer displays in the customizer
                */
                var zindex = pointer_object.pointer.css( 'z-index' );
                pointer_object.pointer.css( 'z-index' , zindex*100 );
            },
            close: function() {
                $.post( ajaxurl, {
                    pointer: pointer_index,
                    action: 'dismiss-wp-pointer'
                });
            }
        }).pointer('open');
    });
});