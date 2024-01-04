<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Address;
use App\Models\Admin\Blog;
use App\Models\Admin\Collection;
use App\Models\Admin\ImageDB;
use App\Models\Admin\Meta;
use App\Models\Admin\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;


class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        view()->share('menu', 'address');
        return view('admin.address.index');
    }
    public function AddressData(Request $request){
        $model = new Address();
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
    public function getAddress(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Address::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            return json_encode(array('status' => 0, 'message' => "Id requerid"));
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.address.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );
        return $data;
    }
    public function saveAddress(Request $request){
        $validator  = \Validator::make($request->all(), [
            'name_am'         => 'required|string|nullable',
            'name_en'         => 'required|string|nullable',
            'name_ru'         => 'required|string|nullable',
            'address_am'   => 'required|string|nullable',
            'address_en'   => 'required|string|nullable',
            'address_ru'   => 'required|string|nullable',
            'date_am'   => 'required|string|nullable',
            'date_en'   => 'required|string|nullable',
            'date_ru'   => 'required|string|nullable',
            'date2_am'   => 'required|string|nullable',
            'date2_en'   => 'required|string|nullable',
            'date2_ru'   => 'required|string|nullable',
            'phone'   => 'required|string|nullable|max:55',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }

        $id = $request->input('id');
        if (!$id) {
            return json_encode(array('status' => 0, 'message' => "Id requerid"));
        } else {
            $item = Address::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $validated = $validator->validated();

        $data = $request->all();

        $item->image_id = $request->input('img');
        // $item->published = $request->input('published');
        $item->name_am = $request->name_am;
        $item->name_ru = $request->name_ru;
        $item->name_en = $request->name_en;
        $item->address_am = $request->address_am;
        $item->address_ru = $request->address_ru;
        $item->address_en = $request->address_en;
        $item->date_am = $request->date_am;
        $item->date_ru = $request->date_ru;
        $item->date_en = $request->date_en;
        $item->date2_am = $request->date2_am;
        $item->date2_ru = $request->date2_ru;
        $item->date2_en = $request->date2_en;
        $item->phone = $request->input('phone');
        $id = $item->id;
        $item->save();
        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));

    }

   
    // public function remove(Request $request){
    //     $ids = $request['ids'];
    //     foreach ($ids as $id) {
    //         $item = Address::find($id);
    //         $item->save();
    //         $item->delete();
    //     }

    //     $data = json_encode(array('status' => 1));
    //     return $data;
    // }
}
