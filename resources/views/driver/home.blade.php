@extends('layouts.app')

@section('content')
<div class="page-content-wrapper " >
    <div class="container-fluid" >
        <div class="row">
            <div class="col-12 mt-5">
                <div class="logo text-center ">
                    <img src="{{asset('logo.jpeg')}}" alt="">
                    <div class="mt-5">
                        <h4>Good Morning {{Auth::user()->name}} You are a rockstar! Anetra and Gary appreciate you!</h4>
                        <h2>Please Be Safe!</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div><!-- container-fluid -->
</div>
@endsection