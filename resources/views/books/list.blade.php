@extends('layouts.app')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@section('content')
    <div class="page-content-wrapper ">

       
    </div>



    {{-- DATATABLE --}}


    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                          <div style="margin: 20px 0px;">
                            <strong>Date Filter:</strong>
                            <input type="text" name="daterange" value="" />
                            <button class="btn btn-success filter">Filter</button>
                        </div>
                            <h4 class="mt-0 header-title">All Manifest</h4>
    
                            <table class="table table-bordered dt-responsive nowrap data-table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Order No</th>
                                        <th>Generator Manifest</th>
                                        <th>Transporter Manifest</th>
                                        <th>Processor Manifest</th>
                                        <th>Disposal Manifest</th>
                                        <th>Original Manifest</th>
                                    </tr>
                                </thead>
    
    
                                <tbody>
                                   
                                
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

    

@endsection

<script type="text/javascript">
  $(function () {
  
    $('input[name="daterange"]').daterangepicker({
        startDate: moment().subtract(1, 'M'),
        endDate: moment()
    });
    var url = window.location.pathname;
    var id = url.substring(url.lastIndexOf('/') + 1);
    let Bookurl = "{{ route('books.list', ':id') }}";
    url = Bookurl.replace(':id', id);

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: url,
            data:function (d) {
                d.from_date = $('input[name="daterange"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                d.to_date = $('input[name="daterange"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'generator', name: 'generator_manifest' ,orderable: false, searchable: false},
            {data: 'transporter', name: 'transporter_manifest',orderable: false, searchable: false},
            {data: 'processor', name: 'processor_manifest',orderable: false, searchable: false},
            {data: 'disposal', name: 'disposal_manifest',orderable: false, searchable: false},
            {data: 'original_generator', name: 'original_manifest',orderable: false, searchable: false}
        ]
    });
  
    $(".filter").click(function(){
        table.draw();
    });
        
  });
</script>
