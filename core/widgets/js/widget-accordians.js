/*
* Layers Widget Specific Functions
*
* This file controls the accordian action on the Layers custom widgets
*
 * Contents
 * 1 - Accordians
 * 1.a - Click
 * 1.b - Init
 * 1.c - Widget Click
 * 2 - Widget Peep Function
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
( function( $ ){

	/**
	* 1 - Accordians
	*/

	// 1.a - Accordian Click

	$( document ).on( 'click' , '.layers-accordion-title' , function(e){
		e.preventDefault();

		// Toggle this accordian
		$me = $(this).closest( 'li.layers-accordion-item' );
		$me.toggleClass( 'open' );
		$me.find( '.layers-accordion-section' ).first().slideToggle({ easing: 'layersEaseInOut', duration: 250 });

		// Close non-active accordians
		$siblings = $me.siblings();
		$siblings.removeClass( 'open' );
		$siblings.find( '.layers-accordion-section' ).slideUp({ easing: 'layersEaseInOut', duration: 250 });
	});

	// 1.b - Accodian Init
	
	$( document ).on( 'layers-interface-init', function( e, element ){
		layers_init_accordians( $(element) );
	});

	function layers_init_accordians( $element_s ){

		$element_s.find( '.layers-accordions' ).each( function(){
			
			$that = $(this);

			$that.find( 'li.layers-accordion-item' ).first().addClass( 'open' );
			$that.find( 'li.layers-accordion-item' ).not(':first').each( function() {
				var $li = $(this);
				$li.find( '.layers-accordion-section' ).hide();
			});
		});

	}

	// 1.c - Accodian Widget Click

	$( document ).on( 'click' , '#available-widgets div[id^="widget-tpl-layers-"]' , function(){
		//layers_init_accordians();
	});

	/**
	* 2 - Widget Peep Function
	*/
	$( document ).on( 'click' , '#layers-widget-peep' , function(e){
		e.preventDefault();

		// "Hi Mom"
		var $that = $(this);

		var $widget_content = $that.closest( '.widget-content' );
		var $widget_inside = $that.closest( '.widget-inside' );

		var $control_wrapper = $widget_content.find( '.layers-visuals-wrapper' );
		var $control_wrapper_width = $control_wrapper.outerWidth();


		if( $control_wrapper_width !== $widget_content.outerWidth() ) {
			$that.attr( 'icon-arrow-right');
			$widget_content.css( 'width',   $control_wrapper_width );
			$widget_inside.css( 'width',   $control_wrapper_width );
		} else {
			$that.attr('class' , 'icon-arrow-left');
			$widget_content.css( 'width' , '' );
			$widget_inside.css( 'width' , '' );
		}

	});

})(jQuery);
