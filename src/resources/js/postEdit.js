import ImageBlot from './quill-ImageBlot.js.js.js';
var siteUrl = 'https://'+window.location.hostname;
var eventBus = new Vue();

/// Quill Editor Component
Vue.component('vue-quill-editor',{  
  props: {
      quillContent: {
          type: String,
          default: ''
      }
  },
  data: function () {
    return {
      quill: null
    }
  },
  mounted: function () {
    var customTools = {
        container:[
            [{ 'font': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }], 
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'align': [] }],
            ['link','image', 'video'],
            ['blockquote'],
            [{ 'indent': '-1'}, { 'indent': '+1' }], 
          ],
        handlers: {
            // handlers object will be merged with default handlers object
            image: function(){
              //upload a file
              var input = this.container.querySelector('input.ql-image[type=file]');
              if(input == null) {
                  input = document.createElement('input');
                  input.setAttribute('type', 'file');
                  input.classList.add('ql-image');

                  input.setAttribute('accept', ['image/png', 'image/jpeg'].join(', '),);
                  input.onchange = (e) => {
                      const file = input.files[0];
                      const img = new Image();
                      img.src = URL.createObjectURL(file);
                      img.onload = function() {
                        console.log('loaded',this.width,':',this.height);
                      }
                      if(file != null){
                        const fd = new FormData();
                        fd.append('image', file, file.name);
                        let uri = siteUrl +'/admin/img';
                        axios.post(uri, fd, {
                          onUploadProgress: uploadEvent => {
                            console.log('Upload Progress:'+ ((uploadEvent.loaded/uploadEvent.total)*100) + '%');
                          }
                        }).then((response) => {
                            const range = this.quill.getSelection(true);
                            ImageBlot.blotName = 'image';
                            ImageBlot.tagName = 'img';
                            this.quill.insertEmbed(range.index, 'image', {
                                alt: response.data,
                                width: '400px',
                                url: siteUrl + `/uploads/img/${response.data}`
                            });
                            this.quill.formatText(range.index + 1, 1, { height: '170', width: '400' });
                            console.log(response);
                            
                            alert("Image successfully saved.");

                        }).catch((error) => {
                          //failure
                          alert(error);
                          console.log(error);
                        });
                      } else {
                        alert('pick a file to upload to the blog');
                      }
                  }
              }
              input.click();

            }
        }
    };
          
    this.quill = new Quill(this.$refs.quill, { 
      modules: {
          imageDrop: true,
          imageResize: {},
          quillCounter: {
            container: '#counter',
            unit: 'word'
          },
          toolbar: customTools
      },
      placeholder: 'Vue',
      theme: 'snow'
    });

    this.quill.root.innerHTML = this.quillContent;
    this.quill.on('text-change', () => this.update());
    this.quill.on('selection-change', () => this.selectedBound());
    eventBus.$once('initialQuill', (val) => {this.quill.root.innerHTML = val});
    
    


  },
  methods: {
        update: function() {
            eventBus.$emit('sendContent', this.quill.getText() ? this.quill.root.innerHTML : '');
            eventBus.$emit('unlockButton', true);

        },
        selectedBound: function(e){
          var range = this.quill.getSelection();
            if(range){
            var [leaf, offset] = this.quill.getLeaf(range.index);
            var box = this.quill.getBounds(range.index,range.length);
            }
        },
        _imageInput: function(input){
              
        }
    },
  template: `<div><div id="#quill" style="min-height:300px;" ref="quill"></div><div>{{quillContent}}</div></div>`
});
/// Form Component
Vue.component('vue-blog-form', {
  props: {
      propId: {
          type: Number,
          default: -1
      },
      propTitle: String,
      propSlug: String,
      propContent: String,
      propStatus: String,
      
  },
  data: function(){
      return {
        package: {},
        serverRequest: false,
        edited: false
      }
    },
    mounted: function(){
    this.$on('getPostId', (val) => this.getId(val));
    eventBus.$on('unlockButton', (val) => {this.edited = val});
    eventBus.$once('unlockButton', () => {this.edited = false});
    eventBus.$on('sendSlug', (val) => {this.propSlug = val});

  },
    methods: {
        //TODO: change to use only props
        createBlog: function(e){
            if(e){
              e.preventDefault();
            } 
            this.serverRequest = true;
            //axios
            let uri = siteUrl +'/admin/post';
            let postData = {
                title: this.propTitle,
                content: this.propContent,
                slug: this.propSlug,
              };
            axios.post(uri, postData).then((response) => {
                //Success
                eventBus.$emit('getPostId', response.data.id);
                this.serverRequest = false;
                alert("Post successfully saved.");
                console.log(response);

              }).catch((error) => {
                //failure
                this.serverRequest = false;
                alert(error);
                console.log(error);
              });
        },
        updateBlog: function(e){
            if(e){
              e.preventDefault();
            } 
            this.serverRequest = true;
            //axios
            let uri = siteUrl +'/admin/post/'+this.propId;
            let postData = {
                id: this.propId,
                title: this.propTitle,
                content: this.propContent,
                slug: this.propSlug,
                status: this.propStatus,
              };
            axios.post(uri, postData).then((response) => {
                //Success
                this.serverRequest = false;
                this.edited = false;
                console.log(response);
                
                alert("Post successfully saved.");
              }).catch((error) => {
                //failure
                this.serverRequest = false;
                alert(error);
                this.edited = false;
                console.log(error);
              });
        },
        slugUpdate: function($event){
            eventBus.$emit('sendSlug', $event.target.value);
        }
    },
    template: `<div class="panel panel-default">
      <div class="panel-heading">
        <h2>Post Editor: </h2>
        <span v-if="propId > -1" >Post saved. Post ID is: {{propId}}</span>
        
        <div>
        Total word count: <span id="counter"></span>
        </div>
      </div>

      <div class="panel-body">
        <form action="" class="form-group" method="post">
          <div class="form-group input-field">
            <label for="blogTitle">Title:</label>
            
            <input :value="propTitle" 
                   @input="$emit('input', $event.target.value)"
                   @change="edited = true"
                   type="text" class="form-control" name="blogTitle" placeholder="e.g. Rick Sanchez">
          </div>

          <div class="form-group input-field">
          <label for="blogSlug">Slug:</label>
          <input :value="propSlug" 
                   @input="slugUpdate($event)"
                   @change="edited = true"
                   type="text" class="form-control" name="blogSlug" placeholder="Im-a-slug">
          </div>
          <vue-blog-status :blogStatus="propStatus" ></vue-blog-status>
          <div class="form-group input-field ">
              <label for="blog-content" >Blog Body:</label>
              <input name="blog-content" type="hidden">
              <vue-quill-editor :quillContent="propContent"></vue-quill-editor>
          </div>
          <div class="form-group">
              <input @click="updateBlog" :disabled="!edited" class="btn btn-primary" type="submit" name="submit" value="Save Post">                
              <span v-if="serverRequest" style="margin-left: 10px">Saving please Wait ...</span>
          </div>
        </form>
      </div>
    </div>`
})

