@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">State</h4>

                            <div class="p-20 text-center">
                                <h3>What Type of Load?</h3>
                                <div class="mt-5">
                                    <a href="{{route('fullfill.load.weight')}}">
                                        <h4>Load By Weight</h4>
                                    </a>
                                    <a href="{{route('fullfill.load.tire', $order->id)}}">
                                        <h4>Load By Tire</h4>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->


    </div>
@endsection
