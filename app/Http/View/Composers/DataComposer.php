<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Cart;
use App\Models\Settings;
// use App\Models\Address;
// use Illuminate\Support\Facades\Auth;
use DB;
// use App;

class DataComposer
{
    public $cartData;
    public $favoriteCount;
    public $adminConfig;
    public $topDeal;
    public $shopAddresses;
    public $nestedCollections;

    public function __construct()
    {
    
        $social = Settings::where('key','social_links')->first();
        if ($social){
            $social = json_decode($social->value,true);
        } else {
            $social = [];
        }

        $global_settings = Settings::where('key','global_settings')->first();
        if ($global_settings) {
            $global_settings = json_decode($global_settings->value,true);
        } else {
            $global_settings = [];
        }

        $adminConfig = array_merge($social,$global_settings);
        $this->adminConfig = $adminConfig;

        $deal = DB::table('deals as d')
                    ->select('d.title','p.code')
                    ->leftJoin('promos as p', 'p.id', '=', 'd.promo_id')
                    ->where('d.published', 1)
                    ->where('p.status', 1)
                    ->where('d.type', 1)
                    ->whereNull('d.temp')
                    ->first();
        $this->topDeal = $deal;
        // if(Auth::check()){
        //     $userId = Auth::user()->id;
        //         $user = DB::table('users')->where('id',$userId)->select("favorite")->first();
        //     $userFavorite = json_decode($user->favorite);  
        //     $favoriteCount =$userFavorite ?  count($userFavorite->items) : 0; // Access the 'items' property
        // }
        // else{
        //     $favorite = \Session::get('favorite');
        //     $favoriteCount = $favorite ? count($favorite['items']) : 0;
            
        // }
        
        // $this->favoriteCount = $favoriteCount;


        $this->cartData = (new Cart())->getCartData();
        $collections = DB::table('collections')
                        ->select('id','title','slug','parent_id','image', DB::raw('(SELECT COUNT(*) FROM product WHERE product.parent_id = collections.id AND product.public = 1) as product_count'))
                        ->where('status', 1)
                        ->orderBy('parent_id')
                        ->orderBy('ordering', 'DESC')
                        ->get();
        $this->nestedCollections = $this->buildNestedTree($collections);
        
        // var_dump($this->nestedCollections);
        // exit();
        // $mainColleactions = DB::table('collections')->select('title_'.$lang.' as title','slug','featured')->where('status',1)->orderBy('ordering','DESC')->get();
        // $this->mainColleactions = $mainColleactions;

        // $addresses = Address::select('address_'.$lang.' as address','phone')->whereNull('main')->get();
        // $this->shopAddresses = $addresses;
    }

    function buildNestedTree($items, $parentId = 0) {
        $branch = array();
        foreach ($items as $item) {
            if ($item->parent_id == $parentId) {
                $children = $this->buildNestedTree($items, $item->id);
                if ($children) {
                    $item->children = $children;
                    // Calculate total product count for this category and its descendants
                    $item->total_product_count = $item->product_count;
                    foreach ($children as $child) {
                        $item->total_product_count += $child->total_product_count;
                    }
                } else {
                    // If no children, set total_product_count equal to product_count
                    $item->total_product_count = $item->product_count;
                }
                $branch[] = $item;
            }
        }
        return $branch;
    }
    // function buildNestedTree($items, $parentId = 0) {
    //     $branch = array();
    
    //     foreach ($items as $item) {
    //         if ($item->parent_id == $parentId) {
    //             $children = $this->buildNestedTree($items, $item->id);
    //             if ($children) {
    //                 $item->children = $children;
    //             }
    //             $branch[] = $item;
    //         }
    //     }
    
    //     return $branch;
    // }
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {   
      
        $view->with('topDeal' , $this->topDeal);
        $view->with('cartData' , $this->cartData);
        $view->with('favoriteCount' , $this->favoriteCount);
        $view->with('adminConfig' , $this->adminConfig);
        $view->with('shopAddresses' , $this->shopAddresses);
        $view->with('nestedCollections' , $this->nestedCollections);
    }
}