Vue.component('vue-blog-status', {
  template: `<div class="form-group input-field">
              <label for="status-select">Post status:</label>
                <select id="status-select" :value="blogStatus" 
                                            @change="statusUpdate($event)"
                                            name="status-select" aria-labelledby="dropdownMenu2">

                    <option v-for="(type,index) in postTypes" :value="type" :selected="blogStatus == type">
                        {{type}}
                    </option>
                </select>
            </div>`,
  props: {
      blogStatus: String,
  },
  mounted: function(){
      this.postTypes = ['private','public','password'];
  },
  data:
    function(){
      return {
        postTypes: [],
      }
  },
  methods: {
    statusUpdate: function(selected){
        eventBus.$emit('sendStatus', selected.target.value); 
        eventBus.$emit('unlockButton', true); 
    },
  }
})


var vueBlog = new Vue({
  el: '#vue-blog',
  data: {
    id: -1,
    title:'',
    content:'',
    slug: '',
    status: ''
  },
  mounted: function(){
    eventBus.$on('getPostId', (val) => this.getId(val));
    eventBus.$on('sendContent', (val) => {this.content = val});
    eventBus.$on('sendSlug', (val) => {this.slug = val});
    eventBus.$on('sendStatus', (val) => {this.status = val});
  },
  methods: {
    getId: function(val){
      this.id = val;
    },
    getBlogData: function(obj){
        this.id = obj.id;
        this.title = obj.title;
        this.content = obj.content;
        this.slug = obj.slug;
        if(obj.status == null || obj.status == ''){
          this.status = 'private';
        } else {
          this.status = obj.status;

        }
        console.log(this.status)
        eventBus.$emit('initialQuill', this.content);
        eventBus.$emit('getPostId', this.id);
    },
    isEdited: function(value){
      this.status = value;
    }
  }
});

