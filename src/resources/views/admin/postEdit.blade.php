
@extends('lightBlog::layouts.app')

@section('stylesheet')
<style>
.ql-pop:before {
  content: "Ω";
}

p.ex{ 
    
    background: lime; 
    height: 200px; 
    width: 300px; 
    }
p.resizable { 
    border: 1px dashed black;
    background: cyan; position: relative; 
    }
p .resizer { 
    width: 10px; height: 10px; 
    background: blue; 
    position:absolute; 
    right: 0; 
    bottom: 0; 
    cursor: se-resize; 
}

div.draggable{
    z-index: 100;
    background: blue; 
    height: 100px; 
    width: 100px;
}
div .dragging {
    position:absolute;

    background: red; 
    height: 20px; 
    width: 20px;
    cursor: move;
}

</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('lightBlog::admin.partials._styleEditor')
@endsection

@section('content')
<div class="container">
{{Breadcrumbs::render('lightBlog::admin.showEdit', 1)}}

    @include('lightBlog::admin.partials._messages')
    {{--  <div style="position: relative">
        <p class="ex" style="display: block; margin:auto"></p>
        <p class="ex" style="display: block; margin:auto"></p>
        //gets owned
    </div>
    <div style="min-height: 300px;">
        <div class="draggable">
            <div class="dragging" id="dragging"></div>
        </div>

    </div>  --}}
    <div class="row">
        <div class="col-md-8" id="vue-blog">
            <vue-blog-form  :prop-id="id"    
                            :prop-title="title" 
                            :prop-content="content" 
                            :prop-slug="slug" 
                            :prop-status="status"
                            v-model='title'></vue-blog-form>
                            
        </div>
         <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div id="vue-tag" class=" panel panel-default">
                        <div class="panel-heading">
                            <h3>Tag</h3>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-success fade in alert-dismissible" v-if="serverRequestTag">Saving Tags...<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                            <div class="alert alert-danger fade in alert-dismissible" v-if="!notifyPostSave">Please save the post first to add tags.<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>                    
                            <div  class="container row">
                                <select id="tag-select" v-model="selected" name="tag-select" aria-labelledby="dropdownMenu1">
                                    <option disabled value="">Please select a Tag</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{$tag->id}}-{{$tag->tag_name}}">
                                            {{$tag->tag_name}}
                                        </option>
                                    @endforeach
                                </select>
                                    {{ csrf_field() }}
                                <button id="update-tag" v-on:click="addTag" class="btn btn-success" type="submit" name="submit" >Add Tag
                                </button>
                            </div>
                            <div class="container row">
                                <ul class="add-tag">
                                    <li style="list-style:none;" v-for="(tag, index) in tags">
                                        <a  v-on:click="removeTag(index)" 
                                            v-bind:id="tag.id" class="remove-tag" ><i class="glyphicon glyphicon-minus-sign"></i></a>
                                        @{{tag.name}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <input @click="postTags" :disabled="postId < 0 || tags.length < 1"class="btn btn-success" type="submit" name="submit" value="Save">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>TODO:</h3>
                        </div>
                        
                        <div class="panel-body">
                            <ul class="" style="list-style:none">
                                <li>Massive code clean-up</li>
                                <li>More functions upload gallery</li>
                                <li><hr/></li>
                                <li>Improve blog display format (front)</li>
                                <li>User Experiance/Feedback</li>
                                <li>Autosave (far future)</li>
                                <li>Search by User</li>
                                <li>Comments (far future)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script src="{{asset('/js/image-drop.min.js')}}"></script>
<script src="{{asset('/js/image-resize.min.js')}}"></script>
<script type="module" src="{{asset('/js/quillCounter.js')}}"></script>
<script type="module" src="{{asset('/js/quill-ImageBlot.js')}}"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
var bladePost = {!!$post!!};
</script>
<script type="module" src="{{asset('/js/postEdit.js')}}"></script>
@endsection
