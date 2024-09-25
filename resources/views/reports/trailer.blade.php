@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <button id="addNewTrailer" class="btn btn-primary mb-5">Add Trailer</button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Trailers Report</h4>
                            
                            @foreach ($trailers as $location => $locationTrailers)
                                <h5 class="mt-4">{{ $location }}</h5> <!-- Section title for location -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Trailer Name</th>
                                                <th>Trailer Going</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($locationTrailers as $trailer)
                                                <tr data-trailer-id="{{ $trailer->id }}">
                                                    <td>{{ $trailer->name }}</td>
                                                    <td>{{ $trailer->trailer_going ?? 'N/A' }}</td>
                                                    <td>{{ $trailer->customer->business_name ?? 'N/A' }}</td>
                                                    <td>{{ $trailer->status }}</td>
                                                    <td>
                                                        <a href="{{ route('trailer.delete', $trailer->id) }}" class="btn btn-danger btn-sm">Delete</a>
                                                        <button class="btn btn-info btn-sm change-status" data-trailer-id="{{ $trailer->id }}">Edit</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- container-fluid -->
    </div>

    <!-- The rest of your modal code remains unchanged -->
@endsection
