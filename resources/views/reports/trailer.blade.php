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
                                                <th>Location</th>
                                                <th>Trailer Going</th>
                                                <th>Customer</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($locationTrailers as $trailer)
                                                @if (in_array(strtolower($trailer->trailer_going), ['burnet', 'victoria', 'cemex','customer']))
                                                    <tr data-trailer-id="{{ $trailer->id }}">
                                                        <td>{{ $trailer->name }}</td>
                                                        <td>{{ $trailer->location }}</td>
                                                        <td>{{ $trailer->trailer_going ?? 'N/A' }}</td>
                                                        <td>{{ $trailer->customerData->business_name ?? 'N/A' }}</td>
                                                        <td>{{ $trailer->status }}</td>
                                                        <td>
                                                            <a href="{{ route('trailer.delete', $trailer->id) }}"
                                                                class="btn btn-danger btn-sm">Delete</a>
                                                            <button class="btn btn-info btn-sm change-status"
                                                                data-trailer-id="{{ $trailer->id }}">Edit</button>
                                                        </td>
                                                    </tr>
                                                @endif
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

    <!-- Update Trailer Modal -->
    <div class="modal fade" id="updateTrailerModal" tabindex="-1" aria-labelledby="updateTrailerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTrailerModalLabel">Update Trailer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.trailer.data') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trailer_id" id="trailer_id">
                        <div class="form-group">
                            <label for="statusData" class="col-form-label">Status</label>
                            {{-- <input type="text" class="form-control" name="statusData" id="statusData"> --}}
                            <select class="form-control" name="statusData" id="statusData">
                                <option value="FULL">FULL</option>
                                <option value="FULL/GRADE">FULL/GRADE</option>
                                <option value="FULL/NO GRADE">FULL/NO GRADE</option>
                                <option value="FULL/SHIP TO CEMEX">FULL/SHIP TO CEMEX</option>
                                <option value="FULL/SHIP TO RTDC">FULL/SHIP TO RTDC</option>
                                <option value="EMPTY">EMPTY</option>
                                <option value="OOS/FULL">OOS/FULL</option>
                                <option value="OOS/EMPTY">OOS/EMPTY</option>
                                <option value="STEEL">STEEL</option>
                                <option value="TDF">TDF</option>
                                <option value="ONSITE">ONSITE</option>
                                <option value="CEMEX/FULL">CEMEX/FULL</option>
                                <option value="CEMEX/EMPTY">CEMEX/EMPTY</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-form-label">Location:</label>
                            <input type="text" class="form-control" name="location" id="location">
                        </div>
                        <div class="form-group">
                            <label for="customer" class="col-form-label">Select Customer</label>
                            <select name="customer" class="form-control">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="trailer_going">Trailer Going</label>
                            <select id="trailer_going" name="trailer_going"
                                class="form-control form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                                <option value="" disabled>Please select where the trailer is going</option>
                                <option value="Burnet" {{ $trailer->trailer_going === 'Burnet' ? 'selected' : '' }}>Burnet
                                </option>
                                <option value="Victoria" {{ $trailer->trailer_going === 'Victoria' ? 'selected' : '' }}>
                                    Victoria</option>
                                <option value="CUSTOMER" {{ $trailer->trailer_going === 'CUSTOMER' ? 'selected' : '' }}>
                                    CUSTOMER</option>
                                <option value="Cemex" {{ $trailer->trailer_going === 'Cemex' ? 'selected' : '' }}>Cemex
                                </option>
                            </select>
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

    <!-- Add New Trailer Modal -->
    <div class="modal fade" id="addNewTrailerModal" tabindex="-1" aria-labelledby="addNewTrailerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewTrailerModalLabel">Add New Trailer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('trailer.store') }}" method="POST">
                        @csrf

                        <!-- Trailer Name -->
                        <div class="form-group">
                            <label for="name">Trailer Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <!-- Select Customer -->
                        <div class="form-group">
                            <label for="customer" class="col-form-label">Select Customer</label>
                            <select name="customer" id="customer" class="form-control" required>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->business_name }}</option>
                                @endforeach
                            </select>
                        </div>



                        <!-- Location -->
                        <div class="form-group">
                            <label for="location" class="col-form-label">Location:</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="statusss" class="col-form-label">Status</label>
                            <select class="form-control" name="status" id="" required>
                                <option value="">Please select</option>
                                <option value="FULL">FULL</option>
                                <option value="FULL/GRADE">FULL/GRADE</option>
                                <option value="FULL/NO GRADE">FULL/NO GRADE</option>
                                <option value="FULL/SHIP TO CEMEX">FULL/SHIP TO CEMEX</option>
                                <option value="FULL/SHIP TO RTDC">FULL/SHIP TO RTDC</option>
                                <option value="EMPTY">EMPTY</option>
                                <option value="OOS/FULL">OOS/FULL</option>
                                <option value="OOS/EMPTY">OOS/EMPTY</option>
                                <option value="STEEL">STEEL</option>
                                <option value="TDF">TDF</option>
                                <option value="ONSITE">ONSITE</option>
                                <option value="CEMEX/FULL">CEMEX/FULL</option>
                                <option value="CEMEX/EMPTY">CEMEX/EMPTY</option>
                            </select>
                        </div>

                        <!-- Trailer Going -->
                        <div class="form-group">
                            <label for="trailer_going" class="col-form-label">Trailer Going</label>
                            <select name="trailer_going" id="trailer_going" class="form-control" required>
                                <option value="" disabled>Please select where trailer is going</option>
                                <option value="Burnet">Burnet</option>
                                <option value="Victoria">Victoria</option>
                                <option value="CUSTOMER">CUSTOMER</option>
                                <option value="Cemex">Cemex</option>
                            </select>
                        </div>

                        <!-- Modal Footer -->
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
        $(document).ready(function() {
            $('#trailersTable').DataTable(); // Initialize DataTable

            $('.change-status').on('click', function() {
                var trailerId = $(this).data('trailer-id');
                $('#trailer_id').val(trailerId);
                $('#updateTrailerModal').modal('show');
            });

            $('#addNewTrailer').on('click', function() {
                $('#addNewTrailerModal').modal('show');
            });
        });
    </script>
@endsection
