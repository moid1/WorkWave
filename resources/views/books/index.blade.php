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





    <div class="page-content-wrapper mt-5">
        <div class="container-fluid">
            <div class="row mx-auto">
                <div class="col-md-9">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search Customers"
                            id="search">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <img src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/zeus/kratos/af2f34c3.svg"
                                    alt="">
                            </span>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" onClick="window.location.reload();">Clear Filter</button>
                </div>
                <div id="product_list"></div>

            </div>
            <div class="row mt-4 customerList">
                @foreach ($customers as $customer )
                    <div class="col-lg-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">{{$customer->business_name}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{$customer->address}}</h6>
                            <p class="card-text">Click on the links below to find the manifest for this CX</p>
                            <a href="{{route('books.list', $customer->id)}}" class="card-link">Manifests</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div> <!-- end row -->
        </div><!-- container-fluid -->
    </div>

@endsection

<script>
     $(document).ready(function(){
        $('#search').on('keyup',function () {
            var query = $(this).val();
            if(query.length<=1){
                return;
            }
            $.ajax({
                url:'{{ route("customer.search.books") }}',
                type:'GET',
                data:{'name':query},
                success:function (response) {
                  $('.customerList').empty();
                    response.data.forEach(element => {
                        let url = "{{ route('books.list', ':id') }}";
                        url = url.replace(':id', element.id);
                        $('.customerList').append(`<div class="col-lg-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                            <h5 class="card-title">${element.business_name}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">${element.address}</h6>
                            <p class="card-text">Click on the links below to find the manifest for this CX</p>
                            <a href="${url}" class="card-link">Manifests</a>
                            </div>
                        </div>
                    </div>`);
                    });
                }
            })
        });
    });
</script>
