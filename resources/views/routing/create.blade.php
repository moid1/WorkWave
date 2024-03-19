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
                <select id="driverID" name="" id=""
                    class="js-example-basic-multiple form-control form-select  mb-3">
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

            <div class="row mt-5">
                <div class="col-lg-12" id="orderDetailDiv">

                </div>
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

        function geocodeAddress(response, address, index, waypoints) {
            // Geocoder object
            var geocoder = new google.maps.Geocoder();

            // Geocode request
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results.length > 0) {

                        $('#orderDetailDiv').append(`
                        <div class="row">
                        <div class="col-lg-3">
                            <p class="border p-2">Business Name = ${response[index].customer.business_name}<p>
                        </div>
                        <div class="col-lg-3">
                            <p class="border p-2 ml-3">Order ID = 000${response[index].id}<p>
                        </div>

                    </div>
                        `)
                        var location = results[0].geometry.location;
                        console.log('Latitude: ' + location.lat());
                        console.log('Longitude: ' + location.lng());
                        var tempLatLng = new google.maps.LatLng(location.lat(), location.lng());

                        latlngs.push({
                            lat: location.lat(),
                            lng: location.lng()
                        })

                        waypoints.push({
                            location: {
                                lat: location.lat(),
                                lng: location.lng()
                            }
                        })

                        if (latlngs.length === response.length) {

                            var directionsService = new google.maps.DirectionsService();
                            var directionsRenderer = new google.maps.DirectionsRenderer({
                                map: mymap
                            });


                            var request = {
                                origin: waypoints[0].location,
                                destination: waypoints[waypoints.length - 1].location,
                                waypoints: waypoints.slice(1, -1),
                                travelMode: 'DRIVING'
                            };

                            directionsService.route(request, function(response, status) {
                                if (status == 'OK') {
                                    console.log(response);
                                    directionsRenderer.setDirections(response);
                                } else {
                                    window.alert('Directions request failed due to ' + status);
                                }
                            });

                        }

                        var markerLabel = {
                            color: 'white',
                            fontFamily: 'Arial, sans-serif',
                            fontSize: '12px',
                            fontWeight: 'bold',
                            text: '' + (index + 1)
                        };


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
            $('#generateRoutes').on('click', function() {
                let driverId = $('#driverID').val();
                $.ajax({
                    url: '/get-driver-orders-routing',
                    type: 'GET',
                    data: {
                        'driver_id': driverId,
                        from_date: startDate,
                        to_date: endDate
                    },
                    success: function(response) {
                        var waypoints = [{
                            location: {
                                lat: 30.749860,
                                lng: -98.180590
                            }
                        }];

                        response.forEach(function(order, index) {
                            // Do something with each item in the array
                            geocodeAddress(response, order.customer.mail_address,
                                index, waypoints);
                        });
                    }
                })
            });
        });

        var myLatlng = new google.maps.LatLng(30.749860, -98.180590);
        var myOptions = {
            zoom: 20,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        }
        var mymap = new google.maps.Map(document.getElementById("mymap"), myOptions);
    </script>
@endsection
