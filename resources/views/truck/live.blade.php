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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATph3BCKxFTZucYVofwV2tuUIB-YXqHFg&callback=initMap" async
    defer></script>

@section('pageSpecificJs')
    <script>
        function initMap() {
            var locations = @json($latestLocations);
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
            }
        }
    </script>

    </script>
@endsection
