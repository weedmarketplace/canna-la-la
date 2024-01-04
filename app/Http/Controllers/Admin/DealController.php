<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Deal;
use App\Models\Admin\Promo;
use Illuminate\Http\Request;
use File;

class DealController extends Controller
{
    // Promo
    public function promoIndex()
    {
        view()->share('menu', 'promos');
        return view('admin.deals.promoIndex');
    }

    public function promoData(Request $request){
        $model = new Promo();
        $filter = array(
            'search' => $request->input('search'),
        );

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

    
    public function promoGet(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Promo::find($id);
            $mode = 'edit';
        }else{
            $item = new Promo();
            $item->created_at = date("Y-m-d H:i:s");
            $item->status = 1;
            $item->used = 0;
            $mode= "add";
        }
        
        $data = json_encode(
            array('data' =>
                (String) view('admin.deals.promoItem', array(
                    'item'=>$item,
                    'mode' => $mode
                )),
                'status' => 1)
        );
        return $data;
    }
    public function promoRemove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Promo::find($id);
            $item->delete();
        }
        
        $data = json_encode(array('status' => 1));
        return $data;
    }
    
    public function promoSave(Request $request){
        $validator = \Validator::make($request->all(), [
            'code' => 'required|string|max:50|min:3|unique:promos,code,' . $request->id,
            'type' => 'required|in:percent,fixed',
            'percent' => 'nullable|numeric|between:0,100',
            'amount' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'limit_type' => 'required|in:0,1',
            'count' => 'nullable|int',
            'status' => 'required|in:0,1',
        ]);
        
        $validator->sometimes('percent', 'required', function ($input) {
            return $input->type === 'percent';
        });
        $validator->sometimes('amount', 'required', function ($input) {
            return $input->type === 'fixed';
        });
        $validator->sometimes('count', 'required', function ($input) {
            return $input->limit_type === 1;
        });
        
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }

        $id = $request->input('id');
        if (!$id) {
            $item = new Promo();
        } else {
            $item = Promo::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $item->status = $request->status;
        $item->code = $request->code;
        $item->type = $request->type;
        $item->percent = $item->type == 'percent' ? $request->percent : null;
        $item->amount = $item->type == 'fixed' ? $request->amount : null;
        $item->ftp = isset($request['ftp']) ? 1 : 0;
        if(!$item->ftp){
            $item->limit_type = $request->limit_type;
            $item->count = $item->limit_type == 1 ? $request->count : null;
        }else{
            $item->limit_type = null;
            $item->count = null;
        }
        $item->title = $request->title;
        $item->description = $request->description;
        $item->save();

        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }

    // Deals

    public function dealIndex()
    {
        view()->share('menu', 'deals');
        return view('admin.deals.dealIndex');
    }

    public function dealData(Request $request){
        $model = new Deal();
        $filter = array(
            'search' => $request->input('search'),
        );

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
    
    public function dealGet(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Deal::find($id);
            $mode = 'edit';
        }else{
            $item = new Deal();
            // $item->created_at = date("Y-m-d H:i:s");
            $item->published = 1;
            $item->temp = 1;
            $item->save();
            $mode= "add";
        }

        $promos = Promo::where('status',1)->get();
        $data = json_encode(
            array('data' =>
                (String) view('admin.deals.dealItem', array(
                    'item'=>$item,
                    'promos' => $promos,
                    'mode' => $mode,
                )),
                'status' => 1)
        );
        return $data;
    }
    public function dealRemove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Deal::find($id);
            if($item->img){
                File::delete('content/'.$item->img);
            }
            $item->delete();
        }
        
        $data = json_encode(array('status' => 1));
        return $data;
    }
    
    public function dealSave(Request $request){
        $validator = \Validator::make($request->all(), [
            'id' => 'required|int',
            'title' => 'required|string|max:255',
            'published' => 'required|in:0,1',
            'description' => 'nullable|string',
            'type' => 'required|in:1,2,3,4',
            'promo_id' => 'required|int|exists:promos,id',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'errors' => $validator->getMessageBag()->first()
            ]);
        }

        $id = (int)$request->id;
        $item = Deal::find($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't save"]));

        if($item->temp != null)$item->temp = null;

        $item->published = $request->published;
        $item->title = $request->title;
        $item->description = $request->description;
        $item->type = $request->type;
        $item->promo_id = $request->promo_id;
        
        if ($request->published == 1 && $item->type !=1 && $item->img == null) {
            return json_encode(array('status' => 0, 'errors' => ["Cannot publish without image"]));
        }
        $item->save();
        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }
}
