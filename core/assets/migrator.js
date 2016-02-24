/**
 * Migrator JS FIle
 *
 * This file contains all settings related to exporting and importing Layers Pages.
 *
 * @package Layers
 * @since Layers 1.0.0
 *
 * Contents
 * 1 - Select a Layout Step
 * 2 - Cancel & Close Modal
 * 3 - Final Importer Step
 * 4 - Import Page Button in Page Edit Screen
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

jQuery(document).ready(function($){

	var $title, $widget_data;

	/**
	* 1 - Select a Layout Step, Sets global vars for use in the import phase
	*/

	$(document).on( 'click', '.layers_page_layers-add-new-page .l_admin-product', function(e){
		e.preventDefault();

		$button = $(this).find('[id^="layers-generate-preset-layout-"]');

		$id = $button.data( 'key' );

		$title = $('#' + $id + '-title' ).val();
		$widget_data = $('#' + $id + '-widget_data' ).val();

		// Show the Modal
		$( '.l_admin-modal-container' ).find( '.l_admin-media-image' ).html( $button.find('img') );
		$( '.l_admin-modal-container' ).hide().removeClass( 'l_admin-hide' ).fadeIn( 350 );
		$( '#adminmenu' ).fadeOut();
	});

	$(document).on( 'keyup', '#layers_preset_page_title', function(e){
		if( '' == $(this).val() ){
			$( '#layers-preset-proceed' ).attr( 'disabled', 'disabled' );
		} else {
			$( '#layers-preset-proceed' ).removeAttr( 'disabled' );
		}
	});

	/**
	* 2 - Cancel And Close Modal
	*/

	$(document).on( 'click', '#layers-preset-layout-next-button a#layers-preset-cancel', function(e){
		e.preventDefault();

		// "Hi Mom!"
		$that = $(this);

		$( '.l_admin-modal-container' ).fadeOut();
		$( '#adminmenu' ).fadeIn();
	});

	/**
	* 3 - Final Preset Layout - Shows loading bar, when complete sends us to the customizer
	*/

	$(document).on( 'click', '#layers-preset-layout-next-button a#layers-preset-proceed', function(e){
		e.preventDefault();

		// "Hi Mom!"
		$that = $(this);

		$( '.l_admin-load-bar' ).hide().removeClass( 'l_admin-hide' ).fadeIn( 750 );
		$( '#layers-preset-layout-next-button' ).addClass( 'l_admin-hide' );

		$( '.l_admin-progress' ).removeClass( 'zero complete' ).css('width' , 0);
		var $load_bar_percent = 0;

		$( '.l_admin-progress' ).animate( {width: "100%"}, 4500 );

		var $page_data = {
				action: 'layers_create_builder_page_from_preset',
				post_title: $( '#layers_preset_page_title' ).val(),
				nonce: layers_migrator_params.preset_layout_nonce,
				widget_data: $.parseJSON( $widget_data ),
			};

		jQuery.post(
			ajaxurl,
			$page_data,
			function(data){

				$results = $.parseJSON( data );

				$( '.l_admin-progress' ).stop().animate({width: "100%"} , 500 , function(e){
					window.location.assign( $results.customizer_location );
				});
			}
		);
	});

	/**
	* 4 - Import Page Button in Page Edit Screen
	*/

	var file_frame;
	$(document).on( 'click', '#layers-page-import-button' , function(e){
		e.preventDefault();

		// "Hi Mom!"
		$that = $(this);

		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			file_frame.close();
		}

		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: $that.data( 'title' ),
			button: {
				text: $that.data( 'button_text' ),
			},
			multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {

			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();

			// Read the file JSON
			$.getJSON( attachment.url, function( import_data ){

				jQuery( '#layers-page-import-button' ).text( migratori18n.importing_message ).addClass( 'btn-link' );

				// Set the attributes to send to the importer
				var $page_data = {
						action: 'layers_import_widgets',
						post_id: $that.data('post-id'),
						nonce: layers_migrator_params.import_layout_nonce,
						widget_data: import_data,
					};

				$.post(
					ajaxurl,
					$page_data,
					function(data){

						// Upon completion update the import button
						jQuery( '#layers-page-import-button' ).fadeOut( 500, function() {
							jQuery(this).text( migratori18n.complete_message ).fadeIn().attr('disabled','disabled');
						} ).closest( '.l_admin-column' ).addClass( 'l_admin-success' );
					}
				);

			});

			return;
		});

		// Finally, open the modal
		file_frame.open();

		return false;
	});

	/**
	* 5 - Duplicate Page Button in Page Edit Screen
	*/

	var file_frame;
	$(document).on( 'click', '#layers-page-duplicate-button' , function(e){
		e.preventDefault();

		// "Hi Mom!"
		$that = $(this);

		// Set the attributes to send to the importer
		var $page_data = {
				action: 'layers_duplicate_builder_page',
				post_id: $that.data('post-id'),
				post_title: $('#title').val(),
				nonce: layers_migrator_params.duplicate_layout_nonce
			};

		$.post(
			ajaxurl,
			$page_data,
			function(data){
				$results = $.parseJSON( data );

				$a = $('<a />').attr('class' , 'layers-button btn-link' ).attr( 'href' , $results.page_location ).text( migratori18n.duplicate_complete_message );
				jQuery( '#layers-page-duplicate-button' ).closest( '.l_admin-column' ).addClass( 'l_admin-success' );
				jQuery( '#layers-page-duplicate-button' ).replaceWith( $a );
			}
		);


	});

});
