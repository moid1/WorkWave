@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maps.google.com/maps/api/js?key=AIzaSyAXsXxGcLCW2GFr9a9rHU0FTo41Q-v-bZE"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsXxGcLCW2GFr9a9rHU0FTo41Q-v-bZE&libraries=geometry">
</script>

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

    .cross {
        cursor: pointer;
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
                <label for="">Select Truck</label>
                <select id="driverID" name="" id=""
                    class="js-example-basic-multiple form-control form-select  mb-3">
                    @foreach ($trucks as $truck)
                        <option value="{{ $truck->id }}">{{ $truck->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex mt-3 justify-content-between">
                <div style="">
                    <strong>Date Filter:</strong>
                    <input type="text" name="daterange" value="" />
                </div>
                <div id="generateRoutes" class="btn btn-primary ">Generate Routes</div>
            </div>
            <hr>
            <div class="col-6 mt-3">
                <label for="route_name">Please enter the route name</label>
                <input type="text" name="route_name" id="routeName" class="form-control">
            </div>
            <div class="row mt-5">
                <h4> Route Details </h4>
                <div class="col-lg-12 mt-3" id="orderDetailDiv">
                </div>
            </div>

            <div class="row w-100 text-center justify-content-center mt-5">
                <button id="createRoute" class="btn btn-primary d-none">Create Route</button>
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

        var actualResponse = null;
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


        });

        function getDistance(point1, point2) {
            var lat1 = point1.lat;
            var lon1 = point1.lng;
            var lat2 = point2.lat;
            var lon2 = point2.lng;

            var R = 6371; // Radius of the Earth in km
            var dLat = (lat2 - lat1) * Math.PI / 180; // Convert degrees to radians
            var dLon = (lon2 - lon1) * Math.PI / 180; // Convert degrees to radians
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c; // Distance in km
            return distance;
        }

        function geocodeAddress(response, address, index, waypoints, order) {
            // Geocoder object
            var geocoder = new google.maps.Geocoder();

            // Geocode request
            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results.length > 0) {


                        var location = results[0].geometry.location;
                        var tempLatLng = new google.maps.LatLng(location.lat(), location.lng());

                        latlngs.push({
                            lat: location.lat(),
                            lng: location.lng()
                        })

                        waypoints.push({
                            location: {
                                lat: location.lat(),
                                lng: location.lng()
                            },
                            order_id: order.id
                        })

                        if (Object.keys(response).length === latlngs.length) {




                            // Calculate distances of each waypoint from the origin
                            var distances = waypoints.slice(1).map(function(waypoint) {
                                return getDistance(waypoints[0].location, waypoint.location);
                            });

                            // Create an array of indices and sort it based on distances
                            var sortedIndices = Array.from(Array(waypoints.length - 1)
                                .keys()); // Exclude the first waypoint
                            
                            sortedIndices.sort(function(a, b) {
                                return distances[b] - distances[
                                    a]; // Sort from longest to shortest distance
                            });

                            console.log(sortedIndices);

                            // Reorder waypoints based on sorted indices
                            var sortedWaypoints = [waypoints[0]]; // Keep the first waypoint unchanged
                            sortedIndices.forEach(function(index) {
                                sortedWaypoints.push({'location':waypoints[index + 1].location});
                            });

                            console.log('SORTED', sortedWaypoints)
                            // 30.749860
                            // Construct the request object
                            var request = {
                                origin: sortedWaypoints[0].location,
                                destination: {
                                    location: {
                                        lat: 30.749760,
                                        lng: -98.180590
                                    }
                                },
                                waypoints: sortedWaypoints.slice(1),
                                travelMode: 'DRIVING'
                            };
                            $('#orderDetailDiv').append(
                                `<div class="mb-3">Starting Route: Reliable Tire Disposal</div>`)
                                sortedIndices.forEach(function(key, index) {
                                var order = response[key];
                                var alphabet = String.fromCharCode(65 + index); // 'A' has ASCII code 65

                                $('#orderDetailDiv').append(`
        <div class="row">
            <div class="col-lg-2">
                <p class="border p-2">${order.customer.business_name}</p>
            </div>
            <div class="col-lg-3">
                <p class="border p-2 ml-3">000${order.id}</p>
            </div>
            <div class="col-lg-3">
                <p class="border p-2 ml-3">${order.load_type}</p>
            </div>
            <div class="col-lg-3">
                <a target="_blank" href="order/${order.id}"><span><i class="fa fa-eye ml-3"></i></span></a> |
                <span class="removeOrder mt-2" data-orderid="${order.id}"><span class="text-primary cross"><i class="mdi mdi-delete "></i></span></span>
            </div>
            <div class="col-lg-2 d-none">
                <input type="number" min="1" max="${Object.keys(response).length}" value="${index + 1}" class="form-control changeOrdering" />
            </div>
        </div>
    `);
                            });


                            $('#orderDetailDiv').append(`<div>End Route: Reliable Tire Disposal</div>`)

                            $('.removeOrder').on('click', function() {
                                // Retrieve the removeOrderID
                                let removeOrderID = parseInt($(this).attr('data-orderid'));
                                console.log(removeOrderID);

                                // Filter out the object with the specified ID
                                // Convert the object to an array of its values
                                const actualResponseArray = Object.values(actualResponse);

                                // Remove the item with the specified id
                                const filteredArray = actualResponseArray.filter(obj => obj.id !==
                                    removeOrderID);

                                // Convert the filtered array back to an object if necessary
                                const filteredObject = Object.fromEntries(filteredArray.map(obj => [obj.id,
                                    obj
                                ]));

                                // Update the actualResponse object
                                actualResponse = filteredObject;
                                // Clear existing markers and directions
                                clearWaypoints(directionsRenderer);

                                // Empty the order details container
                                $('#orderDetailDiv').empty();

                                // Generate waypoints and directions for the updated response
                                generateWayPoints(actualResponse);
                            });

                            $('.changeOrdering').on('change', function() {
                                clearWaypoints(directionsRenderer);

                                // Empty the order details container
                                $('#orderDetailDiv').empty();

                                // Generate waypoints and directions for the updated response
                                generateWayPoints(actualResponse);
                            })


                            directionsService.route(request, function(response, status) {
                                if (status == 'OK') {
                                    console.log(response);
                                    directionsRenderer.setDirections(response);

                                    // var route = response.routes[0];
                                    // var legs = route.legs;
                                    // for (var i = 0; i < legs.length; i++) {
                                    //     var markerLabel = (i + 1).toString(); // Using numbers as labels
                                    //     var markerIcon = {
                                    //         url: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=' +
                                    //             markerLabel + '|FF0000|000000',
                                    //         labelOrigin: new google.maps.Point(11,
                                    //             50) // Position of the label
                                    //     };
                                    //     var marker = new google.maps.Marker({
                                    //         position: legs[i].start_location,
                                    //         map: mymap, // Assuming 'map' is your Google Maps instance
                                    //         label: {
                                    //             text: markerLabel,
                                    //             color: 'white'
                                    //         },
                                    //         icon: markerIcon
                                    //     });
                                    // }

                                    $('#createRoute').removeClass('d-none');


                                    $('#createRoute').removeClass('d-none')
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

                localStorage.setItem('startDate', $('input[name="daterange"]').data('daterangepicker')
                    .startDate);

                localStorage.setItem('endDate', $('input[name="daterange"]').data('daterangepicker')
                    .endDate);


                $('#orderDetailDiv').empty()
                let driverId = $('#driverID').val();
                $.ajax({
                    url: '/get-driver-orders-routing',
                    type: 'GET',
                    data: {
                        'truck_id': driverId,
                        from_date: startDate,
                        to_date: endDate
                    },
                    success: function(response) {
                        if (response.length == 0) {
                            alert('No Order Found for this driver');
                            location.reload()
                        }
                        actualResponse = response;
                        generateWayPoints(response);

                    }
                })
            });

            $('#createRoute').on('click', function() {
                var orderIds = "";

                $('.removeOrder').each(function(index) {
                    // Extract the value of the data-orderid attribute
                    var orderId = $(this).data('orderid');

                    // Add the order ID to the string, followed by a comma
                    orderIds += orderId;

                    // Add a comma if it's not the last element
                    if (index < $('.removeOrder').length - 1) {
                        orderIds += ",";
                    }
                });
                console.log(orderIds)
                let driverId = $('#driverID').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/create-routing-web',
                    type: 'POST',
                    data: {
                        driver_id: driverId,
                        order_ids: orderIds,
                        route_name: $('#routeName').val()
                    },
                    success: function(response) {

                        location.reload()

                    }
                })


            })
        });

        var myLatlng = new google.maps.LatLng(30.749860, -98.180590);
        var myOptions = {
            zoom: 20,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.HYBRID,
            mapTypeControl: true,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.HYBRID],
                style: google.maps.MapTypeControlStyle.DEFAULT,
                position: google.maps.ControlPosition.TOP_RIGHT
            }
        }
        var mymap = new google.maps.Map(document.getElementById("mymap"), myOptions);
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer({
            map: mymap,

        });

        function generateWayPoints(response) {
            latlngs = [];
            var waypoints = [{
                location: {
                    lat: 30.749860,
                    lng: -98.180590
                }
            }];

            Object.values(response).forEach(function(order, index) {
                // Do something with each item in the object
                console.log('index', index);
                geocodeAddress(response, order.customer.address, index, waypoints, order);
            });
        }

        function clearWaypoints(directionsRenderer) {
            directionsRenderer.setOptions({
                markers: []
            });

        }
    </script>
@endsection
