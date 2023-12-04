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
                                                <label>Date</label>
                                                <input name="date" class="form-control" type = "date" id = "datepicker-13"/>
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

                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>2nd Email</label>
                                                <input readonly id="second_mail" type="email"
                                                    class="form-control "
                                                    name="second_mail" value=""  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>2nd POC</label>
                                                <input readonly id="second_poc" type="text"
                                                    class="form-control "
                                                    name="second_poc" value=""  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Mail Address</label>
                                                <input readonly id="mail_address" type="text"
                                                    class="form-control "
                                                    name="mail_address" value=""  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Charge type</label>
                                                <input readonly id="charge_type" type="text"
                                                    class="form-control "
                                                    name="charge_type" value=""  autofocus>
                                            </div>
                                        </div> --}}

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Load Type</label>
                                                <select id="loadType" name="load_type" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value="box">Box</option>
                                                    <option value="swap">Swap</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 box">
                                            <div class="form-group ">
                                                <label>Box Value</label>
                                                <input  id="boxAmount" type="number"
                                                    class="form-control " value="1"
                                                    name="box_amount" max="500"  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 d-none swap">
                                            <div class="form-group ">
                                                <label>Swap</label>
                                                <input  id="swap" type="number"
                                                readonly
                                                    class="form-control "
                                                    name="swap_amount" min="1" max="1" value="1"  autofocus>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>ServiceTime (Seconds)</label>
                                                <input  type="number"
                                                    class="form-control "
                                                    name="serviceTime" value=""  autofocus>
                                            </div>
                                        </div>

                                        
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Driver</label>
                                                <select id="driver" name="driver_id" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    @foreach ($drivers as $driver)
                                                        
                                                   
                                                    <option value="{{$driver->id}}">{{ucfirst($driver->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12  ">
                                            <div class="form-group ">
                                                <label>Notes</label>
                                             <textarea   class="form-control " name="notes" id="notes" cols="30" rows="2"></textarea>
                                            </div>
                                        </div>



                                        {{-- <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Passenger Pricing</label>
                                                <input id="passenger_pricing" type="text"
                                                    class="form-control @error('passenger_pricing') is-invalid @enderror"
                                                    name="passenger_pricing" value="{{ old('passenger_pricing') }}" required
                                                    autofocus>
                                                @error('passenger_pricing')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Truck Pricing</label>
                                                <input id="truck_pricing" type="text"
                                                    class="form-control @error('truck_pricing') is-invalid @enderror"
                                                    name="truck_pricing" value="{{ old('truck_pricing') }}" autofocus>
                                                @error('truck_pricing')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Agri Pricing</label>
                                                <input id="agri_pricing" type="text"
                                                    class="form-control @error('agri_pricing') is-invalid @enderror"
                                                    name="agri_pricing" value="{{ old('agri_pricing') }}" autofocus>
                                                @error('agri_pricing')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Other Pricing</label>
                                                <input id="other" type="text"
                                                    class="form-control @error('other') is-invalid @enderror" name="other"
                                                    value="{{ old('other') }}" autofocus>
                                                @error('other')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Tax</label>
                                                <input id="tax" type="text"
                                                    class="form-control @error('tax') is-invalid @enderror" name="tax"
                                                    value="{{ old('tax') }}" autofocus>
                                                @error('tax')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div> --}}

                                     
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
            // $('#second_poc').val($(this).data('second-poc'));
            // $('#mail_address').val($(this).data('mail-address'));
            // $('#charge_type').val($(this).data('charge-type'));

            $('input[name=customer_id]').val($(this).data('id'));
            $('#product_list').html("");
        });
    });

    $(document).ready(function(){
        $('#loadType').on('change', function() {
       if(this.value === 'swap'){
        $('.swap').removeClass('d-none');
        $('.box').addClass('d-none');

       }else{
        $('.box').removeClass('d-none');
        $('.swap').addClass('d-none');

       }
    });
});

</script>   