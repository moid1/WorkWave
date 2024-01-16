@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
    rel="stylesheet">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="{{ asset('signature.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('signature.css') }}">

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

                        <p class="text-muted m-b-30 font-14">Fill This instructions Carefully.</p>
                        @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        <div class="p-20">



                            <form action="{{route('unfill.fill.order')}}" method="POST">
                                @csrf

                                <div class="row">
                                    <input type="hidden"  name="order_id" value="{{$order->id}}">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Registration No</label>
                                            <input  id="reg_no" type="text" class="form-control" name="reg_no"
                                                value="{{ old('reg_no') }}" autofocus>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Passanger Tires</label>
                                            <input id="passanger_tires" type="text" class="form-control  "
                                                name="passanger_tires" value="{{ old('passanger_tires') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>No of Truck Tires</label>
                                            <input  id="truck_tires" type="text" class="form-control"
                                                name="truck_tires">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Weight of Tires (LBS)</label>
                                            <input id="weight_tire" type="text"
                                                class="form-control @error('weight_tire') is-invalid @enderror"
                                                name="weight_tire" value="{{ old('weight_tire') }}" autofocus>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="" for="">Customer Signature:</label>
                                        <br />
                                        <div id="sig"></div>
                                        <br />
                                        <button id="clear" class="btn btn-danger btn-sm mt-3">Clear</button>
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


</div>

<script type="text/javascript">
    var sig = $('#sig').signature({
        syncField: '#signature64',
        syncFormat: 'PNG'
    });
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature64").val('');
    });
</script>

@endsection

