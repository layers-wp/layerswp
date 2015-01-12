/**
* Page Content Switcher
*
* This file contains global widget functions
 *
 * @package Layers
 * @since Layers 1.0
*/

jQuery(document).ready(function($) {
	$page_template = $('#page_template');

	$(document).on( 'click' , '#layers_toggle_builder a', function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = jQuery(this);

		// Submit form
		$that.closest('form').submit();

		window.location = $that.attr('href');
	});

	$(document).on( 'change' , '#page_template', function(){
		// "Hi Mom"
		$that = jQuery(this);

		// If we use the builder, show the "build" button
		if('builder.php' == $that.val() ){
			$( '#layers_toggle_builder' ).removeClass( 'layers-hide' );
			$( '#postdivrich' ).hide();
		} else {
			$( '#layers_toggle_builder' ).addClass( 'layers-hide' );
			$( '#postdivrich' ).show();
		}

		 jQuery.ajax({
			type: 'POST',
			url: layers_meta_params.ajaxurl,
			data: 'action=update_page_builder_meta&template=' + $that.val() + '&id=' + $('#post_ID').val()
		});
	});
});