<?php

namespace Pavinbd\LightBlog\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Pavinbd\LightBlog\Photos;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    //
    public function __construct() {

        $this->middleware('auth');
    }

    public function imgReadAll(){
        $photos = Photos::all();
        return json_encode($photos);
    }

    public function imgManage(){
        $photos = Photos::all();
        return view('lightBlog::admin.photoManage', ['photos' => $photos]);        
    }

    public function imgRead(Request $request){

    }

    public function imgStore(Request $request){

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $name = pathinfo($img->getClientOriginalName())['filename'];
            $slug = str_slug($name).'.'.$img->getClientOriginalExtension();
            //TODO: search if photo exist in public folder
            $rootPath = public_path('/uploads/img');
            $imgPath = $rootPath. "/".  $slug;
            $img->move($rootPath, $slug);

            $photosData = array(
                'name' => $name,
                'permission' => 0,
                'slug'=> $slug,
                'description' => 'test-field',
            );
            $save = Photos::create($photosData);
            return json_encode($slug);
        }
    }
    public function imgEdit(Request $request){
        
    }

    public function imgDelete(Request $request, $id){
        if(Auth::check()){

            $photo = Photos::find($id);
            if($photo){
                $rootPath = public_path('/uploads/img');
                $imgPath = $rootPath. "/".$photo['name'].'.'.pathinfo($photo['slug'], PATHINFO_EXTENSION);
                if(file_exists($imgPath)){
                    unlink($imgPath);

                }
                $photo->delete();
            }
            // return json_encode($imgPath);

            return redirect('admin/img')->with('status', 'img successfully deleted');
        }
    }

}
