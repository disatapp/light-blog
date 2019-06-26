@extends('lightBlog::layouts.app')

@section('stylesheet')
@include('lightBlog::admin.partials._styleEditor')
<style>

//solution from:https://medium.com/wdstack/bootstrap-equal-height-columns-d07bc934eb27
.row.display-flex {
  display: flex;
  flex-wrap: wrap;
}
.row.display-flex > [class*='col-'] {
  display: flex;
  flex-direction: column;
}
</style>
@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-12">
            {{ Breadcrumbs::render('lightBlog::admin.photoManage') }}

            <div class="panel panel-default " id="photoApp">
                <div class="panel-heading">Photos</div>

                <div class="panel-body">
                    <div class="row display-flex">

                        <div class="col-md-3" style="border-right: 1px solid #ccc;">
                            <image-upload v-on:fileselected="isSet" :selected="selected"></image-upload>
                       </div>
                        <div class="col-md-9">
                        <div class="row text-center text-lg-left">
                            @foreach($photos as $photo)
                            <div class="col-lg-3 col-md-4 col-xs-6">
                                <img class="img-fluid img-thumbnail" src="{{asset('uploads/img/'.$photo->slug)}}" alt="">
                                <a style="position: absolute; right: -5px; top: -15px; z-index: 10;  border-radius: 20px;" 
                                class="btn btn-danger" href="{{route('admin.imgDelete',['imgId' => $photo->id])}}" class="d-block mb-4 h-200">X</a>
                            </div>
                            @endforeach
                        </div>

                        </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="module" src="{{ asset('js/photo-upload.js') }}"></script>

@endsection

