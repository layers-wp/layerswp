/**
* Page Content Switcher
*
* This file contains global widget functions
 *
 * @package Hatch
 * @since Hatch 1.0
*/

jQuery(document).ready(function($) {
	$page_template = $('#page_template');

	$(document).on( 'click' , '#hatch_toggle_builder a', function(e){
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
			$( '#hatch_toggle_builder' ).show();
			$( '#postdivrich' ).hide();
		} else {
			$( '#hatch_toggle_builder' ).hide();
			$( '#postdivrich' ).show();
		}

		 jQuery.ajax({
			type: 'POST',
			url: hatch_meta_params.ajaxurl,
			data: 'action=update_page_builder_meta&template=' + $that.val() + '&id=' + $('#post_ID').val()
		});
	});
});