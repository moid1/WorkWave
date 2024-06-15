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
                                                        <input id="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror" name="business_name" value="{{ old('business_name') }}"  autofocus>
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
                                                        <input id="location" type="text" class="form-control @error('mail_address') is-invalid @enderror" name="mail_address" value="{{ old('mail_address') }}" >
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
                                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}"  >

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
                                                        <input id="phone_no" type="text" class="form-control @error('phone_no') is-invalid @enderror" name="phone_no" >

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
                                                    <input id="company_registration" type="text" class="form-control @error('company_registration') is-invalid @enderror" name="company_registration" >

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
                                                    <input id="poc_name" type="text" class="form-control @error('poc_name') is-invalid @enderror" name="poc_name" value="{{ old('poc_name') }}"  autofocus>
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
                                                        <option value="creditcard">Credit Card</option>
                                                        <option value="cc on file">CC On File</option>
                                                        <option value="cc call in">CC Call in</option>
                                                        <option value="cheque">Check</option>
                                                        <option value="charge">Charge</option>
                                                        <option value="cash">Cash</option>

                                                    </select>
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
                                                    <label>Tax</label>
                                                    <input id="tax" type="number" step="0.01" class="form-control @error('tax') is-invalid @enderror" name="tax" value="{{ old('tax') }}"  autofocus>
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
                                                    <input id="convenienceFee" step="0.1" type="number" class="form-control @error('convenienceFee') is-invalid @enderror" name="convenienceFee" value="{{ old('convenienceFee') }}"  autocomplete="email">
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
                                                    <label>Select Color
                                                    </label>
                                                    <input id="po" type="color" name="color">
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

<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places">
</script>

<script>
    google.maps.event.addDomListener(window, 'load', initialize);

    function initialize() {
        var input = document.getElementById('location');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place);
        });


        var newINput = document.getElementById('address');
        var newAutoComplete = new google.maps.places.Autocomplete(newINput);

        newAutoComplete.addListener('place_changed', function() {
            var place = newAutoComplete.getPlace();
            console.log(place);
        });

        
    }
</script>

