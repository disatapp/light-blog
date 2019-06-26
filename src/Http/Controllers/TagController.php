<?php

namespace Disatapp\LightBlog\Http\Controllers;

use Disatapp\LightBlog\Tag;
use Disatapp\LightBlog\Taggable;
use Disatapp\LightBlog\Therapist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;


//DISPLAYING POST
class TagController extends Controller
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
     * Create a new Tag.
     *
     * @return void
     */

    public function tagStore(Request $request){
        
        //validate
        if ($request->isMethod('post')) {
            $isValid = $request->validate([
                    'name' => 'required|unique:tags,tag_name|max:255',
                    'description' => 'required',
                    'slug' => 'alpha_dash|unique:tags,tag_slug|max:255'
                ]);

            //TODO:check content and reformat special characters
                //addslashes(); for quotes &quot; etc.
                //handle HTML entities, emoji 
                //<img class="alignnone size-medium wp-image-19" src="http://travelistpass.com/wp-content/uploads/2018/07/DJI_0030-225x300.jpg" alt="" width="225" height="300" />

            if($isValid){
                $name = $request->input('name');
                // return $name;
                $description = $request->input('description');
                $slug = $request->input('slug');
                $postData = array( //get user id
                    'tag_name' => $name,
                    'tag_description' => $description,
                    'tag_slug' => $slug,
                    'count' => 0,
                );
                $saveData = Tag::create($postData);
                // return $saveData;
                return redirect('admin/tag')->with('status', 'new tag successfully made.');
                
            }

        }
        return view('failure');
    }

    /**
     * Show all tags created in the database
     *
     * @return form to create now
     */
    public function showTag($id = 0){
        // return $posts;p
        return Tag::find($id);
    }

    /**
     * Show all tags created in the database
     *
     * @return form to create now
     */
    public function postManage(){
        // return $posts;p
        return Tag::all();
    }

    public function tagManage(){

        return view('lightBlog::admin.tagManage',[
            'tags' => $this->postManage(),
        ]);
    }

    public function tagEdit(Request $request, $tag_id)
    {
            //get post object???
            if($tag_id != null) {
                //TODO: user api calls & salt
                //check user id with the post 
                $validatePost = Tag::where('id',  $tag_id )->first();
                
                
                return view('lightBlog::admin.tagEdit', [
                    'tag' => $validatePost
                ]);
            }
        return redirect('admin/dashboard');
    }
       
    /**
     * Update post
     *
     * @return form to edit
     */
    public function tagUpdate(Request $request, $tag_id)
    {
            $isValid = $request->validate([
                //
                'name' => 'required|max:255',
                'description' => 'required',
                'slug' => 'max:255'
            ]);
            if($isValid) {
                if($tag_id != null) {                
                    $tag = Tag::find($tag_id);
                    //CHECK ACTUALLY already checks it for us
                        $tag->tag_name = $request->input('name');
                        $tag->tag_description = $request->input('description');
                        $tag->tag_slug = $request->input('slug');
                        $tag->save();

                        return redirect('admin/tag')->with('status', 'tag successfully edited');
                }
            }

        return redirect('admin/dashboard');
    }

    /**
     * Update post
     *
     * @return form to edit
     */
    public function tagDelete(Request $request, $tag_id)
    {
            //CHECK ACTUALLY already checks it for us
        if($tag_id != null) {
                $tag = Tag::find($tag_id);
                if($tag != null){
                    $this->service->deleteTagRelation($tag_id);
                    $tag->delete();
                    //delete relationship
                    return redirect('admin/tag')->with('status', 'tag successfully deleted');
                }
        }
        
        return redirect('admin/dashboard');
    }



}
