<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Collection_attributes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_attributes';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir,$id){

        $query = DB::table('collection_attributes');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS collection_attributes.id'),
            'collection_attributes.id as DT_RowId',
            'collection_attributes.name_en as name',));
        $query->whereNull('deleted_at')->where('collection_id',$id);

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
