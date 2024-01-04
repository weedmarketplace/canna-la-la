<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Admin\Collection;
use App\Models\Admin\Settings;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Logger;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
// use App\Models\Admin\Subscription;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cal_percentage($num_amount, $num_total) {
        if(!$num_amount || !$num_total)
        return 0;
        $count1 = $num_amount / $num_total;
        $count2 = $count1 * 100;
        $count = number_format($count2, 0);
        return $count;
    }

    public function dashboard()
    {
        $logs = Logger::whereIn('type',['order_created','status_changed','signup'])->orderByDesc('id')->limit(7)->get();

        if($logs){
            foreach($logs as $k => $l){
                if($l->owner_type == 'order'){
                    $order = DB::table('orders')->select('sku')->where('id',$l->owner_id)->first();
                    $l->sku =  $order->sku;
                    if($l->type == "status_changed"){
                       $l->data = json_decode($l->data);
                    }
                }
                if($l->owner_type == 'user'){
                    $user = DB::table('users')->select('name')->where('id',$l->owner_id)->first();
                    $l->fullname = $user->name;
                }
                $l->humanTime = Carbon::createFromFormat('Y-m-d H:i:s', $l->created_at)->diffForHumans(null, true);
            }
        }
        $ordersDone =  DB::table('orders')->where('status','success')->count();
        $ordersShipping =  DB::table('orders')->where('status','shipping')->count();
        $ordersTotal =  DB::table('orders')->where('status','!=','canceled')->count();
        $ordersAll =  DB::table('orders')->count();
        $ordersPercent = $this->cal_percentage($ordersDone,$ordersTotal);
        
        $processing =  DB::table('orders')->where('status','processing')->count();
        $canceled =  DB::table('orders')->where('status','canceled')->count();
        // $orders =  DB::table('orders')->where('status','success')->count();
        $total =   DB::table('orders')->where('status','success')->sum('total');

        $date = new \DateTime;
        $date->modify('-6 month');
        $previousYear = $date->format('Y-m-d H:i:s');
        $billingsData = DB::table('orders')->where('status','success')->where('created_at','>', $previousYear)->get();
        $orderData = DB::table('orders')->where('status','success')->where('created_at','>', $previousYear)->get();

        // var_dump($orderData);
        // var_dump($billingsData);
        // exit();
        for ($i = 5; $i >= 0 ; $i--) {
            $date = new \DateTime;
            if($i > 0){
                $date->modify('-'.$i.' month');
            }
            $chartData['month_title'][] = $date->format('M');
            $period = $date->format('Y-m');

            $orderCount = 0;
            foreach($orderData as $ordeData){
                $orderCreated = substr($ordeData->created_at,0,7);
                if($period == $orderCreated){
                    $orderCount++;
                }
            }
            $chartData['orders_count'][] = $orderCount;

            $revenueSum = 0;
            foreach($billingsData as $bl){
                $billingCreated = substr($bl->created_at,0,7);
                if($period == $billingCreated){
                    $revenueSum = $revenueSum+$bl->total;
                }
            }
            $chartData['revenues'][] = $revenueSum;
        }

        view()->share('chartData', $chartData);
        view()->share('ordersDone', $ordersDone);
        view()->share('ordersTotal', $ordersTotal);
        view()->share('ordersAll', $ordersAll);
        view()->share('ordersShipping', $ordersShipping);
        view()->share('total', $total);
        // view()->share('orders', $orders);
        view()->share('processing', $processing);
        view()->share('canceled', $canceled);
        view()->share('ordersPercent', $ordersPercent);
        view()->share('logs', $logs);
        view()->share('menu', 'dashboard');
        return view('admin.dashboard');
    }

    public function profile(){
        return view('admin.profile');
    }

    public function saveSettings(Request $request){
        $data = $request->all();

        // DB::table('settings')->where('key', 'rso_rate')->update(['value' => $data['rso_rate']]);
        // DB::table('settings')->where('key', 'rs_rate')->update(['value' => $data['rs_rate']]);

        return json_encode(array('status' => 1));
    }

    public function saveContact(Request $request){
        $data = $request->all();

        DB::table('settings')->where('key', 'contact_email')->update(['value' => $data['contact_email']]);
        DB::table('settings')->where('key', 'discord_link')->update(['value' => $data['discord_link']]);

        return json_encode(array('status' => 1));
    }
}
