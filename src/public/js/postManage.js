var siteUrl = 'http://127.0.0.1:8000';
Vue.component('vue-new-post', {
    template: 
        `<div>
            <div class="modal fade" id="postCreateModal" tabindex="-1" role="dialog" aria-labelledby="postCreateModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="clearValue" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="postCreateModalLabel">Create Post</h4>
                        </div>
                        <div class="modal-body">
                            <p v-if="errors.length">
                                <b>Please correct the following error(s):</b>
                                <ul>
                                <li v-for="error in errors">@{{ error }}</li>
                                </ul>
                            </p>
                            <div class="form-group" :class="(errors.length > 0) ? 'has-error' : ''">
                                <label for="inputTitle">Enter a title:</label>
                                    <input  ref="titleInput"
                                            type="text" 
                                            v-model="postTitle" 
                                            class="form-control"
                                            id="inputTitle" placeholder="Post name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-primary" @click="createPost">Create A Post</a>
                            <button type="button" class="btn btn-default" @click="clearValue" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#postCreateModal">Create A Post</button>
            </div>
        </div>`,
    data: function () {
        return {
            postTitle: '',
            errors: []
        }
    },
    methods: {
        clearValue: function (){
            this.postTitle = '';
        },
        createPost: function(e){
            if(e){
              e.preventDefault();
              
            } 
            if(!this.postTitle){
                this.errors.push('Name required.');
                this.$refs.titleInput.focus();
                return false;
            }
            this.serverRequest = true;
            //axios
            let uri = siteUrl + '/admin/post';
            let postData = {
                title: this.postTitle,
              };
            axios.post(uri, postData).then((response) => {
                //Success
                this.serverRequest = false;
                window.location.href = siteUrl + '/admin/post/'+response.data.id;
                alert("Post successfully saved. Redirecting...");
              }).catch((error) => {
                //failure
                this.serverRequest = false;
                alert(error);
                console.log(error);
              });
        }
    }
});

newPost = new Vue({ el: "#newPost" });