var vueTag = new Vue({
  el: '#vue-tag',
  data: {
    selected: '',
    postId: -1,
    tags: [],
    loadTags: [],
    serverRequestTag: false,
    notifyPostSave: false
  },
  mounted: function(){
    eventBus.$on('getPostId', (val) => this.getId(val));
  },
  methods: {
      getId: function(val){
          this.notifyPostSave = true;
          if(this.postId < 0){
            this.postId = val;
          }
      },
      addTag: function(){
        var val = this.selected.split("-");
        for(var i=0;i < this.tags.length ;i++){
            if(this.tags[i].id == val[0]){
                return false;
            }
        }
        if(!this.tags.includes({id:val[0]},{name:val[val.length-1]}) && this.selected){
            this.tags.push({id:parseInt(val[0]),name:val[val.length-1]});
        } else {
            alert("Cannot add this tag");
        }
      },
      removeTag: function(index){
        if(index >= 0  && index <= this.tags.length-1){
            this.tags.splice(index,1);
        }
      },
      checkTags: function(tagId){
          for (var tag in this.tags){
            if(Object.values(this.tags[tag])[0] == tagId){
              return true;
            }
          }
          return false;
      },
      getTags: function(){
          let uri = siteUrl +'/admin/post/'+this.postId+'/tag';
          axios.get(uri).then((response) => {
              for(var i = 0; i < response.data.length; i++){
                  this.tags.push({id:response.data[i].id, name:response.data[i].tag_name});
                  this.loadTags.push(parseInt(response.data[i].id));
              }
              console.log(response);

          }).catch((error) => {
              alert(error);
              console.log(error);
          });
      },
      postTags: function(e){
          if(e){
            e.preventDefault();
          } 
          if(this.postId < 0){
            return false;
          }
          this.serverRequestTag = true;
          var delTags = [];
          //Check for delete
          for(var i = 0; i < this.loadTags.length; i++){
            if(!this.checkTags(this.loadTags[i])){
                delTags.push(this.loadTags[i])
            }
          }
          let tags = {
              'tags': this.tags
            }
          let uriPost = siteUrl +'/admin/post/'+this.postId+'/tag';
          axios.post(uriPost, tags).then((response) => {
              //TODO: setloadTag everytime
              this.loadTags = [];
              for(var i = 0; i < response.data.length; i++){
                  this.loadTags.push(parseInt(response.data[i].id));
              }
              if(delTags.length <= 0){
                this.serverRequestTag = false;
                alert("Tags successfully saved.");
              }
              console.log(response);

          }).catch((error) => {
              this.serverRequestTag = false;
              alert("Tags failed to saved.", error);
              console.log(error);
          });
          if(delTags.length > 0){
            let uriDelete = siteUrl +'/admin/post/'+this.postId+'/tag';
            axios.delete(uriDelete, {'data':delTags}).then((response) => {
                this.serverRequestTag = false;
                alert("Changes successfully saved.");
                console.log(response);
            }).catch((error) => {
                this.serverRequestTag = false;
                alert("");
                alert("Relationship not saved:",error);
                console.log(error);
            });
          }
      }
  }
});

vueBlog.getBlogData(bladePost);
vueTag.getTags();