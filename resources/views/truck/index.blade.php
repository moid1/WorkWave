@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">

        <div class="col-md-12">

            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    {{ Session::get('success') }}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    {{ Session::get('error') }}
                </div>
            @endif

            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('truck.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                        </div>
                        <div class="row mb-3">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-end">{{ __('Truck Label') }}</label>
                            <div class="col-md-6">
                                <select name="truck_type" class="form-control" id="">
                                    <option value="box_truck_center"> Box Truck Center</option>
                                    <option value="semi_truck"> Semi Truck</option>
                                    <option value="box_truck_center">Box Truck Center</option>
                                </select>

                                @error('truck_type')
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

    @include('orders.includes.change_driver')

    {{-- DATATABLE --}}


    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">All Trucks</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Driver</th>
                                        <th>Truck Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($trucks as $truck)
                                        <tr>
                                            <td>{{ $truck->name }}</td>
                                            <td><a
                                                    href="{{ route('change.truck.status', $truck->id) }}">{{ $truck->is_active ? 'Active' : 'InActive' }}</a>
                                            </td>
                                            <td>{{ $truck->truckDriver ? $truck->truckDriver->user->name : 'N/A' }}</td>
                                            <td>{{ $truck->truck_type }}</td>
                                            <td><a href="" class="update_driver"
                                                    data-truck-id="{{ $truck->id }}"> <i class="mdi mdi-account "
                                                        title="Update Driver"></i></a>
                                                /
                                                <a style="text-decoration: none;color:black"
                                                    href="{{ route('truck.update', $truck->id) }}"> <i
                                                        class="mdi mdi-truck " title="Update Truck"></i></a>
                                            </td>

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

@section('pageSpecificJs')
    <script>
        let truckId;
        $(document).on('click', '.update_driver', function(event) {
            event.preventDefault();
            truckId = $(this).attr('data-truck-id');
            $('#driversList').modal('show');
        });

        $('#selectDriver').on('change', function() {
            let driverID = this.value;
            $.ajax({
                url: '{{ route('assign.truck.driver') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    user_id: driverID,
                    truck_id: truckId
                },
                success: function(data) {
                    if (data.success) {
                        location.reload(true);
                    }
                    alert(data.message);
                }
            })
        });
    </script>
@endsection
