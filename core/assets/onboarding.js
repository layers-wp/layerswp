/**
 * Onboarding JS File
 *
 * This file contains all onboarding functions
 *
 * @package Layers
 * @since Layers 1.0.0
 *
 * Contents
 *
 * 1 - Slide Dot Selection
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

jQuery(function($) {

	function layers_onboarding_load_anchors(){

		$anchor_count = $( '.l_admin-onboard-slide' ).length;

		if( 1 == $anchor_count ) return;

		for( $i = 0; $i < $anchor_count; $i++ ){

			$title = $( '.l_admin-onboard-slide' ).eq( $i ).find( '.l_admin-section-title h3' ).text();

			$anchor_template = $( '<a href="" />' );
			$anchor_template.addClass( 'l_admin-dot layers-tooltip' );
			if( 0 == $i ){
				layers_onboarding_set_anchor(0);
			}

			$anchor_template.attr( 'title' , $title.trim() + ' (' + ( $i+1) + ' of ' + $anchor_count + ')' );

			$( '.onboard-nav-dots' ).append( $anchor_template );

		};
	}
	layers_onboarding_load_anchors();

	function layers_onboarding_set_anchor( $i ){

		// Update anchor classes
		$( '#layers-onboard-anchors a').each(function(index, el) {

			if ( index <= $i ) $(el).addClass( 'dot-active' );
			else $(el).removeClass( 'dot-active' );
		});
	}

	$(document).on( 'click' , '.onboard-next-step' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		if( $that.hasClass( 'disable' ) ) return;

		$form = $that.closest( '.l_admin-onboard-slide' );

		$action = $form.find( 'input[name="action"]' ).val();

		if( 'layers_select_preset' == $action ) {

			$progress_indicator = $form.find( '.l_admin-save-progress' );
			$progress_indicator_message = $progress_indicator.data( 'busy-message' );

			$that.text( $progress_indicator_message ).attr( 'disabled' , 'disabled' ).addClass( 'disable disable-tip' );

			$id = $( 'input[name="layes-preset-layout"]:checked' ).val();

			// No template selected
			if( ! $id ){ return false; }

			$title = $('#layers-preset-layout-' + $id + '-title' ).val();
			$widget_data = $('#layers-preset-layout-' + $id + '-widget_data' ).val();

			var $page_data = {
				action: 'layers_create_builder_page_from_preset',
				post_title: ( undefined == $( '#preset_page_title' ) ? false : $( '#preset_page_title' ).val() ),
				widget_data: $.parseJSON( $widget_data ),
				nonce: layers_onboarding_params.preset_layout_nonce
			};

			/** Log Event on Intercom **/
			if( 'undefined' !== typeof Intercom  ){
				$(document).layers_intercom_event(
					'created layers page',
					{
						"Template Type": $title,
						"Page Name": ( undefined == $( '#preset_page_title' ) ? false : $( '#preset_page_title' ).val() )
					}
				);
				$(document).layers_intercom_event( 'completed onboarding' );
			}

			jQuery.post(
				ajaxurl,
				$page_data,
				function(data){

					$results = $.parseJSON( data );

					$that.text( onboardingi18n.step_done_message );

					setTimeout( function(){ window.location.assign( $results.customizer_location ); }, 350 );
				}
			);

		} else if( undefined !== $action ) {
			$progress_indicator = $form.find( '.l_admin-save-progress' );
			$progress_indicator_message = $progress_indicator.data( 'busy-message' );
			$progress_indicator.text( $progress_indicator_message ).hide().removeClass( 'l_admin-hide' ).fadeIn(150);

			$data = $form.find( 'input, textarea, select' ).serialize();

			$.post(
				ajaxurl,
				{
					action: $action,
					data: $data,
					layers_onboarding_update_nonce: layers_onboarding_params.update_option_nonce

				},
				function(data){
					$results = $.parseJSON( data );
					if( true == $results.success ) {
						$form.find( '.l_admin-save-progress' ).text( onboardingi18n.step_done_message );

						setTimeout( function(){
							$form.find( '.l_admin-save-progress' ).hide();
							layers_next_onboarding_slide()
						}, 350 );
					}

				}
			) // $.post
		} else {
			// Go to the next slide
			layers_next_onboarding_slide();
		}

	});

	$(document).on( 'click' , '#layers-onboard-skip' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		// Go to the next slide
		layers_next_onboarding_slide();
	});

	$(document).on( 'click' , '#layers-onboard-anchors a' , function(e){
		e.preventDefault();

		// "Hi Mom"
		$that = $(this);

		$i = $that.index();

		layers_change_onboarding_slide( $i );
		history.pushState( { step: $i }, null, '#step-' + ( $i + 1 ) );
	});

	$( 'input[name="layes-preset-layout"]' ).on( 'change' , function(e){
		// "Hi Mom"
		$that = $(this);

		// Enable the button when preset seleted
		if( $( 'input[name="layes-preset-layout"]:checked' ).length ){
			$( '.l_admin-proceed-to-customizer' ).removeClass('disable');
		}
		else{
			$( '.l_admin-proceed-to-customizer' ).addClass('disable');
		}
	});

	function layers_next_onboarding_slide(){
		$current = $( '#layers-onboard-anchors a.dot-active').last().index();
		$next = (+$current+1);

		layers_change_onboarding_slide( $next );
		history.pushState( { step: $next }, null, '#step-' + ( $next + 1 ) );
	}

	function layers_change_onboarding_slide( $i ){

		$max = $( '.onboard-nav-dots a' ).length-1;

		if( $i == $max ) {
			$('#layers-onboard-skip').fadeOut();
		} else {
			$('#layers-onboard-skip').fadeIn();
		}

		if( $i > $max ) return;

		// Update anchor classes
		layers_onboarding_set_anchor($i);

		// Update slider classes
		$( '.l_admin-onboard-slide' ).eq( $i ).addClass( 'l_admin-onboard-slide-current' ).removeClass( 'l_admin-onboard-slide-inactive' ).siblings().removeClass( 'l_admin-onboard-slide-current' ).addClass( 'l_admin-onboard-slide-inactive' );

		// Focus the first form field in the slide
		$( '.l_admin-onboard-slide' ).eq( $i ).find( 'input, select, textarea, .l_admin-image-upload-button' ).first().focus();
	}

	// History - Allow forward/backward through the history states (enables frame stepping).
	window.addEventListener('popstate', function(e) {
		if ( null !== e.state ) {
			if ( e.state.hasOwnProperty('step') ) {
				layers_change_onboarding_slide( e.state.step );
			}
		}
	});

	$(document).ready(function(){

		// Allow for jumping to a specific step in case of mistaken (or intended) page refresh.
		if ( -1 !== window.location.hash.indexOf( 'step-' ) ) {
			var $step = window.location.hash.replace( '#step-', '' ) - 1;
			layers_change_onboarding_slide( $step );
			history.pushState( { step: ( $step ) }, null, null );
		}
		else{
			layers_change_onboarding_slide(0);
			history.replaceState( { step: 0 }, null, null );
		}
	});

});