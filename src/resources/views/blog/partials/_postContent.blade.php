<div class="blog-box panel">
    <div class="blog-content ">
        <div class="blog-tags">
            @foreach ($post['tags'] as $tag)
              <a href="{{route('blog.tag', ['locale' => 'en','slug' => ($tag->tag_slug != '') ? $tag->tag_slug : $tag->id])}}">{{$tag->tag_name}}</a>
              {{--  <a href="{{route('en/$tag->tag_slug')}}">{{$tag->tag_name}}</a>  --}}
            @endforeach
        </div>
        <h1 class="post-title">{{$post->title}}</h1>
        <div class="post-author">
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
        <div class="post-body">
            <div class="ql-container">
                <div class="ql-editor">
                    {!!html_entity_decode($post->content)!!}
                </div>
            </div>
        </div>
        <div class="post-footer">
            <div class="footer-left">
                <div class="sidebar-content">
                  <h3 class="sidebar-header">Related post:</h3>
                    <ul>
                    @foreach ($newest as $new)
                      <li><a href="/{{ app()->getLocale() }}/blog/{{$new->id}}">{{$new->title}}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="footer-right">
                <h3>Share:</h3>
                <ul class="list-social">
                    <li> <a href="https://www.tripadvisor.com/Hotel_Review-g293917-d14918147-Reviews-Villa_Sanpakoi-Chiang_Mai.html" target="_blank"><i class="fa fa-tripadvisor" aria-hidden="true"></i></a></li>
                    <li> <a href="https://www.facebook.com/villasanpakoi/" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                    <li> <a href="https://www.instagram.com/villasanpakoi/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>           
                </ul>
            </div>
        </div>
    </div>
</div>


