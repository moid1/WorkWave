@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXsXxGcLCW2GFr9a9rHU0FTo41Q-v-bZE&libraries=geometry">
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.dataTables.css">

<style type="text/css">
    #mymap,
    #exceedingOrderMap {
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
                <select id="truck" name="" class="js-example-basic-multiple form-control form-select  mb-3">
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
            <div class="col-6 mt-3">
                <label for="route_name">Please enter the date</label>
                <input type="date" name="routing_date" id="routing_date" class="form-control">
            </div>
            <div class="row mt-5">
                <h4> Route Details </h4>
                <div class="col-lg-12 mt-3" id="orderDetailDiv">
                </div>
            </div>

            <div class="row w-100 text-center justify-content-center mt-5">
                <button id="createRoute" class="btn btn-primary d-none">Create Route</button>
            </div>


            <table id="example" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Order Type</th>
                        <th>Order ID</th>
                        <th>Estimated Tires</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>


            <div class="row w-100 text-center justify-content-center mt-5">
                <button id="generateSimpleRoutes" class="btn btn-primary">Generate Simple Route</button>
            </div>


        </div>


        <div class="col-lg-5">
            <div id="mymap"></div>
        </div>



    </div>

    {{-- <div class="row">
        <div class="col-lg-7">
            <h4>Exceeding Orders</h4>
            <table id="exceedingOrders" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Order Type</th>
                        <th>Order ID</th>
                        <th>Estimated Tires</th>
                    </tr>
                </thead>
            </table>
        </div>
     <div class="col-lg-5">
            <div id="exceedingOrderMap"></div>
        </div> 
    </div> --}}
