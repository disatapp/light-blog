@extends('lightBlog::layouts.site')

@section('title', $post->title)

@section('stylesheet')
<link href="{{asset('/css/quill-custom.css')}}" rel="stylesheet">
@endsection
@section('banner')
 
  <div class="jumbotron secondary" style="height: 25%; padding-bottom: 33.33%">
    <img style="position: absolute; bottom: -20%" class="img-carousel" src="https://images.pexels.com/photos/878489/pexels-photo-878489.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940">
      <h1 class="title">{{$post->title}}</h1>
    <div class="book-now"></div>
  </div>
@endsection
  {{--  <!-- Main Area -->  --}}
@section('content')
  <div class=" row">
    <div class="container">
      <div class="c-8 column">
          @include('lightBlog::blog.partials._postContent', [
          'post' => $post,
          'newest' => $newest,
          ]) 
      </div>
      <div class="c-4 column">
        @include('lightBlog::blog.partials._blogSidebar', ['newest' => $newest])
      </div>
    </div>
  </div>
@endsection

@section('script')
@endsection