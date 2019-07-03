@extends('lightBlog::layouts.app')

@section('stylesheet')
@endsection

@section('content')
<div class="container">
    @include('lightBlog::admin.partials._messages')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        {{Breadcrumbs::render('lightBlog::admin.tagEdit', 1)}}

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Edit Tag</h2>
                </div>
                  <div class="panel-body">
                    <form action="{{ route('admin.tagUpdate', ['tagId'=> $tag->id]) }}" class="form-group" method="post">
                    
                      <div class="form-group input-field">
                        <label>Name:</label>
                        <input class="form-control" type="text" name="name" value="{{$tag->tag_name}}">
                      </div>
                      <div class="form-group input-field">
                        <label>Slug:</label>
                        <input class="form-control" type="text" name="slug" value="{{$tag->tag_slug}}">
                      </div>
                      <div class="form-group input-field">
                        <label>Description:</label>
                        <textarea class="form-control" name="description">{{$tag->tag_description}}</textarea>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                      </div>
                      
                      <div class="form-group">
                          <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
