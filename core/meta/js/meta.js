/**
 * Post Meta JS
 *
 * This file contains all post-meta functionality
 *
 * @package Layers
 * @since Layers 1.0.0
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
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

		$non_layers_boxes = '#postdivrich, #postbox-container-2, #postimagediv';

		// If we use the builder, show the "build" button
		if('builder.php' == $that.val() ){
			$( '#layers_toggle_builder' ).removeClass( 'layers-hide' );
			$( $non_layers_boxes ).hide();
		} else {
			$( '#layers_toggle_builder' ).addClass( 'layers-hide' );
			$( $non_layers_boxes ).show();
		}

		 jQuery.ajax({
			type: 'POST',
			url: layers_meta_params.ajaxurl,
			data: 'action=update_page_builder_meta&template=' + $that.val() + '&id=' + $('#post_ID').val()
		});
	});
});