<?php

namespace Pavinbd\LightBlog\Http\Controllers;

use Pavinbd\LightBlog\Posts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Pavinbd\LightBlog\Tag;
use App\Http\Controllers\Controller;

//DISPLAYING POST
//TODO: more security functions
class BlogController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $locale
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function showBlog($locale, $slug)
    {
        //This will be a generic function the returns a JSON variable
        if(isInteger($slug)){
            $post = Posts::where(['id' => $slug, 'status' => 'public'])->first();

        } else {
            $post = Posts::where(['slug' => $slug, 'status' => 'public'])->first();
        }
        if($post != null){
            $newestPosts = $this->getNewest(5);        
            $author = $post->user->name;
            // TODO:place in JSON?
            return view('lightBlog::blog.postView', [
                    'post' => $post,
                    'newest' => $newestPosts,
            ]);
        }
        return redirect('/en/blog');

    }

    /**
     * Display the blog post that have been publicly published.
     *
     * @return void
     */
    public function getBlog(){
        $displayListings = Posts::where('status', 'public')->paginate(5);
        $newestPosts = $this->getNewest(5);
        return view('lightBlog::blog.blogView',[
            'posts' => $displayListings,
            'newest' => $newestPosts,
        ]);
    }

    /**
     * Redirect the blog.
     *
     * @return void
     */
    public function reBlog(){
        return redirect(Lang::getLocale().'/blog?page=1');
    }

    /**
     * Get the 5 newest public listing.
     *
     * @param int $count
     * @return use App\Posts;
     */
    private function getNewest($count = 5) {
        return Posts::where('status', 'public')->orderBy('id', 'desc')->take($count)->get();
    }


    /**
     * Get the 5 listing with the same tag.
     *
     * @param int $count
     * @param int $tag_id 
     * @return use App\Posts;
     */
    //TODO: this function needs assess the data and determine which post has the most in common with the displayed post
    // EX: take all the tags on a post and add all the tags up
    // EX: purhaps it can be a form of point system use comments, tags, and categories to related each post and create a map
    private function getTop($count = 5, $tag_id){
        return Posts::whereHas('tags', function($query) use ($tag_id){
            $query->where('tag_id', $tag_id);
        })->where('status', 'public')->take($count);
    }




    /**
     * Get the 5 listing with the same tag.
     *
     * @param int $local
     * @param int $tag_id 
     * @return void;
     */
    //Get Tags
    //TODO: add multiple tags 
    public function getBlogByTags($locale, $tag_slug){
        if(isInteger($tag_slug)) {
            $displayListings = Posts::whereHas('tags', function($query) use ($tag_slug){
                $query->where('tag_id', $tag_slug);
            })->where('status', 'public')->paginate(5);
            $findTags = Tag::find($tag_slug);

        } else {
            $displayListings = Posts::whereHas('tags', function($query) use ($tag_slug){
                $query->where('tag_slug', $tag_slug);
            })->where('status', 'public')->paginate(5);
            $findTags = Tag::where('tag_slug', $tag_slug)->first();

        }
        if(!empty($findTags)){
            $newestPosts = $this->getNewest(5);

            return view('lightBlog::blog.blogTagView',[
                'posts' => $displayListings,
                'newest' => $newestPosts,
                'tags' => $findTags,
            ]);
        }
        return redirect('/en/blog');
    }
}
