@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
    rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('signature.js')}}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="{{asset('signature.css')}}">

<style>
    .kbw-signature {
        width: 100%;
        height: 200px;
    }

    #sig canvas {
        width: 100% !important;
        height: auto;
    }
</style>
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

                            <form action="{{route('fulfillorder.store')}}" method="POST">
                                @csrf

                                <div class="row">
                                    <input type="hidden" value="{{$order->id}}" name="order_id">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Company Registration</label>
                                            <select id="company_reg" name="company_reg"
                                                class="form-control form-select form-select-lg mb-3"
                                                aria-label=".form-select-lg example">
                                                <option value="" disabled>Please select Registration No</option>
                                                @foreach ($registrationNos as $registrationNo)
                                                <option value="{{$registrationNo->registrationNo}}">
                                                    {{($registrationNo->reg_no)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Passenger Tires</label>
                                            <input id="passenger_tire" type="text" class="form-control"
                                                name="passenger_tire" value="{{ old('passenger_tire') }}" autofocus>
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
                                            <label>Lawnmowers/ATVMotorcycle With Rim</label>
                                            <input id="lawnmowers_atvmotorcyclewithrim" type="text" class="form-control"
                                                name="lawnmowers_atvmotorcyclewithrim"
                                                value="{{ old('lawnmowers_atvmotorcyclewithrim') }}" autofocus>
                                        </div>
                                    </div>

                                    <div id="colpassanger_lighttruck" class="col-lg-6 d-none">
                                        <div class="form-group">
                                            <label>Passanger/Light truck</label>
                                            <input id="passanger_lighttruck" type="text" class="form-control"
                                                name="passanger_lighttruck" value="{{ old('passanger_lighttruck') }}"
                                                autofocus>
                                        </div>
                                    </div>

                                    <div id="colpassanger_lighttruckwithrim" class="col-lg-6 d-none">
                                        <div class="form-group">
                                            <label>Passanger/Light truck with Rim</label>
                                            <input id="passanger_lighttruckwithrim" type="text" class="form-control"
                                                name="passanger_lighttruckwithrim"
                                                value="{{ old('passanger_lighttruckwithrim') }}" autofocus>
                                        </div>
                                    </div>

                                    {{-- END quantitys of types of passanger tires --}}


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Truck Tires</label>
                                            <input id="truck_tire" type="text" class="form-control" name="truck_tire"
                                                value="{{ old('truck_tire') }}" autofocus>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Types of Truck Tires</label>
                                            <select multiple="multiple" id="truck_tyres_type" name="truck_tyres_type[]"
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
                                            <input id="semi_truck" type="text" class="form-control" name="semi_truck"
                                                value="{{ old('semi_truck') }}" autofocus>
                                        </div>
                                    </div>

                                    <div id="colsemisupersingles" class="col-lg-6 d-none">
                                        <div class="form-group">
                                            <label>Semi Super Singles</label>
                                            <input id="semi_super_singles" type="text" class="form-control"
                                                name="semi_super_singles" value="{{ old('semi_super_singles') }}"
                                                autofocus>
                                        </div>
                                    </div>

                                    <div id="colsemitruckwithrim" class="col-lg-6 d-none">
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

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Cheque No (If any)</label>
                                            <input id="cheque_no" type="text" class="form-control" name="cheque_no"
                                                value="{{ old('cheque_no') }}" autofocus>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Start Weight</label>
                                            <input id="start_weight" type="text" class="form-control"
                                                name="start_weight" value="{{ old('start_weight') }}" autofocus>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>End Weight</label>
                                            <input id="end_weight" type="text" class="form-control" name="end_weight"
                                                value="{{ old('end_weight') }}" autofocus>
                                        </div>
                                    </div>



                                    {{-- <div class="col-md-6">
                                        <label class="" for="">Drivers Signature:</label>
                                        <br />
                                        <div id="sig"></div>
                                        <br />
                                        <button id="clear" class="btn btn-danger btn-sm">Clear</button>
                                        <textarea id="signature64" name="signed" style="display: none"></textarea>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <label class="" for="">Customer Signature:</label>
                                        <br />
                                        <div id="sig"></div>
                                        <br />
                                        <button id="clear" class="btn btn-danger btn-sm">Clear</button>
                                        <textarea id="signature64" name="signed" style="display: none"></textarea>
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

    <script type="text/javascript">
        var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
            $('#clear').click(function(e) {
                e.preventDefault();
                sig.signature('clear');
                $("#signature64").val('');
            });
    </script>
</div>


@endsection
@section('pageSpecificJs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

$('#passanger_tyres_type').on('select2:select', function (e) {
    var data = e.params.data;
    switch(data.id){
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

$('#passanger_tyres_type').on('select2:unselect', function (e) {
    var data = e.params.data;
    switch(data.id){
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


$('#truck_tyres_type').on('select2:select', function (e) {
    var data = e.params.data;
    switch(data.id){
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

$('#truck_tyres_type').on('select2:unselect', function (e) {
    var data = e.params.data;
    switch(data.id){
        case 'semi_truck':
            $('#colsemitruck').addClass('d-none');
            $('#semi_truck').addClass('d-none');
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
</script>
@endsection