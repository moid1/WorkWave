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
                            <h4 class="mt-0 header-title">FullFil Order</h4>
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
                                                <label>PROCESSOR/RECYCLER Registration No:</label>
                                                <input  id="processor_reg_no" type="text" class="form-control  @error('processor_reg_no') is-invalid @enderror"
                                                    name="processor_reg_no" value="{{ old('processor_reg_no') }}" required
                                                    autofocus>
                                                @error('processor_reg_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>STORAGE/DISPOSAL SITE Registration No
                                                </label>
                                                <input  id="storage_reg_no" type="text" class="form-control @error('storage_reg_nos') is-invalid @enderror"
                                                    name="storage_reg_no" value="{{ old('storage_reg_no') }}" required
                                                    autofocus>
                                                    @error('storage_reg_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Passenger Tires</label>
                                                <input  id="passenger_tire" type="text" class="form-control"
                                                    name="passenger_tire" value="{{ old('passenger_tire') }}" required
                                                    autofocus>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Truck Tires</label>
                                                <input  id="truck_tire" type="text" class="form-control"
                                                    name="truck_tire" value="{{ old('truck_tire') }}" required
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Agri Tires</label>
                                                <input  id="agri_tire" type="text" class="form-control"
                                                    name="agri_tire" value="{{ old('agri_tire') }}" required
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No of Other Tires</label>
                                                <input  id="other_tire" type="text" class="form-control"
                                                    name="other_tire" value="{{ old('other_tire') }}" required
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Tire Type</label>
                                               <select name="" id="">
                                                <option value="">Industial</option>
                                                <option value="">Other Type</option>

                                               </select>
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
                                        <div class="col-md-6">
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

