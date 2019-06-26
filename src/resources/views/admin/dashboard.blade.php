@extends('lightBlog::layouts.app')

@section('stylesheet')
@include('lightBlog::admin.partials._styleEditor')
@endsection

@section('content')
<div class="container">

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            {{ Breadcrumbs::render('lightBlog::dashboard') }}
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        
                    @endif

                    You are logged in!
                    <ul>
                                                         
                                    <li>
                                        <a href="{{route('admin.postManage')}}">Manage Posts</a>
                                    </li>
                                    <li>
                                        <a href="{{route('admin.tagManage')}}">Manage Tags</a>
                                    </li>
                                    <li>
                                        <a href="{{route('admin.imgManage')}}">Manage Photos</a>
                                    </li>
                    </ul>
                
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>  




</script>  

@endsection

