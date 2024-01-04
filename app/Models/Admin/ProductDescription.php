<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductDescription extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'custom_attributes';

    
    public $timestamps  = false;
    
    public function getAll($start,$length,$filter,$sort_field,$sort_dir,$productId){

    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS id'), 'id as DT_RowId', 'id', 'title_am as title', 'text_am as text','ordering','position'));
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		$query->where('product_id',$productId);

		if(isset($filter['position'])){
			$query->where('position',$filter['position']);    
		}

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			//Correct search, for copy :)
			$search = $filter['search'];
			$query->where(function($query) use ($search){
				$query->where('title_am', 'LIKE', '%'.$search.'%')
					  ->orWhere('title_ru', 'LIKE', '%'.$search.'%')
					  ->orWhere('title_en', 'LIKE', '%'.$search.'%');
			});
		}

		// $query->whereNull('deleted_at');
		// $query->whereNull('temp');

		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();
		$expression = DB::raw("SELECT FOUND_ROWS() AS recordsTotal;");
        $string = $expression->getValue(DB::connection()->getQueryGrammar());
        $count = DB::select($string)[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
		return $return;
    }
}
