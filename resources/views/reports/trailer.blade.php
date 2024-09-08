@extends('layouts.app')

@section('content')
    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <button id="addNewTrailer" class="btn btn-primary mb-5"> Add Trailer</button>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">

                <div class="col-12">

                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">Report</h4>
                            <div class="row">
                                <div class="col-lg-2">
                                    <h6>Trailers to Grade</h6>
                                </div>

                                <div class="col-lg-2">
                                    <h6>Location</h6>
                                </div>

                                <div class="col-lg-2">
                                    <h6>Customer</h6>
                                </div>
                                <div class="col-lg-2">
                                    <h6>Status</h6>
                                </div>
                                <div class="col-lg-2">
                                    <h6>Action</h6>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($trailers as $trailer)
                                    <div class="col-lg-2 change-status" data-trailer-swap="{{ $trailer->id }}">
                                        <p>{{ $trailer->name }}</p>
                                    </div>

                                    <div class="col-lg-2">
                                        <p>{{ $trailer->location }}</p>
                                    </div>

                                    <div class="col-lg-2">
                                        @php
                                            $customer = \App\Models\Customer::find($trailer->customer);
                                        @endphp
                                        <p>{{ $customer->business_name }}</p>
                                    </div>
                                    <div class="col-lg-2">
                                        <p>{{ $trailer->status }}</p>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="{{ route('trailer.delete', $trailer->id) }}">Delete</a>
                                    </div>
                                @endforeach
                                {{-- @foreach ($graded as $order)
                                    @if (!empty($order->trailerSwapOrder))
                                        <div class="col-lg-3 change-status"
                                            data-trailer-swap="{{ $order->trailerSwapOrder->id }}">
                                            <p>{{ $order->trailerSwapOrder->trailer_pick_up }}</p>
                                        </div>

                                        <div class="col-lg-3">
                                            <p>{{ $order->trailerSwapOrder->location }}</p>
                                        </div>

                                        <div class="col-lg-3">
                                            <p>{{ $order->customer->business_name }}</p>
                                        </div>
                                        <div class="col-lg-3">
                                            <p>{{ $order->trailerSwapOrder->status }}</p>
                                        </div>
                                    @endif
                                @endforeach --}}
                            </div>
                        </div>
                    </div>


                    {{-- <div class="card m-b-20">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-3">
                                    <h6>Trailers Green Light</h6>
                                </div>

                                <div class="col-lg-3">
                                    <h6>Location</h6>
                                </div>

                                <div class="col-lg-3">
                                    <h6>Customer</h6>
                                </div>
                                <div class="col-lg-3">
                                    <h6>Status</h6>
                                </div>

                                @foreach ($notGraded as $order)
                                    @if (!empty($order->trailerSwapOrder))
                                        <div class="col-lg-3 change-status"
                                            data-trailer-swap="{{ $order->trailerSwapOrder->id }}">
                                            <p>
                                                {{ $order->trailerSwapOrder ? $order->trailerSwapOrder->trailer_pick_up : 'N/A' }}
                                            </p>
                                        </div>

                                        <div class="col-lg-3">
                                            <p>{{ $order->trailerSwapOrder ? $order->trailerSwapOrder->location : 'N/A' }}
                                            </p>
                                        </div>

                                        <div class="col-lg-3">
                                            <p>{{ $order->customer ? $order->customer->business_name : 'N/A' }}</p>
                                        </div>

                                        <div class="col-lg-3">
                                            <p>{{ $order->trailerSwapOrder ? $order->trailerSwapOrder->status : 'N/A' }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    </div> --}}
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

    <div class="modal fade" id="updateTrailerModal" tabindex="-1" aria-labelledby="updateTrailerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTrailerModalLabel">Update Trailer </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.trailer.data') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trailer_id" id="trailer_id">
                        <div class="form-group">
                            <label for="k" class="col-form-label">Status</label>
                            <input type="text" class="form-control" name="statusData" id="statusData" />

                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Location:</label>
                            <input type="text" class="form-control" name="location" id="location" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addNewTrailerModal" tabindex="-1" aria-labelledby="addNewTrailerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewTrailerModalLabel">Add New Trailer </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('trailer.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Trailer Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="customer" class="col-form-label">Select Customer</label>
                            <select name="customer" class="form-control" id="">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="k" class="col-form-label">Status</label>
                            <input type="text" class="form-control" name="status" id="statusData" />

                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Location:</label>
                            <input type="text" class="form-control" name="location" id="location" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageSpecificJs')
    <script>
        $('.change-status').on('click', function() {
            $('#trailer_id').val($(this).data('trailer-swap'))
            $('#updateTrailerModal').modal('show');
        });

        $('#addNewTrailer').on('click', function() {
            $('#addNewTrailerModal').modal('show');
        })
    </script>
@endsection
