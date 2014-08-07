jQuery(document).ready(function($){

	/**
	* Sortable items
	*/
	var textareaID;
	$( 'ul[id^="banner_list_"]' ).sortable({
		placeholder: "hatch-sortable-drop",
		start: function(e , li){
 			textareaID = $(li.item).find('.wp-editor-area').attr('id');
			try { tinyMCE.execCommand('mceRemoveControl', false, textareaID); } catch(e){}
		},
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

			// Make sure tinyMCE works
			try { tinyMCE.execCommand('mceAddControl', false, textareaID); } catch(e){}
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

				var mces = new Array();
				i = 0;
				$('.wp-editor-area').each(function(){
					mces[i] = $(this).attr('id');
					i++;
					try { tinyMCE.execCommand('mceRemoveControl', false, mces[i]); } catch(e){}
				})

				// Trigger change for ajax save
				$bannerInput.val( $banner_guids.join() ).trigger("change");

				i = 0;
				$('.wp-editor-area').each(function(){
					mces[i] = $(this).attr('id');
					i++;
					try { tinyMCE.execCommand('mceAddControl', false, mces[i] ); } catch(e){}
				})

				// Trigger color selectors
				jQuery('.hatch-color-selector').wpColorPicker();


			}
		) // $.post
	});

}); //jQuery