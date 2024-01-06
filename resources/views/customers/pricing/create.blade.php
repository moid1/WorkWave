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
                            <h4 class="mt-0 header-title">Customer Pricing</h4>
                            <p class="text-muted m-b-30 font-14">Fill This instructions Carefully.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">

                                <form action="{{ route('customer.pricing.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="customer_id" value="{{$customerId}}">
                                    <div class="row">




                                        {{-- quantitys of types of passanger tires --}}

                                        <div id="collawnmowersatvmotorcycle" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of Lawnmowers/ATVMotorcycle</label>
                                                <input id="lawnmowers_atvmotorcycle" type="number" class="form-control"
                                                    name="lawnmowers_atvmotorcycle"
                                                    value="{{ old('lawnmowers_atvmotorcycle', optional($customerPricing)->lawnmowers_atvmotorcycle) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="collawnmowers_atvmotorcyclewithrim" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Lawnmowers/ATVMotorcycle With Rim</label>
                                                <input id="lawnmowers_atvmotorcyclewithrim" type="number"
                                                    class="form-control" name="lawnmowers_atvmotorcyclewithrim"
                                                    value="{{ old('lawnmowers_atvmotorcyclewithrim',  optional($customerPricing)->lawnmowers_atvmotorcyclewithrim) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colpassanger_lighttruck" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Passanger/Light truck</label>
                                                <input id="passanger_lighttruck" type="number" class="form-control"
                                                    name="passanger_lighttruck" value="{{ old('passanger_lighttruck', optional($customerPricing)->passanger_lighttruck) }}"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div id="colpassanger_lighttruckwithrim" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Passanger/Light truck with Rim</label>
                                                <input id="passanger_lighttruckwithrim" type="number" class="form-control"
                                                    name="passanger_lighttruckwithrim"
                                                    value="{{ old('passanger_lighttruckwithrim', optional($customerPricing)->passanger_lighttruckwithrim) }}" autofocus>
                                            </div>
                                        </div>

                                        {{-- END quantitys of types of passanger tires --}}




                                        {{-- quantitys of types of truck tires --}}

                                        <div id="colsemitruck" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of Semi Truck</label>
                                                <input id="semi_truck" type="number" class="form-control" name="semi_truck"
                                                    value="{{ old('semi_truck', optional($customerPricing)->semi_truck) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colsemisupersingles" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Semi Super Singles</label>
                                                <input id="semi_super_singles" type="number" class="form-control"
                                                    name="semi_super_singles" value="{{ old('semi_super_singles', optional($customerPricing)->semi_super_singles) }}"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div id="colsemitruckwithrim" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Semi Truck With Rim</label>
                                                <input id="semi_truck_with_rim" type="number" class="form-control"
                                                    name="semi_truck_with_rim" value="{{ old('semi_truck_with_rim', optional($customerPricing)->semi_truck_with_rim) }}"
                                                    autofocus>
                                            </div>
                                        </div>

                                        {{-- End quanittys of typres of truck tires --}}


                                        {{-- quantitys of types of agri tires --}}

                                        <div id="colag_med_truck_19_5_skid_steer" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of AG Med Truck 19.5/ Skid Steer</label>
                                                <input id="ag_med_truck_19_5_skid_steer" type="number" class="form-control"
                                                    name="ag_med_truck_19_5_skid_steer"
                                                    value="{{ old('ag_med_truck_19_5_skid_steer', optional($customerPricing)->ag_med_truck_19_5_skid_steer) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colag_med_truck_19_5_with_rim" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of AG Med Truck 19.5/ with Rim</label>
                                                <input id="ag_med_truck_19_5_with_rim" type="number" class="form-control"
                                                    name="ag_med_truck_19_5_with_rim"
                                                    value="{{ old('ag_med_truck_19_5_with_rim',  optional($customerPricing)->ag_med_truck_19_5_with_rim) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colfarm_tractor_last_two_digits" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of Farm Tractor $1.25 per, Last two digits</label>
                                                <input id="farm_tractor_last_two_digits" type="number" class="form-control"
                                                    name="farm_tractor_last_two_digits"
                                                    value="{{ old('farm_tractor_last_two_digits', optional($customerPricing)->farm_tractor_last_two_digits) }}" autofocus>
                                            </div>
                                        </div>

                                        {{-- End quanittys of typres of agri tires --}}



                                        {{-- quantitys of types of otr tires --}}


                                        <div id="col15_5_24" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 15_5_24</label>
                                                <input id="15_5_24" type="number" class="form-control" name="15_5_24"
                                                    value="{{ old('15_5_24',  optional($customerPricing)->{'15_5_24'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col17_5_25" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 17.5-25 (Radial)</label>
                                                <input id="17_5_25" type="number" class="form-control" name="17_5_25"
                                                    value="{{ old('17_5_25', optional($customerPricing)->{'17_5_25'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col20_5_25" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 20.5-25 (Radial)</label>
                                                <input id="20_5_25" type="number" class="form-control" name="20_5_25"
                                                    value="{{ old('20_5_25', optional($customerPricing)->{'20_5_25'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col23_5_25" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 23.5-25 (Radial)</label>
                                                <input id="23_5_25" type="number" class="form-control" name="23_5_25"
                                                    value="{{ old('23_5_25', optional($customerPricing)->{'23_5_25'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col29_5_25" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 29_5-25 (Radial)</label>
                                                <input id="29_5_25" type="number" class="form-control" name="29_5_25"
                                                    value="{{ old('29_5_25', optional($customerPricing)->{'29_5_25'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col24_00R35" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 24.00R35</label>
                                                <input id="24_00R35" type="number" class="form-control"
                                                    name="24_00R35" value="{{ old('24_00R35', optional($customerPricing)->{'24_00R35'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col13_00_24" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 13.00-24</label>
                                                <input id="13_00_24" type="number" class="form-control"
                                                    name="13_00_24" value="{{ old('13_00_24', optional($customerPricing)->{'13_00_24'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col14_00_24" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 14.00-24 (Radial)</label>
                                                <input id="14_00_24" type="number" class="form-control"
                                                    name="14_00_24" value="{{ old('14_00_24', optional($customerPricing)->{'14_00_24'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col19_5L_24" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 19.5L-24</label>
                                                <input id="19_5L_24" type="number" class="form-control"
                                                    name="19_5L_24" value="{{ old('19_5L_24', optional($customerPricing)->{'19_5L_24'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col18_4_30" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 18.4-30</label>
                                                <input id="18_4_30" type="number" class="form-control" name="18_4_30"
                                                    value="{{ old('18_4_30', optional($customerPricing)->{'18_4_30'}) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col18_4_38" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>No of 18.4-38</label>
                                                <input id="18_4_38" type="number" class="form-control" name="18_4_38"
                                                    value="{{ old('18_4_38', optional(optional($customerPricing))->{'18_4_38'}) }}" autofocus>
                                            </div>
                                        </div>



                                        {{-- End quanittys of typres of otr tires --}}

                                        <div id="" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Price Per Ton</label>
                                                <input id="price_per_ton" type="number" class="form-control" name="price_per_ton"
                                                    value="{{ old('price_per_ton', optional(optional($customerPricing))->price_per_ton) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Price Per Lb</label>
                                                <input id="price_per_lb" type="number" class="form-control" name="price_per_lb"
                                                    value="{{ old('price_per_lb', optional(optional($customerPricing))->price_per_lb) }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label>Swap Total</label>
                                                <input id="" type="number" class="form-control" name="swap_total"
                                                    value="{{ old('swap_total', optional(optional($customerPricing))->swap_total) }}" autofocus>
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
@section('pageSpecificJs')
@endsection
