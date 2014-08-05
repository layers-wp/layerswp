var geocoder;
var map;

jQuery(document).ready(function($){
	geocoder = new google.maps.Geocoder();

	$(document).on( 'click' , '.hatch-check-address' , function(e){
		e.preventDefault();
		$map = $(this).closest( '.hatch-map' );
		$address = $(this).closest( '.hatch-content' ).find('input[id$="google_maps_location"]').val();
		$longlat = $(this).closest( '.hatch-content' ).find('input[id$="google_maps_long_lat"]').val();
		$map.data( 'location' , $address.toString() );
		$map.data( 'longlat' , $longlat.toString() );
		console.log( $map.data( 'location' ) );
		hatch_check_address($);
	});
	hatch_check_address($);
})

function hatch_check_address($){
	jQuery('.hatch-map').each(function(){
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