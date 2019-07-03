@extends('lightBlog::layouts.site')

@section('title', 'Blog')

@section('stylesheet')
<link href="{{asset('/css/quill-custom.css')}}" rel="stylesheet">


@endsection
  {{--  Landing Tab  --}}
@section('banner')

  <div class="jumbotron secondary" style="height: 25%; padding-bottom: 33.33%">
    <img style="position: absolute; bottom: -70%" class="img-carousel" src="https://images.pexels.com/photos/733171/pexels-photo-733171.jpeg?cs=srgb&dl=adventure-altitude-asia-733171.jpg&fm=jpg">

    <div class="book-now"></div>
  </div>
  
@endsection
  {{--  Main Area  --}}
@section('content')
    <div class="full-panel page-title">
      <h1 class="main-h1">Discover Chiangmai</h1>
      <h2 class="main-h2">Blog</h2>
    </div>
  <div class="container">
      <div class="c-8 column">
      @if (!empty($posts[0]))
        @foreach ($posts as $post)
          @include('lightBlog::blog.partials._blogList', $posts)
        @endforeach
      @else
        <div class="panel">
        <p>Sorry content has been posted yet. Please, come back again later :)</p>
        </div>
      @endif
        @include('lightBlog::blog.partials._blogLinks', $posts)
      </div>
      <div class="c-4 column">
      
        @include('lightBlog::blog.partials._blogSidebar', $newest)
        <div class="row">
        
      <div id="tbf-widget" data-hash="23db4ef6">
      </div>
      <script src="https://lib.thebookingfactory.com/tbf-booking-widget.js"></script>
        </div>
      </div>
  </div>
@endsection

@section('script')
@endsection
