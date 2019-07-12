$(document).ready(function() {
    $('#viewBlog').click(function(){
        if(window.confirm('Do you want to leave the admin panel?')){
            return true;   
        } else {
            return false;
        }
    });

    $('.delete').click(function(){
        if(window.confirm('Do you want to delete this element?')){
            return true;   
        } else {
            return false;
        }
    });


});



// import resizer from './resizer.js';
// import draggable from './draggable.js';
// var resize = new resizer();
// var drag = new draggable();

