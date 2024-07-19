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
            </div>
            <hr>
            <div class="row">
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
                                <th>Saturday</th>
                                <th>Sunday</th>
                                <th>Left Over</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataGroupedByTruck as $key => $truckData)
                                @php
                                    $totalLeftOver = 0;
                                    $truckInfo = \App\Models\Truck::where('name', $key)->latest()->first();
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('change.truck.status', $truckInfo->id) }}"
                                            class="{{ $truckInfo->is_active ? 'text-success' : 'text-primary' }}">
                                            {{ $key }}
                                        </a>
                                    </td>
                                    <td class="droppable-day" data-day="Monday">
                                        @if (isset($truckData['Monday']))
                                            @foreach ($truckData['Monday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="droppable-day" data-day="Tuesday">
                                        @if (isset($truckData['Tuesday']))
                                            @foreach ($truckData['Tuesday'] as $route)
                                            @if(isset($route['order_ids']))
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="droppable-day" data-day="Wednesday">
                                        @if (isset($truckData['Wednesday']))
                                            @foreach ($truckData['Wednesday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="droppable-day" data-day="Thursday">
                                        @if (isset($truckData['Thursday']))
                                            @foreach ($truckData['Thursday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="droppable-day" data-day="Friday">
                                        @if (isset($truckData['Friday']))
                                            @foreach ($truckData['Friday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="droppable-day" data-day="Saturday">
                                        @if (isset($truckData['Saturday']))
                                            @foreach ($truckData['Saturday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    </td>

                                    <td class="droppable-day" data-day="Sunday">
                                        @if (isset($truckData['Sunday']))
                                            @foreach ($truckData['Sunday'] as $route)
                                                @foreach (explode(',', $route['order_ids']) as $order_id)
                                                    @php
                                                        $tempOrder = App\Models\Order::with([
                                                            'fulfilled',
                                                            'customer',
                                                        ])->find($order_id);
                                                        if ($tempOrder['fulfilled']) {
                                                            $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                        }
                                                    @endphp
                                                    <div class="orderdiv" data-order-id="{{ $order_id }}">
                                                        <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                            <span
                                                                class="{{ $tempOrder->status == 'fulfilled' ? 'strike-through' : '' }}">
                                                                {{ $tempOrder['customer']['business_name'] }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endforeach
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

        $('#filterBtn').click(function(){

            localStorage.setItem('startDate', $('input[name="daterange"]').data('daterangepicker')
                    .startDate);

                localStorage.setItem('endDate', $('input[name="daterange"]').data('daterangepicker')
                    .endDate);

             startDate = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
             endDate = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');

             var url = "{{ route('calander.index') }}" + "?startDate=" + (startDate) + "&endDate=" + (endDate);

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



        // var calendar = $('#calendar').fullCalendar({
        //     editable: true, // Enable dragging
        //     eventBackgroundColor: "#de1f1f",
        //     header: {
        //         left: 'prev,next',
        //         right: 'title'
        //     },
        //     events: {
        //         url: "{{ route('calander.events') }}",

        //     },
        //     select: function(start, end, allDay) {
        //         var title = prompt('Event Title:');
        //         if (title) {
        //             var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

        //             var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

        //             $.ajax({
        //                 url: "",
        //                 type: "POST",
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 data: {
        //                     title: title,
        //                     start: start,
        //                     end: end,
        //                     type: 'add'
        //                 },
        //                 success: function(data) {
        //                     calendar.fullCalendar('refetchEvents');
        //                 }
        //             })
        //         }
        //     },
        //     eventResize: function(event, delta) {
        //         var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
        //         var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
        //         var title = event.title;
        //         var id = event.id;
        //         $.ajax({
        //             url: "",
        //             type: "POST",
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: {
        //                 title: title,
        //                 start: start,
        //                 end: end,
        //                 id: id,
        //                 type: 'update'
        //             },
        //             success: function(response) {
        //                 calendar.fullCalendar('refetchEvents');
        //                 alert("Event updated");
        //             }
        //         })
        //     },
        //     eventDrop: function(event, delta) {
        //         var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
        //         var order_id = event.id;
        //         $.ajax({
        //             url: "{{ route('calander.order.update') }}",
        //             type: "POST",
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: {
        //                 start: start,
        //                 order_id: order_id,
        //                 route_id: event.route_id
        //             },
        //             success: function(response) {
        //                 calendar.fullCalendar('refetchEvents');
        //                 alert("Event updated");
        //             }
        //         })
        //     },
        //     eventClick: function(event) {
        //         location.href = `/order/${event.id}`;
        //         // if(confirm("Are you sure you want to remove it?"))
        //         // {
        //         //     var id = event.id;
        //         //     $.ajax({
        //         //         url:"",
        //         //         type:"POST",
        //         //         headers:{
        //         //             'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        //         //         },
        //         //         data:{
        //         //             id:id,
        //         //             type:"delete"
        //         //         },
        //         //         success:function(response){
        //         //             calendar.fullCalendar('refetchEvents');
        //         //             alert("Event deleted");
        //         //         }
        //         //     })
        //         // }
        //     }
        // });

        Pusher.logToConsole = true;

        // var pusher = new Pusher('3f3145c56ea4cf5b928c', {
        // cluster: 'us2'
        // });

        // Listen for events from Pusher
        //       pusher.subscribe('routes').bind('route-created', function(data) {
        //   // When an event is received, trigger a rerender of the calendar
        //   calendar.fullCalendar('refetchEvents');
        // });
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    

    <script>
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
                    var clonedElement = draggableOrder.clone(); // Pass true to clone with events
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
                    console.log('Order ' + orderId + ' dropped on ' + droppedDay);

                    $.ajax({
                          url:"/get-order-dragging",
                          type:"POST",
                          headers:{
                              'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                          },
                          data:{
                            order_id:orderId,
                            futureDay:droppedDay
                          },
                          success:function(response){
                            //   calendar.fullCalendar('refetchEvents');
                            //   alert("Event deleted");
                          }
                        })

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
