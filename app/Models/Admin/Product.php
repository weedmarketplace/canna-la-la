<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';

    protected $fillable = [
        'code',
        'c_name',
        'product_name',
        'count',
        'price',
        'discount',
        'parent_id',
        'public',
        'is_new',
    ];

	public function getAll($start,$length,$filter,$sort_field,$sort_dir){

		$query = DB::table('product as p')
			->leftJoin('pricing as pw', function($join) {
				$join->on('p.id', '=', 'pw.product_id')
					->where('p.pricing_type', '=', 'by_weight')
					->where('pw.fixed', 0)
					->where('pw.default', 1);
			})
			->leftJoin('pricing as pu', function($join) {
				$join->on('p.id', '=', 'pu.product_id')
					->where('p.pricing_type', '=', 'by_unit')
					->where('pu.fixed', 1);
			});

		$query->select(
			'p.id as DT_RowId', 
			'p.id', 
			'p.title', 
			'p.ordering', 
			'p.public', 
			'p.pricing_type', 
			'p.discount',
			DB::raw('COALESCE(pw.price, pu.price) as price'),
			DB::raw('COALESCE(pw.qty, pu.qty) as qty'),
			DB::raw('ROUND(COALESCE(pw.price, pu.price) * (1 - (COALESCE(p.discount, 0) / 100)), 2) as effective_price')
		);

		$query->whereNull('temp');

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('p.title', 'LIKE', '%'. $filter['search'] .'%');
		}else{
			if(isset($filter['status'])){
				$status = $filter['status'];

				if($status == 0 || $status == 1){
					$query->where('p.public',$filter['status']);
				}
				if($status == 2){
					$query->whereNotNull('p.deleted_at');
				}
			}else{
				$query->whereNull('p.deleted_at');
			}
			
			if(isset($filter['category']) && $filter['category'] != -1){
				$query->where('p.parent_id',$filter['category']);    
			}

			if ($filter['inStock'] == 1) {
				$query->having('qty', '>', 0);
			} else {
				$query->having('qty', '<' , 1)->orHavingNull('qty');
			}
		}

		$countQuery = (clone $query);
		$totalRecords = $countQuery->distinct()->count();
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();

		$pricingList = config('constants.pricing');
        $measurementList = config('constants.measurement');
		foreach ($data as &$product) {
			if ($product->pricing_type == 'by_weight') {
				$product->prices_by_weight = $this->getProductPricesByWeight($product->id);
				foreach ($product->prices_by_weight as $price) {
					if (!isset($price->weight_custom_unit)) {
						$price->unit = $pricingList[$price->weight_id];
					} else {
						$price->unit = $price->weight_custom_num . ' ' . $measurementList[$price->weight_custom_unit];
					}
				}
			}
		}

		$expression = DB::raw("SELECT FOUND_ROWS() AS recordsTotal;");
        $string = $expression->getValue(DB::connection()->getQueryGrammar());
        $count = DB::select($string)[0];

		$return['data'] = $data;
		$return['count'] = $totalRecords;
		return $return;
    }

	public function getProductPricesByWeight($productId) {
		return DB::table('pricing')
			->where('product_id', $productId)
			->where('fixed', 0)
			->select(
				'price',
				'qty',
				'weight_custom_num', 
				'weight_custom_unit', 
				'weight_id',
				'default',
				'id as price_id', 
				DB::raw('ROUND(price * (1 - (COALESCE((SELECT discount FROM product WHERE id = ?), 0) / 100)), 2) as effective_price')
			)
			->addBinding($productId, 'select')
			->get();
	}

	public function getProductShort($id, $priceId)
    {
        $query = DB::table('product as p');
        $query->select('p.id','p.img','p.url','pp.qty');
		$query->leftJoin('pricing as pp', 'pp.product_id', '=', 'p.id');
		$query->where('p.id', $id);
		$query->where('pp.id', $priceId);
        $product = $query->first();

        if (!$product) {
			$query = DB::table('product as p');
			$query->select('p.id','p.img','p.url');
			$query->where('p.id', $id);
			$product = $query->first();
			$product->qty = 'Price removed';
        }
        if ($product->img) {
            $product->imagePath = asset('images/productList/' . $product->img);
        } else {
            $product->imagePath = asset('assets/images/nis.png');
        }
        $product->route = route('product', ['slug' => $product->url]);
        return $product;
    }
}