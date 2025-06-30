@extends('layouts.app')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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



    {{-- DATATABLE --}}


    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">

                            <h4 class="mt-0 header-title">All Customers</h4>

                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>

                                        <th>Business Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone#</th>
                                        <th>RTD Location</th>
                                        <th>TAX</th>
                                        <th>2nd POC</th>
                                        <th>2nd Email</th>
                                        <th>2nd Phone</th>
                                        <th>Charge Type</th>

                                        <th>Convenience Fee</th>
                                        <th>Earliest Pick Up Time</th>
                                        <th>PO#</th>


                                        <th>Status</th>


                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td class="cx-business-name">{{$customer->business_name}}</td>
                                            <td>{{$customer->email}}</td>
                                            <td>{{$customer->address}}</td>
                                            <td>{{$customer->phone_no}}</td>
                                            <td>{{$customer->rtd_location ?? 'N/A'}}</td>
                                            <td>{{$customer->tax ?? 'N/A'}}</td>
                                            <td>{{$customer->second_poc ?? 'N/A'}}</td>
                                            <td>{{$customer->second_mail}}</td>
                                            <td>{{$customer->mail_phone}}</td>
                                            <td>{{$customer->charge_type}}</td>

                                            <td>{{$customer->convenienceFee}}</td>
                                            <td>{{$customer->earlierPT}}</td>
                                            <td>{{$customer->po}}</td>

                                            @if($customer['status'] === 1)
                                                <td>
                                                    <a href="{{url('toggle-customer-status', $customer->id)}}">
                                                        <span class="badge badge-success">Active </span>
                                                    </a>

                                                    | <i onclick="hurra({{$customer->id}})" class="notes mdi mdi-cube-outline"> </i>
                                                    |
                                                    <a href="{{route('customer.show', $customer->id)}}"> <i
                                                            class="mdi mdi-account"></i> </a>
                                                    |<a target="_blank" href="{{route('notes.user', $customer->id)}}"> <i
                                                            class="mdi mdi-notes">Notes</i> </a>
                                                    |
                                                    <a target="_blank"
                                                        href="{{ route('custom.generate.inhouse.manifest', ['customer_id' => $customer->id]) }}">
                                                        <i class="mdi mdi-pdf">Manifest</i>
                                                    </a>
                                                    |
                                                    <a target="_blank" style="color: red"
                                                        href="{{ route('customer.delete', ['id' => $customer->id]) }}">
                                                        <i class="mdi mdi-pdf">Delete</i>
                                                    </a>


                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{url('toggle-customer-status', $customer->id)}}">
                                                        <span class="badge badge-secondary" style="color: white">In Active</span>
                                                    </a>
                                                    | <i onclick="hurra({{$customer->id}})" class="mdi mdi-cube-outline"> </i> |
                                                    <a href="{{route('customer.show', $customer->id)}}"> <i
                                                            class="mdi mdi-account"></i> </a>
                                                    |<a target="_blank" href="{{route('notes.user', $customer->id)}}"> <i
                                                            class="mdi mdi-notes">Notes</i> </a>

                                                </td>
                                            @endif


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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('notes.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" value="0" name="customer_id" id="#customerID">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Title:</label>
                            <input type="text" value="Permanent Notes" class="form-control" id="notesTitle"
                                name="notes_title">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Note</label>
                            <textarea name="note" class="form-control" id="message-text"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Note</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

<script>
    $('.container-fluid').on('click', '.notes', function () {
        $(this).addClass("toggled");
    });

    function hurra(id) {
        $('input[name=customer_id]').val(id);
        $("#exampleModal").modal()

    }
    $(document).ready(function() {
        var table = $('#datatable').DataTable();

        // Remove default search box
        $('#datatable_filter').remove();

        // Custom search input
        $('<input type="text" id="customSearch" class="form-control mb-2" placeholder="Search Business Name (exact match)">')
            .insertBefore('#datatable');

        $('#customSearch').on('keyup change', function() {
            var searchValue = this.value;
            if (searchValue === '') {
                // Clear search and show all records
                table.column(0).search('').draw();
            } else {
                // Use regex for exact match, ^...$
                table.column(0).search('^' + $.fn.dataTable.util.escapeRegex(searchValue) + '$', true, false).draw();
            }
        });
    });


</script>