<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Promo;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Pricing;
use App\Models\Admin\Logger;
use App\Events\SendNotification;
use Exception;

class OrderController extends Controller
{
    public function addToCart(Request $request){
        $validator = Validator::make($request->all(),[
            'productId' => 'required|int',
            'priceId' => 'required|int',
            'qty' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $id = (int)$request->productId;
        $priceId = (int)$request->priceId;
        $qty = (int)$request->qty;
        $product = DB::table('product')->select('*')->whereNull('deleted_at')->where('public', 1)->where('id',$id)->first();
        $price = DB::table('pricing')->select('*')->where('product_id',$id)->where('id',$priceId)->first();

        // TODO: check qty to add cart
        // if($price->qty < 1){
        //     return response()->json(['errors' => ["server"=>"Product is out of stock"]], 422);
        // }
        if(!$product || !$price){
            return response()->json(['errors' => ["server"=>"Product or price not found"]], 422);
        }

        if($qty < 1){
            $qty = 1;
        }
        $item = ['id' => $id, 'qty' => $qty, 'priceId' => $priceId];

        $cart = \Session::get('cart');
       
        if(!isset($cart['items'])){
            $cart['items'] = [];
            $cart['items'][] = $item;
        }else{
            $exists = -1;
            foreach($cart['items'] as $key => $value){
                if($value['id'] == $id && $value['priceId'] == $priceId){
                    $exists = $key;
                    break;
                }
            }
            if($exists != '-1'){
                $cart['items'][$exists]['qty'] = $cart['items'][$exists]['qty'] + $qty;
                // TODO: check qty to add cart
                // if($price->qty < $cart['items'][$exists]['qty']){
                //     return response()->json(['errors' => ["server"=>"Product is out of stock"]], 422);
                // }
            }else{
                $cart['items'][] = $item;
            }
        }

        \Session::put('cart', $cart);
        $cartData = (new Cart())->getCartData();
        return json_encode(array('status' => 1, 'cartData' => $cartData));
    }

    public function applyCoupon(Request $request){
        $validator = Validator::make($request->all(),[
            'couponCode' => 'required|string|max:50|min:3'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $couponCode = $request->couponCode;
        $coupon = DB::table('promos')->select('*')->where('code',$couponCode)->where('status',1)->first();
        if(!$coupon){
            return response()->json(['error' => "Coupon not found"], 422);
        }
        if($coupon->ftp == 1){
            $user = Auth::guard('web')->check();
            if(!$user){
                return response()->json(['error' => "This copount only for registerd user"], 422);
            }else{
                $user = Auth::guard('web')->user();
                $order = Order::select('*')->where('owner_id', $user->id)->where('used_coupon_id',$coupon->id)->first();
                if($order){
                    return response()->json(['error' => "This coupon for one time, You already use it"], 422);
                }
            }
        }else{
            if($coupon->limit_type == 1 && $coupon->count <= $coupon->used){
                return response()->json(['error' => "Coupon is expired"], 422);
            }
        }
    
        // Attach coupon to cart
        $cart = \Session::get('cart');
        $couponData = [];
        $couponData['id'] = $coupon->id;
        $couponData['code'] = $coupon->code;
        if($coupon->type == 'percent'){
            $couponData['type'] = 'percent';
            $couponData['percent'] = $coupon->percent;
        }
        if($coupon->type == 'fixed'){
            $couponData['type'] = 'fixed';
            $couponData['amount'] = $coupon->amount;
        }
        $cart['coupon'] = $couponData;
        \Session::put('cart', $cart);
        // 
        
        return response()->json(['status'=>1, 'couponData' => $couponData]);
    }

    public function clearCart(){
        \Session::forget('cart');
        return redirect()->route('shop');
    }
    public function removeCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productId' => 'required|int',
            'priceId' => 'required|int',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $id = (int)$request->productId;
        $priceId = (int)$request->priceId;
        $all = filter_var($request->input('all', true), FILTER_VALIDATE_BOOLEAN);


        $cart = \Session::get('cart');
        if (!isset($cart['items']) || count($cart['items']) == 0) {
            return response()->json(['error' => 'Cart is empty'], 422);
        }

        $itemIndex = -1;
        foreach ($cart['items'] as $key => $value) {
            if ($value['id'] == $id && $value['priceId'] == $priceId) {
                $itemIndex = $key;
                break;
            }
        }

        if ($itemIndex == -1) {
            return response()->json(['error' => 'Can\'t find item in cart'], 422);
        }

        // Remove the item from the cart
        if ($all) {
            // Remove the item from the cart entirely
            unset($cart['items'][$itemIndex]);
        } else {
            // Decrement the quantity of the item
            if ($cart['items'][$itemIndex]['qty'] > 1) {
                $cart['items'][$itemIndex]['qty']--;
            } else {
                // If only 1 item left, remove it entirely
                unset($cart['items'][$itemIndex]);
            }
        }

        if (count($cart['items']) < 1) {
            \Session::forget('cart');
            $cartData = ['count' => 0, 'html' => '', 'total' => '0'];
        } else {
            \Session::put('cart', $cart);
            $cartData = (new Cart())->getCartData(); // Assuming Cart is your model or service that gets cart data
        }

        return json_encode(['status' => 1, 'cartData' => $cartData]);
    }

    public function create(Request $request){
        
        $user = false;
        if(Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
        }
        if(!$user){
            $request->validate([
                'delivery_name'      => 'required|string|max:100',
                'delivery_phone' => ['required', 'regex:/^\+?[0-9]{6,}$/'],
                'delivery_email' => 'email:rfc|required',
                'delivery_address' => 'required|string|max:255',
                'payment_method' => 'required|in:cash,cashless',
                'total'       => 'required|numeric',
                'delivery_notes' => 'nullable|string|max:500',
            ]);
        }else{
            $request->validate([
                'total'       => 'required|numeric',
                'payment_method' => 'required|in:cash,cashless',
                'new_address' => 'required|in:0,1',
                'address' => 'required|string|max:255',
                'delivery_notes' => 'nullable|string|max:500',
            ]);
        }
        $submittedPrice  = floatval($request->total) ?? false;

        $cart = \Session::get('cart');
        if(!$cart || !isset($cart['items']) || !$submittedPrice){
            return response()->json(['errors' => ['message' => "Something wrong, your cart is empty", 'claerCart' => route('clearCart')]], 500);
        }

        $taxes = DB::table('settings')->select('value')->where('key','taxes')->first();
        $taxes = json_decode($taxes->value);
        $taxConfig = [];
        $taxConfig['sales_tax'] = isset($taxes->sales_tax) ? floatval($taxes->sales_tax) : false;
        $taxConfig['excise_tax'] = isset($taxes->excise_tax) ? floatval($taxes->excise_tax) : false;
        $taxConfig['delivery_fee'] = isset($taxes->delivery_fee) ? floatval($taxes->delivery_fee) : false;
        $taxConfig['minimum_order'] = isset($taxes->minimum_order) ? floatval($taxes->minimum_order) : false;

    
        $coupon = false;
        if(isset($cart['coupon'])){
            $couponData = $cart['coupon'];
            $coupon = Promo::select('*')->where('id',$couponData['id'])->where('status',1)->first();
            if(!$coupon){
                return response()->json(['errors' => ['coupon_code' => "Coupon not found"]], 422);
            }
            if($coupon->ftp == 1){
                $user = Auth::guard('web')->check();
                if(!$user){
                    return response()->json(['errors' => ['coupon_code' => "This copount only for registerd user"]], 422);
                }else{
                    $user = Auth::guard('web')->user();
                    $order = Order::select('*')->where('owner_id', $user->id)->where('used_coupon_id',$coupon->id)->first();
                    if($order){
                        return response()->json(['errors' => ['coupon_code' => "This coupon for one time, You already use it"]], 422);
                    }
                }
            }else{
                if($coupon->limit_type == 1 && $coupon->count <= $coupon->used){
                    return response()->json(['errors' => ['coupon_code' => "Coupon is expired"]], 422);
                }
            }
        }
        $products = array();
        $subTotal = 0;
        $totalQty = 0;
        $productModel = new Product();
        $wrongItems = [];
        $orderItems = [];
        foreach($cart['items'] as $cartItem){
            $product = $productModel->getProductShort($cartItem['id'],$cartItem['priceId'],true);
            if(!$product){
                $wrongItems[] = ['product_id' => $cartItem['id'], 'price_id' => $cartItem['priceId']];
                continue;
            }
            if($product->qty < 1){
                $wrongItems[] = ['product_id' => $cartItem['id'], 'price_id' => $cartItem['priceId'], 'message' => 'Product is out of stock'];
            }
            if ($product->qty > 0 && $product->qty < $cartItem['qty']) {
                $wrongItems[] = ['product_id' => $cartItem['id'], 'price_id' => $cartItem['priceId'], 'message' => "Only {$product->qty} left in stock"];
            }
            $product->cart_data = $cartItem;
            // $product->subTotal = number_format($product->effective_price * $cartItem['qty'],2);
            $product->subTotal = $product->effective_price * $cartItem['qty'];
            $subTotal += $product->subTotal;
            $totalQty += $cartItem['qty'];
            $products[] = $product;

            $orderItems[]  = array(
                'product_id'=>$product->id,
                'price_id'=>$product->price_id,
                'unit'=>$product->unit,
                'qty'=>$cartItem['qty'],
                'sell_price'=> $product->effective_price,
                'price'=> $product->price,
                'total'=>$product->subTotal,
                'discount'=> $product->discount,
                'title'=>$product->title,
                'category_title'=>$product->category_title,
            );
        }
        if(count($wrongItems) > 0){
            return response()->json(['errors' => ['item' => $wrongItems]], 422);
        }
        $order = new Order();
        $total = $subTotal;
        if(isset($taxConfig['minimum_order']) && $taxConfig['minimum_order'] > $subTotal){
            return response()->json(['errors' => ['message' => "Minimum order is $".number_format($taxConfig['minimum_order'],2).""]], 500);
        }
        $discountedAmount = false;
        if($coupon){
            if($coupon->type == 'percent'){
                $discountedAmount = ($total * $coupon->percent)/100;
                $discountedAmount  = $discountedAmount;
                $total = $total - $discountedAmount;
            }
            if($coupon->type == 'fixed'){
                $discountedAmount = $cart['coupon']['amount'];
                $total = $total - $discountedAmount;
            }
        }

        $tempTotal = $total;
        if($taxConfig['sales_tax']){
            $salesTaxAmount = $tempTotal * ($taxConfig['sales_tax'] / 100);
            $order->sales_tax = $salesTaxAmount;
            $total += $salesTaxAmount;
        }
        if($taxConfig['excise_tax']){
            $exciseTaxAmount = $tempTotal * ($taxConfig['excise_tax'] / 100);
            $order->excise_tax = $exciseTaxAmount;
            $total += $exciseTaxAmount;
        }
        if($taxConfig['delivery_fee']){
            $order->delivery_fee = $taxConfig['delivery_fee'];
            $total += $taxConfig['delivery_fee'];
        }

        // $total = number_format($total,2);

        if (abs($total - $submittedPrice) > 0.00001){
            try{
                DB::table('report')->insert(['connection' => 'code','queue' => abs($total - $submittedPrice),'message' => 'Wrong total amount','failed_at' => date("Y-m-d H:i:s"), 'payload' => $total.' | '.$submittedPrice.' | '. json_encode($request->all()) . ' | ' . json_encode($cart)]);
            }
            catch (\Exception $e){}
            return response()->json(['errors' => ['server' => "Wrong total amount, connect to admin" ,'claerCart' => route('clearCart')]], 422);
        }
        if(count($orderItems) < 1){
            try{
                DB::table('report')->insert(['connection' => 'code','message' => 'Empty order items','failed_at' => date("Y-m-d H:i:s"), 'payload' => json_encode($request->all()) . ' | ' . json_encode($cart)]);
            }catch (\Exception $e){}
            return response()->json(['errors' => ['server' => 'Wrong order data, connect to support','claerCart' => route('clearCart')]], 422);
        }
        
        //TODO DATE
        // $now = new \DateTime('now');
        // $transactionDate = $now->format('YmdHi') . '00';

        $order->sku =  uniqid("O-");
        $order->hash =  Str::uuid()->toString();
        $order->notes =  $request->delivery_notes;
        if($user){
            $order->owner_id = $user->id;
            $order->fullname = $user->name;
            $order->phone = $user->phone;
            $order->email = $user->email;
            $order->address = $request->address;

            //TODO address
            if($request->new_address == 1){
                $address = json_decode($user->addresses);
                $address[] = ['address' => $request->address, 'main' => 1];
                $user->addresses = json_encode($address);
                $user->save();
            }else{
                $order->address = $request->address;
            }

        }else{
            $order->fullname = $request->delivery_name;
            $order->phone = $request->delivery_phone;
            $order->email = $request->delivery_email;
            $order->address = $request->delivery_address;
        }
        $order->payment_method = $request->payment_method;
        $order->items_price = $subTotal;
        $order->qty    = $totalQty;
        $order->status = 'processing';
        $order->total    = $total;
        if($coupon){
            $order->used_coupon_id = $coupon->id;
            $order->used_coupon_code = $coupon->code;
            $order->used_coupon_discount = $discountedAmount;
        }

        try {
            if (!$order->save()) {
                throw new Exception('Order could not be saved.');
            }
        
            if ($coupon) {
                $coupon->used = $coupon->used + 1;
                $coupon->save();
            }

            foreach ($orderItems as $key => $rd) {
                $orderItems[$key]['order_id'] = $order->id;
                DB::table('pricing')->where('id', $rd['price_id'])->decrement('qty', $rd['qty']);
                DB::table('product')->where('id', $rd['product_id'])->increment('ordered_count', $rd['qty']);
                $this->inStockManagment($rd['product_id']);
            }
            OrderItems::insert($orderItems);
        
            DB::commit();
            
            \Session::forget('cart');
            
            // Turn on log and mail
            Logger::create(['owner_id' => $order->id, 'type' => 'order_created', 'created_at' => date("Y-m-d H:i:s"), 'owner_type' => 'order']);
            event(new SendNotification('order_created', ['id' => $order->id]));
            
            return response()->json(['payment_method' => $order->payment_method, 'status' => 1, 'redirect' => route('checkout_success', ['hash' => $order->hash])]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => ['server' => 'Connect to admin']], 422);
        }
    }
    public function inStockManagment($id){
        $product = Product::select('id','pricing_type')->where('id', $id)->firstOrFail();
        if($product->pricing_type == 'by_unit'){
            $checkInStock = Pricing::select('qty')->where('product_id', $id)->where('fixed', 1)->first();
            if($checkInStock->qty < 1){
                $product->public = 0;
                $product->save();   
            }
            return true;
        }
        if($product->pricing_type == 'by_weight'){
            $lowestPricing = Pricing::where('product_id', $id)
                                    ->where('fixed', 0)
                                    ->where('qty', '>', 0)
                                    ->orderBy('price', 'asc')
                                    ->first();
            if(!$lowestPricing){
                $product->public = 0;
                $product->save();
                return true;
            }
            if ($lowestPricing && $lowestPricing->default != 1) {
                Pricing::where('product_id', $id)->update(['default' => null]);
                
                $lowestPricing->default = 1;
                $lowestPricing->save();
            }
        }
        return true; 
    }
    public function cart(){
        $result = $this->getCartForView();
        
        if(!$result){
            return redirect()->route('shop');
        }
        $breadscrumbData['mainTitle'] = "Cart";
        $breadscrumbData['links'][] = ['title' => 'Cart', 'active' => true];
        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('menu', 'cart');
        return view('app.cart');
    }
    public function checkout(){
        $result = $this->getCartForView();

        if(!$result){
            return redirect()->route('shop');
        }
        $breadscrumbData['mainTitle'] = "Cart";
        $breadscrumbData['links'][] = ['title' => 'Cart', 'active' => true];
        view()->share('breadscrumbData', $breadscrumbData);

        return view('app.checkout');
    }
    public function getCartForView(){
        $cart = \Session::get('cart');

        if(!$cart || !isset($cart['items'])){
            return false;
        }
        $products = array();

        $taxes = DB::table('settings')->select('value')->where('key','taxes')->first();
        $taxes = json_decode($taxes->value);
        $taxConfig = [];
        $taxConfig['sales_tax'] = isset($taxes->sales_tax) ? floatval($taxes->sales_tax) : false;
        $taxConfig['excise_tax'] = isset($taxes->excise_tax) ? floatval($taxes->excise_tax) : false;
        $taxConfig['delivery_fee'] = isset($taxes->delivery_fee) ? floatval($taxes->delivery_fee) : false;

        $subTotal = 0;
        $productModel = new Product();
        $removedItems = false;

        foreach($cart['items'] as $key => $cartItem){
            $product = $productModel->getProductShort($cartItem['id'],$cartItem['priceId'],true);
            if(!$product){
                unset($cart[$key]);
                $removedItems = true;
                continue;
            }
            $product->cart_data = $cartItem;
            $product->subTotal = $product->effective_price * $cartItem['qty'];
            $subTotal += $product->subTotal;
            $products[] = $product;
        }

        if ($removedItems) {
            $cart = array_values($cart); // Re-index the array
            \Session::put('cart', $cart);
    
            // Check if the cart is empty after removal
            if (empty($cart)) {
                // Handle the empty cart scenario
                return response()->json(['message' => 'Your cart is empty.'], 200);
            }
        }

        $couponDiscountData = false;

        $cartSummarize = [];
        $cartSummarize['subTotal'] = $subTotal;
        $total = $subTotal;
        
        if(isset($cart['coupon'])){
            if($cart['coupon']['type'] == 'percent'){
                $discountedAmount = ($total * $cart['coupon']['percent'])/100;
                $discountedAmount  = $discountedAmount;
                $total = $total - $discountedAmount;
            }
            if($cart['coupon']['type'] == 'fixed'){
                $discountedAmount = $cart['coupon']['amount'];
                $total = $total - $discountedAmount;
            }
            $couponDiscountData = ['id' => $cart['coupon']['id'] ,'type' => $cart['coupon']['type'], 'discountedAmount' => $discountedAmount];
            if(isset($cart['coupon']['percent'])){
                $couponDiscountData['size'] = $cart['coupon']['percent']; 
            }
            if(isset($cart['coupon']['amount'])){
                $couponDiscountData['size'] = $cart['coupon']['amount'];
            }
        }
        
        $tempTotal = $total;
        if($taxConfig['sales_tax']){
            $salesTaxAmount = $tempTotal * ($taxConfig['sales_tax'] / 100);
            $cartSummarize['salesTaxAmount'] = $salesTaxAmount;
            $total += $salesTaxAmount;
        }
        if($taxConfig['excise_tax']){
            $exciseTaxAmount = $tempTotal * ($taxConfig['excise_tax'] / 100);
            $cartSummarize['exciseTaxAmount'] = $exciseTaxAmount;
            $total += $exciseTaxAmount;
        }

        if($taxConfig['delivery_fee']){
            $total += $taxConfig['delivery_fee'];
        }
        $cartSummarize['totalPrice'] = $total;

        view()->share('cartSummarize', $cartSummarize);
        view()->share('taxConfig', $taxConfig);
        view()->share('products', $products);
        view()->share('couponDiscountData', $couponDiscountData);
        // view()->share('subTotal', $subTotal);
        // view()->share('totalPrice', $total);
        return true;
    }
    public function checkoutSuccess($hash){
        //TODO:: STATUS CHECK, cash or new or ???
        
        $order = Order::select('*')->where('hash', $hash)->firstOrFail();

        if($order->owner_id && (!Auth::guard('web')->check() || $order->owner_id != Auth::guard('web')->user()->id)){
            return redirect()->route('homepage');
        }
        $orderItems =  DB::table('order_items')->where('order_id',$order->id)->get();
        $productModel = new Product();
        foreach($orderItems as $key => $orderItem){
            $product = $productModel->getProductShort($orderItem->product_id,$orderItem->price_id,true);
            $unavailable = false;
            if(!$product){
                $unavailable = true;
                $product = $productModel->getUnavailable($orderItem->product_id);
            }
            if($product && $product->img){
                $imagePath = asset('images/productList/'.$product->img);
            }else{
                $imagePath = asset('assets/images/nis.png');
            }
            if($product && $unavailable == false && $product->public == 1){
                $orderItems[$key]->url = route('product', ['slug' => $product->url]);
            }else{
                $orderItems[$key]->url = 'javascirpt:void(0)';
            }
            $orderItems[$key]->imagePath = $imagePath;
        }

        $currentRouteName = Route::currentRouteName();
        $pageFor = 'order';
        if ($currentRouteName == 'checkout_success') {
            $pageFor = 'checkout_success';
        }
        view()->share('pageFor', $pageFor);
        // view()->share('listItem', $listItem);
        view()->share('orderItems', $orderItems);
        view()->share('order', $order);
        return view('app.checkout_success');
    }

    public function checkoutFail($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->where('status','new')->firstOrFail();
        
        view()->share('menu', false);
        view()->share('order', $order); 
        return view('app.checkout_fail');
    }
    
    public function checkoutSuccessFail($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->where('status','new')->firstOrFail();
        
        view()->share('menu', false);
        view()->share('order', $order);
        return view('app.checkout_success_fail');   
    }
    // public function order($hash){
    //     $order = Order::select('*')->where('hash', $hash)->where('status','!=','new')->firstOrFail();
    //     $orderItems =  DB::table('order_items')->where('order_id',$order->id)->get();
    //     $productModel = new Product();
    //     foreach($orderItems as $key => $orderItem){
    //         $product = $productModel->getProductWithImage($orderItem->product_id,isset($orderItem->color) ? $orderItem->color: false);
    //         if($product->filename){
    //             $imagePath = asset('images/productList/'.$product->filename.'.'.$product->ext.''); 
    //         }else{
    //             $imagePath = asset('asset/img/product-detail-1.jpg'); 
    //         }
    //         $orderItems[$key]->slug = $product->slug;
    //         $orderItems[$key]->sku = $product->sku;
    //         $orderItems[$key]->imagePath = $imagePath;
    //     }

    //     $country = DB::table('countries')->select('title')->where('id',$order->country_id)->first();
    //     view()->share('country', $country->title);
        
    //     view()->share('orderItems', $orderItems);
    //     view()->share('menu', false);
    //     view()->share('order', $order);
    //     return view('app.order');
    // }
}