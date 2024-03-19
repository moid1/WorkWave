@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyATph3BCKxFTZucYVofwV2tuUIB-YXqHFg"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

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
            <label for="">Select Driver</label>
            <select id="driverID" name="" id="" class="js-example-basic-multiple form-control form-select  mb-3">
                @foreach ($drivers as $driver)
                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex mt-3 justify-content-between">
            <div style="">
                <strong>Date Filter:</strong>
                <input type="text" name="daterange" value="" />
                <button class="btn btn-success filter">Filter</button>
            </div>
            <div id="generateRoutes" class="btn btn-primary ">Generate Routes</div>
        </div>

    </div>


    <div class="col-lg-5">
        <div id="mymap"></div>
    </div>
</div>
@endsection

@section('pageSpecificJs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
    var latlngs = [];
    $(function() {
            var startDate = localStorage.getItem('startDate');
            var endDate = localStorage.getItem('endDate');
            if (startDate && endDate) {
                startDate = new Date(startDate);
                endDate = new Date(endDate);

                $('input[name="daterange"]').daterangepicker({
                    startDate: startDate,
                    endDate: endDate
                });
            } else {
                $('input[name="daterange"]').daterangepicker({
                    startDate: moment().subtract(1, 'M'),
                    endDate: moment()
                });
            }



            $(".filter").click(function() {
                localStorage.setItem('startDate', $('input[name="daterange"]').data('daterangepicker')
                    .startDate);

                localStorage.setItem('endDate', $('input[name="daterange"]').data('daterangepicker')
                    .endDate);

                table.draw();
            });

        });

        function geocodeAddress(response, address, index) {
    // Geocoder object
    var geocoder = new google.maps.Geocoder();

    // Geocode request
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            if (results.length > 0) {
                var location = results[0].geometry.location;
                console.log('Latitude: ' + location.lat());
                console.log('Longitude: ' + location.lng());
                latlngs.push({lat:location.lat(), lng:location.lng()})

                if (latlngs.length === response.length) {
                    // All geocoding requests are completed, create and add the polyline
                  
                }

                 var markerLabel = {
                color: 'white',
                fontFamily: 'Arial, sans-serif',
                fontSize: '12px',
                fontWeight: 'bold',
                text: '' + (index + 1)
            };
            mymap.addMarker({
                lat: location.lat(),
                lng: location.lng(),
                icon: {
                    labelOrigin: new google.maps.Point(16, 16) // Adjust label position
                },
                label: markerLabel
            });
            } else {
                console.log('No results found');
            }
        } else {
            console.log('Geocode was not successful for the following reason: ' + status);
        }
    });
}


        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            let startDate = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
            let endDate = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
            $('#generateRoutes').on('click', function(){
               let driverId = $('#driverID').val();
               $.ajax({
                url:'/get-driver-orders-routing',
                type:'GET',
                data:{'driver_id':driverId, from_date:startDate, to_date:endDate},
                success:function (response) {
                    response.forEach(function(order, index) {
                        // Do something with each item in the array
                        geocodeAddress(response,order.customer.mail_address, index);
                    });

                    //////////

                    var waypoints = []; // Array to store waypoints for the route

                    response.forEach(function(order, index) {
                        // Do something with each item in the array
                        waypoints.push({
                            location: order.customer.mail_address,
                            stopover: true
                        });
                    });

    // Define the directions request
    var directionsRequest = {
        origin: waypoints[0].location,
        destination: waypoints[waypoints.length - 1].location,
        waypoints: waypoints.slice(1, waypoints.length - 1),
        travelMode: 'driving' // Assuming you want to draw driving routes
    };

    // Send the directions request
    mymap.getRoutes({
        origin: directionsRequest.origin,
        destination: directionsRequest.destination,
        waypoints: directionsRequest.waypoints,
        travelMode: directionsRequest.travelMode,
        callback: function(routes) {
            if (routes.length > 0) {
                // Draw the route on the map
                mymap.drawRoute({
                    origin: directionsRequest.origin,
                    destination: directionsRequest.destination,
                    waypoints: directionsRequest.waypoints,
                    travelMode: directionsRequest.travelMode,
                    routes: routes
                });
            } else {
                console.error('No routes found.');
            }
        }
    });

                    
                   
                }
            })
            });
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