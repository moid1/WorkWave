@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
@section('content')

<div class="page-content-wrapper mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="card m-b-20">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">All Compared Orders</h4>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                            width="100%">
                            <thead>
                                <tr>

                                    <th>ID</th>
                                    <th>Business Name</th>
                                    <th>Created By</th>
                                    <th>POC Name</th>
                                    <th>Email</th>
                                    <th>Driver</th>
                                    <th>Order Date</th>
                                 <th>Action</th>

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
                                    <td>{{$order->driver ?$order->driver->name : 'N/A'}}</td>
                                    <td>{{$order->created_at->format('M d Y')}}</td>
                                  <td><a href="{{route('generate.countsheet', $order->id)}}">Generate Count Sheet </a> </td>

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
