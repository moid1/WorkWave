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
                <div class="btn btn-primary ">Generate Routes</div>
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
