@extends('layouts.app')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
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
    color: red!important;
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
    <div class="page-content-wrapper ">
        <div class="container-fluid">
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
                                    <td> <a href={{ route('change.truck.status', $truckInfo->id) }}
                                        class="{{ $truckInfo->is_active ? 'text-success' : 'text-primary' }}">
                                        {{ $key }} </a></td>
                                    <td>
                                        @if (isset($truckData['Monday']))
                                            {{-- Iterate over routes if there are any --}}
                                            @foreach ($truckData['Monday'] as $route)
                                                <div class="row">
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with('fulfilled')
                                                                ->find($order_id);
                                                               
                                                            if ($tempOrder['fulfilled']) {
                                                                $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                            }
                                                        @endphp
                                                        <div class="col-lg-4">
                                                            <span class="{{$tempOrder->status == 'fulfilled' ? 'strike-through' : ''}}">Order {{ $order_id }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($truckData['Tuesday']))
                                            {{-- Iterate over routes if there are any --}}
                                            @foreach ($truckData['Tuesday'] as $route)
                                                <div class="row">
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with('fulfilled')
                                                                ->find($order_id);
                                                              
                                                            if ($tempOrder['fulfilled']) {
                                                                $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                            }
                                                        @endphp
                                                        <div class="col-lg-4">
                                                            <span class="{{$tempOrder->status == 'fulfilled' ? 'strike-through' : ''}}">Order {{ $order_id }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($truckData['Wednesday']))
                                            {{-- Iterate over routes if there are any --}}
                                            @foreach ($truckData['Wednesday'] as $route)
                                                <div class="row">
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with('fulfilled')
                                                                ->find($order_id);
                                                               
                                                            if ($tempOrder['fulfilled']) {
                                                                $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                            }
                                                        @endphp
                                                        <div class="col-lg-4">
                                                            <span class="{{$tempOrder->status == 'fulfilled' ? 'strike-through' : ''}}">Order {{ $order_id }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($truckData['Thursday']))
                                            {{-- Iterate over routes if there are any --}}
                                            @foreach ($truckData['Thursday'] as $route)
                                                <div class="row">
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with('fulfilled')
                                                                ->find($order_id);
                                                              
                                                            if ($tempOrder['fulfilled']) {
                                                                $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                            }
                                                        @endphp
                                                        <div class="col-lg-4">
                                                            <span class="{{$tempOrder->status == 'fulfilled' ? 'strike-through' : ''}}">Order {{ $order_id }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if (isset($truckData['Friday']))
                                            {{-- Iterate over routes if there are any --}}
                                            @foreach ($truckData['Friday'] as $route)
                                                <div class="row">
                                                    @foreach (explode(',', $route['order_ids']) as $order_id)
                                                        @php
                                                            $tempOrder = App\Models\Order::with('fulfilled')
                                                                ->find($order_id);
                                                               
                                                            if ($tempOrder['fulfilled']) {
                                                                $totalLeftOver += $tempOrder['fulfilled']['left_over'];
                                                            }
                                                        @endphp
                                                        <div class="col-lg-4">
                                                            <a target="_blank" href="{{ route('order.show', $order_id) }}">
                                                                <span class="{{$tempOrder->status == 'fulfilled' ? 'strike-through' : ''}}">Order {{ $order_id }}</span></a>
                                                        </div>
                                                    @endforeach
                                                </div>
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

    {{-- DATATABLE --}}
    {{-- <div class="page-content-wrapper">
        <button id="fullScreen" class="btn btn-primary float-right">Full Screens</button>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div id='calendar' style="overflow: auto"></div>
                </div>
            </div> 
        </div>
    </div> --}}
@endsection


@section('pageSpecificJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/gcal.js"></script>
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
@endsection
