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
                            <h4 class="mt-0 header-title">All Orders</h4>

                            <table class="table table-bordered dt-responsive nowrap data-table" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Created By</th>
                                        <th>Order Date</th>
                                        <th>Email</th>
                                         <th>Driver</th>
                                        <th>Update Driver</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->customer->business_name }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->customer->email }}</td>
                                            <td>{{ $order->driver ? $order->driver->name : 'N/A' }}</td>
                                            <td><a href="" class="update_driver" data-order_id="{{ $order->id }}"><i class="mdi mdi-account " 
                                                    title="Update Driver"></i></a> </td> 

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
    @include('orders.includes.change_driver')
@endsection

@section('pageSpecificJs')
    <script type="text/javascript">
        $(function() {

            $('input[name="daterange"]').daterangepicker({
                startDate: moment().subtract(1, 'M'),
                endDate: moment()
            });

            let url = "{{ route('order.index') }}";
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
                        name: 'id'
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
                        data: 'created_at',
                        name: 'Order Date'
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
                        data: 'update_driver',
                        name: 'Update Driver'
                    }
                ]
            });

            $(".filter").click(function() {
                table.draw();
            });

        });
    </script>

    <script>
    function updateDriver(id){
            $('.orderID').val(id)
            $('#driversList').modal('show');
                    $('#selectDriver').on('change', function() {
            let driverID = this.value;
            $.ajax({
                url: '{{ route('order.updateDriver') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    order_id: $('.orderID').val(),
                    driver_id: driverID
                },
                success: function(data) {
                    alert(data.message);
                    window.location.reload();
                }
            });
        });
    }

    </script>
@endsection
