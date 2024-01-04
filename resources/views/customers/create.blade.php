@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Add CX Here</h4>
                            <p class="text-muted m-b-30 font-14">Fill This instructions Carefully.</p> 
                                    @if (Session::has('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ Session::get('success')}}
                                        </div>
                                    @endif
                                    <div class="p-20">
                                        <form action="{{route('customer.store')}}" method="POST" >
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label>Business Name</label>
                                                        <input id="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror" name="business_name" value="{{ old('business_name') }}" required autofocus>
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
                                                        <input id="mail_address" type="text" class="form-control @error('mail_address') is-invalid @enderror" name="mail_address" value="{{ old('mail_address') }}" >
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
                                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required >

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
                                                        <input id="phone_no" type="text" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no" required>

                                                        @error('phone_no')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                        
                                                    </div>
                                            </div>                                           
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>POC Name</label>
                                                    <input id="poc_name" type="text" class="form-control @error('poc_name') is-invalid @enderror" name="poc_name" value="{{ old('poc_name') }}" required autofocus>
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
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">
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
                                                        <option value="rtd_central">RTD Central </option>
                                                        <option value="rtd_south">RTD South</option>
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
                                                    <input id="mail_phone" type="text" class="form-control @error('mail_phone') is-invalid @enderror" name="mail_phone" value="{{ old('mail_phone') }}" >
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
                                                    <input id="second_mail" type="text" class="form-control @error('second_mail') is-invalid @enderror" name="second_mail" value="{{ old('second_mail') }}"  autocomplete="email">
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
                                                        <option value="cc on file">CC On File</option>
                                                        <option value="cc call in">CC Call in</option>
                                                        <option value="cheque">Cheque</option>
                                                        <option value="charge">Charge</option>
                                                        <option value="cash">Cash</option>

                                                    </select>
                                                    @error('second_mail')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>  

                                            
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label>Passenger Pricing</label>
                                                    <input id="passenger_pricing" type="text" class="form-control @error('passenger_pricing') is-invalid @enderror" name="passenger_pricing" value="{{ old('passenger_pricing') }}" required autofocus>
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
                                                    <input id="truck_pricing" type="text" class="form-control @error('truck_pricing') is-invalid @enderror" name="truck_pricing" value="{{ old('truck_pricing') }}"  autofocus>
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
                                                    <input id="agri_pricing" type="text" class="form-control @error('agri_pricing') is-invalid @enderror" name="agri_pricing" value="{{ old('agri_pricing') }}"  autofocus>
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
                                                    <input id="other" type="text" class="form-control @error('other') is-invalid @enderror" name="other" value="{{ old('other') }}"  autofocus>
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
                                                    <input id="tax" type="text" class="form-control @error('tax') is-invalid @enderror" name="tax" value="{{ old('tax') }}"  autofocus>
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
                                                    <input id="convenienceFee" type="text" class="form-control @error('convenienceFee') is-invalid @enderror" name="convenienceFee" value="{{ old('convenienceFee') }}"  autocomplete="email">
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
                                                    <input id="earlierPT" type="time" class="form-control @error('earlierPT') is-invalid @enderror" name="earlierPT" value="{{ old('earlierPT') }}"  autocomplete="email">
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
                                                    <input id="po" type="text" class="form-control @error('po') is-invalid @enderror" name="po" value="{{ old('po') }}"  autocomplete="email">
                                                    @error('po')
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
