@extends('layouts.app')

@section('content')
   <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>


    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h1>Truck: {{ $truckName }}</h1>
                                <div id="map"></div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>
@endsection

@section('pageSpecificJs')
     <script>
        function initMap() {
            var location = { lat: {{ $location['lat'] }}, lng: {{ $location['lng'] }} };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: location
            });
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                title: 'Truck Location'
            });
        }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initMap">
    </script>
@endsection
