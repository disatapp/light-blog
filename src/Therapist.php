<?php
//Last Reviewed:

namespace Pavinbd\LightBlog;

use Illuminate\Http\Request;
use Pavinbd\LightBlog\Taggable;
use Pavinbd\LightBlog\Tag;

class Therapist {

    private $postPath = 'Pavinbd\LightBlog\Posts';

    // TODO: add success or failure
    private function addTagCount($tag_id){
        $tag = Tag::find($tag_id);
        $tag->count += 1;
        $tag->save();
        return $tag;
    }

    private function subTagCount($tag_id){
        $tag = Tag::find($tag_id);
        if($tag->count > 0){
            $tag->count -= 1;
            $tag->save();
        }
        return $tag;
    }

    /**
     * Show get all the relationships of a post.
     *
     * @return \App\Taggable;
     */
    public function getPostRelation($taggable_id){
        return Taggable::where('taggable_id', $taggable_id)->get();
    }

    /**
     * Show get all the relationships of a post.
     *
     * @return \App\Taggable;
     */
    public function getTagRelation($tag_id){
        return Taggable::where('tag_id', $tag_id)->get();
    }


    /**
     * Show get all the relationships of a post.
     *
     * @return \App\Tag;
     */
    public function getTags(){
        
        return Tag::all();
    }

    /**
     * Find all relationships of a post.
     *
     * @return \App\Taggable;
     */
    public function findRelation($taggable_id, $tag_id){
        return Taggable::where(['taggable_id' => $taggable_id, 'tag_id' => $tag_id])->first();
    }

    public function existRelation($taggable_id, $tag_id){
        return ($this->findRelation($taggable_id, $tag_id) ? true : false);
    }

    /**
     * Show get all the relationships of a post.
     *
     * 
     */
    public function createRelation($taggable_id, $tag_id){

        if(!empty($tag_id) && !empty($taggable_id)){
            $exist = $this->existRelation($taggable_id, $tag_id);
            if(!$exist){
                    $relation = new Taggable();
                    $relation->taggable_id = $taggable_id;
                    $relation->tag_id = (int) $tag_id;
                    $relation->taggable_type = $this->postPath;
                    $relation->save();
                    $this->addTagCount($tag_id);
                return $relation;
            } 
        }
    }

    /**
     * Delete a single post tag relation.
     *
     * 
     */
    public function deletePostTagRelation($taggable_id, $tag_id){

        //TODO: make it work with array
        //do i need to check the database that often?
        if(!empty($tag_id) && !empty($taggable_id)){
            $taggable = Taggable::whereIn('tag_id', $tag_id)->where('taggable_id', $taggable_id);
            // return $taggable;
            if($taggable != null){
                foreach($tag_id as $tag){
                    $this->subTagCount($tag);
                }
                $taggable->delete();
            }        
        }
    }

    /**
     * Delete remove tags from post.
     *
     * 
     */
    public function deletePostRelation($taggable_id){

        if(!empty($taggable_id)){
            $taggables = Taggable::where('taggable_id', $taggable_id);
            //subtract count
            if($taggables != null){
                foreach($taggables->get() as $taggable){
                    $this->subTagCount($taggable->tag_id);
                }
                $taggables->delete();
            }
        }
    }

    /**
     * Delete tags for many post.
     *
     * 
     */
    public function deleteTagRelation($tag_id){

        if(!empty($tag_id)){
            $tag = Taggable::where('tag_id', $tag_id);
            if($tag != null){
                $tag->delete();
            }
        }
    }

    // $post = Post::find($post_id);	
    // $tag = new Tag;
    // $tag->tag_name = "ItSolutionStuff.com";
    // $post->tags()->save($tag);
}