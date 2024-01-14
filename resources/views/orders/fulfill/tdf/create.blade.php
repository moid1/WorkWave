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

                            <h4 class="mt-0 header-title">TDF</h4>

                            <div class="p-20">

                                <form action="{{ route('order.store.tdf') }}" method="POST">
                                    @csrf

                                    <input type="hidden" value="0" name="customer_id" id="#customerID">
                                    <div class="row">

                                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Start Weight</label>
                                                <input id="startWeight" type="number"
                                                    class="form-control  "name="start_weight"
                                                    value="{{ old('start_weight') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>End Weight</label>
                                                <input id="endWeight" type="number" class="form-control  "name="end_weight"
                                                    value="{{ old('end_weight') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Total Weight in LBS</label>
                                                <input id="totalWeight" type="number"
                                                    class="form-control  "name="total_weight_lbs"
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

@section('pageSpecificJs')
    <script>
        $("#startWeight, #endWeight").on("input", function() {
            // Get the values from the input fields
            var startWeight = parseFloat($("#startWeight").val()) || 0;
            var endWeight = parseFloat($("#endWeight").val()) || 0;

            // Calculate the total weight
            var totalWeight = Math.abs(startWeight - endWeight);

            // Update the totalWeight input field
            if(startWeight && endWeight)
                $("#totalWeight").val(totalWeight.toFixed(2)); // You can adjust the decimal places as needed
        });
    </script>
@endsection
