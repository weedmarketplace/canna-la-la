<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Countries extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('countries');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS countries.id'),
            'countries.id as DT_RowId',
            'countries.title_en as title_en',));
        $query->whereNull('deleted_at');

        if($length != '-1'){
            $query->skip($start)->take($length);
        }

         if( isset($filter['search']) && strlen($filter['search']) > 0 ){
             $query->where('countries.title_en', 'LIKE', '%'. $filter['search'] .'%')->orWhere('countries.title_en', 'LIKE', '%'. $filter['search'] .'%');
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
