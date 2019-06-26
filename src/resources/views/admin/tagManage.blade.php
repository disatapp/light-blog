@extends('lightBlog::layouts.app')

@section('stylesheet')
@endsection

@section('content')
<div class="container">
    {{Breadcrumbs::render('lightBlog::admin.tagManage', 1)}}
    @include('lightBlog::admin.partials._messages')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Create A Tag</h2>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.tagStore') }}"  method="post">
                    
                      <div class="form-group input-field">
                        <label>Name:</label>
                        <input class="form-control" type="text" name="name" placeholder="e.g. Rick Sanchez">
                      </div>
                      <div class="form-group input-field">
                        <label>Slug:</label>
                        <input class="form-control" type="text" name="slug" placeholder="URI label">
                      </div>
                      <div class="form-group input-field">
                        <label>Description:</label>
                        <textarea class="form-control" name="description" placeholder="What does this do"></textarea>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                      </div>
                      
                      <div class="form-group">
                          <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Tag List</h2>                
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">   
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Count</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $tag)
                            <tr>
                                <th><a href="{{route('admin.tagEdit', [
                                    'tagId' => $tag->id])}}"><i class="glyphicon glyphicon-pencil"></i></a> {{$tag->tag_name}}</th>
                                <th>{{$tag->tag_slug}}</th>
                                <th>{{str_limit($tag->tag_description, $limit = 70, $end = '...')}}</th>
                                <th>{{$tag->count}}</th>
                                <th>
                                <a class="btn btn-danger delete" href="{{route('admin.tagDelete', [
                                    'tagId' => $tag->id])}}"><i class="glyphicon glyphicon-trash"></i></a>
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
@endsection
