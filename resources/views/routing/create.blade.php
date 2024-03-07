@extends('layouts.app')
<script src="http://maps.google.com/maps/api/js?key=AIzaSyATph3BCKxFTZucYVofwV2tuUIB-YXqHFg"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
    #mymap {
        width: 100%;
        height: 500px;
    }
</style>
@section('content')
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
        </div>

        <div class="col-lg-7">
            <div class="select-driver">
                <select name="" id="" class="js-example-basic-multiple form-control form-select  mb-3">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>

                </select>
            </div>
        </div>


        <div class="col-lg-5">
            <div id="mymap"></div>
        </div>
    </div>
@endsection

@section('pageSpecificJs')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
        var mymap = new GMaps({
            el: '#mymap',
            lat: 30.749860,
            lng: -98.180590,
            zoom: 6,
            mapType: 'satellite' // Set the map type to satellite

        });

        var markersData = [{
            lat: 30.749860,
            lng: -98.180590,
            label: '0'
        }];

        // Add markers to the map
        markersData.forEach(function(marker) {
            var markerLabel = {
                color: 'white',
                fontFamily: 'Arial, sans-serif',
                fontSize: '12px',
                fontWeight: 'bold',
                text: marker.label
            };
            mymap.addMarker({
                lat: marker.lat,
                lng: marker.lng,
                icon: {
                    labelOrigin: new google.maps.Point(16, 16) // Adjust label position
                },
                label: markerLabel
            });
        });

        mymap.fitZoom();
    </script>
@endsection
