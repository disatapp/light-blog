@extends('layouts.blog')

@section('title', 'Blog')

@section('stylesheet')
<link href="{{asset('/css/quill-custom.css')}}" rel="stylesheet">
@endsection
  {{--  Landing Tab  --}}
@section('banner')
 
  <div class="jumbotron secondary" style="height: 25%; padding-bottom: 33.33%">
    <img style="position: absolute; bottom: -20%" class="img-carousel" src="https://images.pexels.com/photos/130149/pexels-photo-130149.jpeg?cs=srgb&dl=asia-beautiful-chiang-mai-130149.jpg&fm=jpg">
  </div>
    <div class="full-panel page-title">
      <h1 class="main-h1">Tag</h1>
      <h2 class="main-h2">{{$tags->tag_name}}</h2>
    </div>
@endsection
  {{--  Main Area  --}}
@section('content')
  <div class="full-panel container">
  
      
      {{--  for testing  --}}
      {{--  {{url()->full()}}   --}}
      @if(empty($posts[0]))
      <div class="inverse panel">
        <h3 style="text-align:center;"> Sorry, we were unable to find results for {{$tags->tag_name}} :(</h3>
      </div>
      @else 
      <div class="c-8 column">
        @foreach ($posts as $post)
          @include('lightBlog::blog.partials._blogList', $posts)
        @endforeach
       @include('lightBlog::blog.partials._blogLinks', $posts)
       </div>
      <div class="c-4 column">
        @include('lightBlog::blog.partials._blogSidebar', $newest)
      </div>
      @endif

      
  </div>
@endsection

@section('script')
@endsection
