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

                            <h4 class="mt-0 header-title">State</h4>

                            <div class="p-20">
                                
                                <form action="{{ route('order.store.state.weight') }}" method="POST">
                                    @csrf

                                    <input type="hidden" value="{{$order->id}}" name="order_id" >
                                    <div class="row">



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Start Weight</label>
                                                <input type="text" class="form-control  "name="start_weight"
                                                    value="{{ old('start_weight') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>End Weight</label>
                                                <input type="text" class="form-control  "name="end_weight"
                                                    value="{{ old('end_weight') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Total Weight in LBS</label>
                                                <input type="text" class="form-control  "name="total_weight_lbs"
                                                    value="{{ old('total_weight_lbs') }}" required>
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

