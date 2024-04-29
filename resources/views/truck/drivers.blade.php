@extends('layouts.app')

@section('content')



    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">All Truck Drivers</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>Truck Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($trucks as $truck)
                                        <tr>
                                            <td>{{ $truck->truck ? $truck->truck->name : 'N/A' }}</td>
                                            <td>
                                                        <a style="text-decoration: none;color:black"
                                                    href="{{ route('show.truck.location', ['truck_id' => $truck->id]) }}"> <i
                                                        class="mdi mdi-truck " title="Show Truck"></i></a>
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
