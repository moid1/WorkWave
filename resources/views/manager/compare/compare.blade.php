@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
    rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

@section('content')
<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card m-b-20">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Count Tires</h4>
                        <p class="text-muted m-b-30 font-14">Fill This instructions Carefully.</p>
                        @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        @elseif (Session::has('error'))
                        @foreach (Session::get('error') as $error)
                        <div class="alert alert-danger" role="alert">
                            {{$error}}
                        </div>
                        @endforeach
                        @endif

                        <div class="p-20">

                            <form action="{{route('compare.order.post')}}" method="POST">
                                @csrf

                                <div class="row">
                                    <input type="hidden" value="{{$order->id}}" name="order_id">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Passenger Tires</label>
                                            <input id="passenger_tire" type="text" class="form-control"
                                                name="passenger_tire" value="{{ old('passenger_tire') }}" autofocus>
                                        </div>
                                    </div>

                                    {{-- quantitys of types of passanger tires --}}

                                    <div id="collawnmowersatvmotorcycle" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>No of Lawnmowers/ATVMotorcycle</label>
                                            <input id="lawnmowers_atvmotorcycle" type="text" class="form-control"
                                                name="lawnmowers_atvmotorcycle"
                                                value="{{ old('lawnmowers_atvmotorcycle') }}" autofocus>
                                        </div>
                                    </div>

                                    <div id="collawnmowers_atvmotorcyclewithrim" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>Lawnmowers/ATVMotorcycle With Rim</label>
                                            <input id="lawnmowers_atvmotorcyclewithrim" type="text" class="form-control"
                                                name="lawnmowers_atvmotorcyclewithrim"
                                                value="{{ old('lawnmowers_atvmotorcyclewithrim') }}" autofocus>
                                        </div>
                                    </div>

                                    <div id="colpassanger_lighttruck" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>Passanger/Light truck</label>
                                            <input id="passanger_lighttruck" type="text" class="form-control"
                                                name="passanger_lighttruck" value="{{ old('passanger_lighttruck') }}"
                                                autofocus>
                                        </div>
                                    </div>

                                    <div id="colpassanger_lighttruckwithrim" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>Passanger/Light truck with Rim</label>
                                            <input id="passanger_lighttruckwithrim" type="text" class="form-control"
                                                name="passanger_lighttruckwithrim"
                                                value="{{ old('passanger_lighttruckwithrim') }}" autofocus>
                                        </div>
                                    </div>



                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Truck Tires</label>
                                            <input id="truck_tire" type="text" class="form-control" name="truck_tire"
                                                value="{{ old('truck_tire') }}" autofocus>
                                        </div>
                                    </div>

                                    {{-- quantitys of types of truck tires --}}

                                    <div id="colsemitruck" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>No of Semi Truck</label>
                                            <input id="semi_truck" type="text" class="form-control" name="semi_truck"
                                                value="{{ old('semi_truck') }}" autofocus>
                                        </div>
                                    </div>

                                    <div id="colsemisupersingles" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>Semi Super Singles</label>
                                            <input id="semi_super_singles" type="text" class="form-control"
                                                name="semi_super_singles" value="{{ old('semi_super_singles') }}"
                                                autofocus>
                                        </div>
                                    </div>

                                    <div id="colsemitruckwithrim" class="col-lg-6 ">
                                        <div class="form-group">
                                            <label>Semi Truck With Rim</label>
                                            <input id="semi_truck_with_rim" type="text" class="form-control"
                                                name="semi_truck_with_rim" value="{{ old('semi_truck_with_rim') }}"
                                                autofocus>
                                        </div>
                                    </div>

                                    {{-- End quanittys of typres of truck tires --}}

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Agri Tires</label>
                                            <input id="agri_tire" type="text" class="form-control" name="agri_tire"
                                                value="{{ old('agri_tire') }}" autofocus>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Other Tires</label>
                                            <input id="other_tire" type="text" class="form-control" name="other_tire"
                                                value="{{ old('other_tire') }}" autofocus>
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