@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">

        <div class="col-md-12">

            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {{Session::get('success')}}
                </div>
            @endif

            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('company.registration.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="reg_no" class="col-md-4 col-form-label text-md-end">{{ __('Registration No') }}</label>

                            <div class="col-md-6">
                                <input id="reg_no" type="text" class="form-control @error('reg_no') is-invalid @enderror" name="reg_no" value="{{ old('reg_no') }}" required autocomplete="reg_no" autofocus>

                                @error('reg_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- DATATABLE --}}


    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
    
                            <h4 class="mt-0 header-title">All Registration No</h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                     
                                        <th>ID</th>
                                        <th>Registration No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
    
    
                                <tbody>
                                    @foreach ($companyReg as $reg)
                                    <tr>
                                        <td>{{$reg->id}}</td>
                                        <td>{{$reg->reg_no}}</td>
                                        <td><a href="{{route('company.registration.delete', $reg->id)}}" class="mdi mdi-delete"></a></td>
                                        
        
                                    </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

@endsection
