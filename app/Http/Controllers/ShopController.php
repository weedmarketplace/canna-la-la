<?php

namespace App\Http\Controllers;

use App\Models\Admin\ImageDB;
use App\Models\Admin\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Meta;
use App\Models\Product;
use App;
use Illuminate\Support\Collection;

class ShopController extends Controller
{
    public function __construct(Request $request){
        $this->request = $request;
	}

    public function shop($categoryId = false){
        $priceRange = $this->request->input('priceRange', false);
        $priceFrom = false;
        $priceTo = false;
        if($priceRange){
            $priceRange = explode(';', $priceRange);
            $priceFrom = (int)$priceRange[0];
            $priceTo = (int)$priceRange[1];
        }
        $sort = $this->request->input('sort', false);
        $categories = $this->request->input('categories', false);
        if(!$categories && !$this->request->ajax()){
            $categoryId = $categoryId ? (int)$categoryId['id'] : false;
            if($categoryId){
                $categories = [$categoryId];
            }
        }

        // $minPriceSubQuery = DB::table('pricing as p1')
        //     ->select('product_id', DB::raw('MIN(price) as min_price'))
        //     ->where('fixed', 0)
        //     ->groupBy('product_id');

        $query = DB::table('product as p');

        $query->leftJoin('pricing as pw', function($join) {
            $join->on('p.id', '=', 'pw.product_id')
                 ->where('p.pricing_type', '=', 'by_weight')
                 ->where('pw.fixed', 0)
                 ->where('pw.default', 1);  // Assuming you have a 'default' column to indicate the default price.
        });

        // $query->leftJoin('pricing as pw', function($join) use ($minPriceSubQuery) {
        //     $join->on('p.id', '=', 'pw.product_id')
        //          ->where('p.pricing_type', '=', 'by_weight')
        //          ->where('pw.fixed', 0)
        //          ->joinSub($minPriceSubQuery, 'minPricing', function ($join) {
        //              $join->on('pw.product_id', '=', 'minPricing.product_id')
        //                   ->on('pw.price', '=', 'minPricing.min_price');
        //          });
        // });
        
        $query->leftJoin('pricing as pu', function($join) {
            $join->on('p.id', '=', 'pu.product_id')
                 ->where('p.pricing_type', '=', 'by_unit')
                 ->where('pu.fixed', 1);
        });

        $query->leftJoin('collections as c', 'p.parent_id', '=', 'c.id');

        $query->select(
            'p.id', 'p.title', 'p.url', 'p.img', 'c.title as category_title', 'p.discount','p.description','p.pricing_type',
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


        // Consolidated category processing
        if ($categories && count($categories) > 0) {
            $allCategoryIds = array_unique(array_merge(...array_map([$this, 'getSelectedCategoryIds'], $categories)));
            $query->whereIn('p.parent_id', $allCategoryIds);
        }

        $query->where('p.public', 1)->whereNull(['p.temp', 'p.deleted_at']);

        if($priceRange){
            if($priceFrom !== false) {
                $query->havingRaw('effective_price >= ?', [$priceFrom]);
            }
            if($priceTo !== false) {
                $query->havingRaw('effective_price <= ?', [$priceTo]);
            }
        }
        // Simplified sorting
        $sortOptions = [
            'pop' => ['p.ordered_count', 'DESC'],
            'low' => ['effective_price', 'ASC'], // Adjusted for effective price
            'high' => ['effective_price', 'DESC'], // Adjusted for effective price
            'aToz' => ['p.title', 'ASC'],
            'zToa' => ['p.title', 'DESC'],
            'off' => ['discount_amount', 'DESC'],
        ];

        $countQuery = clone $query;
        $totalCount = $countQuery->count();

        $orderBy = $sortOptions[$sort] ?? $sortOptions['pop'];
        $query->orderBy(...$orderBy);

        $page = $this->request->input('page', 1);

        $feed = $query->paginate(24, ['*'], 'page', $page);
        
        // $countQuery = clone $query;
        // $totalCount = $countQuery->count();

        $pricingList = config('constants.pricing');
        $measurementList = config('constants.measurement');
        $productModel = new Product();
        foreach($feed as $product){
            $product->cannabinoid = $productModel->getCannabinoidContent($product);
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
        
        
        $selectedCollection = array();
        $collection = false;
        if($categoryId){
            $collection = DB::table('collections')->select('id','title','description','meta_title','meta_title','meta_description','slug','parent_id','inheritMeta')->where('id',$categoryId)->where('status',1)->first();
            $selectedCollection[] = $collection->id;
            if($collection){
                // $active = $collection->id == $categoryId ? true : false;
                // $breadscrumbData['links'][] = ['title' => $collection->title, 'url' => route('shop',['slug' => $collection->slug]), 'active' => $active];
            }
            if(isset($collection) && $collection->parent_id != 0){
                $parentCol = DB::table('collections')->select('id','title', 'slug','parent_id')->where('id',$collection->parent_id)->where('status',1)->first();
                $selectedCollection[] = $parentCol->id;
                // $active = $parentCol->id == $categoryId ? true : false;
                // $breadscrumbData['links'][] = ['title' => $parentCol->title, 'url' => route('shop',['slug' => $parentCol->slug]), 'active' => $active];
            }
            if(isset($parentCol) && $parentCol->parent_id != 0){
                $parentParentCol = DB::table('collections')->select('id','title', 'slug','parent_id')->where('id',$parentCol->parent_id)->where('status',1)->first();
                $selectedCollection[] = $parentParentCol->id;
                // $active = $parentParentCol->id == $categoryId ? true : false;
                // $breadscrumbData['links'][] = ['title' => $parentParentCol->title, 'url' => route('shop',['slug' => $parentParentCol->slug]), 'active' => $active];
            }
        }
        $breadscrumbData['mainTitle'] = 'Shop';
        $breadscrumbData['links'][] = ['title' => "Shop", 'url' => route('shop'), 'active' => false];
        $breadscrumbData['links'] = array_reverse($breadscrumbData['links']);

        view()->share('totalCount', $totalCount);
        view()->share('selectedCollection', $selectedCollection);
        view()->share('collection', $collection);
        // view()->share('totalCount', $totalCount);
        
        if($this->request->ajax()){
            $girdViewType = $this->request->input('girdViewType', 'forth-grid');
            $gridClass = '';
            switch ($girdViewType) {
                case "forth-grid":
                    $gridClass = 'row-cols-xxl-4';
                    break;
                case 'list-grid':
                    $gridClass = 'row-cols-xxl-4 list-style';
                    break;
            }
            return response()->json([
                'products' => view('app.product-list-item-ajax', ['feed'=>$feed, 'gridClass' => $gridClass])->render(),
                'totalCount' => $totalCount
            ]);
		}
        $metaModel = new Meta();
        $meta = $metaModel->getMetaCollection($collection);
        view()->share('meta', $meta);

        view()->share('feed', $feed);
        view()->share('breadscrumbData', $breadscrumbData);
        return view('app.shop');
    }

    public function getSelectedCategoryIds($categoryId) {
        $selectedCategoryIds = [$categoryId];
    
        // Get the selected category and its immediate parent category
        $category = DB::table('collections')
            ->select('id', 'parent_id')
            ->where('id', $categoryId)
            ->where('status', 1)
            ->first();
    
        if ($category) {
            // If it's a top-level category, fetch IDs from this category and all its subcategories and sub-subcategories
            if ($category->parent_id === 0) {
                $subCategories = DB::table('collections')
                    ->select('id')
                    ->where('id', $categoryId)
                    ->orWhere('parent_id', $categoryId)
                    ->orWhereIn('parent_id', function($query) use ($categoryId) {
                        $query->select('id')
                            ->from('collections')
                            ->where('parent_id', $categoryId);
                    })
                    ->get();
    
                // Extract IDs from subcategories and add them to the selectedCategoryIds array
                foreach ($subCategories as $subCategory) {
                    $selectedCategoryIds[] = $subCategory->id;
                }
            } 
            // If it's a sub-category, fetch its child categories
            else {
                $childCategories = DB::table('collections')
                    ->select('id')
                    ->where('parent_id', $categoryId)
                    ->get();
    
                // Extract IDs from child categories and add them to the selectedCategoryIds array
                foreach ($childCategories as $childCategory) {
                    $selectedCategoryIds[] = $childCategory->id;
                }
            }
        }
    
        return $selectedCategoryIds;
    }

    public function getProduct(){
        $id = (int) $this->request->input('id', false);

        if(!$id) {
            return response()->json(['error' => 'Invalid product ID'], 400);
        }

        $productModel = new Product();
        $product = $productModel->getProductFull($id, false);
        
        return response()->json($product);
    }
    public function product($id){
        $id = $id ? (int)$id['id'] : false;

        if(!$id) {
            return response()->json(['error' => 'Invalid product ID'], 400);
        }

        $productModel = new Product();
        $product = $productModel->getProductFull($id, true);

        //TODO:: get related products, from parent category too
        $relatedProducts = $productModel->getProductList('related',8,$product->parent_id,$product->id);
        $productModel->getSidebar(true,false);

        $metaModel = new Meta();
        $meta = $metaModel->getItemMeta($product);
        view()->share('meta', $meta);

        $breadscrumbData['mainTitle'] = $product->title;
        $breadscrumbData['links'][] = ['title' => 'Shop', 'url' => route('shop'), 'active' => false];
        $breadscrumbData['links'][] = ['title' => $product->title, 'active' => true];
        view()->share('breadscrumbData', $breadscrumbData);
        view()->share('product', $product);
        view()->share('relatedProducts', $relatedProducts);
        return view('app.product');
    }

    public function search(Request $request){

        $queryText = $request->input('q',false);
                
        $feed = false;
        if ($queryText) {
            $query = DB::table('product as p');
            $query->whereRaw("MATCH(p.title) AGAINST(? IN BOOLEAN MODE)", [$queryText]);
            // $queryTextLow = strtolower($queryText);
            // $query->where(function($subQuery) use ($queryTextLow) {
            //     $subQuery->whereRaw('lower(p.title) like ?', ["%{$queryTextLow}%"])
            //              ->orWhereRaw('lower(p.description) like ?', ["%{$queryTextLow}%"])
            //              ->orWhereRaw('lower(p.body) like ?', ["%{$queryTextLow}%"]);
            // });

            $query->leftJoin('pricing as pw', function($join) {
                $join->on('p.id', '=', 'pw.product_id')
                     ->where('p.pricing_type', '=', 'by_weight')
                     ->where('pw.fixed', 0)
                     ->where('pw.default', 1);  // Assuming you have a 'default' column to indicate the default price.
            });
            
            $query->leftJoin('pricing as pu', function($join) {
                $join->on('p.id', '=', 'pu.product_id')
                     ->where('p.pricing_type', '=', 'by_unit')
                     ->where('pu.fixed', 1);
            });
    
            $query->leftJoin('collections as c', 'p.parent_id', '=', 'c.id');
    
            $query->select(
                'p.id', 'p.title', 'p.url', 'p.img', 'c.title as category_title', 'p.discount','p.description','p.pricing_type',
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
    
            $orderBy = ['p.ordered_count', 'DESC'];
            $query->orderBy(...$orderBy);
    
            $page = $this->request->input('page', 1);
    
            $feed = $query->paginate(20, ['*'], 'page', $page);
                
            $pricingList = config('constants.pricing');
            $measurementList = config('constants.measurement');
            $productModel = new Product();
            foreach($feed as $product){
                $product->cannabinoid = $productModel->getCannabinoidContent($product);
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
        }

        $breadscrumbData['mainTitle'] = 'Shop';
        $breadscrumbData['links'][] = ['title' => "Shop", 'url' => route('search'), 'active' => false];
        $breadscrumbData['links'] = array_reverse($breadscrumbData['links']);

        $count = $feed ? $feed->total() : 0;
        view()->share('queryText', $queryText);
        
        if($this->request->ajax()){
            return response()->json([
                'products' => view('app.product-list-item-ajax', ['feed'=>$feed, 'gridClass' => 'search'])->render(),
                'count' => $count
            ]);
		}

        $metaModel = new Meta();
        $meta = $metaModel->getMeta('search');
        view()->share('meta', $meta);

        view()->share('menu', 'search');
        view()->share('count', $count);
        view()->share('feed', $feed);
        view()->share('breadscrumbData', $breadscrumbData);
        return view('app.search');
    }
}