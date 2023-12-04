@extends('layouts.app')

@section('content')
<div class="page-content-wrapper ">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="mini-stat clearfix bg-primary">
                    <span class="mini-stat-icon"><i class="mdi mdi-account"></i></span>
                    <div class="mini-stat-info text-right text-white">
                        <span class="counter">{{$dataArray['customersCount']}}</span>
                        Total Customers
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="mini-stat clearfix bg-primary">
                    <span class="mini-stat-icon"><i class="mdi mdi-currency-usd"></i></span>
                    <div class="mini-stat-info text-right text-white">
                        <span class="counter">{{$dataArray['ordersCount']}}</span>
                       Total Orders
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="mini-stat clearfix bg-primary">
                    <span class="mini-stat-icon"><i class="mdi mdi-cube-outline"></i></span>
                    <div class="mini-stat-info text-right text-white">
                        <span class="counter">{{$dataArray['notesCount']}}</span>
                      Total Notes
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 m-b-15 header-title">Recent Customers</h4>
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                <tr>
                                    <th>Business Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone#</th>
                                    <th>Status</th>
                                </tr>

                                </thead>
                                <tbody>
                                    @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{$customer['business_name']}}</td>
                                        <td>{{$customer['email']}}</td>
                                        <td>{{$customer['address']}}</td>
                                        <td>{{$customer['phone_no']}}</td>
                                        @if($customer['status'] === 1)
                                            <td><span class="badge badge-success">Active</span></td>
                                        @else
                                        <td><span class="badge badge-secondary" style="color: white">In Active</span></td>
                                        @endif


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