@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div style="margin: 20px 0px;">
                                <strong>Date Filter:</strong>
                                <input type="text" name="daterange" value="" />
                                <button class="btn btn-success filter">Filter</button>
                            </div>
                            <h4 class="mt-0 header-title">All Compared Orders</h4>

                            <table id="" class="table table-bordered dt-responsive nowrap data-table"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Created By</th>
                                        <th>Load Type</th>
                                        <th>Email</th>
                                        <th>Driver</th>
                                        <th>Order Date</th>
                                        <th>Generate</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->customer->business_name }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->load_type }}</td>
                                            <td>{{ $order->customer->email }}</td>
                                            <td>{{ $order->driver ? $order->driver->name : 'N/A' }}</td>
                                            <td>{{ $order->created_at->format('M d Y') }}</td>
                                            <td><a href="{{ route('generate.countsheet', $order->id) }}">Count
                                                    Sheet </a>
                                                @if ($order->load_type == 'box_truck_route')
                                                    / <a href="{{ route('generate.weightsheet', $order->id) }}">Weight
                                                        Sheet </a>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>
@endsection
<script>
    $(function() {

        $('input[name="daterange"]').daterangepicker({
            startDate: moment().subtract(1, 'M'),
            endDate: moment()
        });


        let url = "{{ route('orders.compared') }}";
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                data: function(d) {
                    d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate
                        .format('YYYY-MM-DD');
                    d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format(
                        'YYYY-MM-DD');
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'business_name',
                    name: 'Business Name'
                },
                {
                    data: 'created_by',
                    name: 'Created By'
                },
                {
                    data: 'load_type',
                    name: 'Load Type'
                },
                {
                    data: 'email',
                    name: 'Email'
                },
                {
                    data: 'driver',
                    name: 'Driver'
                },
                {
                    data: 'created_at',
                    name: 'Order Date'
                },
               
                {
                    data: 'generate',
                    name: 'Generate'
                }
            ]
        });

        $(".filter").click(function() {
            table.draw();
        });

    })
</script>
