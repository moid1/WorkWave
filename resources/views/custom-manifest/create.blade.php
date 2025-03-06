@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
    rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@section('content')
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Generator</h4>
                            <p class="text-muted m-b-30 font-14">Fill This instructions Carefully.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">

                                <form action="{{ route('custom.generate.inhouse.manifest.store') }}" method="POST" id="fulFilledForm">
                                    @csrf

                                    <div class="row">
                                        {{-- <input type="hidden" value="{{ $order->id }}" name="order_id"> --}}
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company Registration</label>
                                                <input id="company_reg" type="text" class="form-control"
                                                    name="company_reg" value="" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input id="company_name" type="text" class="form-control"
                                                    name="company_name" value="" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Telephone No</label>
                                                <input id="telephone_no" type="text" class="form-control"
                                                    name="telephone_no" value="" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Contact Name</label>
                                                <input id="contact_name" type="text" class="form-control"
                                                    name="contact_name" value="" autofocus>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Contact PhoneNo</label>
                                                <input id="contact_phone_no" type="text" class="form-control"
                                                    name="contact_phone_no" value="" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company Address</label>
                                                <input id="company_Address" type="text" class="form-control"
                                                    name="company_Address" value="" autofocus>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Types of Passenger Tires</label>
                                                <select multiple="multiple" id="passanger_tyres_type"
                                                    name="passanger_tyres_type[]"
                                                    class="js-example-basic-multiple form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="lawnmowers_atvmotorcycle">Lawnmowers/ATVMotorcycle
                                                    </option>
                                                    <option value="lawnmowers_atvmotorcyclewithrim">Lawnmowers/ATVMotorcycle
                                                        With Rim</option>
                                                    <option value="passanger_lighttruck">Passanger/Light truck</option>
                                                    <option value="passanger_lighttruckwithrim">Passanger/Light truck with
                                                        Rim</option>
                                                </select>
                                            </div>
                                        </div>

                                        {{-- quantitys of types of passanger tires --}}

                                        <div id="collawnmowersatvmotorcycle" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Lawnmowers/ATVMotorcycle</label>
                                                <input id="lawnmowers_atvmotorcycle" type="text" class="form-control"
                                                    name="lawnmowers_atvmotorcycle"
                                                    value="{{ old('lawnmowers_atvmotorcycle') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="collawnmowers_atvmotorcyclewithrim" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Lawnmowers/ATVMotorcycle With Rim</label>
                                                <input id="lawnmowers_atvmotorcyclewithrim" type="text"
                                                    class="form-control" name="lawnmowers_atvmotorcyclewithrim"
                                                    value="{{ old('lawnmowers_atvmotorcyclewithrim') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colpassanger_lighttruck" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Passanger/Light truck</label>
                                                <input id="passanger_lighttruck" type="text" class="form-control"
                                                    name="passanger_lighttruck" value="{{ old('passanger_lighttruck') }}"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div id="colpassanger_lighttruckwithrim" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Passanger/Light truck with Rim</label>
                                                <input id="passanger_lighttruckwithrim" type="text"
                                                    class="form-control" name="passanger_lighttruckwithrim"
                                                    value="{{ old('passanger_lighttruckwithrim') }}" autofocus>
                                            </div>
                                        </div>

                                        {{-- END quantitys of types of passanger tires --}}



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Types of Truck Tires</label>
                                                <select multiple="multiple" id="truck_tyres_type"
                                                    name="truck_tyres_type[]"
                                                    class="js-example-basic-multiple form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="semi_truck">Semi Truck
                                                    </option>
                                                    <option value="semi_super_singles">Semi Super Singles</option>
                                                    <option value="semi_truck_with_rim">Semi Truck With Rim</option>

                                                </select>
                                            </div>
                                        </div>

                                        {{-- quantitys of types of truck tires --}}

                                        <div id="colsemitruck" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Semi Truck</label>
                                                <input id="semi_truck" type="text" class="form-control"
                                                    name="semi_truck" value="{{ old('semi_truck') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colsemisupersingles" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Semi Super Singles</label>
                                                <input id="semi_super_singles" type="text" class="form-control"
                                                    name="semi_super_singles" value="{{ old('semi_super_singles') }}"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div id="colsemitruckwithrim" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Semi Truck With Rim</label>
                                                <input id="semi_truck_with_rim" type="text" class="form-control"
                                                    name="semi_truck_with_rim" value="{{ old('semi_truck_with_rim') }}"
                                                    autofocus>
                                            </div>
                                        </div>

                                        {{-- End quanittys of typres of truck tires --}}

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Types of Agri Tires</label>
                                                <select multiple="multiple" id="agri_tires_type" name="agri_tires_type[]"
                                                    class="js-example-basic-multiple form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="ag_med_truck_19_5_skid_steer">AG Med Truck 19.5/ Skid
                                                        Steer
                                                    </option>
                                                    <option value="ag_med_truck_19_5_with_rim">AG Med Truck 19.5/ with Rim
                                                    </option>
                                                    <option value="farm_tractor_last_two_digits">Farm Tractor $1.25 per,
                                                        Last two digits</option>

                                                </select>
                                            </div>
                                        </div>

                                        {{-- quantitys of types of agri tires --}}

                                        <div id="colag_med_truck_19_5_skid_steer" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of AG Med Truck 19.5/ Skid Steer</label>
                                                <input id="ag_med_truck_19_5_skid_steer" type="text"
                                                    class="form-control" name="ag_med_truck_19_5_skid_steer"
                                                    value="{{ old('ag_med_truck_19_5_skid_steer') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colag_med_truck_19_5_with_rim" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of AG Med Truck 19.5/ with Rim</label>
                                                <input id="ag_med_truck_19_5_with_rim" type="text"
                                                    class="form-control" name="ag_med_truck_19_5_with_rim"
                                                    value="{{ old('ag_med_truck_19_5_with_rim') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="colfarm_tractor_last_two_digits" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of Farm Tractor $1.25 per, Last two digits</label>
                                                <input id="farm_tractor_last_two_digits" type="text"
                                                    class="form-control" name="farm_tractor_last_two_digits"
                                                    value="{{ old('farm_tractor_last_two_digits') }}" autofocus>
                                            </div>
                                        </div>

                                        {{-- End quanittys of typres of agri tires --}}




                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Types of OTR Tires</label>
                                                <select multiple="multiple" id="otr_tires_type" name="otr_tires_type[]"
                                                    class="js-example-basic-multiple form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="15_5_24">15.5-25</option>
                                                    <option value="17_5_25">17.5-25 (Radial)</option>
                                                    <option value="20_5_25">20.5-25 (Radial)</option>
                                                    <option value="23_5_25">23.5-25 (Radial)</option>
                                                    <option value="26_5_25">26.5-25 (Radial)</option>
                                                    <option value="29_5_25">29.5-25 (Radial)</option>
                                                    <option value="24_00R35">24.00R35</option>
                                                    <option value="13_00_24">13.00-24</option>
                                                    <option value="14_00_24">14.00-24 (Radial)</option>
                                                    <option value="19_5L_24">19.5L-24</option>
                                                    <option value="18_4_30">18.4-30</option>
                                                    <option value="18_4_38">18.4-38</option>
                                                    <option value="520_80R46">520/80R46</option>
                                                    <option value="480_80R50">480/80R50</option>
                                                    <option value="710_70R43">710/70R43</option>
                                                    <option value="odd_tire">Odd Tire/ Inches</option>

                                                </select>
                                            </div>
                                        </div>
                                        {{-- quantitys of types of otr tires --}}


                                        <div id="col15_5_24" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 15_5_24</label>
                                                <input id="15_5_24" type="text" class="form-control" name="15_5_24"
                                                    value="{{ old('15_5_24') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col17_5_25" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 17.5-25 (Radial)</label>
                                                <input id="17_5_25" type="text" class="form-control" name="17_5_25"
                                                    value="{{ old('17_5_25') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col20_5_25" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 20.5-25 (Radial)</label>
                                                <input id="20_5_25" type="text" class="form-control" name="20_5_25"
                                                    value="{{ old('20_5_25') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col23_5_25" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 23.5-25 (Radial)</label>
                                                <input id="23_5_25" type="text" class="form-control" name="23_5_25"
                                                    value="{{ old('23_5_25') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col29_5_25" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 29_5-25 (Radial)</label>
                                                <input id="29_5_25" type="text" class="form-control" name="29_5_25"
                                                    value="{{ old('29_5_25') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col24_00R35" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 24.00R35</label>
                                                <input id="24_00R35" type="text" class="form-control"
                                                    name="24_00R35" value="{{ old('24_00R35') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col13_00_24" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 13.00-24</label>
                                                <input id="13_00_24" type="text" class="form-control"
                                                    name="13_00_24" value="{{ old('13_00_24') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col14_00_24" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 14.00-24 (Radial)</label>
                                                <input id="14_00_24" type="text" class="form-control"
                                                    name="14_00_24" value="{{ old('14_00_24') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col19_5L_24" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 19.5L-24</label>
                                                <input id="19_5L_24" type="text" class="form-control"
                                                    name="19_5L_24" value="{{ old('19_5L_24') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col18_4_30" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 18.4-30</label>
                                                <input id="18_4_30" type="text" class="form-control" name="18_4_30"
                                                    value="{{ old('18_4_30') }}" autofocus>
                                            </div>
                                        </div>

                                        <div id="col18_4_38" class="col-lg-6 d-none">
                                            <div class="form-group">
                                                <label>No of 18.4-38</label>
                                                <input id="18_4_38" type="text" class="form-control" name="18_4_38"
                                                    value="{{ old('18_4_38') }}" autofocus>
                                            </div>
                                        </div>

                                        {{-- End quanittys of typres of otr tires --}}

                                        <div id="" class="col-lg-6 ">
                                            <div class="form-group">
                                                <label> Payment Type</label>

                                                <input id="" type="text" class="form-control"
                                                    name="payment_type" value="" autofocus>
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Payment Type</label>
                                                <select id="payment_type" name="payment_type"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" disabled>Please select payment type</option>
                                                    <option value="CreditCard">Credit Card</option>
                                                    <option value="Cheque">Check</option>
                                                    <option value="Credit Card on File">Credit Card on File</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Charge">Charge</option>

                                                </select>
                                            </div>
                                        </div> --}}



                                        {{-- <div class="col-lg-6 " id="">
                                            <div class="form-group">
                                                <label>Do you want us back?</label>
                                                <select id="" name="want_back"
                                                class="form-control form-select form-select-lg mb-3"
                                                aria-label=".form-select-lg example">
                                                <option value="no">No</option>
                                                <option value="yes">yes</option>
                                            </select>
                                            </div>
                                        </div> --}}


                                        <div class="col-lg-6 d-none" id="chequeCol">
                                            <div class="form-group">
                                                <label>Cheque No (If any)</label>
                                                <input id="cheque_no" type="text" class="form-control"
                                                    name="cheque_no" value="{{ old('cheque_no') }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 d-none" id="cashCol">
                                            <div class="form-group">
                                                <label>Cash Counted</label>
                                                <input id="cash" type="text" class="form-control" name="cash"
                                                    value="{{ old('cash') }}" autofocus>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let firstTimeSubmitted = false;
        $('#payment_type').on('change', function() {
            const selectedPaymentType = $(this).val();
            if (selectedPaymentType == 'Cheque') {
                $('#chequeCol').removeClass('d-none');
                $('#cashCol').addClass('d-none');
            } else if (selectedPaymentType === 'Cash') {
                $('#chequeCol').addClass('d-none');
                $('#cashCol').removeClass('d-none');
            } else {
                $('#chequeCol').addClass('d-none');
                $('#cashCol').addClass('d-none');

            }
        });
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });

        $('#passanger_tyres_type').on('select2:select', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case 'lawnmowers_atvmotorcycle':
                    $('#collawnmowersatvmotorcycle').removeClass('d-none');
                    break;
                case 'lawnmowers_atvmotorcyclewithrim':
                    $('#collawnmowers_atvmotorcyclewithrim').removeClass('d-none');
                    break;
                case 'passanger_lighttruck':
                    $('#colpassanger_lighttruck').removeClass('d-none');
                    break;
                case 'passanger_lighttruckwithrim':
                    $('#colpassanger_lighttruckwithrim').removeClass('d-none');
                    break;
            }
        });

        $('#passanger_tyres_type').on('select2:unselect', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case 'lawnmowers_atvmotorcycle':
                    $('#collawnmowersatvmotorcycle').addClass('d-none');
                    $('#lawnmowersatvmotorcycle').val();
                    break;
                case 'lawnmowers_atvmotorcyclewithrim':
                    $('#collawnmowers_atvmotorcyclewithrim').addClass('d-none');
                    $('#lawnmowers_atvmotorcyclewithrim').val();
                    break;
                case 'passanger_lighttruck':
                    $('#colpassanger_lighttruck').addClass('d-none');
                    $('#passanger_lighttruck').val();
                    break;
                case 'passanger_lighttruckwithrim':
                    $('#colpassanger_lighttruckwithrim').addClass('d-none');
                    $('#passanger_lighttruckwithrim').val();
                    break;
            }
        });


        $('#truck_tyres_type').on('select2:select', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case 'semi_truck':
                    $('#colsemitruck').removeClass('d-none');
                    break;
                case 'semi_super_singles':
                    $('#colsemisupersingles').removeClass('d-none');
                    break;
                case 'semi_truck_with_rim':
                    $('#colsemitruckwithrim').removeClass('d-none');
                    break;

            }
        });

        $('#truck_tyres_type').on('select2:unselect', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case 'semi_truck':
                    $('#colsemitruck').addClass('d-none');
                    $('#semi_truck').val();
                    break;
                case 'semi_super_singles':
                    $('#colsemisupersingles').addClass('d-none');
                    $('#semi_super_singles').val();
                    break;
                case 'semi_truck_with_rim':
                    $('#colsemitruckwithrim').addClass('d-none');
                    $('#semi_truck_with_rim').val();
                    break;
            }
        });

        $('#agri_tires_type').on('select2:select', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case 'ag_med_truck_19_5_skid_steer':
                    $('#colag_med_truck_19_5_skid_steer').removeClass('d-none');
                    break;
                case 'ag_med_truck_19_5_with_rim':
                    $('#colag_med_truck_19_5_with_rim').removeClass('d-none');
                    break;
                case 'farm_tractor_last_two_digits':
                    $('#colfarm_tractor_last_two_digits').removeClass('d-none');
                    break;

            }
        });

        $('#agri_tires_type').on('select2:unselect', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case 'ag_med_truck_19_5_skid_steer':
                    $('#colag_med_truck_19_5_skid_steer').addClass('d-none');
                    $('#ag_med_truck_19_5_skid_steer').val();
                    break;
                case 'ag_med_truck_19_5_with_rim':
                    $('#colag_med_truck_19_5_with_rim').addClass('d-none');
                    $('#ag_med_truck_19_5_with_rim').val();
                    break;
                case 'farm_tractor_last_two_digits':
                    $('#colfarm_tractor_last_two_digits').addClass('d-none');
                    $('#farm_tractor_last_two_digits').val();
                    break;
            }
        });

        $('#otr_tires_type').on('select2:select', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case '15_5_24':
                    $('#col15_5_24').removeClass('d-none');
                    break;
                case '17_5_25':
                    $('#col17_5_25').removeClass('d-none');
                    break;
                case '20_5_25':
                    $('#col20_5_25').removeClass('d-none');
                    break;
                case '23_5_25':
                    $('#col23_5_25').removeClass('d-none');
                    break;

                case '26_5_25':
                    $('#col26_5_25').removeClass('d-none');
                    break;

                case '29_5_25':
                    $('#col29_5_25').removeClass('d-none');
                    break;

                case '24_00R35':
                    $('#col24_00R35').removeClass('d-none');
                    break;

                case '13_00_24':
                    $('#col13_00_24').removeClass('d-none');
                    break;

                case '14_00_24':
                    $('#col14_00_24').removeClass('d-none');
                    break;


            }
        });

        $('#otr_tires_type').on('select2:unselect', function(e) {
            var data = e.params.data;
            switch (data.id) {
                case '15_5_24':
                    $('#col15_5_24').addClass('d-none');
                    $('#col15_5_24').val();
                    break;
                case '17_5_25':
                    $('#col17_5_25').addClass('d-none');
                    $('#17_5_25').val();
                    break;
                case '20_5_25':
                    $('#col20_5_25').addClass('d-none');
                    $('#20_5_25').val();
                    break;
                case '23_5_25':
                    $('#col20_5_25').addClass('d-none');
                    $('#20_5_25').val();
                    break;
                case '26_5_25':
                    $('#col26_5_25').addClass('d-none');
                    $('#26_5_25').val();
                    break;
                case '29_5_25':
                    $('#col29_5_25').addClass('d-none');
                    $('#29_5_25').val();
                    break;
                case '24_00R35':
                    $('#col24_00R35').addClass('d-none');
                    $('#24_00R35').val();
                    break;
                case '13_00_24':
                    $('#col13_00_24').addClass('d-none');
                    $('#13_00_24').val();
                    break;

                case '14_00_24':
                    $('#col14_00_24').addClass('d-none');
                    $('#14_00_24').val();
                    break;


            }
        });


    </script>
@endsection
