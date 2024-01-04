<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Promo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promos';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('promos');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS promos.id'),
            'promos.id as DT_RowId',
            'promos.title',
            'promos.code',
            'promos.type',
            'promos.used',
            'promos.status',
        ));
        $query->whereNull('deleted_at');

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        // if( isset($filter['search']) && strlen($filter['search']) > 0 ){
        //     $query->where('brends.name_en', 'LIKE', '%'. $filter['search'] .'%')->orWhere('brends.name_en', 'LIKE', '%'. $filter['search'] .'%');
        // }
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
