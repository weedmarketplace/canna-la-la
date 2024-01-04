<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Meta extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meta';
	public $logoPath = 'assets/images/logo1.png';

    public function getMeta($page){
		$meta = DB::table('meta')->select('meta.title','meta.description','images.filename','images.ext')
				->leftJoin('images', 'images.id', '=', 'meta.image_id')	
				->where('pagename', $page)->where('published',1)->first();

		if(!$meta){
			$meta = DB::table('meta')->select('meta.title','meta.description','images.filename','images.ext')
				->leftJoin('images', 'images.id', '=', 'meta.image_id')	
				->where('pagename', 'home')->first();
		}
		if($meta->filename && $meta->ext){
			$meta->imagePath = asset('images/metaThumb/'.$meta->filename.'.'.$meta->ext);
		}else{
			$meta->imagePath =  asset($this->logoPath);
		}
		$meta->locale = 'en_EN';
		$meta->type = 'website';
		$meta->publisher = env('APP_NAME');

    	return $meta;
    }
	public function getItemMeta($item){
		$meta = new \stdClass();
		$meta->title = $item->inheritMeta == 0 ? $item->meta_title : $item->title;
		$meta->description = $item->inheritMeta == 0 ? $item->meta_description : $item->description;
		if($item->img){
			$meta->imagePath = asset('images/metaThumb/'.$item->img);
		}else{
			$meta->imagePath =  asset($this->logoPath);
		}
    	$meta->locale = 'en_EN';
		$meta->type = 'website';
		$meta->publisher = env('APP_NAME');
    	return $meta;
	}
	public function getMetaCollection($item){
		if(!$item){
			return $this->getMeta('shop');
		}
		$meta = new \stdClass();
		$meta->title = $item->inheritMeta == 0 ? $item->meta_title : $item->title;
		$meta->description = $item->inheritMeta == 0 ? $item->meta_description : $item->description;
		$meta->imagePath =  asset($this->logoPath);

    	$meta->locale = 'en_EN';
		$meta->type = 'website';
		$meta->publisher = env('APP_NAME');
    	return $meta;
	}
}