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

                            <h4 class="mt-0 header-title">Trailer Swap</h4>
                            <p class="text-muted m-b-30 font-14">Complete This Form Carefully.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <div class="row ml-1">
                                    <p>Customer Name</p>
                                    <p class="ml-3" style="font-weight: bold">{{ $order->customer->business_name }}</p>

                                </div>

                                <form action="{{ route('order.store') }}" method="POST">
                                    @csrf

                                    <input type="hidden" value="0" name="customer_id" id="#customerID">
                                    <div class="row">



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Trailer # Picked Up:</label>
                                                <input type="text" class="form-control  "name="address"
                                                    value="{{ old('trailer_picked_up') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Trailer # Droped:</label>
                                                <input type="text" class="form-control  "name="address"
                                                    value="{{ old('trailer_dropped') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Payment Type</label>
                                                <select id="payment_type" name="payment_type"
                                                    class="form-control form-select form-select-lg mb-3"
                                                    aria-label=".form-select-lg example">
                                                    <option value="" disabled>Please select payment type</option>
                                                    <option value="CreditCard">Credit Card</option>
                                                    <option value="Cheque">Cheque</option>
                                                    <option value="Credit Card on File">Credit Card on File</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Charge">Charge</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 d-none" id="chequeCol">
                                            <div class="form-group">
                                                <label>Cheque No (If any)</label>
                                                <input id="cheque_no" type="text" class="form-control" name="cheque_no"
                                                    value="{{ old('cheque_no') }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 d-none" id="cashCol">
                                            <div class="form-group">
                                                <label>Cash Counted</label>
                                                <input id="cash" type="text" class="form-control" name="cash"
                                                    value="{{ old('cash') }}" autofocus>
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
    </script>
@endsection
