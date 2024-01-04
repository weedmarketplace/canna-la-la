<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\Admin\Logger;
use App\Models\Product;
use App\Events\SendNotification;
use App\Models\Admin\Collection;
use App\Models\Admin\CDataManager;
use App\Models\Admin\Users;



class UserController  extends Controller{


    public function usersIndex()
    {
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;

        view()->share('page', $page);
        view()->share('menu', 'users');
        return view('admin.users.index');
    }

    public function searchUser(Request $request)
    {
        // Get the search term from the request
        $searchTerm = $request->input('term');

        // Query the database for users matching the search term
        $users = Users::where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
                    ->take(10)
                    ->get(['id', 'name', 'phone']);

        // Return the results as JSON
        return response()->json($users);
    }
    public function userData(Request $request)
    {
        $model = new Users();
       
        $filter = array('search' => $request->input('search'),
            'status' => $request->input('filter_status'));

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );

        $data = json_encode(
            array('data' => $items['data'],
                'recordsFiltered' => $items['count'],
                'recordsTotal' => $items['count']));
                
        return $data;
    }

    public function get(Request $request)
    {   
        $id = (int)$request['id'];
        
        if($id){
            $item = Users::findOrFail($id);
            $mode = 'edit';
        }
        if(!$item){
            return json_encode(array('status' => 0, 'message' => 'Item not found'));
        }
        $orderCount = Order::where('owner_id', $id)->count();
        $orderTotalSum = Order::where('owner_id', $id)->sum('total');
        $item->orderCount = $orderCount;
        $item->orderTotalSum = $orderTotalSum;
        $item->userAddresses = false;
        if($item->addresses && json_decode($item->addresses)){
            $item->userAddresses = json_decode($item->addresses);
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.users.item', array('item'=>$item,
                    'mode'=>$mode,
                    'item'=>$item,
                )),'status' => 1)
        );
        return $data;
    }
}