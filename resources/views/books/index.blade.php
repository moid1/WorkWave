@extends('layouts.app')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

@section('content')
    <div class="page-content-wrapper ">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    @if (Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success')}}
                    </div>
                     @endif
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div><!-- container-fluid -->
    </div>





    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                @foreach ($customers as $customer )
                    <div class="col-lg-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">{{$customer->business_name}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$customer->address}}</h6>
                            <p class="card-text">Click on the links below to find the manifest for this CX</p>
                            <a href="{{route('books.list', $customer->id)}}" class="card-link">Manifests</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

@endsection
