<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;

class BlogController extends Controller
{
    public function blog(){
        view()->share('menu', 'blog');
        return view('admin.blog.index');
    }

    public function blogData(Request $request){
        $model = new Blog();
        $filter = false;

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function getBlog(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Blog::find($id);
            $mode = 'edit';
        }else{
            $item = new Blog();
            $item->inheritMeta = 1;
            $item->featured = 1;
            $item->temp = 1;
            $item->save();
            $mode= "add";
        }

        $data = json_encode(
            array('data' =>
                (String) view('admin.blog.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }
    public function saveBlog(Request $request){

        $validator  = \Validator::make($request->all(), [
            'id' => 'required|int',
            'published' => 'required|in:0,1',
            'title'     => 'required|string',
            'description'   => 'string|nullable',
            'body'   => 'string|nullable',
            'slug' => 'required|string|min:2|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }

        $id = (int)$request->id;
        $item = Blog::find($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't save"]));

        if($item->temp != null)$item->temp = null;

        $slug = strtolower(str_replace(' ', '-', $request->slug));
        $checkSlug = Blog::where('slug', $slug)->where('id','!=',$id)->first();
        if($checkSlug)return json_encode(array('status' => 0, 'message' => ["Slug already exist"]));

        $item->slug = $request->input('slug');
        $item->published = $request->input('published');
        $item->title = $request->title;
        $item->description = $request->description;
        $item->body = $request->body;

        $item->featured = isset($request->featured) ? $request->featured : null;
        
        if(!isset($request->inheritMeta)){
            $item->inheritMeta = 0;
            $item->meta_title = $request->meta_title;
            $item->meta_description = $request->meta_description;
        }else{
            $item->inheritMeta = 1;            
        }
        
        $item->published_at = $request->publishedDate;

        if ($request->published == 1 && $item->img == null) {
            return json_encode(array('status' => 0, 'errors' => ["Cannot publish without image"]));
        }
        $item->save();
        $id = $item->id;
        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }

    public function remove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Blog::find($id);
            if($item->img){
                File::delete('content/'.$item->img);
            }
            $item->delete();
        }

        $data = json_encode(array('status' => 1));
        return $data;
    }
}

