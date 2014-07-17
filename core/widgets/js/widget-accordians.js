/*
* Hatch Widget Accordians
*
* This file controls the accordian action on the Hatch custom widgets
*
*/
( function( $ ){

	$( document ).on( 'click' , '.hatch-accordion-title' , function(e){
		e.preventDefault();

		$me = $(this).closest( 'li.hatch-accordion-item' );
		$me.toggleClass( 'open' );
		$me.find( '.hatch-accordion-section' ).first().slideToggle();

		$siblings = $me.siblings();
		$siblings.removeClass( 'open' );
		$siblings.find( '.hatch-accordion-section' ).slideUp();

	});

	function hatch_init_accordians(){
		$( '.hatch-accordions' ).each( function(){
			var $that = $(this);

			$that.find( 'li.hatch-accordion-item' ).first().addClass( 'open' );

			$that.find( 'li.hatch-accordion-item' ).each( function() {
				$li = $(this);

				if( $li.hasClass( 'open' ) ){
					$li.find( '.hatch-accordion-section' ).first().slideDown();
				} else {
					$li.find( '.hatch-accordion-section' ).slideUp();
				}
			});
		});
	} // @TODO: Make sure that when adding a new widget, that the right accordians are open & closed
	hatch_init_accordians();

	$( document ).on( 'click' , '.available-widgets div[id$=widget-tpl-obox-hatch]' , function(){ hatch_init_accordians() });

})(jQuery);
