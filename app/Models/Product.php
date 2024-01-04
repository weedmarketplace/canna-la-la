<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
	use HasFactory;
    protected $table = 'product';

    public function getProductList($flag = false, $limit = 10, $categoryId = false, $productIdNot = false){
        $query = DB::table('product as p');

        $query->leftJoin('pricing as pw', function($join) {
            $join->on('p.id', '=', 'pw.product_id')
                 ->where('p.pricing_type', '=', 'by_weight')
                 ->where('pw.fixed', 0)
                 ->where('pw.default', 1);
        });

        $query->leftJoin('pricing as pu', function($join) {
            $join->on('p.id', '=', 'pu.product_id')
                 ->where('p.pricing_type', '=', 'by_unit')
                 ->where('pu.fixed', 1);
        });

        $query->leftJoin('collections as c', 'p.parent_id', '=', 'c.id');

        $query->select(
            'p.id', 'p.title', 'p.url', 'p.img', 'c.title as category_title', 'p.discount','p.description','p.pricing_type','p.ordered_count',
            'p.thc','p.cbd','p.thc_milligrams','p.cbd_milligrams',
            DB::raw('COALESCE(pw.price, pu.price) as price'),
            DB::raw('ROUND(COALESCE(pw.price, pu.price) * (1 - (COALESCE(p.discount, 0) / 100)), 2) as effective_price'),
            DB::raw('COALESCE(p.discount, 0) as discount_amount'),
            DB::raw('COALESCE(pw.weight_custom_num, pu.weight_custom_num) as weight_custom_num'),
            DB::raw('COALESCE(pw.weight_custom_unit, pu.weight_custom_unit) as weight_custom_unit'),
            DB::raw('COALESCE(pw.weight_id, pu.weight_id) as weight_id'),
            DB::raw('COALESCE(pw.id, pu.id) as price_id'),
            DB::raw('COALESCE(pw.qty, pu.qty) as qty'),
            DB::raw('COALESCE(pw.fixed, pu.fixed) as fixed')
        );

        $query->where('p.public', 1)->whereNull(['p.temp', 'p.deleted_at']);

        if($categoryId){
            $query->where('p.parent_id', $categoryId);
            if($productIdNot){
                $query->where('p.id', '!=', $productIdNot);
            }
        }
        $sort = 'rand';
        if($flag != 'related'){
            if($flag != 'pop'){
                $query->where('p.'.$flag,1);
            }else{
                $sort = 'pop';
            }
        }

        // Simplified sorting
        $sortOptions = [
            'pop' => ['p.ordered_count', 'DESC'],
            'low' => ['effective_price', 'ASC'],
            'high' => ['effective_price', 'DESC'],
            'aToz' => ['p.title', 'ASC'],
            'zToa' => ['p.title', 'DESC'],
            'off' => ['discount_amount', 'DESC'],
            'rand' => [DB::raw('RAND()')],
        ];
        
        if($limit){
            $query->take($limit);
        }

        $orderBy = $sortOptions[$sort] ?? $sortOptions['pop'];
        $query->orderBy(...$orderBy);

        // $sql = $query->toSql();
        // $bindings = $query->getBindings();

        $feed = $query->get();

        
        // $countQuery = clone $query;
        // $totalCount = $countQuery->count();

        $pricingList = config('constants.pricing');
        $measurementList = config('constants.measurement');
        foreach($feed as $product){
            $product->cannabinoid = $this->getCannabinoidContent($product);
            if($product->img){
                $product->imagePath = asset('images/productList/'.$product->img);
            }else{
                $product->imagePath = asset('assets/images/nis.png');
            }
            if($product->pricing_type == 'by_weight'){
                if(!isset($product->weight_custom_unit)){
                    $product->unit = $pricingList[$product->weight_id];
                }else{
                    $product->unit = $product->weight_custom_num.' '.$measurementList[$product->weight_custom_unit];
                }
            }else{
                $product->unit = '1 Unit';
            }
        }
        return $feed;
    }
    public function getProductShort($id, $priceId, $aditional = false)
    {
        $query = DB::table('product as p')
            ->join('pricing as pr', function($join) use ($id, $priceId) {
                $join->on('p.id', '=', 'pr.product_id')
                    ->where('pr.id', $priceId);
        });
        $query->select(
            'p.id', 'p.title', 'p.url','p.img','p.public', 'p.pricing_type','pr.price', 'pr.qty', 'pr.id as price_id', 'pr.weight_id', 'pr.weight_custom_num', 'pr.weight_custom_unit',
            DB::raw('ROUND(pr.price * (1 - (COALESCE(p.discount, 0) / 100)), 2) as effective_price')
        )->where('p.id', $id);

        if($aditional){
            $query->leftJoin('collections as c', 'p.parent_id', '=', 'c.id');
            $query->addSelect('c.title as category_title', 'p.discount', 'p.description', 'p.thc','p.cbd','p.thc_milligrams','p.cbd_milligrams');
        }

        $query->where('p.public', 1)->whereNull(['p.temp', 'p.deleted_at']);
        $productWithPrice = $query->first();

        if (!$productWithPrice) {
            return null;
        }

        // Image path
        if ($productWithPrice->img) {
            $productWithPrice->imagePath = asset('images/productItem/' . $productWithPrice->img);
        } else {
            $productWithPrice->imagePath = asset('assets/images/nis.png');
        }

        $productWithPrice->route = route('product', ['slug' => $productWithPrice->url]);
        // Handle price unit based on pricing type
        $pricingList = config('constants.pricing');
        $measurementList = config('constants.measurement');
        if ($productWithPrice->pricing_type == 'by_weight') {
            if (isset($pricingList[$productWithPrice->weight_id])) {
                $productWithPrice->unit = $pricingList[$productWithPrice->weight_id];
            } else {
                $productWithPrice->unit = $productWithPrice->weight_custom_num.' '.$measurementList[$productWithPrice->weight_custom_unit];
            }
        } else {
            $productWithPrice->unit = '1 Unit';
        }
        $productWithPrice->effective_price = $productWithPrice->effective_price;
        return $productWithPrice;
    }
    public function getUnavailable($id)
    {
        $query = DB::table('product');
        $query->select('img','public')->where('id', $id);

        $query->whereNull(['temp', 'deleted_at']);
        $product = $query->first();
        return $product;
    }

    public function getCannabinoidContent($product){
        $thcContent = isset($product->thc) ? "{$product->thc}%" : (isset($product->thc_milligrams) ? "{$product->thc_milligrams} mg" : '');
        $cbdContent = isset($product->cbd) ? "{$product->cbd}%" : (isset($product->cbd_milligrams) ? "{$product->cbd_milligrams} mg" : '');
    
        if ($thcContent && $cbdContent) {
            return $thcContent . ' THC | ' . $cbdContent . ' CBD';
        } elseif ($thcContent) {
            return $thcContent . ' THC';
        } elseif ($cbdContent) {
            return $cbdContent . ' CBD';
        }
        return false;
    }
    public function getProductFull($id, $aditional = false)
    {
        // $minPriceSubQuery = DB::table('pricing as mp')
        //     ->select('mp.product_id', DB::raw('MIN(mp.price) as min_price'))
        //     ->where('mp.fixed', 0)
        //     ->groupBy('mp.product_id');

        // $query = DB::table('product as p')
        // ->leftJoin('collections as c', 'p.parent_id', '=', 'c.id')
        // ->leftJoinSub($minPriceSubQuery, 'minPricing', function($join) {
        //     $join->on('p.id', '=', 'minPricing.product_id');
        // })
        // ->leftJoin('pricing as pw', function($join) {
        //     $join->on('p.id', '=', 'pw.product_id')
        //         ->on('pw.price', '=', 'minPricing.min_price')
        //         ->where('p.pricing_type', '=', 'by_weight')
        //         ->where('pw.fixed', 0);
        // })
        // ->leftJoin('pricing as pu', function($join) {
        //     $join->on('p.id', '=', 'pu.product_id')
        //         ->where('p.pricing_type', '=', 'by_unit')
        //         ->where('pu.fixed', 1);
        // });

        $query = DB::table('product as p')
            ->leftJoin('collections as c', 'p.parent_id', '=', 'c.id')
            ->leftJoin('pricing as pw', function($join) {
                $join->on('p.id', '=', 'pw.product_id')
                    ->where('p.pricing_type', '=', 'by_weight')
                    ->where('pw.fixed', 0)
                    ->where('pw.default', 1); // Added this line to fetch rows where `default` is 1
            })
            ->leftJoin('pricing as pu', function($join) {
                $join->on('p.id', '=', 'pu.product_id')
                    ->where('p.pricing_type', '=', 'by_unit')
                    ->where('pu.fixed', 1);
            });

        $query->select(
            'p.id', 'p.title', 'p.url','p.parent_id','p.img', 'p.discount', 'p.description', 'p.pricing_type','c.title as category_title',
            'p.thc','p.cbd','p.thc_milligrams','p.cbd_milligrams','p.strain','p.genetic','p.meta_title','p.meta_description','p.inheritMeta',
            // DB::raw('COALESCE(minPricing.min_price, pu.price) as price'),
            // DB::raw('ROUND(COALESCE(minPricing.min_price, pu.price) * (1 - (COALESCE(p.discount, 0) / 100)), 2) as effective_price'),
            DB::raw('COALESCE(pw.price, pu.price) as price'), // Assuming that pw.price will have the default price for fixed = 0
            DB::raw('ROUND(COALESCE(pw.price, pu.price) * (1 - (COALESCE(p.discount, 0) / 100)), 2) as effective_price'),
            DB::raw('COALESCE(pw.weight_custom_num, pu.weight_custom_num) as weight_custom_num'),
            DB::raw('COALESCE(pw.weight_custom_unit, pu.weight_custom_unit) as weight_custom_unit'),
            DB::raw('COALESCE(pw.weight_id, pu.weight_id) as weight_id'),
            DB::raw('COALESCE(pw.id, pu.id) as price_id'),
            DB::raw('COALESCE(pw.fixed, pu.fixed) as fixed')
        )->where('p.id', $id);
        
        if($aditional){
            $query->addSelect('p.gallery_id','p.body');
        }

        $product = $query->first();
        $product->cannabinoid = $this->getCannabinoidContent($product);
        
        $pricingList = config('constants.pricing');
        $measurementList = config('constants.measurement');
        
        if(isset($product->strain)){
            $strainsList = config('constants.strains');
            $product->strain = $strainsList[$product->strain];
        }
        if(isset($product->genetic)){
            $geneticList = config('constants.genetics');
            $product->genetic = $geneticList[$product->genetic];
        }

        if($product->img){
            $product->imagePath = asset('images/productItem/'.$product->img);
        }else{
            $product->imagePath = asset('assets/images/nib.png');
        }
        
        if($product->pricing_type == 'by_weight'){
            $product->prices_by_weight = $this->getProductPricesByWeight($product->id);

            foreach ($product->prices_by_weight as $price) {
                if (!isset($price->weight_custom_unit)) {
                    $price->unit = $pricingList[$price->weight_id];
                }else{
                    $price->unit = $price->weight_custom_num.' '.$measurementList[$price->weight_custom_unit];
                }
            }
        }else{
            $product->unit = '1 Unit';
        }
        $product->route = route('product', ['slug'=>$product->url]);

        if($aditional){
            $images = array();
            if($product->img){
                $images[] = ['small' => asset('images/productList/'.$product->img), 'big' => asset('images/productItem/'.$product->img)];
            }
            if ($product->gallery_id){
                $gallery = DB::table('images')->select('filename','ext')->where('parent_id',$product->gallery_id)->orderBy('images.ordering','asc')->get();
                if(count($gallery) > 0){
                    foreach($gallery as $img){
                        $images[] = ['small' => asset('images/productList/'.$img->filename.'.'.$img->ext), 'big' => asset('images/productItem/'.$img->filename.'.'.$img->ext)];
                    }
                }
            }
            $product->images = $images;
            if(count($product->images) < 1){
                $product->images[] = ['small' => asset('assets/images/nis.png'), 'big' => asset('assets/images/nib.png')];
            }
        }
        return $product;
    }

    public function getProductPricesByWeight($productId) {
        return DB::table('pricing')
            ->where('product_id', $productId)
            ->where('fixed', 0)
            ->where('qty', '>', 0)
            ->select(
                'price', 
                'weight_custom_num', 
                'weight_custom_unit', 
                'weight_id',
                'id as price_id', 
                DB::raw('ROUND(price * (1 - (COALESCE((SELECT discount FROM product WHERE id = ?), 0) / 100)), 2) as effective_price')
            )
            ->addBinding($productId, 'select') // Bind the productId to the select statement.
            ->get();
    }

    public function getSidebar($trendingBlock = false, $dealBlock = false){
        $sidebarExist = false;
        if($trendingBlock){
            $trandingProducts = $this->getProductList('trending',4);
            $deals = DB::table('deals as d')
                        ->select('d.title','d.description','d.img','p.code','d.type')
                        ->leftJoin('promos as p', 'p.id', '=', 'd.promo_id')
                        ->where('d.published', 1)
                        ->where('p.status', 1)
                        ->where('d.type','!=', 1)
                        ->whereNull('d.temp')
                        ->get();

            if($trandingProducts && count($trandingProducts) > 0){
                $sidebarExist = true;
            }
            view()->share('trandingProducts', $trandingProducts);
        }
        if($dealBlock){
            $dealsArray = false;
            if($deals && count($deals) > 0){
                $dealsArray = $deals->groupBy('type')->map(function ($item) {
                            return $item->toArray();
                        })->all();
            }
            
            
            if($dealsArray && (isset($dealsArray[3]) || isset($dealsArray[4]))){
                $sidebarExist = true;
            }
            view()->share('dealsArray', $dealsArray);
        }
        view()->share('sidebarExist', $sidebarExist);
        return true;
    }
}
