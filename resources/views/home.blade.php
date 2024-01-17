@extends('layouts.app')
<style>
    .heading {
        text-align: center !important;
        margin-bottom: 30px;
    }

    .box {
        text-align: center !important;
        width: 100%;
    }

    .main-head {
        margin-top: 10px;
        background: white;
        padding-bottom: 10px;
        padding-top: 10px;

    }

    .overloaded{
        color: red
    }
</style>
@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="main-head">
                <h4 class="heading">Box Truck</h4>
                <div class="row justify-content-center">
                    <div class=" col-lg-2 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5> Total Orders Today </h5>
                                </div>
                                <div class="box">
                                    <span>BOX Truck With Assigned Routes</span>
                                    <div class=" justify-content-center">
                                        @foreach ($dataArray['boxTruckassignedTrucks'] as $assignedTruck)
                                            <span class="{{$assignedTruck['is_overload'] ? 'overloaded' : ''}}">{{ $assignedTruck['truckName'] }}</span> &nbsp;
                                        @endforeach


                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>BOX Truck Without Assigned Routes</span>
                                    <div class=" justify-content-center">
                                        @foreach ($dataArray['boxNotAssignedTrucks'] as $truck)
                                            <span>{{ $truck->name }}</span> &nbsp;
                                        @endforeach


                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Orders Completed</span>
                                    <div class=" justify-content-center">
                                        <span>{{ $dataArray['totalBoxOrderCompleted'] }}</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Orders Missed</span>
                                    <div class=" justify-content-center">
                                        <span>{{ $dataArray['totalBoxOrderNotCompleted'] }}</span> &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-2 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Tires</h5>
                                </div>
                                <div class="box">
                                    <span>Number of Tires Collected Today</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $dataArray['totalTiresCollectedToday'] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Number of Tires Resale</span>
                                    <div class="d-flex justify-content-center">
                                        <span>N/A</span> &nbsp;

                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Weight Collected</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Tires Collected To Date</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $dataArray['totalTiresCollectedYTD'] }}</span> &nbsp;

                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Weights To Date</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class=" col-lg-2 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Customers</h5>
                                </div>
                                <div class="box">
                                    <span>What CX were Missed</span>
                                    <div class="d-flex justify-content-center">
                                        @if (!empty($dataArray['boxTruckMissedCX']))
                                            @foreach ($dataArray['boxTruckMissedCX'] as $order)
                                                <span>{{ $order->customer->business_name }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> --}}

                    <div class=" col-lg-2 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Total Active CX</h5>
                                </div>
                                <div class="box">
                                    <span>Total New CX this Month</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $dataArray['newCustomersCount'] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total New CX YTD</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $dataArray['customersCountYTD'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-2 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Total Completed Jobs</h5>
                                </div>
                                <div class="box">
                                    <span>Monthly</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $dataArray['boxTruckCompletedJobs'][0] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Yearly</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $dataArray['boxTruckCompletedJobs'][1] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-head">
                <h4 class="heading">Semi Routes</h4>
                <div class="row justify-content-center">
                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5> Total Orders Today </h5>
                                </div>
                                <div class="box">
                                    <span>Semi With Assigned Route</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;
                                        <span>10</span> &nbsp;
                                        <span>11</span>&nbsp;
                                        <span>12</span>&nbsp;
                                        <span>13</span>&nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Semi Without Routes</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;
                                        <span>10</span> &nbsp;
                                        <span>11</span>&nbsp;
                                        <span>12</span>&nbsp;
                                        <span>13</span>&nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Orders Completed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Orders Missed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Tires</h5>
                                </div>
                                <div class="box">
                                    <span>Number of Tires Collected Today</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Number of Tires Resale</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;

                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Weight Collected</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Tires Collected To Date</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;

                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Weights To Date</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Customers</h5>
                                </div>
                                <div class="box">
                                    <span>What CX were Missed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Weights To Date</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span> &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>State Route</h5>
                                </div>
                                <div class="box">
                                    <span>Total Orders Today</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Orders Completed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>How Many Orders Missed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Weight Collected</span>
                                    <div class="d-flex justify-content-center">
                                        <span>9</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-head">
                <h4 class="heading">Material Shipped</h4>
                <div class="row justify-content-center">
                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5> TDF </h5>
                                </div>
                                <div class="box">
                                    <span>Total Loads Today</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $tdfData['totalLoadsToday'] }}</span>
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Tons Delivered</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $tdfData['totalTonsDelivered'] }}</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Tons Needed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $tdfData['totalTonNeeded'] }}</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Completion %</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $tdfData['todaysCompletion'] }}</span> &nbsp;

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Steel</h5>
                                </div>
                                <div class="box">
                                    <span>Total Loads Today</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $steelData['totalLoadsToday'] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Tons Delivered</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $steelData['totalTonsDelivered'] }}</span> &nbsp;

                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Total Tons Needed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $steelData['totalTonNeeded'] }}</span> &nbsp;
                                    </div>
                                </div>

                                <hr>
                                <div class="box">
                                    <span>Completion %</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $steelData['todaysCompletion'] }}</span> &nbsp;

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Monthly</h5>
                                </div>
                                <div class="box">
                                    <span>Total Tons Delivered</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $materialShippedData['totalTonsDelivered'] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Tons Needed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ optional($adminSettings)->total_tons_need / 12 }}</span>
                                        &nbsp;
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Completion %</span>
                                    <div class="d-flex justify-content-center">
                                        @if($materialShippedData['totalTonsDelivered'] > 0)
                                            <span>{{ number_format((optional($adminSettings)->total_tons_need / 12) / $materialShippedData['totalTonsDelivered'], 2) }}</span>
                                        &nbsp;
                                        @else
                                            <span>N/A</span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-3 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center">
                                    <h5>Yearly To Date</h5>
                                </div>
                                <div class="box">
                                    <span>Total Loads</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $materialShippedYearly['totalLoads'] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Tons Delivered</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ $materialShippedYearly['totalTonsDelivered'] }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Total Tons Needed</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ optional($adminSettings)->total_tons_need ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="box">
                                    <span>Completed %</span>
                                    <div class="d-flex justify-content-center">
                                        <span>{{ ($materialShippedYearly['totalTonsDelivered'] / optional($adminSettings)->total_tons_need)*100 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container-fluid -->


    </div>
@endsection
