@extends('layouts.app')

@section('content')

    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        {{Session::get('success')}}
                    </div>
                    @endif
                    <div class="card m-b-20">
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
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

@endsection
