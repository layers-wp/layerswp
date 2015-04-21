/**
* Layers Customizer Preview JS file
*
* This file contains global widget functions
*
* @package Layers
* @since Layers 1.0.4
* Contents
* 1 - Fix customizer FOUC during render
* 2 - Customizer UX Enhancements
*
* Author: Obox Themes
* Author URI: http://www.oboxthemes.com/
* License: GNU General Public License v2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

( function ( wp, $ ) {

	"use strict";

	// Check if customizer exists
	if ( ! wp || ! wp.customize ) return;

	// WordPress Stuff
	var	api = wp.customize,
		Preview;

	// New Customizer Previewer class
	api.LayersCustomizerPreview = {

		init: function () {
			var self = this; // cache previewer reference

			// layers-loaded event sent when the previewer is initialised
			this.preview.bind( 'active', function() {

				/**
				 * 1 - Fix customizer FOUC during render
				 *
				 * Fix issue where font size is incorrectly displayed due to % font-size in an iframe in chrome
				 */

				$('body').css({ 'font-size': '1.5rem' });
				setTimeout(function() {
					$('body').css({ 'font-size': '1.5rem' });
				},3000 );

				/**
				 * 2 - Customizer UX Enhancements
				 *
				 * Handle edit buttons and and other UI elemnts
				 */

				// Edit widget buttons
				$( '.widget' ).each( function( index, val ) {

					var $that = $(this);

					// Add Edit Buttons
					var $button = $( '<button class="layers-edit-widget">Edit</button>' );
					//$that.append( $button );

					// Send event to parent on click
					$button.click( function( event ) {
						var $widget_id = $button.parent( '.widget' ).attr( 'id' );
						self.preview.send( 'layers-open-widget', { 'id' : 'customize-control-widget_' + $widget_id } );
					});
				});

				// Close all widgets
				$( document ).on( 'click', function( e ){
					if ( false == $( e.target ).hasClass( 'layers-edit-widget' ) ) {
						// Send 'close all' event to parent so long as not Edit button clicked
						self.preview.send( 'layers-close-all-widgets' );
					}
				});
			});
		}
	};

	// Cache Preview
	Preview = api.Preview;
	api.Preview = Preview.extend( {
		initialize: function( params, options ) {

			// cache the Preview
			api.LayersCustomizerPreview.preview = this;

			// call the Preview's initialize function
			Preview.prototype.initialize.call( this, params, options );
		}
	} );

	// On document ready
	$( function () {

		// Initialize Layers Preview
		api.LayersCustomizerPreview.init();
	} );

} )( window.wp, jQuery );
