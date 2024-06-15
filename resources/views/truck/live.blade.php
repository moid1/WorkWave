@extends('layouts.app')
<style type="text/css">
    #map {
        width: 100%;
        height: 1500px;
    }

    .cross {
        cursor: pointer;
    }
</style>
@section('content')
    {{-- latestLocations --}}
    <div class="row justify-content-center">

        <div class="col-md-12">

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    {{ Session::get('success') }}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    {{ Session::get('error') }}
                </div>
            @endif
            <div id="map"></div>

        </div>
    </div>
@endsection
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsXxGcLCW2GFr9a9rHU0FTo41Q-v-bZE&callback=initMap" async
    defer></script>

@section('pageSpecificJs')
    <script>
        var trailerCoordinates = {
    Burnet: { lat: 30.75042397995036, lng: -98.18061549016744 },
    Victoria: { lat: 28.8053, lng: -97.0036 },
    Robstown: { lat: 27.7909, lng: -97.6689 },
    Cemex: { lat: 27.7975, lng: -97.6689 }
};
        function initMap() {
            var locations = @json($latestLocations);
            var trailers = @json($trailers);
            console.log(trailers);
            if (locations.length) {
                var myLatlng = new google.maps.LatLng(locations[0].users_lat, locations[0].users_long);
                var myOptions = {
                    zoom: 20,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.HYBRID,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DEFAULT,
                        position: google.maps.ControlPosition.TOP_RIGHT
                    }
                }


                var map = new google.maps.Map(document.getElementById('map'), myOptions);

                var truckIcon = {
                    url: 'https://maps.google.com/mapfiles/ms/icons/truck.png', // URL to the truck icon image
                    scaledSize: new google.maps.Size(50, 50), // Size of the icon
                };
                var blackBoxIcon = {
                    url: 'https://maps.google.com/mapfiles/dir_walk_36.png', // Black box icon URL
                    scaledSize: new google.maps.Size(50, 50)
                };

                locations.forEach(function(location) {
                    var marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(location.users_lat),
                            lng: parseFloat(location.users_long)
                        },
                        map: map,
                        icon: truckIcon,
                        label: {
                            text: location.name,
                            color: 'black', // Set the color of the text,
                            fontWeight: 'bold'

                        }
                    });
                });

                var geocoder = new google.maps.Geocoder();
                trailers.forEach(function(trailer) {
                    if (!trailer.trailer_swap_order || !trailer.trailer_swap_order.trailer_drop_off) {
    return;
}
                    geocoder.geocode({
                        'address': trailer.customer.address
                    }, function(results, status) {
                        if (status === 'OK') {
                            var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                                title: trailer.trailer_swap_order ? trailer.trailer_swap_order
                                    .trailer_drop_off : 'N/A',
                                icon: blackBoxIcon, // Use black box icon for trailers,
                                label: {
                                    text: trailer.trailer_swap_order ? trailer.trailer_swap_order
                                        .trailer_drop_off : 'N/A',
                                    color: 'white', // Set the color of the text,
                                    fontWeight: 'normal',

                                }

                            });
                            if (trailer.trailer_swap_order&& trailer.trailer_swap_order
                                        .trailer_pick_up && trailer.trailer_swap_order.trailer_going !== null && trailer.trailer_swap_order.trailer_going !== undefined && trailer.trailer_swap_order.trailer_going !== '' && trailerCoordinates.hasOwnProperty(trailer.trailer_swap_order.trailer_going)) {
                                var coordinates = trailerCoordinates[trailer.trailer_swap_order.trailer_going];
                                console.log('thids ', coordinates);

                                var markers = new google.maps.Marker({
                                    map: map,
                                    position: { lat: coordinates.lat, lng: coordinates.lng },
                                    title: trailer.trailer_swap_order ? trailer.trailer_swap_order
                                        .trailer_pick_up : 'N/A',
                                    icon: blackBoxIcon, // Use black box icon for trailers,
                                    label: {
                                        text: trailer.trailer_swap_order ? trailer
                                            .trailer_swap_order
                                            .trailer_pick_up : 'N/A',
                                        color: 'white', // Set the color of the text,
                                        fontWeight: 'normal',

                                    }

                                });
                            }
                        }
                    })

                });


            }
        }
    </script>

    </script>
@endsection
