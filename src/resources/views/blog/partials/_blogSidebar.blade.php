<div class="sidebar-box inverse panel">
  <div class="sidebar-content">
    <h4 class="sidebar-header"><span>Newest Post</span></h4>
        <ul>
          @foreach ($newest as $new)
            <li><a href="/{{ app()->getLocale() }}/blog/{{$new->slug}}">{{$new->title}}</a></li>
          @endforeach
        </ul>
  </div>
</div>