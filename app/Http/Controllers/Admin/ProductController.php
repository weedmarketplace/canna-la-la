<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Collection;
use App\Models\Admin\Pricing;
use App\Models\Admin\Gallery;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(){
        $result = Collection::select('id','title','parent_id')->orderBy('title', 'asc')->whereNull('deleted_at')->get();
        
        $cats = [];
        if  (count($result) > 0){
            foreach($result as $cat){
                $cats[$cat['parent_id']][$cat['id']] =  $cat;
            }
            $cats = Collection::build_options_tree($cats,0,'-',false,false,[]);
        }
        if(!$cats){
            $cats = '';
        }

        view()->share('collections', $cats);
        view()->share('menu', 'products');
        return view('admin.product.index');
    }

    public function get(Request $request){
        $id = (int)$request['id'];

        $customVariations = false;
        if ($id) {
            $item = Product::findOrFail($id);
            if(!$item){
                return json_encode(array('status' => 0 , 'message' => 'Product not found'));
            }
            $customVariations = Pricing::where('product_id', $id)
                            ->where('fixed', 0)
                            ->whereNull('weight_id')
                            ->get(['id','weight_custom_num as num','weight_custom_unit as unit','price','cost','qty']);
        } else {
            $item = new Product();
            $item->created_at = date("Y-m-d H:i:s");
            $item->public = 0;
            $item->inheritMeta = 1;
            $item->temp = 1;
        }

        $hasGallery = true;
        if($item->gallery_id == null){
            $hasGallery = false;
            $model = new Gallery();
            $model->temp = null;
            $model->save();
            $item->gallery_id = $model->id;
            $item->save();
        }

        $result = Collection::select('id','title','parent_id')->orderBy('title', 'asc')->whereNull('deleted_at')->get();
        
        $cats = [];
        if  (count($result) > 0){
            foreach($result as $cat){
                $cats[$cat['parent_id']][$cat['id']] =  $cat;
            }

            $selectedArray = [$item->parent_id];
            $parentIds = Collection::getParentAndGrandparentIds($item->parent_id, $result);
            $selectedArray = array_merge($selectedArray, $parentIds);
            
            $cats = Collection::build_options_tree($cats,0,'-',false,false,$selectedArray,'radio');
        }
        if(!$cats){
            $cats = '';
        }

        $pricingByWeight = Pricing::where('fixed',0)->whereNull('weight_custom_unit')->whereNotNull('weight_id')->where('product_id',$id)->get();
        $pricingByUnit = Pricing::where('fixed',1)->where('product_id',$id)->first();
        $pricingByUnit = $pricingByUnit ? $pricingByUnit : new Pricing();

        $strains = config('constants.strains');
        $genetics = config('constants.genetics');
        $pricing = config('constants.pricing');
        $measurement = config('constants.measurement');
        $features = config('constants.features');

        $fillPricing = array();
        foreach ($pricing as $key => $value) {
            $pricingData = $pricingByWeight->where('weight_id', $key)->first();
        
            if ($pricingData) {
                $fillPricing[$key]['price'] = $pricingData->price;
                $fillPricing[$key]['cost'] = $pricingData->cost;
                $fillPricing[$key]['qty'] = $pricingData->qty;
            }
        }

        $data = json_encode(
            array('data' =>
                (String) view('admin.product.item', array('item'=>$item,
                                                    'hasGallery'=>$hasGallery,
                                                    'strains'=>$strains,
                                                    'genetics'=>$genetics,
                                                    'collections'=>$cats,
                                                    'pricing'=>$pricing,
                                                    'measurement'=>$measurement,
                                                    'pricingByUnit'=>$pricingByUnit,
                                                    'fillPricing'=>$fillPricing,
                                                    'features'=>$features,
                                                    'customVariations' => $customVariations,
                                                    'currentPairingIds'=>[],
                                                    'otherProducts'=>[],
                                                    'raitingOrder'=>[],
                                                    'attributes'=>[],
                                                    'footPairing'=>[],
                                                    'brends'=>[],
                                                    'countries'=>[],
                                                    'logs'=>false,
                                                )),'status' => 1)
            );
        return $data;
    }

    public function data(Request $request){
        $model = new Product();

        $filter = array(
            'search' => $request->input('search'),
            'status' => $request->input('filter_status'),
            'category' => $request->input('filter_category'),
            'inStock' => $request->input('inStock'),
        );

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function deleteVariation(Request $request)
    {
        $variationId = $request->input('id');
        $variation = Pricing::find($variationId);

        if ($variation) {
            $variation->delete();
            $this->setDefaultPirce($variation->product_id);
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function save(Request $request){
        $id = (int)$request['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required|int',
            'title' => 'required|string|max:255',
            'status' => 'required|in:0,1',
            // 'collection' => 'required|exists:collections,id',
            'description' => 'nullable|string',
            'body' => 'nullable|string',
            'discount' => 'nullable|int|between:0,100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'strain' => 'required|int',
            'genetic' => 'required|int',
            'pricing_type' => 'required|in:by_weight,by_unit',
            'category_level_0' => [
                'required_without_all:category_level_1,category_level_2',
                Rule::exists('collections', 'id')
            ],
            'category_level_1' => [
                'nullable',
                // 'required_without:category_level_2',
                Rule::exists('collections', 'id')
            ],
            'category_level_2' => 'nullable|exists:collections,id'
        ]);

        if ($validator->fails())return response()->json(['status'=>0,'errors'=>$validator->errors()->first()]);

        if ($validator->passes()) {
            $collection = $request->input('category_level_2') ?? 
                            $request->input('category_level_1') ?? 
                            $request->input('category_level_0');
        }

        if(!$collection){
            return json_encode(array('status' => 0, 'errors' => ["Please select category"]));
        }

        // $url = strtolower(str_replace(' ', '-', $request->url));
        // $checkSlug = Product::where('url', $url)->where('id','!=',$id)->whereNull('temp')->first();
        // if($checkSlug)return json_encode(array('status' => 0, 'errors' => ["Url already exist"]));

        $item = Product::findorFail($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't find product"]));

        // if (empty($item->url) || $item->url == '' || $item->url == null) {
        $baseSlug = strtolower(str_replace([' ', '_','%','/'], '-', $request->title));
        // $baseSlug = strtolower(str_replace([' ', '_'], '-', $request->title));
        $url = $baseSlug;
        $counter = 0;
        do {
            if ($counter > 0) {
                $url = $baseSlug . $counter;
            }

            $checkSlug = Product::where('url', $url)
                                ->where('id', '!=', $id)
                                ->whereNull('temp')
                                ->first();
            $counter++;
        } while ($checkSlug);
        $item->url = $url;
        // }

        if($item->temp != null)$item->temp = null;

        $features = config('constants.features');
        foreach($features as $feature){
            $item->$feature = $request->$feature ? $request->$feature : null;
        }

        $item->title = $request->title;
        $item->description = $request->description;
        $item->body = $request->body;
        $item->parent_id = $collection;
        
        $item->thc = $request->thc;
        $item->cbd = $request->cbd;
        $item->thc_milligrams = $request->thc_milligrams;
        $item->cbd_milligrams = $request->cbd_milligrams;
        
        if($request->strain && $request->strain != '-1'){
            $item->strain = $request->strain;
        }else{
            $item->strain = null;
        }
        if($request->genetic && $request->genetic != '-1'){
            $item->genetic = $request->genetic;
        }else{
            $item->genetic = null;
        }

        $item->discount = $request->discount;
        $item->pricing_type = $request->pricing_type;
        
        /// Pricing
        if($item->pricing_type == 'by_unit'){
            $fixedPrice = Pricing::where('product_id',$id)->where('fixed',1)->first();
            if(!$fixedPrice){
                $fixedPrice = new Pricing();
                $fixedPrice->product_id = $id;
                $fixedPrice->created_at = date("Y-m-d H:i:s");
                $fixedPrice->fixed = 1;
            }
            $fixedPrice->price = $request->unit_price;
            $fixedPrice->cost = $request->unit_cost;
            $fixedPrice->qty = isset($request->unit_count) ? $request->unit_count : 1000;
            $fixedPrice->save();
            
            Pricing::where('product_id', $id)->where('fixed', 0)->delete();
        }

        if($item->pricing_type == 'by_weight'){
            foreach ($request->input('weight_price') as $key => $price) {
                $pricing = Pricing::where('product_id',$id)->where('weight_id',$key)->where('fixed',0)->first();
                
                if ($pricing) {
                    if($request->input('weight_price.' . $key) > 0){
                        $pricing->price = $request->input('weight_price.' . $key);
                        $pricing->cost = $request->input('weight_cost.' . $key);
                        $prQty = $request->input('weight_count.' . $key);
                        $pricing->qty = isset($prQty) ? $prQty : 1000;
                        $pricing->save();
                    }else{
                        $pricing->delete();
                    }
                } else {
                    if($request->input('weight_price.' . $key) > 0){
                        $newPricing = new Pricing();
                        $newPricing->product_id = $id;
                        $newPricing->price = $request->input('weight_price.' . $key);
                        $newPricing->cost = $request->input('weight_cost.' . $key);
                        $prQty = $request->input('weight_count.' . $key);
                        $newPricing->qty = isset($prQty) ? $prQty : 1000;
                        $newPricing->weight_id = $key;
                        $newPricing->fixed = 0;
                        $newPricing->created_at = date("Y-m-d H:i:s");
                        $newPricing->save();
                    }
                }
            }

            if ($request->has('variations')) {
                $validVariationIds = [];
            
                foreach ($request->input('variations.num') as $index => $num) {
                    $variationId = $request->input("variations.id.$index");
                    $unit = $request->input("variations.unit.$index");
                    $price = $request->input("variations.price.$index");
                    $cost = $request->input("variations.cost.$index");
                    $count = $request->input("variations.count.$index");
                    $count = isset($count) ? $count : 1000;
                    if (!empty($num) && isset($unit) && !empty($price)) {
                        if ($variationId) {
                            // Update existing variation
                            $variation = Pricing::find($variationId);
                            if ($variation) {
                                $variation->update([
                                    'weight_custom_num' => $num,
                                    'weight_custom_unit' => $unit,
                                    'price' => $price,
                                    'cost' => $cost ?? 0,
                                    'qty' =>  $count,
                                ]);
                                $validVariationIds[] = $variationId; // Add the ID to the list of valid IDs
                            }
                        } else {
                            // Create new variation
                            $newVariation = Pricing::create([
                                'product_id' => $id,
                                'weight_custom_num' => $num,
                                'weight_custom_unit' => $unit,
                                'price' => $price,
                                'cost' => $cost ?? 0,
                                'qty' => $count,
                                'fixed' => 0,
                                'weight_id' => null,
                            ]);
                            $validVariationIds[] = $newVariation->id; // Add the new ID to the list of valid IDs
                        }
                    }
                }
            
                Pricing::where('product_id', $id)
                    ->where('fixed', 0)
                    ->whereNull('weight_id')
                    ->whereNotIn('id', $validVariationIds)
                    ->delete();
            }
            $this->setDefaultPirce($id);
            Pricing::where('product_id', $id)->where('fixed', 1)->delete();
        }


        $hasPricing = false;
        if ($item->pricing_type == 'by_unit') {
            $hasPricing = Pricing::where('product_id', $id)->where('fixed', 1)->whereNotNull('price')->exists();
        } else {
            $hasPricing = Pricing::where('product_id', $id)->where('fixed', 0)->whereNotNull('price')->exists();
        }

        $status = $request->status;
        if ($status == 1 && !$hasPricing) {
            return json_encode(array('status' => 0, 'errors' => ["Cannot publish without pricing"]));
        }

        if(!isset($request->inheritMeta)){
            $item->inheritMeta = 0;
            $item->meta_title = $request->meta_title;
            $item->meta_description = $request->meta_description;
        }else{
            $item->inheritMeta = 1;            
        }
        
        if ($item->deleted_at) {
            $item->deleted_at = null;
        }

        if ($hasPricing) {
            $item->public = $status;
        }else{
            if($item->public == 1){
                $item->public = 0;
            }
        }
        $item->save();

        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }

    public function setDefaultPirce($id){
        $lowestPricing = Pricing::where('product_id', $id)
                                ->where('fixed', 0)
                                ->where('qty', '>', 0)
                                ->orderBy('price', 'asc')
                                ->first();

        if ($lowestPricing && $lowestPricing->default != 1) {
            Pricing::where('product_id', $id)->update(['default' => null]);
            
            $lowestPricing->default = 1;
            $lowestPricing->save();
        }
        return true; 
    }
    public function changeStatus(Request $request){
        $id = (int)$request['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required|int',
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails())return response()->json(['status'=>0,'message'=>$validator->errors()->first()]);

        $item = Product::findorFail($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't find product"]));

        if($item->temp != null)$item->temp = null;


        $hasPricing = false;
        if ($item->pricing_type == 'by_unit') {
            $hasPricing = Pricing::where('product_id', $id)->where('fixed', 1)->whereNotNull('price')->exists();
        } else {
            $hasPricing = Pricing::where('product_id', $id)->where('fixed', 0)->whereNotNull('price')->exists();
        }

        $status = $request->status;
        if ($status == 1 && !$hasPricing) {
            return json_encode(array('status' => 0, 'message' => ["Cannot publish without pricing"]));
        }
        
        if ($hasPricing) {
            $item->public = $status;
        }else{
            if($item->public == 1){
                $item->public = 0;
            }
        }
        $item->save();

        return json_encode(array('status' => 1, 'message' => 'Status changed!'));
    }

    public function sort(Request $request){
       
        $ids = $request->input('ids');
        $category = $request->input('category');
        $newOrdering = count($ids);

        if(!$category){
            return response()->json(['status' => 0,'message' => 'something went wrong']);
        }
        foreach($ids as $value => $key)
        {
            $item = Product::find($key);
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;

            }
        }
        exit() ;
    }

    public function remove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Product::find($id);
            $item->public = 0;
            $item->deleted_at = date("Y-m-d H:i:s");
            $item->save();
        }

        $data = json_encode(array('status' => 1));
        return $data;
    }

    public function fixSlug(){
        $products = Product::get();
        foreach($products as $product){
            $baseSlug = strtolower(str_replace([' ', '_','%','/'], '-', $product->title));
            $url = $baseSlug;
            $counter = 0;
            do {
                if ($counter > 0) {
                    $url = $baseSlug . $counter;
                }

                $checkSlug = Product::where('url', $url)
                                    ->where('id', '!=', $product->id)
                                    ->whereNull('temp')
                                    ->first();
                $counter++;
            } while ($checkSlug);
            $product->url = $url;
            $product->save();
        }
    }
}
