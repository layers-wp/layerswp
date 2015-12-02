/**
 * Marketplace JS file
 *
 * This file contains all functions relating to the Layers Marketplace
 *
 * @package Layers
 * @since Layers 1.0.0
 *
 * Contents
 *
 * 1 - Modal Closing Functions
 * 2 - Modal Keyboard Navigation
 * 3 - Modal population script
 * 4 - Marketplace Filter and Search functions
 * 5 - Item height matcher
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery(function($) {

	/**
	* 1 - Modal Closing Functions
	*/
	$(document).on( 'click', '#layers-marketplace .theme-backdrop', function(e){
		if( $(this).not( '.theme-overlay' ) ){
			$( '#layers-marketplace .theme-overlay button.close' ).trigger( 'click' );
		}
	});

	$(document).on( 'click', '#layers-marketplace .theme-overlay button.close', function(e){
		e.preventDefault();

		$( '.theme-overlay' ).fadeOut(250).addClass( 'layers-hide' );
	});

	/**
	* 2 - Modal Keyboard Navigation
	*/
	$( '.toplevel_page_layers-marketplace' ).on( "keyup", function( e ) {
		e.preventDefault();

		$modal = $( '.theme-overlay' );

		// Esc
		if( 27 ==  event.which ){
			$modal.find( '.close' ).click();
		}

		// <-
		if( 37 ==  event.which ){
			$modal.find( '.left' ).click();
		}

		// ->
		if( 39 ==  event.which ){
			$modal.find( '.right' ).click();
		}
	});

	/**
	* 3 - Modal population script
	*/
	$(document).on( 'click', '#layers-marketplace [data-view-item^="product-details-"]', function(e){
		e.preventDefault();

		var $layers_a = $(this);

		$id = '#' + $layers_a.attr('data-view-item');

		var $my_data = $( $id ).find( 'input' ).val();

		var $json = jQuery.parseJSON( $my_data );

		$modal = $( '.theme-overlay' );

		/**
		* Product Screenshot
		*/
		$screenshot = $( $id ).find( '.layers-product-screenshot' ).html();
		$modal.find( '.theme-screenshots' ).html( $( $screenshot ).removeAttr( 'width') );

		/**
		* Product Details
		*/
		$modal.find( '.theme-name' ).text( $json.name );

		/**
		* Product Meta
		*/
		$price = $json.price_cents/100;
		$modal.find( '.theme-author-img' ).attr( 'src' , $json.author_image );
		$modal.find( '.theme-author' ).attr( 'href' , $json.author_url )
		$modal.find( '.theme-author' ).text( 'By ' + $json.author_username );
		$sales_word = ( $json.number_of_sales == 1 ? ' sale' : ' sales' );
		$modal.find( '.theme-sales' ).html( $json.number_of_sales + $sales_word);

		/**
		* Product :inks
		*/
		var $url = $( $id ).data( 'url' );

		$modal.find( '.theme-details-link' ).attr( 'href' , $url );
		if( 'undefined' !== typeof $json.previews.live_site ){
			$modal.find( '.theme-demo-link' ).show().attr( 'href' , $url + '&type=demo&slug=' + $( $id ).data( 'slug' ) );
		} else {
			$modal.find( '.theme-demo-link' ).hide();
		}
		$modal.find( '.theme-buy-link' ).attr( 'href' , $url + "&type=purchase" );
		$modal.find( '.theme-details-link, .theme-demo-link, .theme-buy-link' ).attr( 'data-item', $json.name ).attr( 'data-price', '$ ' + $price );


		/**
		* Product Description & Summary
		*/
		var decoded_description = $("<div/>").html( $json.description );
		$modal.find( '.theme-description' ).html( decoded_description + ' <a href="' + $url + '" target="_blank">Read More</a>' );
		$modal.find( '.theme-price' ).text( $price );
		$modal.find( '.theme-tags' ).text( $json.summary );

		/**
		* Next / Previous buttons
		*/
		if( 1 > $( $id ).prev( 'div.layers-product' ).length ){
			$prev = $('.layers-products .layers-product').eq( $('.layers-products .layers-product').length - 1 ).attr( 'id' );
		} else {
			$prev = $( $id ).prev().attr( 'id' );
		}
		$modal.find( '.left' ).attr( 'data-view-item' , $prev );

		if( 1 > $( $id ).next( 'div.layers-product' ).length ){
			$next = $('.layers-products .layers-product').eq(0).attr( 'id' );
		} else {
			$next = $( $id ).next().attr( 'id' );
		}
		$modal.find( '.right' ).attr( 'data-view-item' , $next );

		/**
		* Rating
		*/
		$modal.find( '.theme-rating' ).html('');

		if( 3 >= $json.rating.count ){
			$modal.find( '.theme-rating' ).hide();
		} else {
			$modal.find( '.theme-rating' ).show();
			for( i = 1; i < 6; i++ ){
				if( i <= Math.round( $json.rating.rating ) ){
					$star_class = 'star star-full';
				} else {
					$star_class = 'star star-empty';
				}

				$modal.find( '.theme-rating' ).append( $('<span class="' + $star_class + '" />') );
			}
		}

		if( $( '.theme-overlay' ).hasClass( 'layers-hide' ) ){
			$( '.theme-overlay' ).hide().removeClass( 'layers-hide' ).fadeIn(250);
		}

	});

	/**
	* 4 - Marketplace Filter and Search functions
	*/
	$(document).on( 'click', '#layers-marketplace-clear-search', function(e){
		e.preventDefault();

		$( '#layers-marketplace #layers-marketplace-search' ).val('').trigger( 'change' );
		$( '#layers-marketplace #layers-marketplace-authors' ).val('').trigger( 'change' );

	} );

	$(document).on( 'change', '#layers-marketplace-sortby', function(e){
		e.preventDefault();
		marketplace_sort();
	});
	marketplace_sort();

	function marketplace_sort(){
		// If this is the first time the page is loading fade in the products
		$( '.layers-marketplace-loading' ).fadeOut( 350 );

		setTimeout(function(){
			$( '.layers-products.layers-hide' ).hide().removeClass( 'layers-hide' ).fadeIn( 350 );
			$( '.layers-marketplace-intro.layers-hide' ).hide().removeClass( 'layers-hide' ).fadeIn( 350 );
			marketplace_resize();
		}, 350 );

		var $products = $( 'div.layers-products' ),
		$productsli = $products.children( 'div.layers-product' ),
		$search_type = $( '#layers-marketplace-sortby' ).val().split('-');

		$( '#intro-sort' ).text( $( '#layers-marketplace-sortby option:selected').data( 'excerpt-label' ) );

		if( '' == $search_type ){
			$productsli.sort();
		} else {
			$productsli.sort(function(a,b){
				var an = a.getAttribute( 'data-' + $search_type[0] ),
					bn = b.getAttribute( 'data-' + $search_type[0] );

				if( 'sales' == $search_type[0] || 'price' == $search_type[0] ){
					an = +an;
					bn = +bn;
				}

				if( 'asc' ==  $search_type[1] ){
					if(an > bn) {
						return 1;
					}
					if(an < bn) {
						return -1;
					}
				} else {
					if(an < bn) {
						return 1;
					}
					if(an > bn) {
						return -1;
					}
				}
				return 0;
			});

			$productsli.detach().appendTo($products);
		}
	}

	$(document).on( 'keyup mouseup change', '#layers-marketplace #layers-marketplace-search, #layers-marketplace #layers-marketplace-authors', function(e){
		e.preventDefault();

		$search_val = $( '#layers-marketplace #layers-marketplace-search' ).val().toLowerCase();
		$author_val = $( '#layers-marketplace #layers-marketplace-authors' ).val().toLowerCase();
		$rating_val = $( '#layers-marketplace #layers-marketplace-ratings').val();


		if( '' !== $author_val ){
			$( '#intro-author' ).text( ' created by ' + $( '#layers-marketplace-authors option:selected').text() );
		}

		$valid_products = new Array();
		$invalid_products = new Array();

		$( '.layers-product' ).each(function(){

			// Start with a valid product
			var $valid = true;

			// Decode the JSON
			var $json_string = $(this).find('.layers-product-json').val().toLowerCase();
			var $json_decoded = $.parseJSON( $json_string );

			// Set the Product ID
			var $product_id = '#' + $(this).attr( 'id' );

			// Check the Search Box
			if( '' !== $search_val && -1 == $json_string.indexOf( $search_val ) ) {
				$valid = false;
			}

			// Check the Rating
			if( '' !== $rating_val && $rating_val > $json_decoded.rating.rating ){
				$valid = false;
			}

			// Check the Author
			if( '' !== $author_val && $author_val !== $json_decoded.author_username ){
				$valid = false;
			}

			// If valid is still true, add this product to the valid_products array

			if( true == $valid ){
				$valid_products.push( $product_id );
			} else {
				$invalid_products.push( $product_id );
			}
		});

		// Do something about the information we've got
		if( 0 == $valid_products.length && $( '#layers-marketplace-empty-search' ).hasClass( 'layers-hide' ) ){
			$( '#layers-marketplace-empty-search' ).hide().removeClass( 'layers-hide' ).fadeIn( 750 );
		} else if( 0 < $valid_products.length ) {
			$( '#layers-marketplace-empty-search' ).addClass( 'layers-hide' );
		}

		$( $valid_products.join(", ") ).removeClass( 'layers-hide' );
		$( $invalid_products.join(", ") ).addClass( 'layers-hide' );
	});

	/**
	* 5 - Marketplace Filter and Search functions
	*/

	$(window).bind( 'resize', function(){
		marketplace_resize();
	});

	function  marketplace_resize(){

		var max_height = 0;
		var max_img_height = 0;

		$( '.layers-product' ).each(function(){

			if( 0 < $(this).find( 'img' ).length && max_img_height < $(this).find( 'img' ).outerHeight() ){
				max_img_height = $(this).find( 'img' ).outerHeight();
			}
		});

		$( '.layers-product .layers-product-screenshot' ).height( max_img_height );
	}

});