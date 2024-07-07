@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <div class="p-20">
                                <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Business Name</label>
                                                <input id="business_name" type="text"
                                                    class="form-control @error('business_name') is-invalid @enderror"
                                                    name="business_name" value="{{ $customer->business_name }}" autofocus>
                                                @error('business_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Mailing Address</label>
                                                <input id="mail_address" type="text"
                                                    class="form-control @error('mail_address') is-invalid @enderror"
                                                    name="mail_address" value="{{ $customer->mail_address }}">
                                                @error('mail_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>No to Physical Address</label>
                                                <input id="address" type="text"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    name="address" value="{{ $customer->address }}">

                                                @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Phone #</label>
                                                <input id="phone_no" value="{{ $customer->phone_no }}" type="text"
                                                    class="form-control @error('phone_no') is-invalid @enderror"
                                                    name="phone_no">

                                                @error('phone_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Company Registration#</label>
                                                <input id="company_registration"
                                                    value="{{ $customer->company_registration }}" type="text"
                                                    class="form-control @error('company_registration') is-invalid @enderror"
                                                    name="company_registration">

                                                @error('company_registration')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>POC Name</label>
                                                <input id="poc_name" type="text"
                                                    class="form-control @error('poc_name') is-invalid @enderror"
                                                    name="poc_name" value="{{ $customer->poc_name }}" autofocus>
                                                @error('poc_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>POC Email</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                                    value="{{ $customer->email }}" autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>RTD Location</label>
                                                <select name="rtd_location" class="form-control" id="">
                                                    <option value="rtd_central"
                                                        {{ $customer->rtd_location == 'rtd_central' ? 'selected' : '' }}>
                                                        RTD Central </option>
                                                    <option value="rtd_south"
                                                        {{ $customer->rtd_location == 'rtd_south' ? 'selected' : '' }}>RTD
                                                        South</option>
                                                </select>
                                                @error('rtd_location')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>A/P Phone No</label>
                                                <input id="mail_phone" type="text"
                                                    class="form-control @error('mail_phone') is-invalid @enderror"
                                                    name="mail_phone" value="{{ $customer->mail_phone }}">
                                                @error('mail_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>




                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>A/P Email</label>
                                                <input id="second_mail" type="text"
                                                    class="form-control @error('second_mail') is-invalid @enderror"
                                                    name="second_mail" value="{{ $customer->second_mail }}"
                                                    autocomplete="email">
                                                @error('second_mail')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Charge Type</label>
                                                <select name="charge_type" class="form-control" id="">
                                                    <option value="" disabled>Please select Charge Type</option>
                                                    <option value="creditcard"
                                                        {{ $customer->charge_type == 'creditcard' ? 'selected' : '' }}>
                                                        Credit Card</option>
                                                    <option value="cc on file"
                                                        {{ $customer->charge_type == 'cc on file' ? 'selected' : '' }}>CC
                                                        On File</option>
                                                    <option value="cc call in"
                                                        {{ $customer->charge_type == 'cc call in' ? 'selected' : '' }}>CC
                                                        Call in</option>
                                                    <option value="cheque"
                                                        {{ $customer->charge_type == 'cheque' ? 'selected' : '' }}>Check
                                                    </option>
                                                    <option value="charge"
                                                        {{ $customer->charge_type == 'charge' ? 'selected' : '' }}>Charge
                                                    </option>
                                                    <option value="cash"
                                                        {{ $customer->charge_type == 'cash' ? 'selected' : '' }}>Cash
                                                    </option>

                                                </select>
                                                @error('charge_type')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Tax</label>
                                                <input id="tax" type="number" step="0.01"
                                                    class="form-control @error('tax') is-invalid @enderror" name="tax"
                                                    value="{{ $customer->tax }}" autofocus>
                                                @error('tax')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>






                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Convenience Fee
                                                </label>
                                                <input id="convenienceFee" step="0.1" type="number"
                                                    class="form-control @error('convenienceFee') is-invalid @enderror"
                                                    name="convenienceFee" value="{{ $customer->convenienceFee }}"
                                                    autocomplete="email">
                                                @error('convenienceFee')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="earlierPT">Earliest Pick Up Time
                                                </label>
                                                <input id="earlierPT" type="time"
                                                    class="form-control @error('earlierPT') is-invalid @enderror"
                                                    name="earlierPT" value="{{ $customer->earlierPT }}"
                                                    autocomplete="email">
                                                @error('earlierPT')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>PO#
                                                </label>
                                                <input id="po" type="text"
                                                    class="form-control @error('po') is-invalid @enderror" name="po"
                                                    value="{{ $customer->po }}" autocomplete="email">
                                                @error('po')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Select Color
                                                </label>
                                                <input id="po" type="color" value="{{ $customer->color }}"
                                                    name="color">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Trailer Gradation Type</label>
                                                <select id="" name="trailer_grading_type" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value="" selected disabled>Please select</option>
                                                    <option value="trailers_to_grade">Trailers To Grade</option>
                                                    <option value="trailers_green_light">Trailers Green Light</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Please Select Truck</label>
                                                <select id="truck" name="truck_id" class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                                    <option value=""  selected>Please select Truck</option>
                                                    @foreach ($trucks as $truck)
                                                    <option value="{{$truck->id}}"  {{$customer->truck_id === $truck->id ? 'selected' : ''}}>{{($truck->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Trailer Duration
                                                </label>
                                                <input id="" type="number"
                                                    class="form-control @error('trailer_duration') is-invalid @enderror"
                                                    name="trailer_duration" value="{{ old('trailer_duration') }}">
                                                @error('trailer_duration')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
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
