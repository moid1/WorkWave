@extends('layouts.app')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<style>
    body:fullscreen {
        overflow: scroll !important;
    }

    body:-ms-fullscreen {
        overflow: scroll !important;
    }

    .fc-time {
        display: none !important;
    }

    .fc-day {
        background: #0000FF !important;
    }

    .fc-day-number {
        color: white;
    }

    .fc-event {
        background: transparent !important;
    }

    .strike-through {
        text-decoration: line-through;
        color: red !important;
    }
</style>
<style>
    * {
        box-sizing: border-box;
        padding: 0px;
        margin: 0px;
        font-family: Arial, Helvetica, sans-serif;
    }

    .body {
        margin: 40px;
        background-color: #f3f3f3;
        padding: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000000;
        text-align: left;
        padding: 8px;
    }

    .pink {
        background-color: #ff4ce4;
    }

    .red {
        color: red;
    }

    .white {
        color: transparent;
    }

    .blue {
        background-color: #069de7;
        text-align: center;
    }

    th:nth-child(2),
    td:nth-child(2) {
        width: 300px;
    }
</style>
@section('content')
    <div class="page-content-wrapper">
        <div class="container-fluid">
            <div class="d-flex mt-3 justify-content-between">
                <div style="">
                    <strong>Date Filter:</strong>
                    <input type="text" name="daterange" value="" />
                </div>

                <div id="filterBtn" class="btn btn-primary ">Filter</div>
                <button id="fullScreen" class="btn btn-primary">Full Screens</button>

            </div>
            <div class="col-lg-4">
                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Truck Label') }}</label>
                <select id="truck_type" name="truck_type" class="form-control" id="">
                    <option value="box_truck_center"> Box Truck Center</option>
                    <option value="semi_truck"> Semi Truck</option>
                    <option value="box_truck_south">Box Truck South</option>
                </select>
            </div>
            <hr>
            <div class="row" style="background: white;margin-top:20px" id="calendar">
                <div class="col-12">
                    <table>
                        <thead>
                            <tr>
                                <th>Truck#</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                {{-- <th>Saturday</th>
                                <th>Sunday</th> --}}
                                <th>Left Over</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataGroupedByTruck as $key => $truckData)
                                @php
                                    $totalLeftOver = 0;
                                    $truckInfo = \App\Models\Truck::where('name', $key)->latest()->first();
                                @endphp
                                <tr data-truck-id="{{ $truckInfo->id }}" class="truck-row">
                                    <td>
                                        <a href="{{ route('change.truck.status', $truckInfo->id) }}"
                                            class="{{ $truckInfo->is_active ? 'text-success' : 'text-primary' }}">
                                            {{ $key }}
                                        </a>
                                    </td>
                                    <td class="droppable-day" data-day="Monday"
                                        data-route-id="{{ $truckData['Monday'][0]['id'] ?? '' }}">
                                        @if (isset($truckData['Monday']) && is_array($truckData['Monday']))
                                            @php
                                                $totalLeftOver = 0;
                                            @endphp
                                            @foreach ($truckData['Monday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder && $tempOrder->fulfilled) {
                                                            $totalLeftOver += intval($tempOrder->fulfilled->left_over);
                                                        }
                                                    @endphp
                                                    @if (isset($tempOrder))
                                                        <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                            <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                                <span
                                                                    class="{{ $tempOrder->status === 'created' ? '' : 'strike-through' }}">
                                                                    {{ $tempOrder->customer->business_name }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="droppable-day" data-day="Tuesday"
                                        data-route-id="{{ $truckData['Tuesday'][0]['id'] ?? '' }}">
                                        @if (!empty($truckData['Tuesday']) && is_array($truckData['Tuesday']))
                                            @php
                                                $totalLeftOver = 0;
                                            @endphp
                                            @foreach ($truckData['Tuesday'] as $route)
                                                @if (!empty($route['order_ids']))
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with([
                                                                'fulfilled',
                                                                'customer',
                                                            ])->find($order_id);

                                                            if ($tempOrder && $tempOrder->fulfilled) {
                                                                $totalLeftOver += intval(
                                                                    $tempOrder->fulfilled->left_over,
                                                                );
                                                            }
                                                        @endphp
                                                        @if ($tempOrder)
                                                            <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                                <a target="_blank"
                                                                    href="{{ route('order.show', $order_id) }}">
                                                                    <span
                                                                        class="{{ $tempOrder->status === 'created' ? '' : 'strike-through' }}">
                                                                        {{ $tempOrder->customer->business_name }}
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="droppable-day" data-day="Wednesday"
                                        data-route-id="{{ $truckData['Wednesday'][0]['id'] ?? '' }}">
                                        @if (!empty($truckData['Wednesday']) && is_array($truckData['Wednesday']))
                                            @php
                                                $totalLeftOver = 0;
                                            @endphp
                                            @foreach ($truckData['Wednesday'] as $route)
                                                @if (!empty($route['order_ids']))
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with([
                                                                'fulfilled',
                                                                'customer',
                                                            ])->find($order_id);

                                                            if ($tempOrder && $tempOrder->fulfilled) {
                                                                $totalLeftOver += intval(
                                                                    $tempOrder->fulfilled->left_over,
                                                                );
                                                            }
                                                        @endphp
                                                        @if ($tempOrder)
                                                            <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                                <a target="_blank"
                                                                    href="{{ route('order.show', $order_id) }}">
                                                                    <span
                                                                        class="{{ $tempOrder->status === 'created' ? '' : 'strike-through' }}">
                                                                        {{ $tempOrder->customer->business_name }}
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="droppable-day" data-day="Thursday"
                                        data-route-id="{{ $truckData['Thursday'][0]['id'] ?? '' }}">
                                        @if (!empty($truckData['Thursday']) && is_array($truckData['Thursday']))
                                            @php
                                                $totalLeftOver = 0;
                                            @endphp
                                            @foreach ($truckData['Thursday'] as $route)
                                                @if (!empty($route['order_ids']))
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with([
                                                                'fulfilled',
                                                                'customer',
                                                            ])->find($order_id);

                                                            if ($tempOrder && $tempOrder->fulfilled) {
                                                                $totalLeftOver += intval(
                                                                    $tempOrder->fulfilled->left_over,
                                                                );
                                                            }
                                                        @endphp
                                                        @if ($tempOrder)
                                                            <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                                <a target="_blank"
                                                                    href="{{ route('order.show', $order_id) }}">
                                                                    <span
                                                                        class="{{ $tempOrder->status === 'created' ? '' : 'strike-through' }}">
                                                                        {{ $tempOrder->customer->business_name }}
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="droppable-day" data-day="Friday"
                                        data-route-id="{{ $truckData['Friday'][0]['id'] ?? '' }}">
                                        @if (!empty($truckData['Friday']) && is_array($truckData['Friday']))
                                            @php
                                                $totalLeftOver = 0;
                                            @endphp
                                            @foreach ($truckData['Friday'] as $route)
                                                @if (!empty($route['order_ids']))
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with([
                                                                'fulfilled',
                                                                'customer',
                                                            ])->find($order_id);

                                                            if ($tempOrder && $tempOrder->fulfilled) {
                                                                $totalLeftOver += intval(
                                                                    $tempOrder->fulfilled->left_over,
                                                                );
                                                            }
                                                        @endphp
                                                        @if ($tempOrder)
                                                            <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                                <a target="_blank"
                                                                    href="{{ route('order.show', $order_id) }}">
                                                                    <span
                                                                        class="{{ $tempOrder->status === 'created' ? '' : 'strike-through' }}">
                                                                        {{ $tempOrder->customer->business_name }}
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>



                                    <td>{{ $totalLeftOver }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>
@endsection


@section('pageSpecificJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/gcal.js"></script>
    <script>
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

        $('#fullScreen').on('click', function() {
            var element = document.getElementById('calendar');
            enterFullScreen(element);
        })

        function enterFullScreen(element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen(); // Firefox
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen(); // Safari
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen(); // IE/Edge
            }
        }

        $('#filterBtn').click(function() {

            localStorage.setItem('startDate', $('input[name="daterange"]').data('daterangepicker')
                .startDate);

            localStorage.setItem('endDate', $('input[name="daterange"]').data('daterangepicker')
                .endDate);

            startDate = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
            endDate = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
            let truckType = $('#truck_type').val();

            var url = "{{ route('calander.index') }}" + "?startDate=" + (startDate) + "&endDate=" + (endDate) +
                "&truck_type=" + (truckType);

            window.location.href = url;


        })
    </script>
    <script>
        $('#fullScreen').on('click', function() {
            var element = document.getElementById('calendar');
            enterFullScreen(element);
        })

        function enterFullScreen(element) {
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen(); // Firefox
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen(); // Safari
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen(); // IE/Edge
            }
        }

        Pusher.logToConsole = true;
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>



    <script>
        setTimeout(function() {
            window.location.reload();
        }, 300000);
        // Map days of the week to numbers
        var dayMap = {
            'Sunday': 0,
            'Monday': 1,
            'Tuesday': 2,
            'Wednesday': 3,
            'Thursday': 4,
            'Friday': 5,
            'Saturday': 6
        };
        $(document).ready(function() {
            $('.orderdiv').draggable({
                revert: true,
                zIndex: 1000,
                scroll: true,
                helper: 'clone'
            });

            $('.droppable-day').droppable({
                accept: '.orderdiv',
                drop: function(event, ui) {

                    var draggableOrder = ui.draggable;
                    var droppedDay = $(this).data('day');
                    var orderId = draggableOrder.data('order-id');
                    var destinationRouteId = $(this).data('route-id');

                    var clonedElement = draggableOrder.clone(); // Pass true to clone with events

                    // Get the truck ID from the row where the order was originally located
                    var sourceTruckRow = draggableOrder.closest('.truck-row');
                    var sourceTruckId = sourceTruckRow.data('truck-id');

                    // Get the truck ID from the row where the order is being dropped
                    var destinationTruckRow = $(this).closest('.truck-row');
                    var destinationTruckId = destinationTruckRow.data('truck-id');

                    console.log(destinationTruckRow);

                    var currentDayOfWeek = new Date().getDay();

                    var droppedDayOfWeek = dayMap[droppedDay];

                    //             if (droppedDayOfWeek < currentDayOfWeek) {
                    //     // Prevent dropping onto previous days
                    //    alert('Cannot drop onto previous days.');
                    //     return; // Exit the function without performing drop action
                    // }


                    // Example: Move order to another day (update UI logic)
                    $(this).append(clonedElement); // Append the cloned element
                    draggableOrder.remove(); // Remove the original draggable

                    // Here you can implement logic to update backend data or perform other actions
                    console.log('Route Id', destinationRouteId);
                    console.log('Order ' + orderId + ' moved from truck ' + sourceTruckId +
                        ' to truck ' + destinationTruckId + ' on ' + droppedDay);
                    $.ajax({
                        url: "/get-order-dragging",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            order_id: orderId,
                            futureDay: droppedDay,
                            sourceTruck: sourceTruckId,
                            destinationTruck: destinationTruckId,
                            destinationRouteId: destinationRouteId,
                            startDate: $('input[name="daterange"]').data('daterangepicker')
                                .startDate.format('YYYY-MM-DD'),
                            endDate: $('input[name="daterange"]').data('daterangepicker')
                                .endDate.format('YYYY-MM-DD')
                        },
                        success: function(response) {
                            // Your success handling code here
                            // calendar.fullCalendar('refetchEvents');
                            // alert("Event deleted");
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 500) {
                                alert(
                                    "An error occurred on the server. Please try again later.");
                            } else {
                                alert("An unexpected error occurred. Please try again.");
                            }
                        }
                    });


                    clonedElement.draggable({
                        revert: true,
                        zIndex: 1000,
                        scroll: true,
                        helper: 'clone',
                        start: function(event, ui) {
                            // Add any start event logic if needed
                        },
                        stop: function(event, ui) {
                            // Add any stop event logic if needed
                        }
                    });

                }
            });
        });
    </script>
@endsection
