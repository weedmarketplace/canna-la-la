<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Blog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('blog');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS blog.id'),
            'blog.id as DT_RowId',
            'blog.title',
            'blog.published'));
        $query->whereNull('temp');

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        // if( isset($filter['search']) && strlen($filter['search']) > 0 ){
        //     $query->where('blog.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('blog.pagename', 'LIKE', '%'. $filter['search'] .'%');
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
