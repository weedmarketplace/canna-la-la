<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ImageDB;
use App\Models\Admin\Slider;
use File;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        view()->share('menu', 'sliders');
        return view('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function get(Request $request){
        $id = (int)$request['id'];
        $mode = $id ? "edit" : "add";
        if($id){
            $item = Slider::findOrFail($id);
            if ($item->image_id){
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Slider();
            $max = DB::table('sliders')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
            $item->temp = 1;
            $item->status =1;
            $item->save();
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.slider.item', array('item'=>$item,
                    'mode'=>$mode,
                )),'status' => 1)
        );
        return $data;
    }
    public function sliderData(Request $request){
        $model = new Slider();
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
    public function saveSlider(Request $request){

        $data = $request->all();
        $id = $request->input('id');

        $validator = \Validator::make($request->all(),[
            'image_id'=>"required|",
            'title'=>"required|string|max:125",
            'status'=>"required|integer|in:0,1",
        ]);
        
        if ($validator->fails())return response()->json(['status'=>0,'errors'=>$validator->errors()->first()]);

        $item = Slider::find($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't save"]));
        if($item->temp != null)$item->temp = null;

        $item->title = $request->input('title');
        $item->button_title = $request->input('button_title');
        $item->description = $request->input('description');

        $item->image_id = $request->input('image_id');
        $item->link = $request->input('link');
        $item->linkType = $request->input('linkType');

        $item->status = $request->input('status');

        $item->save();
        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));

    }
    public function sort(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Slider::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
    }


    public function remove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Slider::find($id);
            if($item->image_id){
                $image = ImageDB::find($item->image_id);
                $path = 'content/'.$image->filename.'.'.$image->ext;
                $image->delete();
                File::delete($path);
            }
            
            $item->delete();
        }
        $data = json_encode(array('status' => 1));
        return $data;
    }
}
