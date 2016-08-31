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

		$( '.theme-overlay' ).fadeOut(250).addClass( 'l_admin-hide' );
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

	function layers_marketplace_hide_preview(){
		$( '.theme-preview iframe' ).remove();
		$( '.theme-preview' ).hide();
		$( '.theme-about' ).removeClass( 'l_admin-hide' ).show();

		$( '.theme-demo-link' ).text( $( '.theme-demo-link' ).data( 'show-preview-label' ) );
	}

	$(document).on( 'click', '#layers-marketplace [data-view-item^="product-details-"]', function(e){
		e.preventDefault();

		var $layers_a = $(this);

		$id = '#' + $layers_a.attr('data-view-item');

		var $my_data = $( $id ).find( 'input' ).val();

		var $json = '';
		$json = jQuery.parseJSON( $my_data );
		$modal = $( '.theme-overlay' );

		/**
		* Product Screenshot
		*/
		$screenshot = $( $id ).find( '.l_admin-product-screenshot' ).html();
		$modal.find( '.theme-screenshots' ).html( $( $screenshot ).removeAttr( 'width') );

		/**
		* Product Details
		*/
		$modal.find( '.theme-name' ).text( $json.name );

		/**
		* Product Meta
		*/
		$price = $json.price;
		$modal.find( '.theme-author-img' ).attr( 'src' , $json.author_image );
		$modal.find( '.theme-author' ).attr( 'href' , $json.author_url )
		$modal.find( '.theme-author' ).text( 'By ' + $json.author );
		$sales_word = ( $json.sales == 1 ? ' sale' : ' sales' );
		$modal.find( '.theme-sales' ).html( $json.sales + $sales_word).show();
		if( 0 == $json.sales ) $modal.find( '.theme-sales' ).hide();

		/**
		* Product Preview
		*/

		layers_marketplace_hide_preview();

		$( '.theme-demo-link' ).attr( 'data-allow-demo', $json.allow_demo );
		$( '.theme-demo-link' ).attr( 'data-demo-url', $json.demo_url );

		/**
		* Product Links
		*/
		var $url = $( $id ).data( 'url' );

		$modal.find( '.theme-details-link' ).attr( 'href' , $url );
		if( '' == $json.demo_url ){
			$modal.find( '.theme-demo-link' ).hide();
		} else {
			$modal.find( '.theme-demo-link' ).show().attr( 'href' , $json.demo_url + '&type=demo&slug=' + $( $id ).data( 'slug' ) );
		}
		$modal.find( '.theme-buy-link' ).attr( 'href' , $url + "&type=purchase" );
		$modal.find( '.theme-details-link, .theme-demo-link, .theme-buy-link' ).attr( 'data-item', $json.name ).attr( 'data-price', '$ ' + $price );


		/**
		* Product Description & Summary
		*/
		var decoded_description = $("<div/>").html( $json.description ).text();
		$modal.find( '.theme-description' ).html( decoded_description + ' <a href="' + $url + '" target="_blank">Read More</a>' );
		$modal.find( '.theme-price' ).text( '$' + $price );
		$modal.find( '.theme-tags' ).text( $json.summary );

		/**
		* Next / Previous buttons
		*/
		if( 1 > $( $id ).prev( 'div.l_admin-product' ).length ){
			$prev = $('.l_admin-products .l_admin-product').eq( $('.l_admin-products .l_admin-product').length - 1 ).attr( 'id' );
		} else {
			$prev = $( $id ).prev().attr( 'id' );
		}
		$modal.find( '.left' ).attr( 'data-view-item' , $prev );

		if( 1 > $( $id ).next( 'div.l_admin-product' ).length ){
			$next = $('.l_admin-products .l_admin-product').eq(0).attr( 'id' );
		} else {
			$next = $( $id ).next().attr( 'id' );
		}
		$modal.find( '.right' ).attr( 'data-view-item' , $next );

		/**
		* Rating
		*/
		$modal.find( '.theme-rating' ).html('');

		if( 3 > $json.rating_count ){
			$modal.find( '.theme-rating' ).hide();
		} else {
			$modal.find( '.theme-rating' ).show();
			for( i = 1; i < 6; i++ ){
				if( i <= Math.round( $json.rating ) ){
					$star_class = 'star star-full';
				} else {
					$star_class = 'star star-empty';
				}

				$modal.find( '.theme-rating' ).append( $('<span class="' + $star_class + '" />') );
			}
		}

		if( $( '.theme-overlay' ).hasClass( 'l_admin-hide' ) ){
			$( '.theme-overlay' ).hide().removeClass( 'l_admin-hide' ).fadeIn(250);
		}

	});

	$(document).on( 'click', '.theme-demo-link', function(e){

		var $demo_url = $(this).attr( 'data-demo-url' );
		var $allow_demo = $(this).attr( 'data-allow-demo' );

		if( 'true' == $allow_demo ) e.preventDefault();

		if( 'true' == $allow_demo && '' !== $demo_url && 0 == $( '.theme-preview iframe' ).length ){

			$iframe = $( '<iframe />' ).attr( 'src', $demo_url );
			$iframe.attr( 'height', $( '.theme-preview' ).outerHeight() );

			$( '.theme-preview' ).html( $iframe ).removeClass( 'l_admin-hide' ).show();

			$( '.theme-about' ).addClass( 'l_admin-hide' ).hide();

			$(this).text( $(this).data( 'hide-preview-label' ) );
		} else {
			layers_marketplace_hide_preview()
		}

	});
	/**
	* 4 - Marketplace Filter and Search functions
	*/

	$(document).on( 'click', '#layers-marketplace-categories-clear, #layers-marketplace-tags-clear', function(e){

		e.preventDefault();

		$(this).addClass( 'l_admin-hide' );

		$cats = $( '#layers-marketplace input[name="layers-marketplace-categories"]:checked' );
		$tags = $( '#layers-marketplace input[name="layers-marketplace-tags"]:checked' );

		if( 'categories' == $(this).data( 'type' ) ){
			$cats.prop( 'checked', false );
		}

		if( 'tags' == $(this).data( 'type' ) ){
			$tags.prop( 'checked', false );
		}

		marketplace_filter();
	});

	$(document).on( 'click', '#layers-marketplace-clear-search', function(e){
		e.preventDefault();

		$( '#layers-marketplace #layers-marketplace-search' ).val('');
		$( '#layers-marketplace #layers-marketplace-authors' ).val('');

		marketplace_filter();
	} );

	$(document).on( 'change', '#layers-marketplace-sortby', function(e){
		e.preventDefault();
		marketplace_sort();
	});
	marketplace_sort();

	function marketplace_sort(){

		if( $( 'div.l_admin-products' ).count == 0 ) return;

		// If this is the first time the page is loading fade in the products
		$( '.l_admin-marketplace-loading' ).fadeOut( 350 );

		setTimeout(function(){
			$( '.l_admin-products.l_admin-hide' ).hide().removeClass( 'l_admin-hide' ).fadeIn( 350 );
			$( '#layers-marketplace-sort.l_admin-hide' ).hide().removeClass( 'l_admin-hide' ).fadeIn( 350 );
			$( '.l_admin-marketplace-intro.l_admin-hide' ).hide().removeClass( 'l_admin-hide' ).fadeIn( 350 );
			marketplace_resize();
		}, 350 );

		var $products = $( 'div.l_admin-products' ),
		$productsli = $products.children( 'div.l_admin-product' ),
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

	$(document).on( 'keyup mouseup change', '#layers-marketplace #layers-marketplace-search, #layers-marketplace #layers-marketplace-authors, #layers-marketplace input[name="layers-marketplace-categories"], #layers-marketplace input[name="layers-marketplace-tags"]', function(e){

		e.preventDefault();

		marketplace_filter();
	});

	function marketplace_filter(){

		$search_val = $( '#layers-marketplace #layers-marketplace-search' ).val().toLowerCase();
		$author_val = $( '#layers-marketplace #layers-marketplace-authors' ).val().toLowerCase();
		$rating_val = $( '#layers-marketplace #layers-marketplace-ratings').val();

		$cats = $( '#layers-marketplace input[name="layers-marketplace-categories"]:checked' );
		$tags = $( '#layers-marketplace input[name="layers-marketplace-tags"]:checked' );


		if( '' !== $author_val ){
			$( '#intro-author' ).text( ' created by ' + $( '#layers-marketplace-authors option:selected').text() );
		}

		$valid_products = new Array();
		$invalid_products = new Array();

		$( '.l_admin-product' ).each(function(){

			var $li = $(this);

			// Start with a valid product
			var $valid = true;
			var $cats_valid = false;
			var $tags_valid = false;

			// Decode the JSON
			var $json_string = $(this).find('.l_admin-product-json').val().toLowerCase();
			var $json_decoded = $.parseJSON( $json_string );

			// Set the Product ID
			var $product_id = '#' + $(this).attr( 'id' );

			if( '' == $search_val && '' == $author_val && '' == $rating_val && 0 == $cats.count && 0 == $tags )// Check the Categories
				$valid = true;

			if( 0 == $cats.length ) {
				$cats_valid = true;
				$( '#layers-marketplace-categories-clear' ).addClass( 'l_admin-hide' );
			} else {
				$( '#layers-marketplace-categories-clear' ).removeClass( 'l_admin-hide' );

				$cats.each(function( c_key, c_val ){
					c_val_string = $( c_val ).val();

					if( -1 < $li.data( 'categories' ).toString().indexOf( c_val_string ) )
						$cats_valid = true;
				})
			}

			// Check the Tags
			if( 0 == $tags.length ) {
				$tags_valid = true;
				$( '#layers-marketplace-tags-clear' ).addClass( 'l_admin-hide' );
			} else {
				$( '#layers-marketplace-tags-clear' ).removeClass( 'l_admin-hide' );

				$tags.each(function( t_key, t_val ){
					t_val_string = $( t_val ).val();

					if( -1 < $li.data( 'tags' ).toString().indexOf( t_val_string ) )
						$tags_valid = true;
				})
			}

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
				console.log( "Author not found" );
				$valid = false;
			}

			// If valid is still true, add this product to the valid_products array

			if( true == $valid && true == $cats_valid && true == $tags_valid ){
				$valid_products.push( $product_id );
			} else {
				$invalid_products.push( $product_id );
			}
		});

		// Do something about the information we've got
		if( 0 == $valid_products.length && $( '#layers-marketplace-empty-search' ).hasClass( 'l_admin-hide' ) ){
			$( '#layers-marketplace-empty-search' ).hide().removeClass( 'l_admin-hide' ).fadeIn( 750 );
		} else if( 0 < $valid_products.length ) {
			$( '#layers-marketplace-empty-search' ).addClass( 'l_admin-hide' );
		}

		$( $valid_products.join(", ") ).removeClass( 'l_admin-hide' );
		$( $invalid_products.join(", ") ).addClass( 'l_admin-hide' );
	}
});