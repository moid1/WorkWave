@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Order Details</h4>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">

                                <form action="{{ route('order.updateOrder') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <input type="hidden" name="customer_id" value="{{$order->customer->id}}">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Business Name</label>
                                                <input readonly id="business_name" type="text" class="form-control"
                                                    name="business_name" value="{{ $order->customer->business_name }}"
                                                    required autofocus>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Date</label>
                                                <input name="date" class="form-control readonly" type = "date"
                                                    value="{{ $order->delivery_date }}" />
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input readonly id="address" type="text"
                                                    class="form-control  "name="address"
                                                    value="{{ $order->customer->address }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Phone #</label>
                                                <input readonly id="phone_no" type="text" class="form-control"
                                                    name="phone_no" value="{{ $order->customer->phone_no }}" required>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>POC Name</label>
                                                <input readonly id="poc_name" type="text"
                                                    class="form-control @error('poc_name') is-invalid @enderror"
                                                    name="poc_name" value="{{ $order->customer->poc_name }}" required
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input readonly id="email" type="email" class="form-control "
                                                    name="email" value="{{ $order->customer->email }}" required autofocus>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>2nd Email</label>
                                                <input readonly id="second_mail" type="email"
                                                    class="form-control "
                                                    name="second_mail" value=""  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>2nd POC</label>
                                                <input readonly id="second_poc" type="text"
                                                    class="form-control "
                                                    name="second_poc" value=""  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Mail Address</label>
                                                <input readonly id="mail_address" type="text"
                                                    class="form-control "
                                                    name="mail_address" value=""  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Charge type</label>
                                                <input readonly id="charge_type" type="text"
                                                    class="form-control "
                                                    name="charge_type" value=""  autofocus>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Load Type</label>
                                                <select id="loadType" name="load_type"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="box_truck_route"
                                                        {{ $order->load_type == 'box_truck_route' ? 'selected' : '' }}>Box
                                                        Truck Route</option>
                                                    <option value="trailer_swap"
                                                        {{ $order->load_type == 'trailer_swap' ? 'selected' : '' }}>Trailer
                                                        Swap</option>
                                                    <option value="state"
                                                        {{ $order->load_type == 'state' ? 'selected' : '' }}>State</option>
                                                    <option value="tdf"
                                                        {{ $order->load_type == 'tdf' ? 'selected' : '' }}>TDF</option>
                                                    <option value="steel"
                                                        {{ $order->load_type == 'steel' ? 'selected' : '' }}>Steel</option>

                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Driver</label>
                                                <select id="driver" name="driver_id"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" selected>Please select Driver</option>
                                                    @foreach ($drivers as $driver)
                                                        <option value="{{ $driver->id }}" {{$driver->id  == $order->driver_id ? 'selected' : ''}}>{{ ucfirst($driver->name) }}
                                                        </option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Spoke With</label>
                                                <input type="text" name="spoke_with" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Estimated Tires</label>
                                                <input type="text" name="estimated_tires" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Want to create Order</label>
                                                <select id="" name="create_order"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="createOrder">Yes</option>
                                                    <option value="createOrder">No</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-lg-6  ">
                                            <div class="form-group ">
                                                <label>Notes</label>
                                                <textarea class="form-control " name="notes" id="notes" cols="30" rows="2"></textarea>
                                            </div>
                                        </div>



                                        <div class="col-lg-12 justify-content-center text-center mt-5">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Submit
                                                </button>
                                                <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->


    </div>
@endsection
