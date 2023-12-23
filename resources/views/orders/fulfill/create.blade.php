@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css" rel="stylesheet"> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{asset('signature.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('signature.css')}}">

<style>
    .kbw-signature { width: 100%; height: 200px;}
    #sig canvas{
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
                                                    <select id="company_reg" name="company_reg" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                        <option value=""  disabled>Please select Registration No</option>
                                                        @foreach ($registrationNos as $registrationNo)
                                                        <option value="{{$registrationNo->registrationNo}}">{{($registrationNo->reg_no)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Passenger Tires</label>
                                                <input  id="passenger_tire" type="text" class="form-control"
                                                    name="passenger_tire" value="{{ old('passenger_tire') }}" 
                                                    autofocus>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Truck Tires</label>
                                                <input  id="truck_tire" type="text" class="form-control"
                                                    name="truck_tire" value="{{ old('truck_tire') }}" 
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Agri Tires</label>
                                                <input  id="agri_tire" type="text" class="form-control"
                                                    name="agri_tire" value="{{ old('agri_tire') }}" 
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Other Tires</label>
                                                <input  id="other_tire" type="text" class="form-control"
                                                    name="other_tire" value="{{ old('other_tire') }}" 
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Cheque No (If any)</label>
                                                <input  id="cheque_no" type="text" class="form-control"
                                                    name="cheque_no" value="{{ old('cheque_no') }}" 
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Start Weight</label>
                                                <input  id="start_weight" type="text" class="form-control"
                                                    name="start_weight" value="{{ old('start_weight') }}" 
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>End Weight</label>
                                                <input  id="end_weight" type="text" class="form-control"
                                                    name="end_weight" value="{{ old('end_weight') }}" 
                                                    autofocus>
                                            </div>
                                        </div>

               
                                   
                                        {{-- <div class="col-md-6">
                                            <label class="" for="">Drivers Signature:</label>
                                            <br/>
                                            <div id="sig" ></div>
                                            <br/>
                                            <button id="clear" class="btn btn-danger btn-sm">Clear</button>
                                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                                        </div> --}}
                                        <div class="col-md-12">
                                            <label class="" for="">Customer Signature:</label>
                                            <br/>
                                            <div id="sig" ></div>
                                            <br/>
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

