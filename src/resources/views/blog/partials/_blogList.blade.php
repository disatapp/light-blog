
  <div class="blog-box panel">
  <div class="blog-content ql-container">
    <div class="blog-tags">
        @foreach ($post['tags'] as $tag)
                  <a href="{{route('blog.tag', ['locale' => 'en','slug' => ($tag->tag_slug != '') ? $tag->tag_slug : $tag->id])}}">{{$tag->tag_name}}</a>
                   
      @endforeach
    </div>
    <h3 class="listing-title">{{$post->title}}</h3>
    <div class="listing-author">
      <div class="author-pic">
          <img src="{{asset('/img/toplogo.jpg')}}">
      </div>
      <div class="author-info">
        <span class="author-name">
          <a>{{$post->user->name}}</a>
        </span>
        <span class="author-date">
          {{$post->updated_at->format('d/m/Y H:i:s')}}
        </span>
      </div>
    </div>
     @php
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $post->content, $img);
        if(empty($img)){
            
        }
    @endphp
    <div class="listing-preview">

      <div style="min-height:240px; padding:20px 0px 20px; overflow:hidden;">
      @if(!empty($img))

         <div style="overflow:hidden; position: relative; float: left; width:200px; height:200px; background-color:blue; margin: 0px 25px 0px 0px; vertical-align: middle; text-align: center;">
                <img src="{{end($img)}}" alt="" height="200" style="margin-left:-70px;"/>
            
        </div>
        @endif
          <p style=" margin:10px;">{!!str_limit(strip_tags($post->content), $limit = 200, $end = '...')!!}</p>
      </div>
      
    </div>
    <div class="listing-footer">
      <div class="footer-left">
        <a href="/{{ app()->getLocale() }}/blog/{{$post->slug}}" class="read-more">read more</a>
      </div>
      <div class="footer-right">
        {{--  <a href="#!" class="comments"><i class="fa fa-comment-o" aria-hidden="true"></i> comments</a>
        <a class="share"></a>  --}}
      </div>
    </div>
  </div>
</div>


