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
                @foreach ($notes as $note)
                    <div class="col-lg-4 mt-3">
                        <div class="card" style="min-height: 400px">
                            <div class="card-body">
                            <h5 class="card-title">{{$note->title}}</h5>
                            <p class="card-text">{{$note->note}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="col-12"> --}}
                    
                    {{-- <div class="card m-b-20">
                        <div class="card-body">
    
                            <h4 class="mt-0 header-title">All Notes</h4>
    
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                     
                                        <th>ID</th>
                                        <th>Business Name</th>
                                        <th>Created By</th>
                                        <th>Title</th>
                                        <th>Note</th>
                                        <th>Created At</th>


                                    </tr>
                                </thead>
    
    
                                <tbody>
                                    @foreach ($notes as $note)
                                    <tr>
                                        <td>{{$note->id}}</td>
                                        <td>{{$note->customer->business_name}}</td>
                                        <td>{{$note->user->name}}</td>
                                        <td>{{$note->title}}</td>
                                        <td>{{$note->note}}</td>
                                        <td>{{$note->created_at}}</td>

                                    </tr>
                                    @endforeach
                                
                                </tbody>
                            </table>
    
                        </div>
                    </div> --}}
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
