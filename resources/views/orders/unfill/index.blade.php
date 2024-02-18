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
                    data: 'customer.business_name',
                    name: 'customer.business_name'
                },
                {
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'email',
                    name: 'email'
                },

                {
                    data: 'driver',
                    name: 'driver',
                    render: function(data, type, full, meta) {
                        if (full.driver) {
                            return full.driver;
                        } else {
                            return 'N/A';
                        }
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'Action'
                }
            ]
        });

        $(".filter").click(function() {
            table.draw();
        });

    })
</script>
