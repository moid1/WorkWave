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
    <div class="row justify-content-center">

        <div class="col-md-12">


            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('trailer.search.post') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Trailer No') }}</label>

                            <div class="col-md-6">
                                <input id="trailer_no" type="text" class="form-control" name="trailer_no" required
                                    autocomplete="name" autofocus>

                            </div>
                        </div>



                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="trailer-date">
                @if ($trailers)
                    <div>
                        <h4>Date: {{$trailers->created_at}}</h4>
                    </div>
                @endif
            </div>


            <div id="map"></div>
        </div>
    </div>
@endsection

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsXxGcLCW2GFr9a9rHU0FTo41Q-v-bZE&callback=initMap" async
    defer></script>

    <script>
        function initMap() {
            var trailer = @json($trailers) ?? [];
    
            if (trailer) {
                var myLatlng = new google.maps.LatLng(40.7128, -74.0060); // Example coordinates for New York City
    
                var myOptions = {
                    zoom: 12, // Adjust zoom level according to your needs
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.HYBRID,
                    mapTypeControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.DEFAULT,
                        position: google.maps.ControlPosition.TOP_RIGHT
                    }
                };
    
                var map = new google.maps.Map(document.getElementById('map'), myOptions);
                var blackBoxIcon = {
                    url: 'https://maps.google.com/mapfiles/dir_walk_36.png', // Ensure this URL is correct and accessible
                    scaledSize: new google.maps.Size(50, 50)
                };
    
                var geocoder = new google.maps.Geocoder();
                var bounds = new google.maps.LatLngBounds(); // Initialize bounds to contain all markers

                    if (!trailer.order || !trailer.order.customer || !trailer.order.customer.address) {
                        return; // Ensure trailer data is valid before geocoding
                    }
    
                    geocoder.geocode({
                        'address': trailer.order.customer.address
                    }, function(results, status) {
                        if (status === 'OK') {
                            var marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                                title: trailer ? trailer.trailer_drop_off : 'N/A',
                                icon: blackBoxIcon,
                                label: {
                                    text: trailer ? trailer.trailer_drop_off : 'N/A',
                                    color: 'white',
                                    fontWeight: 'normal',
                                }
                            });
                            bounds.extend(marker.getPosition()); // Extend bounds to include this marker
                    map.fitBounds(bounds); 
                        } else {
                            console.error('Geocode was not successful for the following reason: ' + status);
                        }
                    });
            }
        }
    </script>
    