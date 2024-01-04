<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blog extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog';

    public function getBlog($page){
		$blog = DB::table('blog')->select('title','description','image_id')->where('pagename', $page)->where('published',1)->first();
		if(!$blog){
			$blog = DB::table('blog')->select('title','description','image_id')->where('pagename', 'home')->first();
		}
		$blog->imagePath =  asset('asset/img/logo.png');
		if($blog->image_id){
			$image = DB::table('images')->select('*')->where('id', $blog->image_id)->first();
			if($image){
				$blog->imagePath = asset('images/blogThumb/'.$image->filename.'.'.$image->ext);
			}
		}
		$blog->locale = 'en_EN';
		$blog->type = 'website';
    	return $blog; 
    }
	public function getBlogProduct($id){
		$blog = DB::table('product')->select('title_am','description','image_id')->where('id', $id)->where('status',1)->whereNull('deleted_at')->first();

		$blog->imagePath =  asset('asset/img/logo.png');
		if($blog->image_id){
			$image = DB::table('images')->select('*')->where('id', $blog->image_id)->first();
			if($image){
				$blog->imagePath = asset('images/blogThumb/'.$image->filename.'.'.$image->ext);
			}
		}
    	$blog->locale = 'en_EN';
		$blog->type = 'website';
    	return $blog; 
	}
	public function getBlogCollection($id){
		$blog = DB::table('collections')->select('title','image_id')->where('id', $id)->where('status',1)->whereNull('deleted_at')->first();
		$blogHome = DB::table('blog')->select('description')->where('pagename', 'home')->first();

		$blog->description = $blogHome->description;
		$blog->imagePath =  asset('asset/img/logo.png');
		if($blog->image_id){
			$image = DB::table('images')->select('*')->where('id', $blog->image_id)->first();
			if($image){
				$blog->imagePath = asset('images/blogThumb/'.$image->filename.'.'.$image->ext);
			}
		}
    	$blog->locale = 'en_EN';
		$blog->type = 'website';
    	return $blog; 
	}
}