@extends('layouts.app')

@section('content')
<div class="page-content-wrapper ">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 m-b-15 header-title">Recent Orders</h4>
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Order Date</th>
                                    <th>Generator Manifest</th>
                                    <th>Transporter Manifest</th>
                                    <th>Processor Manifest</th>
                                    <th>Disposal Manifest</th>
                                    <th>Original Manifest</th>
                                </tr>

                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td>000{{$order->id}}</td>
                                        <td>000{{$order->created_at}}</td>
                                        <td><a href="{{url($order->manifest->generator)}}"> Manifest</a></td>
                                        <td><a href="{{url($order->manifest->transporter)}}"> Manifest</a></td>
                                        <td><a href="{{url($order->manifest->processor)}}"> Manifest</a></td>
                                        <td><a href="{{url($order->manifest->disposal)}}"> Manifest</a></td>
                                        <td><a href="{{url($order->manifest->original_generator)}}"> Manifest</a></td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->

    </div><!-- container-fluid -->


</div>
@endsection