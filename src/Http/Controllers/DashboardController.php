<?php

namespace Disatapp\LightBlog\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Disatapp\LightBlog\Posts;
use Disatapp\LightBlog\Therapist;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    private $service;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Therapist $service)
    {
        $this->middleware('auth');
        $this->service = $service;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index()
    {
        return view('lightBlog::admin.dashboard');
    }

    /**
     * Redirect to login.
     *
     * @return \Illuminate\Http\Response
     */
    public function reLogin()
    {
        return redirect('admin/login');
    }


     /**
     * Show the post that user will created.
     *
     * @return form to create now
     */
    public function postCreate(){
        $tags = $this->service->getTags();

        return view('lightBlog::admin.postCreate',[
            'tags' => $tags
        ]);
    }
    
    /**
     * Store a new Post.
     *
     */

    //test to see if auth restricts access
    //TODO: refresh not working
    public function postStore(Request $request)
    {
        //validate
        if ($request->isMethod('post')) {

            $user =  Auth::id();
            // return  $request->title;
            //TODO: validate user
            $isValid = true;
            $isValid = $request->validate([
                'title' => 'required|unique:posts|max:255',
            ]);

            //TODO:check content and reformat special characters
                //addslashes(); for quotes &quot; etc.
                //handle HTML entities, emoji 
                //<img class="alignnone size-medium wp-image-19" src="http://travelistpass.com/wp-content/uploads/2018/07/DJI_0030-225x300.jpg" alt="" width="225" height="300" />
            
            
            //in array in the future
            $title = $request->input('title');
            $content = $request->input('content');
            $slug = str_replace("-", " ",$title);
            $postData = array(
                'user_id' => $user, //get user id
                'title' => $title,
                'content' => 'Edit this new post',
                'slug' => $slug,
                'status' => 'private',
            );
            $saveData = Posts::create($postData);
            return json_encode($saveData);
            
        }
        return redirect('admin');
    }

    //will be moved to another class later
    public function tagToPostStore(Request $request, $post_id){
        if ($request->isMethod('post')) {
            $tags = $request->input('tags');
            foreach ($tags as $tag){
                $this->service->createRelation($post_id, $tag['id']); 
            }
            return json_encode($tags);
        } 
        // return redirect('admin/post');
    }

    //will be moved to another class later
    public function tagToPostRead(Request $request, $post_id){
        if ($request->isMethod('get')) {
            $post = Posts::find($post_id);
            $tags = $post->tags;
            return json_encode($tags);
        } 
    }

    public function tagToPostDelete(Request $request, $post_id){
        if ($request->isMethod('delete')) {
            $tags = $request->all();
            $tags = $this->service->deletePostTagRelation($post_id, $tags); 
// make work with array
            // foreach ($tags as $tag){
            //     $tags = $this->service->deletePostTagRelation($post_id, $tag); 
            // }
            return json_encode($tags);
        } 
    }

     /**
     * Show the posts associated with the user
     *
     * @return form to create now
     */
    public function postManage(){
        $posts = Posts::where('user_id', Auth::id())->get();
        // return $posts;
        return view('lightBlog::admin.postManage', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the post that user will edit.
     *
     * @return form to edit
     */
    public function showEdit(Request $request, $post_id)
    {
        if(Auth::check()){
            
            //get post object???
            if($post_id != null) {
                $tags = $this->service->getTags();
                
                //TODO: user api calls & salt
                //check user id with the post 
                $validatePost = Posts::where('id',  $post_id)->first();
                if(Auth::id() == $validatePost->user_id){
                    return view('lightBlog::admin.postEdit', [
                        'post' => $validatePost,
                        'tags' => $tags
                    ]);
                }
            }
        }
        return redirect('admin/post');
    }

    
    /**
     * Update post
     *
     * @return form to edit
     */
    public function postUpdate(Request $request, $post_id)
    {
        if(Auth::check()){
            
            if($post_id != null) {
                $post = Posts::find($post_id);

                if($request->input('slug') == $post->slug){

                    $this->validate($request,array (
                        'title' => 'required|max:255',
                    ));
                } else {
                    $this->validate($request,array (
                        'title' => 'required|max:255',
                        'slug' => 'alpha_dash|unique:posts,slug',
                    ));
                }

                $post->title = $request->input('title');
                $post->content = $request->input('content');
                $post->slug = $request->input('slug');
                $post->status = $request->input('status');
                $post->save();
                
                return json_encode($post);
            }
        } 
    }

    /**
     * Update post
     *
     * @return form to edit
     */
    public function postDelete(Request $request, $post_id)
    {
        if(Auth::check()){
            //CHECK ACTUALLY already checks it for us
            if($post_id != null) {
                $post = Posts::find($post_id);
                if(Auth::id() == $post->user_id){
                    $post->delete();
                    $this->service->deletePostRelation($post_id);
                    return redirect('admin/post')->with('status','post successfully deleted');
                }
            }
        }
        return redirect('admin/dashboard');
    }
}
