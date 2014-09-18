jQuery(document).ready(function($){

	/**
	* Sortable items
	*/

	$( 'ul[id^="banner_list_"]' ).sortable({
		placeholder: "hatch-sortable-drop",
		start: function(e , li){
			// Get the current tab index
			$current_index = li.item.index();
		},
		stop: function(e , li){
			// Get the new tab index
			$new_index = li.item.index();

			// Banner UL, looking up from our current target
			$bannerList = li.item.closest( 'ul' );

			// Banners <input>
			$bannerInput = $( '#banner_ids_input_' + $bannerList.data( 'number' ) );

			// Apply new banner order
			$banner_guids = [];
			$bannerList.find( 'li' ).each(function(){
				$banner_guids.push( $(this).data( 'guid' ) );
			});

			// Trigger change for ajax save
			$bannerInput.val( $banner_guids.join() ).trigger("change");

			// Get the nearest tab containers
			$tab_nav = li.item.closest( '.hatch-nav-tabs' );
			$tab_container = $tab_nav.siblings('.hatch-tab-content');

			// Re-order the tab body
			$tab_content = $tab_container.find( 'section.hatch-tab-content' ).eq( $current_index ).remove();
			if( 0 == $new_index ){
				$tab_container.prepend( $tab_content );
			} else {
				$tab_content.insertAfter(  $tab_container.find( 'section.hatch-tab-content' ).eq( ( +$new_index-1) ) );
			}


		}
	});

	/**
	* Banner Additions
	*/

	$(document).on( 'click' , 'hatch-tabs li .icon-cross' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Banner UL
		$bannerList = $( '#banner_list_' + $that.data( 'number' ) );

		// Banners <input>
		$bannerInput = $( '#banner_ids_input_' + $bannerList.data( 'number' ) );

		// Remove this banner
		$that.closest( '.hatch-accordion-item' ).remove();

		// Curate banner IDs
		$banner_guids = [];
		$bannerList.find( 'li' ).each(function(){
			$banner_guids.push( $(this).data( 'guid' ) );
		});

		// Trigger change for ajax save
		$bannerInput.val( $banner_guids.join() ).trigger("change");

	});

	$(document).on( 'click' , '.hatch-add-widget-banner' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Banner UL
		$bannerList = $( '#banner_list_' + $that.data( 'number' ) );

		// Banners <input>
		$bannerInput = $( '#banner_ids_input_' + $bannerList.data( 'number' ) );

		// Get the nearest tab containers
		$tab_nav = $bannerList.closest( '.hatch-nav-tabs' );
		$tab_container = $tab_nav.siblings('.hatch-tab-content');

		// Generate a unique GUID for this slide
		$guid = Math.floor((Math.random() * 1000) + 1);

		$.post(
			hatch_widget_params.ajaxurl,
			{
				action: 'hatch_banner_widget_actions',
				widget_action: 'add',
				id_base: $bannerList.data( 'id_base' ),
				number: $bannerList.data( 'number' ),
				nonce: hatch_widget_params.nonce,
				guid: $guid

			},
			function(data){

				// Append banner HTML
				$bannerList.append( '<li data-guid="' + $guid + '"><a href="#">Slide <span class="icon-cross hatch-small" data-number="' + $bannerList.data( 'number' ) + '"></span></a></li>' );
				$tab_container.append( data );
				$tab_container.find( 'section.hatch-tab-content' ).last().hide();

				// Curate banner IDs
				$banner_guids = [];
				$bannerList.find( 'li' ).each(function(){
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