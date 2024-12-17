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
                                        <th>Truck</th>
                                        <th>Action </th>
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
                                            <td>{{ $order->truck ? $order->truck->name : 'N/A' }}</td>
                                            <td><a href="" class="update_driver"
                                                    data-order_id="{{ $order->id }}"><i class="mdi mdi-account "
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
    <div class="modal fade" id="truckList" tabindex="-1" aria-labelledby="schoolUsersListLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="schoolUsersListLabel">Truck</h5>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="hidden" name="order_id" class="orderID">
                    <select id="selectTruck" name="truck" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                        <option value=""  selected>Please select Truck</option>
                        @foreach ($trucks as $truck)
                        <option value="{{$truck->id}}">{{ucfirst($truck->name)}}</option>
                        @endforeach
                    </select>
                 
                </div>
            </div>
          </div>
        </div>
    </div>
    
    <div class="modal fade" id="customerSummary" tabindex="-1" aria-labelledby="schoolUsersListLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="schoolUsersListLabel">Customer Summary</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <p>Customer Last Note</p>&nbsp;
                            <p id="lastNote"></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p>Estimated tires</p>&nbsp;
                            <p id="estimatedTires"></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p>Spoke With</p>&nbsp;
                            <p id="spokeWith"></p>
                        </div>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageSpecificJs')
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
                        data: 'customer.business_name',
                        name: 'customer.business_name',
                        render: function(data, type, full, meta) {
                            if (full.customer && full.customer.business_name) {
                                return '<span class="customerName" data-customer-id=' + full
                                    .customer.id + '>' + full.customer.business_name + '</span>';
                            } else {
                                return 'N/A';
                            }
                        }
                    },
                    {
                        data: 'created_by',
                        name: 'Created By'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'customer.email',
                        name: 'customer.email'
                    },
                    {
                        data: 'truck',
                        name: 'truck',
                        render: function(data, type, full, meta) {
                            if (full.truck) {
                                return full.truck;
                            } else {
                                return 'N/A';
                            }
                        }
                    },
                    {
                        data: 'update_truck',
                        name: 'Update Truck'
                    }
                ],
                drawCallback: function(settings) {
                    window.scrollTo(0, 0);

                    // Attach click event listener to customer name
                    $('.data-table').on('click', '.customerName', function() {
                        var customerId = $(this).data('customer-id');
                        $.ajax({
                            url: '{{ route('customer.last.note') }}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: {
                                id: customerId
                            },
                            success: function(response) {
                                $('#estimatedTires').text(' '+response.data.estimated_tires)
                                $('#lastNote').text(' '+response.data.note)
                                $('#spokeWith').text(' '+response.data.spoke_with)

                                
                                $('#customerSummary').modal('show');
                            }
                        });


                    });
                }
            });

            $(".filter").click(function() {
                localStorage.setItem('startDate', $('input[name="daterange"]').data('daterangepicker')
                    .startDate);

                localStorage.setItem('endDate', $('input[name="daterange"]').data('daterangepicker')
                    .endDate);

                table.draw();
            });

        });
    </script>

    <script>
        function updateTruck(id) {
            $('.orderID').val(id)
            $('#truckList').modal('show');
            $('#selectTruck').on('change', function() {
                let truckID = this.value;
                $.ajax({
                    url: '{{ route('order.updateDriver') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        order_id: $('.orderID').val(),
                        truck_id: truckID
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
