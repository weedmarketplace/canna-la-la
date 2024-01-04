<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Faq extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'faq';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('faq');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS id'),
            'id as DT_RowId',
            'question_am as question',
            'ordering as ordering',
            'published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }

        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$search = $filter['search'];
			$query->where(function($query) use ($search){
                            $query->where('question_am', 'LIKE', '%'.$search.'%')
                                  ->orWhere('question_ru', 'LIKE', '%'.$search.'%')
                                  ->orWhere('question_en', 'LIKE', '%'.$search.'%')
                                  ->orWhere('answer_am', 'LIKE', '%'.$search.'%')
                                  ->orWhere('answer_ru', 'LIKE', '%'.$search.'%')
                                  ->orWhere('answer_en', 'LIKE', '%'.$search.'%');
                        });
		}

        $query->whereNull('faq.deleted_at');

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