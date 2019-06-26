@extends('lightBlog::layouts.app')

@section('stylesheet')
@endsection

@section('content')

<div id="newPost" class="container-fluid">
    @include('lightBlog::admin.partials._messages')
    
    <div class="row">
    
        <div class="col-xs-12 col-md-8  col-md-offset-2">
            {{ Breadcrumbs::render('lightBlog::admin.postManage') }}

            <div class="panel panel-default">
                <div class="panel-heading"><h2>Post List</h2></div>
                <div class="panel-body">
                    <vue-new-post></vue-new-post>
                    <div class="table-responsive">
                        <table class="table table-hover">   
                        <thead>
                            <tr>
                            <th>Post Id</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                            <tr>
                                <th>{{$post->id}}
                                </th>
                                <th><a href="{{route('admin.showEdit', [
                                    'postId' => $post->id
                                ])}}"><i class="glyphicon glyphicon-pencil"></i></a> {{$post->title}}</th>
                                <th>{{str_limit(html_entity_decode($post->content), $limit = 40, $end = '...')}}</th>
                                <th>{{$post->user->name}}</th>
                                <th>{{$post->created_at}}</th>
                                <th>

                                <a class="btn btn-danger delete" href="{{route('admin.postDelete', [
                                    'postId' => $post->id
                                ])}}">
                                <i class="glyphicon glyphicon-trash"></i></a>
                                
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script src="{{asset('js/postManage.js')}}"></script>
@endsection
