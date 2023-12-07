@extends('layouts.app')

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
    
                            <h4 class="mt-0 header-title">All Manifest</h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                                    @foreach ($pdfManifest as $pdf)
                                    <tr>
                                      <td>000{{$pdf->order_id}}</td>
                                        <td><a href="{{url($pdf->generator)}}"> Manifest</a></td>
                                        <td><a href="{{url($pdf->transporter)}}"> Manifest</a></td>
                                        <td><a href="{{url($pdf->processor)}}"> Manifest</a></td>
                                        <td><a href="{{url($pdf->disposal)}}"> Manifest</a></td>
                                        <td><a href="{{url($pdf->original_generator)}}"> Manifest</a></td>
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <input type="text" value="Permanent Notes" class="form-control" id="notesTitle" name="notes_title">
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

