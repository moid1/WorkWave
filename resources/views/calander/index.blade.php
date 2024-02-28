@extends('layouts.app')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<style>
    .fc-time {
        display: none !important;
    }
</style>
@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

    {{-- DATATABLE --}}
    <div class="page-content-wrapper">
    <button id="fullScreen" class="btn btn-primary float-right">Full Screens</button>

        <div class="container-fluid">
            <div class="row justify-content-center">
                {{-- CaLANDER --}}
                <div class="col-lg-8">
                    <div id='calendar'></div>
                </div>
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

@endsection


@section('pageSpecificJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/gcal.js"></script>
    <script>
      $('#fullScreen').on('click', function(){
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



        var calendar = $('#calendar').fullCalendar({
            editable: true, // Enable dragging
            eventBackgroundColor: "#de1f1f",
            header: {
                left: 'prev,next',
                right: 'title'
            },
            events: {
                url: "{{ route('calander.events') }}",

            },
            select: function(start, end, allDay) {
                var title = prompt('Event Title:');
                if (title) {
                    var start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

                    var end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                    $.ajax({
                        url: "",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            type: 'add'
                        },
                        success: function(data) {
                            calendar.fullCalendar('refetchEvents');
                        }
                    })
                }
            },
            eventResize: function(event, delta) {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url: "",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success: function(response) {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event updated");
                    }
                })
            },
            eventDrop: function(event, delta) {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
                var order_id = event.id;
                $.ajax({
                    url: "{{route('calander.order.update')}}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        start: start,
                        order_id: order_id,
                        route_id: event.route_id
                    },
                    success: function(response) {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event updated");
                    }
                })
            },
            eventClick: function(event) {
                // if(confirm("Are you sure you want to remove it?"))
                // {
                //     var id = event.id;
                //     $.ajax({
                //         url:"",
                //         type:"POST",
                //         headers:{
                //             'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                //         },
                //         data:{
                //             id:id,
                //             type:"delete"
                //         },
                //         success:function(response){
                //             calendar.fullCalendar('refetchEvents');
                //             alert("Event deleted");
                //         }
                //     })
                // }
            }
        });
    </script>
@endsection
