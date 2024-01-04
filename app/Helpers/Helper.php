<?php

namespace App\Helpers;
use App;
use DB;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Blog;

class Helper
{
    // public static function checkArticleSlug($slug){
	// 	$exist = Articles::select('articles.id')
    //                     ->where('articles.published', 1)
	// 					->where('articles.system_name',$slug)
	// 					->where('show_'.App::getLocale(),1)
    //                     ->where('categories.type','!=' ,'trash')
    //                     ->leftJoin('categories', 'categories.id', '=', 'articles.category_id')->first();
    //     if($exist)return $exist->id;
    //     return false;
    // }

    public static function checkCollectionSlug($slug){
		$exist = Collection::select('id','slug','title')->whereNull('deleted_at')->where('status', 1)->where('slug',$slug)->first();
        if($exist)return array('id'=>$exist->id);
        return false;
    }

    public static function checkProductSlug($slug){
		$exist = Product::select('id')->whereNull('deleted_at')->where('public', 1)->where('url',$slug)->first();
        if($exist)return array('id'=>$exist->id);
        return false;
    }
    public static function checkBlogSlug($slug){
		$exist = Blog::select('id')->where('slug',$slug)->first();
        if($exist)return array('id'=>$exist->id);
        return false;
    }
    public static function checkBrandSlug($slug){
		$exist = DB::table('brends')->select('id')->where('url',$slug)->whereNull('deleted_at')->first();
        if($exist)return array('id'=>$exist->id);
        return false;
    }
//    public static function checkBlogSlug($slug){
//		$exist = Blog::select('id')->where('slug',$slug)->first();
//        if($exist)return array('id'=>$exist->id);
//        return false;
//    }

    public static function checkPermission($roles = []): bool
    {
        $user = Auth::guard('admin')->user();
        return in_array($user->role, $roles);
    }

    // public static function getPathInfo()
    // {
    //     return app('request')->create(URL::previous())->getPathInfo();
    // }
    // public static function isNewCarrier(): bool
    // {
    //     return self::getPathInfo() === '/new-carrier';
    // }
}
