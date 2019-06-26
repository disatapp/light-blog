
@if (session('status'))
    <div class="alert alert-success fade in alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success:</strong> {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger fade in alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success:</strong>
        <ul>
            @foreach ($errors->all() as $key => $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif