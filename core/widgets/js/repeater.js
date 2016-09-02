/**
* Content Widget JS file
*
* This file contains functions relating to the Content Widget
 *
 * @package Layers
 * @since Layers 1.0.0
 * Contents
 * 1 - Define Repeater Plugin
 * 2 - Init Repeaters
 * 3 - Remove Item
 * 4 - Add Item
 * 5 - Update Item Title
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery(document).ready(function($){

	/**
	* 1 - Define Repeater Plugin
	*/

	$.fn.layersRepeater = function( options ) {

		// Apply defaults to the options
        $.extend( options, options, {});

		return this.each(function() {

			var $repeater = $(this);

			$repeater.find( 'ul.layers-accordions-sortable' ).sortable({
				placeholder: "layers-sortable-drop",
				handle: ".layers-accordion-title",
				stop: function(e , li){

					// Get Elements
					$repeater_list = li.item.closest( 'ul' );
					$repeater = $repeater_list.parents('.layers-widget-repeater');
					$repeater_input = $repeater.find('.layers-repeater-input');

					// Apply new column order
					$item_guids = [];
					$repeater_list.find( 'li.layers-accordion-item' ).each(function(){
						$item_guids.push( $(this).data( 'guid' ) );
					});

					// Trigger change for ajax save
					$repeater_input.val( $item_guids.join() ).layers_trigger_change();
				}
			});
		});
	};

	/**
	* 2 - Init Init Repeaters
	*/

	$( document ).on( 'layers-interface-init', function( e, element ){

		$(element).find( '.layers-widget-repeater' ).each( function(){
			$(this).layersRepeater();
		});
	});

	/**
	* 3 - Add Item Function (used for 'add item', 'duplicate item')
	*/

	function add_item( $repeater, $duplicate_guid ) {

		// Get elements
		$repeater              = $repeater;
		$repeater_add_button   = $repeater.find('.layers-widget-repeater-add-item');
		$repeater_list         = $repeater.find('.layers-accordions');
		$repeater_input        = $repeater.find('.layers-repeater-input');
		$repeater_new_item_tpl = $repeater.find('.layers-widget-repeater-template');
		$widget_form           = $repeater.parents('.widget-content');
		$duplicate_element     = $repeater_list.find('[data-guid="' + $duplicate_guid + '"]');

		// Generate a new unique guid.
		$guid = false;
		while( ! $guid || $repeater.find('[data-guid="' + $guid + '"]').length ) {
			$guid = _.random(100, 999);
		}

		// Get the template text.
		$repeater_new_item_tpl_text = $repeater_new_item_tpl.text();
		// Convert it to an jQuery element.
		$new_item = $( $repeater_new_item_tpl_text );
		$new_item.find('input[type="checkbox"]').prop( 'checked', true ); // Pre-check all checkbox, so the following serialize knows they exist.

		// Get all the inputs so we can save them for reference.
		$new_item_data = $new_item.find('select, hidden, textarea, input:not([type=radio]), input:checked').serializeArray();

		// Convert the template back to text again, so we can do string replace on it.
		$repeater_new_item_tpl = $new_item.wrapAll('<div>').parent().html();
		// Do string replace, with the new unique guid.
		$repeater_new_item_tpl_text = $repeater_new_item_tpl.replace( /{{{{guid}}}}/g, $guid );
		// Convert it back to jQuery element again.
		$new_item = $( $repeater_new_item_tpl_text );

		// If we've passed an element to reference then lets grab the data from it.
		if ( $duplicate_element.length ) {

			$( $new_item_data ).each(function( index ){

				// Do string replaces on the name so we know the reference field and the original field.
				$original_name = $new_item_data[index].name;
				$new_item_data[index].name = $original_name.replace( /{{{{guid}}}}/g, $guid );
				$new_item_data[index].name_to_get = $original_name.replace( /{{{{guid}}}}/g, $duplicate_guid );

				// Ge the reference field and the original field.
				$new_field = $new_item.find( '[name="' + $new_item_data[index].name + '"]' );
				$duplicated_field = $repeater.find( '[name="' + $new_item_data[index].name_to_get + '"]' );

				// Update the new field values with the duplicated field values.
				if ( $new_field.is(':radio') ) {

					// Radio
					$duplicated_field = $duplicated_field.filter(':checked');
					if ( $duplicated_field.length ) {

						// Un-check all.
						$new_field.removeAttr('checked');
						$new_field.prop( 'checked', false );

						// Check the correct field.
						$new_field = $new_field.filter('[value="' + $duplicated_field.val() + '"]');
						$new_field.prop( 'checked', true );
						$new_field.attr( 'checked', 'checked' );
					}
				}
				else if ( $new_field.is(':checkbox') ) {

					// Checkbox
					$duplicated_field = $duplicated_field.filter(':checked');
					if ( $duplicated_field.length ) {

						// Check the correct field.
						$new_field.prop( 'checked', true );
						$new_field.attr( 'checked', 'checked' );
					}
				}
				else {

					// Input, Select, etc
					$new_field.val( $duplicated_field.val() );
				}

				// Special behaviour for Image Select items.
				if ( $duplicated_field.parents('.layers-image-container').length ) {

					// Get elements.
					$new_field_container        = $new_field.parents('.layers-image-container');
					$duplicated_field_container = $duplicated_field.parents('.layers-image-container');

					// Get Image HTML
					var $duplicated_field_image = $duplicated_field_container.find('.layers-image-display').clone();

					// Duplicate the duplicated fields image.
					$new_field_container.find('.layers-image-display').replaceWith( $duplicated_field_image );

					// Add 'Has Image' Class.
					$new_field_container.addClass('layers-has-image');

				}

			});
		}

		// Hide the section so just title is showing.
		$new_item.find('.layers-accordion-section').hide();
		$new_item.addClass('layers-accordion-item-adding');
		$new_item.addClass('layers-accordion-item-adding-hidden');
		$new_item.addClass('layers-accordion-item-adding-flash');

		// Append item HTML
		if ( $duplicate_element.length )
			$duplicate_element.after($new_item);
		else
			$repeater_list.append($new_item);

		// Append item IDs to the items input
		$new_item_guids = [];
		$repeater_list.find( 'li.layers-accordion-item' ).each(function(){
			$new_item_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$repeater_input.val( $new_item_guids.join() ).layers_trigger_change();

		// Trigger interface init. will trigger init of elements eg colorpickers etc
		$(document).trigger( 'layers-interface-init', $new_item );

		// Remove loading class
		$repeater_add_button.removeClass('layers-loading-button');

		// Auto-update the title
		update_titles( $new_item );

		// Add Open Class to item
		$hidden_items = $repeater.find('.layers-accordion-item-adding-hidden');
		$hidden_items.removeClass('layers-accordion-item-adding-hidden');
		setTimeout( function(){
			$hidden_items.find('.layers-accordion-title').trigger('click');
		}, 200 );
		setTimeout( function(){
			$hidden_items.removeClass('layers-accordion-item-adding-flash');
		}, 1000 );
		setTimeout( function(){
			$hidden_items.removeClass('layers-accordion-item-adding');
		}, 1500 );
	}

	/**
	* 4 - Duplicate Item
	*/

	$( document ).on( 'click', '.layers-accordion-duplicate', function( e, element ){

		$repeater = $(this).closest('.layers-widget-repeater');
		$repeater_item_clicked = $(this).closest('.layers-accordion-item');
		$repeater_item_clicked_guid = $repeater_item_clicked.attr('data-guid');

		add_item( $repeater, $repeater_item_clicked_guid );

		return false;
	});

	// Add the duplciated buttons, so that we don't have to add them in the HTML.
	$( document ).on( 'layers-interface-init', function( e, element ){
		$(element).find( '.layers-accordion-title' ).each( function(){
			if ( ! $(this).find('.layers-accordion-duplicate').length ) {
				$(this).append( $('<span class="layers-accordion-duplicate" title="' + repeateri18n.duplicate_text + '"></span>') );
				$(this).append( $('<span class="layers-accordion-edit" title="' + repeateri18n.edit_text + '"></span>') );
			}
		});
	});

	/**
	* 4 - Add Item
	*/

	$(document).on( 'click', '.layers-widget-repeater-add-item' , function(e){

		e.preventDefault();
		$repeater           = $(this).closest('.layers-widget-repeater');
		$last_repeater_item = $repeater.find('ul.layers-accordions > li.layers-accordion-item:last-child');
		if ( $last_repeater_item.length )
			$last_repeater_guid = $last_repeater_item.attr('data-guid');
		else
			$last_repeater_guid = 0;

		add_item( $repeater, $last_repeater_guid );
	});

	/**
	* 5 - Remove Item
	*/

	$(document).on( 'click' , '.layers-widget-repeater .layers-icon-error' , function(e){

		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		// Confirmation message @TODO: Make JS confirmation column

		if( false === confirm( repeateri18n.confirm_message ) ) return;

		// Get elements
		$repeater_delete_button = $(this);
		$repeater_item_row      = $repeater_delete_button.closest( '.layers-accordion-item' );
		$repeater_item_title    = $repeater_item_row.find('.layers-accordion-title');
		$repeater               = $repeater_delete_button.parents('.layers-widget-repeater');
		$repeater_list          = $repeater.find('.layers-accordions');
		$repeater_input         = $repeater.find('.layers-repeater-input');

		// Close the row first.
		$repeater_item_title.click();

		// Delay till the row closed.
		setTimeout(function() {

			$repeater_item_row.addClass('layers-accordion-item-remove');

			// Delay while the remove animation plays.
			setTimeout(function() {

				$repeater_item_row.animate({ height: 0, margin: 0 }, { duration: 150, complete: function() {

					// Remove this row completely now.
					$repeater_item_row.remove();

					// Curate column IDs
					$column_guids = [];

					$repeater_list.find( 'li.layers-accordion-item' ).each(function(){
						$column_guids.push( $(this).data( 'guid' ) );
					});

					// Trigger change for ajax save
					$repeater_input.val( $column_guids.join() ).layers_trigger_change();

					// Reset Sortable Items
					// layers_set_column_sortable( $that );
					$repeater.find( 'ul.layers-accordions-sortable' ).sortable('refresh');
				}});

			}, 700 );

		}, 500 );
	});

	/**
	* 5 - Update Item Title
	*/
	$(document).on( 'keyup', '.layers-widget-repeater > ul input[id*="-title"], .layers-widget-repeater > ul input[id*="-button-link_text"]', function(e){

		// "Hi Mom"
		$that = $(this);

		$repeater_item = $that.closest('.layers-accordion-item');

		update_titles( $repeater_item );
	});

	function update_titles( $repeater_item ) {

		// "Hi Mom"
		$title_field = $repeater_item.find( 'input[id*="-title"], input[id*="-button-link_text"]' );

		if( 'undefined' == typeof( $title_field.val() ) ) return;

		// Set the string value
		$val = $title_field.val().substr( 0 , 51 );

		// Set the Title
		$string = ': ' + ( $val.length > 50 ? $val + '...' : $val );

		// Update the accordian title
		$title_field.closest( '.layers-accordion-item' ).find( 'span.layers-detail' ).text( $string );
	}


}); //jQuery
