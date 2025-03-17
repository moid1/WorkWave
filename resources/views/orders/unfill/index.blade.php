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
                            <h4 class="mt-0 header-title">All UnfullFill Orders</h4>

                            <table class="table table-bordered dt-responsive nowrap data-table" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Created By</th>
                                        <th>Email</th>
                                        <th>Driver</th>
                                        <th>Order Date</th>
                                        <th>Action</th>


                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->customer->business_name }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->customer->email }}</td>
                                            <td>{{ $order->driver ? $order->driver->name : 'N/A' }}</td>
                                            <td>{{ $order->created_at->format('M d Y') }}</td>
                                            <td><a href="{{ route('unfill.manifest.order', $order->id) }}"> <i
                                                        class="mdi mdi-note "></i></td>
                                            </a>

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


        let url = "{{ route('fill.manifest.index') }}";
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url, // The URL endpoint for your AJAX request
                data: function(d) {
                    // Get the start and end date from the daterangepicker input
                    var daterange = $('input[name="daterange"]').data('daterangepicker');
                    if (daterange) {
                        d.from_date = daterange.startDate.format('YYYY-MM-DD');
                        d.to_date = daterange.endDate.format('YYYY-MM-DD');
                    }
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'customer.business_name',
                    name: 'customer.business_name',
                    render: function(data) {
                        return data ? data : 'N/A'; // If no business name, return 'N/A'
                    }
                },
                {
                    data: 'user.name',
                    name: 'user.name',
                    render: function(data) {
                        return data ? data : 'N/A'; // If no user name, return 'N/A'
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(data) {
                        return data ? data : 'N/A'; // If no email, return 'N/A'
                    }
                },
                {
                    data: 'driver',
                    name: 'driver',
                    render: function(data, type, full) {
                        return data ? data : 'N/A'; // If no driver, return 'N/A'
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data) {
                        return data ? moment(data).format('MMM D, YYYY') :
                        'N/A'; // Format the date if available
                    }
                },
                {
    data: 'id',
    name: 'action',
    render: function(data, type, row) {
        // Dynamically generate the route using the 'data' (order.id)
        var url = "/fill-manifest/" + data;  // Assuming the URL structure is like this
        return '<a href="' + url + '"> <i class="mdi mdi-note"></i></a>';
    },
    orderable: false, // Assuming the 'action' column shouldn't be sorted
    searchable: false, // Assuming the 'action' column shouldn't be searched
}

            ],
            drawCallback: function(settings) {
                window.scrollTo(0, 0); // Scroll to the top of the page after a draw
            },
            language: {
                processing: 'Loading...', // Optionally, add a custom processing message
            },
        });


        $(".filter").click(function() {
            table.draw();
        });

    })
</script>
