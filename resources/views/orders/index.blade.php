@extends('layouts.app')

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
    
                            <h4 class="mt-0 header-title">All Orders</h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                     
                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Created By</th>
                                        <th>POC Name</th>
                                        <th>Email</th>
                                        <th>Order Type</th>
                                        <th>Qty</th>
                                        <th>Api Response</th>
                                        <th>Created_at</th>


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
                                        <td>{{$order->load_type == 0 ? 'BOX' : 'SWAP'}}</td>
                                        <td>{{$order->load_value}}</td>
                                        <td>{{$order->api_response}}</td>
                                        <td>{{$order->created_at}}</td>

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