@endsection
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.5.0/js/rowReorder.dataTables.js"></script>
@section('pageSpecificJs')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            $('.js-example-basic-multiple').select2();
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
    </script>
    <script type="text/javascript">
        var markers = [];
        var Exceedingmarkers = [];
        var estimatedTires = 0;
        let table = new DataTable('#example', {
            rowReorder: true,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'position'
                },
                {
                    data: 'order_id'
                },
                {
                    data: 'estimated_tires'
                },
                {
                    // Define the column for Actions
                    data: null,
                    defaultContent: '<button class="delete-btn btn btn-primary">Delete</button>'
                }
            ],
            rowReorder: {
                dataSrc: 'id'
            }
        });


        $('#example').on('click', '.delete-btn', function() {
            var data = table.row($(this).parents('tr')).data()

            var rowIndex = table.row($(this).parents('tr')).index();

            // Remove the row from the DataTable
            table.row(rowIndex).remove().draw();

        });

        // let exceedingOrdersTable = new DataTable('#exceedingOrders', {
        //     rowReorder: true, // Enable row reordering
        //     columns: [{
        //             data: 'id'
        //         },
        //         {
        //             data: 'name'
        //         },
        //         {
        //             data: 'position'
        //         },
        //         {
        //             data: 'order_id'
        //         },
        //         {
        //             data: 'estimated_tires'
        //         }
        //     ],
        //     rowReorder: {
        //         dataSrc: 'id'
        //     }
        // });

        var latlngs = [];
        var actualResponse = null;

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
        var totalTires = 400; // Maximum number of tires allowed
        var estimatedTires = 0; // Initialize counter for added tires
        function geocodeAddress(response, address, index, waypoints, order) {
            var geocoder = new google.maps.Geocoder();
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
                                return distances[b] - distances[a];
                            });
                            var sortedWaypoints = [waypoints[0]];
                            sortedIndices.forEach(function(index) {
                                sortedWaypoints.push({
                                    'location': waypoints[index + 1].location
                                });
                            });

                            $('#orderDetailDiv').append(
                                `<div class="mb-3">Starting Route: Reliable Tire Disposal</div>`)
                            table.clear().draw();
                            // exceedingOrdersTable.clear().draw();
                            sortedIndices.forEach(function(key, index) {
                                var order = response[key];
                                var newData = {
                                    "id": index + 1,
                                    "name": order.customer.business_name,
                                    "position": order.load_type,
                                    "order_id": `<a href="/order/${order.id}" target="_blank">${order.id}</a>`,
                                    "estimated_tires": order.estimated_tires
                                };

                                table.rows.add([newData]).draw();
                                estimatedTires += order.estimated_tires;

                                // if (estimatedTires + order.estimated_tires <= totalTires || order
                                //     .estimated_tires === 0) {
                                //     table.rows.add([newData]).draw();
                                //     estimatedTires += order
                                //     .estimated_tires; 
                                // } 
                                // else if (estimatedTires < totalTires) {
                                //     // Split the order to fit the remaining space
                                //     var remainingSpace = totalTires - estimatedTires;
                                //     var partialOrder = Object.assign({}, newData, {
                                //         "estimated_tires": remainingSpace
                                //     });
                                //     var remainingOrder = Object.assign({}, newData, {
                                //         "estimated_tires": order.estimated_tires - remainingSpace
                                //     });

                                //     table.rows.add([partialOrder]).draw();
                                //     estimatedTires +=
                                //     remainingSpace; // Update estimatedTires with the remaining space

                                //     exceedingOrdersTable.rows.add([remainingOrder]).draw();
                                // } else {
                                //     exceedingOrdersTable.rows.add([newData]).draw();
                                // }
                            });

                            // exceedingOrdersTable.data().each(function(order) {
                            //     if (estimatedTires + order.estimated_tires <= totalTires) {
                            //         table.rows.add([order]).draw();
                            //         estimatedTires += order.estimated_tires;
                            //         exceedingOrdersTable.row(function(idx, data, node) {
                            //             return data.id === order.id;
                            //         }).remove().draw(); // Remove the added order from exceedingOrdersTable
                            //     }
                            // });

                            var tableOrderIds = new Set();
                            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                                var data = this.data();
                                tableOrderIds.add(data.order_id);
                            });

                            var filteredSortedWaypoints = sortedWaypoints.filter(function(waypoint, index) {
                                // Exclude the first waypoint which is the origin
                                if (index === 0) {
                                    return true;
                                }
                                var orderIndex = sortedIndices[index - 1];
                                return tableOrderIds.has(response[orderIndex].id);
                            });

                            var request = {
                                origin: filteredSortedWaypoints[0].location,
                                destination: {
                                    location: {
                                        lat: 30.749760,
                                        lng: -98.180590
                                    }
                                },
                                waypoints: filteredSortedWaypoints.slice(1),
                                travelMode: 'DRIVING'
                            };


                            $('#orderDetailDiv').append(`<div>End Route: Reliable Tire Disposal</div>`)
                            $('.removeOrder').on('click', function() {
                                // Retrieve the removeOrderID
                                let removeOrderID = parseInt($(this).attr('data-orderid'));
                                const actualResponseArray = Object.values(actualResponse);
                                const filteredArray = actualResponseArray.filter(obj => obj.id !==
                                    removeOrderID);
                                const filteredObject = Object.fromEntries(filteredArray.map(obj => [obj.id,
                                    obj
                                ]));
                                actualResponse = filteredObject;
                                $('#orderDetailDiv').empty();
                                generateWayPoints(actualResponse);
                            });

                            directionsService.route(request, function(response, status) {
                                if (status == 'OK') {
                                    directionsRenderer.setDirections(response);
                                    $('#createRoute').removeClass('d-none');
                                } else {
                                    window.alert('Directions request failed due to ' + status);
                                }
                            });
                        }
                    } else {
                        console.log('No results found');
                    }
                } else {
                    console.log('Geocode was not successful for the following reason: ' + status);
                }
            });
        }


        $(document).ready(function() {
            let startDate = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
            let endDate = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
            $('#generateRoutes').on('click', function() {
                localStorage.setItem('startDate', $('input[name="daterange"]').data('daterangepicker')
                    .startDate);
                localStorage.setItem('endDate', $('input[name="daterange"]').data('daterangepicker')
                    .endDate);

                $('#orderDetailDiv').empty()
                let truck_id = $('#truck').val();
                $.ajax({
                    url: '/get-driver-orders-routing',
                    type: 'GET',
                    data: {
                        'truck_id': truck_id,
                        from_date: startDate,
                        to_date: endDate
                    },
                    success: function(response) {
                        console.log("this is respose", response);
                        if (response.length == 0) {
                            alert('No Order Found for this truck');
                            location.reload()
                        }
                        actualResponse = response;
                        table.on('row-reorder', function(e, diff, edit) {
                            table.draw();
                            $('#orderDetailDiv').empty();
                        });
                        generateWayPoints(response);
                    }
                })
            });

            $('#createRoute').on('click', function() {
                var orderIdsArray = [];
                var exceedingOrderIds = [];

                var simpleOrderObjects = [];
                var exceedingOrderObjects = [];

                table.rows().every(function() {
                    let data = this.data();
                    simpleOrderObjects.push({
                        orderId: data.order_id,
                        estimatedTires: data.estimated_tires
                    });
                    orderIdsArray.push(data.order_id);
                });

                // exceedingOrdersTable.rows().every(function() {
                //     let data = this.data();
                //     exceedingOrderObjects.push({
                //         orderId: data.order_id,
                //         estimatedTires: data.estimated_tires
                //     });
                //     exceedingOrderIds.push(data.order_id);
                // });

                // console.log('waow1', simpleOrderObjects);
                // console.log('waow2', exceedingOrderObjects);

                var orderIds = orderIdsArray.join(',');
                // var exceedingOrders = exceedingOrderIds.join(',');
                let truckId = $('#truck').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/create-routing-web',
                    type: 'POST',
                    data: {
                        simpleOrderObjects,
                        truck_id: truckId,
                        order_ids: orderIds,
                        routing_date: $('#routing_date').val(),
                        route_name: $('#routeName').val()
                    },
                    success: function(response) {
                        location.reload()
                    }
                })
            });
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
        // var exceedingOrderMap = new google.maps.Map(document.getElementById("exceedingOrderMap"), myOptions);
        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer({
            map: mymap,

        });
        // var directionsRendererExceeding = new google.maps.DirectionsRenderer({
        //     suppressMarkers: true,
        //     map: exceedingOrderMap,

        // });

        function generateWayPoints(response) {
            latlngs = [];
            var waypoints = [{
                location: {
                    lat: 30.749860,
                    lng: -98.180590
                }
            }];

            Object.values(response).forEach(function(order, index) {
                geocodeAddress(response, order.customer.address, index, waypoints, order);
            });
        }

        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }


        $('#generateSimpleRoutes').on('click', function() {
            let customOrderIds = [];
            let exceedingOrderIds = [];
            table.rows().every(function() {
                let data = this.data();
                customOrderIds.push(data.order_id)
            });
            // exceedingOrdersTable.rows().every(function() {
            //     let data = this.data();
            //     exceedingOrderIds.push(data.order_id)
            // });
            var geocoder = new google.maps.Geocoder();
            let filteredOrders = customOrderIds.map(orderId => actualResponse.find(order => order.id === orderId));
            // let filterExceedingOrders = exceedingOrderIds.map(orderId => actualResponse.find(order => order.id ===
            //     orderId));

            var waypoints = [{
                location: {
                    lat: 30.749860,
                    lng: -98.180590
                }
            }];

            var exceedingWaypoints = [{
                location: {
                    lat: 30.749860,
                    lng: -98.180590
                }
            }];

            let geocodePromises = [];
            let exceedingGeoCodePromises = [];

            filteredOrders.forEach(function(order, index) {
                let promise = new Promise(function(resolve, reject) {
                    geocoder.geocode({
                        'address': order.customer.address
                    }, function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {
                            if (results.length > 0) {
                                var location = results[0].geometry.location;
                                waypoints.push({
                                    location: {
                                        lat: location.lat(),
                                        lng: location.lng()
                                    }
                                });
                                resolve
                                    (); // Resolve the promise once geocoding is successful
                            } else {
                                console.log('No results found');
                                reject('No results found');
                            }
                        } else {
                            console.log(
                                'Geocode was not successful for the following reason: ' +
                                status);
                            reject(status);
                        }
                    });
                });

                geocodePromises.push(promise);
            });
            // Wait for all geocoding promises to resolve
            Promise.all(geocodePromises).then(function() {
                var request = {
                    origin: waypoints[0].location,
                    destination: {
                        location: {
                            lat: 30.749760,
                            lng: -98.180590
                        }
                    },
                    travelMode: 'DRIVING',
                    waypoints: waypoints.slice(1).map(waypoint => ({
                        location: waypoint.location,
                        stopover: true // Ensure each waypoint is treated as a stop
                    }))
                };

                $('#orderDetailDiv').empty();
                $('.removeOrder').on('click', function() {
                    let removeOrderID = parseInt($(this).attr(
                        'data-orderid'));
                });

                clearMarkers();
                directionsService.route(request, function(response, status) {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(response);

                        // Add markers in the order of customerOrderId
                        filteredOrders.forEach((order, index) => {
                            geocoder.geocode({
                                'address': order.customer.address
                            }, function(results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    var marker = new google.maps.Marker({
                                        position: results[0].geometry
                                            .location,
                                        map: mymap, // Assuming 'map' is your Google Map instance
                                        title: `Order ${order.id}`,
                                        label: {
                                            text: (index + 1)
                                                .toString(), // Replace with your desired label text (e.g., 'A', 'B', 'C', ...)
                                            color: 'white', // Label text color
                                            fontSize: '12px', // Label font size
                                            fontWeight: 'bold', // Label font weight
                                        },
                                    });

                                    markers.push(marker);

                                    // Example of adding an info window to each marker
                                    var infoWindow = new google.maps.InfoWindow({
                                        content: `<h3>Order ${order.id}</h3><p>Customer: ${order.customer.business_name}</p>`
                                    });

                                    marker.addListener('click', function() {
                                        infoWindow.open(mymap, marker);
                                    });
                                } else {
                                    console.log(
                                        'Geocode was not successful for the following reason: ' +
                                        status);
                                }
                            });
                        });

                        $('#createRoute').removeClass('d-none');
                    } else {
                        window.alert('Directions request failed due to ' +
                            status);
                    }
                });
            }).catch(function(error) {
                console.error('Error in geocoding:', error);
            });


            /// this is for exceeding orders

            // filterExceedingOrders.forEach(function(order, index) {
            //     let promise = new Promise(function(resolve, reject) {
            //         geocoder.geocode({
            //             'address': order.customer.address
            //         }, function(results, status) {
            //             if (status === google.maps.GeocoderStatus.OK) {
            //                 if (results.length > 0) {
            //                     var location = results[0].geometry.location;
            //                     exceedingWaypoints.push({
            //                         location: {
            //                             lat: location.lat(),
            //                             lng: location.lng()
            //                         }
            //                     });
            //                     resolve
            //                         (); // Resolve the promise once geocoding is successful
            //                 } else {
            //                     console.log('No results found');
            //                     reject('No results found');
            //                 }
            //             } else {
            //                 console.log(
            //                     'Geocode was not successful for the following reason: ' +
            //                     status);
            //                 reject(status);
            //             }
            //         });
            //     });

            //     exceedingGeoCodePromises.push(promise); // Push the promise to the array
            // });


            // Promise.all(exceedingGeoCodePromises).then(function() {
            //     // Once all promises are resolved (i.e., all geocoding requests are complete), construct the request object
            //     var request = {
            //         origin: waypoints[0].location,
            //         destination: {
            //             location: {
            //                 lat: 30.749760,
            //                 lng: -98.180590
            //             }
            //         },
            //         travelMode: 'DRIVING',
            //         waypoints: exceedingWaypoints.slice(1).map(waypoint => ({
            //             location: waypoint.location,
            //             stopover: true // Ensure each waypoint is treated as a stop
            //         }))
            //     };

            //     $('#orderDetailDiv').empty();

            //     clearMarkers();

            //     directionsService.route(request, function(response, status) {
            //         if (status === 'OK') {
            //             directionsRendererExceeding.setDirections(response);

            //             // Add markers in the order of customerOrderId
            //             filterExceedingOrders.forEach((order, index) => {
            //                 geocoder.geocode({
            //                     'address': order.customer.address
            //                 }, function(results, status) {
            //                     if (status === google.maps.GeocoderStatus.OK) {
            //                         var marker = new google.maps.Marker({
            //                             position: results[0].geometry
            //                                 .location,
            //                             map: exceedingOrderMap, // Assuming 'map' is your Google Map instance
            //                             title: `Order ${order.id}`,
            //                             label: {
            //                                 text: (index + 1)
            //                                     .toString(), // Replace with your desired label text (e.g., 'A', 'B', 'C', ...)
            //                                 color: 'white', // Label text color
            //                                 fontSize: '12px', // Label font size
            //                                 fontWeight: 'bold', // Label font weight
            //                             },
            //                         });

            //                         Exceedingmarkers.push(marker);

            //                         // Example of adding an info window to each marker
            //                         var infoWindow = new google.maps.InfoWindow({
            //                             content: `<h3>Order ${order.id}</h3><p>Customer: ${order.customer.business_name}</p>`
            //                         });

            //                         marker.addListener('click', function() {
            //                             infoWindow.open(exceedingOrderMap,
            //                                 marker);
            //                         });
            //                     } else {
            //                         console.log(
            //                             'Geocode was not successful for the following reason: ' +
            //                             status);
            //                     }
            //                 });
            //             });

            //             $('#createRoute').removeClass('d-none');
            //         } else {
            //             window.alert('Directions request failed due to ' +
            //                 status);
            //         }
            //     });
            // });


        });
    </script>
@endsection
