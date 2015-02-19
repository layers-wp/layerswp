/**
* Map Widget JS file
 *
 * Author: Obox Themes
 * Author URI: http://www.oboxthemes.com/
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
var geocoder;
var map;

jQuery(document).ready(function($){
	geocoder = new google.maps.Geocoder();

	$(document).on( 'click' , '.layers-check-address' , function(e){
		e.preventDefault();
		$map = $(this).closest( '.layers-map' );
		$address = $(this).closest( '.layers-content' ).find('input[id$="google_maps_location"]').val();
		$longlat = $(this).closest( '.layers-content' ).find('input[id$="google_maps_long_lat"]').val();
		$map.data( 'location' , $address.toString() );
		$map.data( 'longlat' , $longlat.toString() );
		layers_check_address($);
	});
	layers_check_address($);
})

function layers_check_address($){
	jQuery('.layers-map').each(function(){
		//"Hi Mom"
		$that = $(this);

		$longlat = ( undefined !== $that.data( 'longlat' ) ) ? $that.data( 'longlat' ) : null;

		if( null !== $longlat ){
			$longlat = $longlat.split(",");
			var latitude = $longlat[0];
			var longitude = $longlat[1];
		} else {
			var latitude = "-34.397";
			var longitude = "150.644";
		}

		var latlng = new google.maps.LatLng( latitude, longitude );

		$map = new google.maps.Map( $that[0] ,
			{
				scrollwheel: false,
				zoom: 10,
  				center: latlng,
  				mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		);

		$location = ( undefined !== $that.data( 'location' ) ) ? $that.data( 'location' ) : null ;

		if( null !== $location ){
			geocoder.geocode( { 'address': $location},
				function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {

						// Center the map
						$map.setCenter(results[0].geometry.location);

						// Add the map marker
						var marker = new google.maps.Marker({
							map: $map,
							position: results[0].geometry.location
						});
					}
				});
		}

	})

}