<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class ImageDB extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    public function get($id){
      $image = DB::table('images')
                ->select('*')
                ->where('id', $id)
                ->first();
      if($image){
        $image->path = asset('images/backendSmall/'.$image->filename.'.'.$image->ext);
        $image->path_original = asset('images/original/'.$image->filename.'.'.$image->ext);
        $image->path_small = asset('images/selfSmall/'.$image->filename.'.'.$image->ext);
        $image->path_medium = asset('images/selfMedium/'.$image->filename.'.'.$image->ext);
        $image->path_large = asset('images/selfLarge/'.$image->filename.'.'.$image->ext);
      }
      return $image;
    }

    public function addCover($image,$product_id){
        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();

        if($image->move('products/', $filename.'.'.$ext)){
            // $oldImage = DB::table('product')->select('img')->where('id', $product_id)->first();
            // if($oldImage){
            //     $path = 'products/'.$oldImage->img;
            //     File::delete($path);
            // }
            DB::table('product')->where('id', $product_id)->update(['img' => $filename.'.'.$ext]);
            return asset('images/backendSmall/'.$filename.'.'.$ext);
        }
        return false;
    }
    public function addBlog($image,$blog_id){
        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();

        if($image->move('content/', $filename.'.'.$ext)){
            DB::table('blog')->where('id', $blog_id)->update(['img' => $filename.'.'.$ext]);
            return asset('images/backendSmall/'.$filename.'.'.$ext);
        }
        return false;
    }
    public function addDeal($image,$deal_id){
        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();

        if($image->move('content/', $filename.'.'.$ext)){
            DB::table('deals')->where('id', $deal_id)->update(['img' => $filename.'.'.$ext]);
            return asset('images/backendSmall/'.$filename.'.'.$ext);
        }
        return false;
    }
    public function addMap($image,$product_id){
        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();

        if($image->move('products/', $filename.'.'.$ext)){
            // $oldImage = DB::table('product')->select('img_region')->where('id', $product_id)->first();
            // if($oldImage){
            //     $path = 'products/'.$oldImage->img_region;
            //     File::delete($path);
            // }
            DB::table('product')->where('id', $product_id)->update(['img_region' => $filename.'.'.$ext]);
            return asset('images/backendSmall/'.$filename.'.'.$ext);
        }
        return false;
    }

    // public function addBase64Image($image,$userId){

    //     $filename = $this->generateFilename();

    //     switch ($image->mime) {
    //         case 'image/png':
    //             $ext = 'png';
    //             break;
    //         case 'image/jpg':
    //             $ext = 'jpg';
    //             break;
    //         case 'image/jpeg':
    //             $ext = 'jpeg';
    //             break;
    //         default:
    //             $ext = 'jpeg';
    //             break;
    //     }

    //     if($image->save('users_avatar/'.$filename.'.'.$ext,100)){

    //         $oldImage = DB::table('users')->select('avatar')->where('id', $userId)->first();
    //         if($oldImage){
    //             $path = 'users_avatar/'.$oldImage->avatar;
    //             File::delete($path);
    //         }
    //         DB::table('users')->where('id', $userId)->update(['avatar' => $filename.'.'.$ext]);
    //         return asset('images/avatar/'.$filename.'.'.$ext);
    //     }
    //     return false;
    // }

    public function removeCover($cover){

        $img = DB::table('product')->select('img')->where('id', $cover)->first();
        if($img){
            $path = 'products/'.$img->img;
            File::delete($path);
        }
        DB::table('product')->where('id', $cover)->update(['img' => NULL]);
    }

    public function removeDeal($deal_id){

        $img = DB::table('deals')->select('img')->where('id', $deal_id)->first();
        if($img){
            $path = 'content/'.$img->img;
            File::delete($path);
        }
        DB::table('deals')->where('id', $deal_id)->update(['img' => NULL]);
    }

    public function removeBlog($blog_id){

        $img = DB::table('blog')->select('img')->where('id', $blog_id)->first();
        if($img){
            $path = 'content/'.$img->img;
            File::delete($path);
        }
        DB::table('blog')->where('id', $blog_id)->update(['img' => NULL]);
    }

    public function removeCollection($collection){

        $img = DB::table('collections')->select('image')->where('id', $collection)->first();
        if($img){
            $path = 'content/'.$img->image;
            File::delete($path);
        }
        DB::table('collections')->where('id', $collection)->update(['image' => NULL]);
    }

    // public function removeCategoryImage($categoryId){
    //     $img = DB::table('categories')->select('icon')->where('id', $categoryId)->first();
    //     if($img){
    //         $path = 'content/'.$img->icon;
    //         File::delete($path);
    //     }
    //     DB::table('categories')->where('id', $categoryId)->update(['icon' => NULL]);
    // }
    // public function master($image,$categoryId){
    //     $filename = $this->generateFilename();
    //     $ext = $image->getClientOriginalExtension();

    //     if($image->move('content/', $filename.'.'.$ext)){
    //         $oldImage = DB::table('categories')->select('icon')->where('id', $categoryId)->first();
    //         if($oldImage){
    //             $path = 'content/'.$oldImage->icon;
    //             File::delete($path);
    //         }
    //         DB::table('categories')->where('id', $categoryId)->update(['icon' => $filename.'.'.$ext]);
    //         return asset('images/backendSmall/'.$filename.'.'.$ext);
    //     }
    //     return false;
    // }

    public function add($image,$gallery_id = false,$temp = 0){
        $filename = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();
        $size = $image->getSize();


        $folder = $gallery_id ? 'products/' : 'content/';

        if($image->move($folder, $filename.'.'.$ext)){
            $data = array();
            if($gallery_id){
                $data['parent_id'] = $gallery_id;

                $max = DB::table('images')->where('parent_id', $gallery_id)->max('ordering');
                $data['ordering'] = (is_null($max) ? 0 : $max + 1);
            }
            if($temp){
                $tempStoreUntil = time() + (3 * 24 * 60 * 60);
                $data['temp'] = $tempStoreUntil;
            }
            $data['size'] = $size;
            $data['filename'] = $filename;
            $data['ext'] = $ext;
            $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();

            $id = DB::table('images')->insertGetId($data);
            return $this->get($id);
        }
        return false;
    }

    public function addOriginal($image,$filename){

      if($image->move('img/', $filename)){
        return true;
      }
      return false;
    }

    public function addCollection($image,$collection){
        $filename = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();

        if($image->move('content/', $filename.'.'.$ext)){
            DB::table('collections')->where('id', $collection)->update(['image' => $filename.'.'.$ext]);
            return asset('content/'.$filename.'.'.$ext);
        }
        return false;
    }


    public function remove($imageId){
        $image = ImageDB::find($imageId);

        // If this image is primary
        // if($image->parent_id){
        //     $product = DB::table('product')->select('id','image_id')->where('gallery_id', $image->parent_id)->first();
        //     if($product && $product->image_id == $image->id){
        //         $otherImage = DB::table('images')->select('id')->where('parent_id', $image->parent_id)->where('id','!=',$image->id)->orderBy('ordering','ASC')->first();
        //         if($otherImage){
        //             DB::table('product')->where('id', $product->id)->update(['image_id' => $otherImage->id]);
        //         }else{
        //             DB::table('product')->where('id', $product->id)->update(['image_id' => null,'status' => 0]);
        //         }
        //     }
        // }

        $folder = $image->parent_id ? 'products/' : 'content/';
        if($image){
            $path = $folder.$image->filename.'.'.$image->ext;
            File::delete($path);

            $image->delete();
        }
    }

    public function generateFilename(){
		return substr(md5(microtime()),0,12);
	}
}
