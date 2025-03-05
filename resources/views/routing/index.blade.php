@extends('layouts.app')

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
    </div>


    {{-- DATATABLE --}}


    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">All Routes</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Order IDS</th>
                                        <th>Truck</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($allRoutes as $route)
                                        <tr>
                                            <td>{{ $route->route_name }}</td>
                                            @php
                                            $orders = explode(',', $route->order_ids)
                                            @endphp
                                            <td>
                                                @foreach ($orders as $order)
                                                    <a href="{{route('order.show', $order)}}">{{$order}}</a>
                                                @endforeach
                                            </td>
                                            <td>{{ $route->truck->name }}</td>
                                            <td>
                                                <a style="text-decoration: none;color:red"
                                                    href="{{ route('routing.delete', $route->id) }}"> <i
                                                        class="mdi mdi-delete " title="Delete Route"></i></a>
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

