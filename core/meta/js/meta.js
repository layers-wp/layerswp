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

		if( 'auto-draft' !== $( '#original_post_status' ).val() ){
			window.location = $that.attr('href');
		}
	});

	$(document).on( 'change' , '#page_template', function(){
		// "Hi Mom"
		$that = jQuery(this);

		$non_layers_boxes = '#postdivrich';

		// If we use the builder, show the "build" button
		if('builder.php' == $that.val() ){
			$( '#layers_toggle_builder' ).removeClass( 'l_admin-hide' );
			$( $non_layers_boxes ).hide();
		} else {
			$( '#layers_toggle_builder' ).addClass( 'l_admin-hide' );
			$( $non_layers_boxes ).show();
		}

		layers_update_page_template();
	});

	function layers_update_page_template(){
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: 'action=update_page_builder_meta&template=' + $( '#page_template' ).val() + '&id=' + $('#post_ID').val() + '&nonce=' + layers_meta_params.nonce
		});
	}
});