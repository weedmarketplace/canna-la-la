<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Article extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    // public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('articles');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS id'),'id as DT_RowId','page_name'));

        if($length != '-1'){
            $query->skip($start)->take($length);
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
