@extends('layouts.app')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.4.1/css/rowReorder.dataTables.min.css">

@section('content')

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        {{Session::get('success')}}
                    </div>
                    @endif
                    <div class="card m-b-20">
                        <div class="card-body">
    
                            <h4 class="mt-0 header-title">All Orders assigned to {{$driver->name}}</h4>
    
                            <table id="example" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                     
                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Created By</th>
                                        <th>POC Name</th>
                                        <th>Email</th>
                                        <th>Qty</th>
                                        <th>Order Date</th>


                                    </tr>
                                </thead>
    
    
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>{{$order->id}}</td>
                                        <td>{{$order->customer->business_name}}</td>
                                        <td>{{$order->user->name}}</td>
                                        <td>{{$order->customer->poc_name}}</td>
                                        <td>{{$order->customer->email}}</td>
                                        <td>{{$order->load_value}}</td>
                                        <td>{{$order->created_at->format('M d Y')}}</td>

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
@section('pageSpecificJs')
<script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>


<script src="https://cdn.datatables.net/rowreorder/1.4.1/js/dataTables.rowReorder.min.js"></script>

<script>
const table = new DataTable('#example', {
    rowReorder: true,
});
</script>
@stop

