<?php
namespace App\Http\Controllers\Admin;

use App\Models\Admin\Article;
use App\Http\Controllers\Controller;
use App\Models\Admin\Collection;
use Illuminate\Http\Request;
use Validator;

class ArticleController extends Controller
{
    public function index(){
        view()->share('menu', 'articles');
        return view('admin.article.index');
    }

    public function data(Request $request){
        $filter = array('search' => $request->input('search'));
        
        $model = new Article();
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

    public function get(Request $request){
        $id = (int)$request['id'];
        if(!$id){
            return response()->json(['status'  => 0,'message' => "Can't find item"]);    
        }
        $item = Article::find($id);
        $template = view('admin.article.item', ['item' => $item])->render();

        $res = ['data' => $template,'status' => 1];
        return response()->json($res, 200);
    }

    public function save(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'title' => 'nullable|string',
            'body' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'  => 0,'message' => $validator->getMessageBag()->first()]);
        }
        $data = $request->all();
        
        $id = $request->input('id');
        if(!$id){
            return response()->json(['status'  => 0,'message' => "Can't find item"]);    
        }
        
        $item = Article::find($id);
        $item->title = $request->title;
        $item->body    = $data['body'];
        $item->save();

        return json_encode(array('status' => 1));
    }
}