@extends('layouts.app')

@section('content')

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row justify-content-between">
                @if (count($notes)>0)
                    <h4 class="font-bold">All Notes ({{$notes[0]->customer->business_name}})</h4>
                @endif
                <div onclick="hurra({{$customer->id}})" class="btn btn-primary">Create Notes</div>
            </div>
            @if (count($notes)>0)
            <div class="row">

                <div class="col-12">
                    
                <div class="card m-b-20">
                        <div class="card-body">
    
                            <h4 class="mt-0 header-title">All Notes</h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                     
                                        <th>ID</th>
                                        <th>Created By</th>
                                        <th>Note</th>
                                        <th>Estimated Tires</th>
                                        <th>Spoke With</th>
                                        <th>Created At</th>


                                    </tr>
                                </thead>
    
    
                                <tbody>
                                    @foreach ($notes as $note)
                                    <tr>
                                        <td>{{$note->id}}</td>
                                        <td>{{$note->user->name}}</td>
                                        <td>{{$note->note}}</td>
                                        <td>{{$note->estimated_tires ?? 'N/A'}}</td>
                                        <td>{{$note->spoke_with ?? 'N/A'}}</td>
                                        <td>{{$note->created_at->format('d M Y')}}</td>

                                    </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
    
                        </div>
                    </div>
                {{-- </div> <!-- end col --> --}}
            </div> <!-- end row -->
            @endif
        </div><!-- container-fluid -->
    </div>

@endsection

@include('notes.includes.create')

<script>
    function hurra(id){
  $('input[name=customer_id]').val(id);
 $("#exampleModal").modal()

}
</script>
