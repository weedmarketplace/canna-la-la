<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Slider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sliders';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('sliders');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS sliders.id'),
            'sliders.id as DT_RowId', 'sliders.ordering',
            'sliders.title'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }

        $query->whereNull('temp');
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
