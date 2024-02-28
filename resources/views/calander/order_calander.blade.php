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
            editable: false, // Enable dragging
            eventBackgroundColor: "#de1f1f",
            header: {
                left: 'prev,next',
                right: 'title'
            },
            events: {
                url: "{{ route('calander.order') }}",

            },
            select: function(start, end, allDay) {
              
            },
            eventResize: function(event, delta) {
                
            },
            eventDrop: function(event, delta) {
              
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