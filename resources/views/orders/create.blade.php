@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Create Order</h4>
                            <p class="text-muted m-b-30 font-14">Fill This instructions Carefully.</p>
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search Customers"
                                                id="search">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/af2f34c3.svg"
                                                        alt="">
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                    <div id="product_list"></div>

                                </div>

                                <form action="{{route('order.store')}}" method="POST">
                                    @csrf

                                <input type="hidden" value="0" name="customer_id" id="#customerID">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Business Name</label>
                                                <input readonly id="business_name" type="text" class="form-control"
                                                    name="business_name" value="{{ old('business_name') }}" required
                                                    autofocus>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>From Date</label>
                                                <input name="date" class="form-control" type = "date"  value="<?php echo date('Y-m-d'); ?>"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input name="end_date" class="form-control" type = "date"  value="<?php echo date('Y-m-d'); ?>"/>
                                            </div>
                                        </div>




                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input readonly id="address" type="text"
                                                    class="form-control  "name="address" value="{{ old('address') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Phone #</label>
                                                <input readonly id="phone_no" type="text" class="form-control"
                                                    name="phone_no" required>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>POC Name</label>
                                                <input readonly id="poc_name" type="text"
                                                    class="form-control @error('poc_name') is-invalid @enderror"
                                                    name="poc_name" value="{{ old('poc_name') }}" required autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input readonly id="email" type="email"
                                                    class="form-control "
                                                    name="email" value="" required autofocus>
                                            </div>
                                        </div>

                                     

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Load Type</label>
                                                <select id="loadType" name="load_type" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value="box_truck_route">Box Truck Route</option>
                                                    <option value="trailer_swap">Trailer Swap</option>
                                                    <option value="state">State</option>
                                                    <option value="tdf">TDF</option>
                                                    <option value="steel">Steel</option>
                                                    <option value="flatbed">Flatbed</option>

                                                </select>
                                            </div>
                                        </div>

                                 
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Truck</label>
                                                <select id="truck" name="truck_id" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value=""  selected>Please select Truck</option>
                                                    @foreach ($trucks as $truck)
                                                    <option value="{{$truck->id}}">{{($truck->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Spoke With</label>
                                               <input type="text" name="spoke_with" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Estimated Tires</label>
                                               <input type="text" name="estimated_tires" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Want to create Order</label>
                                                <select id="" name="create_order" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value="createOrder">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-lg-6  ">
                                            <div class="form-group ">
                                                <label>Notes</label>
                                             <textarea   class="form-control " name="notes" id="notes" cols="30" rows="2"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <input type="checkbox" id="is_recurring_order" name="is_recurring_order" class="">
                                            <label for="is_recurring_order">Is Recurring Order</label>
                                       
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

<script type="text/javascript">
    $(document).ready(function(){


        function fetchCustomerDetails(customerId) {
        $.ajax({
            url: '{{ route("customer.fetch") }}',
            type: 'GET',
            data: {'customerId': customerId},
            success: function(data) {
                // Populate input fields with customer details
                $('#business_name').val(data.business_name);
                $('#address').val(data.address);
                $('#phone_no').val(data.phone_no);
                $('#poc_name').val(data.poc_name);
                $('#email').val(data.email);
                $('#notes').val(data.notes);
                $('#loadType').val(data.load_type);
                $('input[name=customer_id]').val(data.id);
            }
        });
    }

    var customerId = new URLSearchParams(window.location.search).get('customerId');
    if (customerId) {
        // Fetch customer details if customerId is available
        fetchCustomerDetails(customerId);
    }


        $('#search').on('keyup',function () {
            var query = $(this).val();
            if(query.length<=1){
                return;
            }
            $.ajax({
                url:'{{ route("customer.search") }}',
                type:'GET',
                data:{'name':query},
                success:function (data) {
                    $('#product_list').html(data);
                }
            })
        });
        $(document).on('click', 'li', function(){
            var value = $(this).text();
            $('#business_name').val(value);
            $('#address').val($(this).data('address'));
            $('#phone_no').val($(this).data('phone'));
            $('#poc_name').val($(this).data('poc'));
            $('#email').val($(this).data('email'));
            $('#notes').val($(this).data('lastest-note'));
            $('#loadType').val($(this).data('order-type'));
            $('#truck').val($(this).data('truck-id'))
            // $('#second_poc').val($(this).data('second-poc'));
            // $('#mail_address').val($(this).data('mail-address'));
            // $('#charge_type').val($(this).data('charge-type'));

            $('input[name=customer_id]').val($(this).data('id'));
            $('#product_list').html("");
        });
    });


</script>   