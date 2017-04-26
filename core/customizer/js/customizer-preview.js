/**
* Layers Customizer Preview JS file
*
* This file contains global widget functions
*
* @package Layers
* @since Layers 1.0.4
* Contents
* 1 - Send Custom Customizer Init Event to the parent
* 2 - Fix customizer FOUC during render
* 3 - Customizer UX Enhancements
* 4 - Remove all '#' href's in Preview
* 5 - Helper funciton removes specific line from any css <style> block
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
				 * 1 - Send Custom Customizer Init Event to the parent.
				 */
				self.preview.send( 'layers-customizer-preview-init' );

				/**
				 * 2 - Fix customizer FOUC during render
				 *
				 * Fix issue where font size is incorrectly displayed due to % font-size in an iframe in chrome
				 */
				/*var temp_rem = ( parseInt( $('body').css('font-size') ) / 10 ) + 'rem';
				$('body').css({ 'font-size': temp_rem });
				setTimeout(function() {
					$('body').css({ 'font-size': temp_rem });
				},3000 );*/

				/**
				 * 3 - Customizer UX Enhancements
				 */
				
				// UX to help with widget opening.
				$( '.widget[id^=layers-widget]' ).each( function( index, val ) {

					var $widget = $(this);
					var $widget_id = $widget.attr( 'id' );
					
					// Add the helper Title.
					$widget.attr( 'title', 'Shift-click to edit this widget.' );
					
					/**
					 * Open Widget on Shift-Click (custom code required after WordPress changed widget containers).
					 */
					
					$( document ).on( 'click', '#' + $widget_id, function( e ) {
						
						// Only proceed if a shift-click.
						if ( ! e.shiftKey ) return;
						
						e.preventDefault();
						
						// Send/Trigger the focus widget.
						self.preview.send( 'focus-widget-control', $widget_id );
					});
					
					/**
					 * Open Widget Button.
					 */
					if ( false ) {
						
						// Add Edit Buttons.
						var $button = $( '<button class="layers-edit-widget">Edit</button>' );
						$widget.append( $button );

						// Send event to parent on click
						$button.click( function( event ) {
							
							// Old Method
							/*self.preview.send( 'layers-open-widget', {
								'id' : 'customize-control-widget_' + $widget_id,
							});*/
							
							// New WP method.
							self.preview.send( 'focus-widget-control', $widget_id );
						});
					}
					
				});
				
				
				// Close all widgets when clickign anywhere in document.
				$( document ).on( 'click', function( e ){
					
					// Don't close all widgets if shift-cliking a Widget.
					if ( true === e.shiftKey ) return true;
					
					// Don't close all widgets if clicking Edit-Widget button.
					if ( true === $( e.target ).hasClass( 'layers-edit-widget' ) ) return true;
						
					// Send 'close all' event to parent.
					self.preview.send( 'layers-close-all-widgets' );
				});
				
				/**
				 * 4 - Remove all '#' href's in Preview so WP does not incorrectly activate them causing new page click.
				 */
				$( 'a[href="#"]' ).attr( 'href', '' );
				
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


/**
 * 5 - Helper function removes specific line from any CSS <style> block and adds new CSS at the last point that CSS was found.
 */
function layers_replace_customizer_css( $search_string, $new_css ) {
	
	// Loop all <style> blocks.
	jQuery('style').each(function(index, el) {
		
		// Cache elements.
		var $style_block = jQuery(this);
		
		// Get the CSS text.
		var $css = $style_block.text();
		
		// Convert CSS text to array split on lines.
		$css = $css.split("\n");
		
		var $found_at_index = false;
		
		// Loop each line, search for the string, remove it if it's found.
		jQuery.each( $css, function( index, value ){
			if ( undefined !== value && -1 !== value.indexOf( $search_string ) ) {
				
				// Empty this line.
				$css[index] = '';
				
				// Record the last index that we matched CSS, so we can insert new CSS there later.
				$found_at_index = index;
			}
		});
		
		// Insert new CSS if we found any.
		if ( false !== $found_at_index ) {
			
			// First Convert the CSS passed to the JS function.
			$new_css = decodeURIComponent( $new_css );
			
			// Insert the CSS.
			$css.splice( $found_at_index, 1, $new_css );
		}
		
		// Convert CSS from array back to it's initial format.
		$css = $css.join("\n");
		
		// Put the CSS back in the <style> block.
		$style_block.text( $css );
	});
}
