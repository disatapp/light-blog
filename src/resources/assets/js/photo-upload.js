var siteUrl = 'http://127.0.0.1:8000';
Vue.component('image-upload', {
    template: `<div><input @change="selectPhoto" class="form-control" type="file" value="choose a photo">
               <input @click="uploadPhoto" :disabled="selected == false" class="btn btn-primary" type="submit" name="submit" value="Save Post"></div>`
    ,
    props: {
        selected: Boolean,
    },
    data: function(){
        return{
            photo: null,
            select: false,
        }
    },
    mounted: function(){
    },
    methods: {
        selectPhoto: function(e){
            console.log(this.selected);
            this.file = e.target.files[0];
            if(this.file != null){
                this.select = true;
            }
            this.$emit('fileselected', this.select);
        },
        uploadPhoto: function(){
            const img = new Image();
            img.src = URL.createObjectURL(this.file);
            img.onload = function() {
                console.log('loaded',this.width,':',this.height);
            }
            if(this.file != null){
                this.select = false;                
                const fd = new FormData();
                fd.append('image', this.file, this.file.name);
                let uri = siteUrl + '/admin/img';
                axios.post(uri, fd, {
                    onUploadProgress: uploadEvent => {
                        console.log('Upload Progress:'+ ((uploadEvent.loaded/uploadEvent.total)*100) + '%');
                    }
                }).then((response) => {
                    //success
                    console.log(response);
                    this.$emit('fileselected', this.select);
                    this.file = null;
                    alert("Image successfully upoaded.");
                }).catch((error) => {
                    //failure
                    console.log(error);
                    alert(error);
                });
            } else {
                alert('pick a file to upload to the blog');
            }
        }
    }
});



var vue = new Vue({
    el: '#photoApp',
    data: {
        selected: false,
    },
    mounted: {
    },
    methods: {
        isSet(select) {
            console.log(select);
            this.selected = select;
        }
    }    
});


Vue.component('image-manage', {
    template: ``,
    props: {
    },
    data: function(){
        return{
            selectdPhoto: null,
        }
    },
    mounted: function(){
    },
    methods: {
        deletePhoto: function(){
            let uriDelete = siteUrl + '/admin/img/'+ this.selectedPhoto+'/delete';
            axios.delete(uriDelete, {'data':delTags}).then((response) => {
                console.log(response);
                this.serverRequestTag = false;
                alert("Changes successfully saved.");
            }).catch((error) => {
                this.serverRequestTag = false; alert("Changes successfully saved.");
                alert(error);
                console.log(error);
            });
        }
    }
});