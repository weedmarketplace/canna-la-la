<?php

namespace App\Http\Controllers;

use Validator;
use App;
use DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function account(){
        $breadscrumbData['mainTitle'] = "User profile";
        $breadscrumbData['links'][] = ['title' => 'User profile', 'active' => true];

        $user = Auth::guard('web')->user();
        $authUserId = $user->id;
        $query = DB::table('orders')
            ->select('orders.id','orders.address','orders.qty','orders.status','orders.hash','orders.payment_method', 'orders.sku','orders.created_at', 'orders.total', 'orders.notes')
            ->where('orders.owner_id', $authUserId);
        $query->orderBy('orders.id', 'desc');

        $userOrders = $query->paginate(5);
        view()->share('userOrders', $userOrders);
        if($this->request->ajax()){
            return response()->json([
                'orders' => view('app.profile.order-item-ajax', ['userOrders'=>$userOrders])->render()
            ]);
		}
        $wishlist = json_decode($user->wishlist, true);
        $wishlistProducts = [];
        $updatedWishlistItems = [];
        $wishlistChanged = false;
        if($wishlist && count($wishlist['items']) > 0){
            $productModel = new Product();
            foreach($wishlist['items'] as $wl){
                $product = $productModel->getProductShort($wl['id'],$wl['priceId'],true);
                if ($product) {
                    $product->cannabinoid = $productModel->getCannabinoidContent($product);
                    $wishlistProducts[] = $product;
                    $updatedWishlistItems[] = $wl;
                } else {
                    $wishlistChanged = true;
                }
            }
            $wishlistProducts = array_reverse($wishlistProducts);
        }

        if ($wishlistChanged) {
            $wishlist['items'] = $updatedWishlistItems;
            $user->wishlist = json_encode($wishlist);
            $user->save();
        }
        view()->share('wishlistProducts', $wishlistProducts);
        view()->share('breadscrumbData', $breadscrumbData);
        return view('app.profile.account');
    }
    public function editAccount(){
        $user = Auth::guard('web')->user();
        if($user->addresses){
            $addresses = json_decode($user->addresses);
            foreach ($addresses as $address) {
                if($address->main == 1){
                    $user->address = $address->address;
                }
            }
        }else{
            $user->address = '';
        }
        unset($user->password);
        unset($user->recovery_exp);
        unset($user->recovery_hash);
        unset($user->notes);
        unset($user->licanece_number);
        return response()->json($user);
    }
    public function editAddress(Request $request){
        $user = Auth::guard('web')->user();
        
        $addressId = (int)$request->input('address_id', false);
        if($addressId === false){
            return response()->json(['status' => 0, 'message' => 'Address not found']);
        }
        $editAddress = false;
        if($user->addresses){
            $addresses = json_decode($user->addresses);
            foreach ($addresses as $key => $address) {
                if($addressId == $key){
                    $editAddress = $address->address;
                }
            }
        }
        if(!$editAddress){
            return response()->json(['status' => 0, 'message' => 'Address not found']);
        }
        return response()->json(['status' => 1, 'address' => $editAddress]);
    }
    public function orders(){

        $authUserId = Auth::guard('web')->user()->id;
        $query = DB::table('orders')
            ->distinct()
            ->select('orders.id','orders.address','orders.status','orders.hash','orders.payment_method', 'orders.sku')
            ->where('orders.owner_id', $authUserId);

        $feed = $query->paginate(5);
        view()->share('feed', $feed);

        if($this->request->ajax()){
            return response()->json([
                'orders' => view('app.profile.item-ajax', $feed)->render()
            ]);
		}

        return view('app.profile.orders');
    }
}
