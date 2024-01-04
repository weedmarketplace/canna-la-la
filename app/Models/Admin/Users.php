<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
	protected $table = 'users';

	public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('users');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS users.id'),
										'users.id as DT_RowId',
										'users.name',
										'users.email',
										'users.phone',
										'users.created_at',
										));

		if($length != '-1'){
			$query->skip($start)->take($length);
		}
		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('users.name', 'LIKE', '%'. $filter['search'] .'%')
			->orWhere('users.phone', 'LIKE', '%'. $filter['search'] .'%')
			->orWhere('users.email', 'LIKE', '%'. $filter['search'] .'%');
		}
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
