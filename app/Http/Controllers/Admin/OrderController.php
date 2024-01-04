<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\Admin\Logger;
use App\Models\Admin\Product;
use App\Events\SendNotification;

class OrderController extends Controller
{
    public function index(){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;

        view()->share('page', $page);
        view()->share('menu', 'orders');
        return view('admin.orders');
    }
    
    public function getOrder(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        
        $order = Order::select('*')->where('id', $id)->first();
        $orderItems =  DB::table('order_items')->where('order_id',$order->id)->get();
        $productModel = new Product();
        foreach($orderItems as $key => $orderItem){
            $product = $productModel->getProductShort($orderItem->product_id,$orderItem->price_id,true);
            $orderItems[$key]->route = $product->route;
            $orderItems[$key]->imagePath = $product->imagePath;
            // $orderItems[$key]->shopPrice = $product->price;
            // $orderItems[$key]->shopSellPrice = $product->effective_price;
            // $orderItems[$key]->shopDiscount = $product->discount;
            $orderItems[$key]->inStock = $product->qty;
        }
        
        $logs =  DB::table('log')->where('owner_id',$order->id)->where('owner_type', 'order')->orderBy('created_at','desc')->get();
        
        $data = [
            'item'=>$order,
            'orderItems'=>$orderItems,
            'logs'=>$logs
        ];

        $template = view('admin.order', $data)->render();
        $res = [
            'data' => $template,
            'status' => 1
        ];
        return response()->json($res);
    }

    public function data(Request $request){
        $model = new Order();

        $filter = array(
            'status' => $request->input('filter_status'),
            'search' => $request->input('search'),
            'userId' => $request->input('filter_user'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
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

    public function saveOrder(Request $request){
        $id = (int)$request['id'];
        $status = $request->status;
        $comment = $request->comment;

        $order = Order::findorfail($id);
        $message = 'Saved!';
        if($status && $status != $order->status){
            $payload = json_encode(array('old_status'=>$order->status,'new_status'=>$status));
            Logger::create(['owner_id' => $order->id,'type' => 'status_changed','data'=>$payload,'created_at' => date("Y-m-d H:i:s"),'owner_type' => 'order']);

            $data = [
                'sku' => $order->sku,
                'hash' => $order->hash,
                'email' => $order->email
            ];
            
            if($status == 'shipping'){
                event(new SendNotification('order_shipping',$data));
            }
            if($status == 'success'){
                event(new SendNotification('order_success',$data));
            }
            if($status == 'canceled'){
                event(new SendNotification('order_canceled',$data));      
            }
            $order->status = $status;
            $message = 'Status changed';
        }
        $order->comment = $comment;
        $order->save();
        return json_encode(array('status' => 1, 'message' => $message));
    }
    public function changeStatus(Request $request){
        $id = (int)$request['id'];
        $status = $request->status;

        $order = Order::findorfail($id);
        $message = 'Saved!';
        if($status && $status != $order->status){
            $payload = json_encode(array('old_status'=>$order->status,'new_status'=>$status));
            Logger::create(['owner_id' => $order->id,'type' => 'status_changed','data'=>$payload,'created_at' => date("Y-m-d H:i:s"),'owner_type' => 'order']);

            $data = [
                'sku' => $order->sku,
                'hash' => $order->hash,
                'email' => $order->email
            ];
            
            $message = 'Status changed';
            if($status == 'shipping'){
                $message = 'Mail sended to customer';
                event(new SendNotification('order_shipping',$data));
            }
            if($status == 'success'){
                $message = 'Mail sended to customer';
                event(new SendNotification('order_success',$data));
            }
            if($status == 'canceled'){
                $message = 'Mail sended to customer';
                event(new SendNotification('order_canceled',$data));      
            }
            $order->status = $status;
            $order->save();
            return json_encode(array('status' => 1, 'message' => $message));
        }
        return json_encode(array('status' => 0, 'message' => "Nothing changed"));
    }
}