<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';

    public function getAddress($page){
        $address = DB::table('address')->select('name','address','image_id')->where('pagename', $page)->where('published',1)->first();
        if(!$address){
            $address = DB::table('address')->select('name','address','image_id')->where('pagename', 'home')->first();
        }
        $address->imagePath =  asset('asset/img/logo.png');
        if($address->image_id){
            $image = DB::table('images')->select('*')->where('id', $address->image_id)->first();
            if($image){
                $address->imagePath = asset('images/blogThumb/'.$image->filename.'.'.$image->ext);
            }
        }
        $address->locale = 'en_EN';
        $address->type = 'website';
        return $address;
    }
//    public function getBlogProduct($id){
//        $blog = DB::table('product')->select('title_am','description','image_id')->where('id', $id)->where('status',1)->whereNull('deleted_at')->first();
//
//        $blog->imagePath =  asset('asset/img/logo.png');
//        if($blog->image_id){
//            $image = DB::table('images')->select('*')->where('id', $blog->image_id)->first();
//            if($image){
//                $blog->imagePath = asset('images/blogThumb/'.$image->filename.'.'.$image->ext);
//            }
//        }
//        $blog->locale = 'en_EN';
//        $blog->type = 'website';
//        return $blog;
//    }
//    public function getBlogCollection($id){
//        $blog = DB::table('collections')->select('title','image_id')->where('id', $id)->where('status',1)->whereNull('deleted_at')->first();
//        $blogHome = DB::table('blog')->select('description')->where('pagename', 'home')->first();
//
//        $blog->description = $blogHome->description;
//        $blog->imagePath =  asset('asset/img/logo.png');
//        if($blog->image_id){
//            $image = DB::table('images')->select('*')->where('id', $blog->image_id)->first();
//            if($image){
//                $blog->imagePath = asset('images/blogThumb/'.$image->filename.'.'.$image->ext);
//            }
//        }
//        $blog->locale = 'en_EN';
//        $blog->type = 'website';
//        return $blog;
//    }
    use HasFactory;
}
