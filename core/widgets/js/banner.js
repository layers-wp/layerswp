jQuery(document).ready(function($){

	/**
	* Sortable items
	*/

	$( 'ul[id^="banner_list_"]' ).sortable({
		placeholder: "hatch-sortable-drop",
		stop: function(e , li){
			// Banner UL, looking up from our current target
			$bannerList = li.item.closest( 'ul' );

			// Banners <input>
			$bannerInput = $( '#banner_ids_input_' + $bannerList.data( 'number' ) );

			// Apply new banner order
			$banner_guids = [];
			$bannerList.find( 'li.hatch-accordion-item' ).each(function(){
				$banner_guids.push( $(this).data( 'guid' ) );
			});

			// Trigger change for ajax save
			$bannerInput.val( $banner_guids.join() ).trigger("change");
		}
	});

	/**
	* Banner Additions
	*/

	$(document).on( 'click' , '.hatch-add-widget-banner' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Banner UL
		$bannerList = $( '#banner_list_' + $that.data( 'number' ) );

		// Banners <input>
		$bannerInput = $( '#banner_ids_input_' + $bannerList.data( 'number' ) );

		$.post(
			hatch_widget_params.ajaxurl,
			{
				action: 'hatch_banner_widget_actions',
				widget_action: 'add',
				id_base: $bannerList.data( 'id_base' ),
				number: $bannerList.data( 'number' ),
				nonce: hatch_widget_params.nonce

			},
			function(data){

				// Append banner HTML
				$bannerList.append( data );

				// Append banner IDs to the banners input
				$banner_guids = [];
				$bannerList.find( 'li.hatch-accordion-item' ).each(function(){
					$banner_guids.push( $(this).data( 'guid' ) );
				});

				// Trigger change for ajax save
				$bannerInput.val( $banner_guids.join() ).trigger("change");

				// Trigger color selectors
				jQuery('.hatch-color-selector').wpColorPicker();
			}
		) // $.post
	});

}); //jQuery