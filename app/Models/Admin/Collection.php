<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{
	use SoftDeletes;
    protected $table = 'collections';
    public $timestamps = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS collections.id'),
										'collections.id as DT_RowId',
										'collections.title',
										'collections.status',
										'collections.ordering',
										)
								);

		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('collections.title', 'LIKE', '%'. $filter['search'] .'%');
		}

		if(isset($filter['status']) && $filter['status'] != -1){
			$query->where('collections.status',$filter['status']);
		}

		// $query->whereNull('collections.temp');
		// $query->whereNull('collections.deleted_at');
		if(isset($filter['category']) && $filter['category'] != -1){
			$query->where('parent_id',$filter['category']);    
		}
		
		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();

		foreach ($data as $d) {
			$d->DT_RowId = "row_".$d->DT_RowId;
		}

		$expression = DB::raw("SELECT FOUND_ROWS() AS recordsTotal;");
        $string = $expression->getValue(DB::connection()->getQueryGrammar());
        $count = DB::select($string)[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }

	public static function build_options_tree($cats, $parent_id, $hh, $self, $disabelChiled, $selectedArray, $inputType = 'select', $level = 0) {
        if (!is_array($cats) || !isset($cats[$parent_id])) {
            return null;
        }

        $hh .= '--';
        $tree = '';
        $level === 0;

        foreach ($cats[$parent_id] as $cat) {
            $catId = $cat["id"];
            $catParentId = $cat["parent_id"];
            $catTitle = $cat["title"];

            $disabled = false;
            $selected = false;
            $checked = false;

            if($self){
                $selfId = $self["id"];
                $selfParentId = $self["parent_id"];

                // Self or this or parent of this category, or self chiled 
                if(($catParentId === $selfId) || $catId == $selfId){//$disabelChiled
                    $disabelChiled = true;
                    $disabled = true;
                }

                //if this category is parent of self category
                if($catId == $selfParentId){
                    $selected = true;
                    $checked = true;
                    
                }
            }
            

            if($selectedArray && in_array($catId,$selectedArray)){
                $selected = true;
                $checked = true;
            }

            $disabledAttr = $disabled ? 'disabled' : '';
            $selectedAttr = $selected ? 'selected="selected"' : '';
            $checkedAttr = $checked ? 'checked' : '';

            switch ($inputType) {
                case 'checkbox':
                    $tree .= "<li style='list-style:none;cursor:pointer' class='d-flex categories'>
                                <input type='checkbox' class='child' value='$catId' name='categories[]' $checkedAttr $disabledAttr><span>$hh $catTitle</span></li>";
                    break;

                case 'radio':
                    $tree .= "<label><input type='radio' name='category_level_$level' value='$catId' $checkedAttr $disabledAttr> $catTitle</label>";
                    break;

                case 'select':
                default:
                    $tree .= "<option $disabledAttr $selectedAttr value='$catId'>$hh $catTitle</option>";
                    break;
            }

            // Generate subcategories
            $subTree = self::build_options_tree($cats, $catId, $hh, $self, $disabelChiled, $selectedArray, $inputType, $level + 1);
            if ($inputType === 'select') {
                $tree .= $subTree;
            } else if ($subTree != '' && $inputType === 'radio') {
                $tree .= "<div class='sub-category' id='subCategory_$catId' style='display: none;'>$subTree</div>";
            }
        }

        // Wrap each level of categories in a div for radio button version
        if ($inputType === 'radio') {
            $style = $level == 0 ? "display: block;" : "display: none;";
            $tree = "<div class='category-level' id='categoryLevel$level' style='$style'>$tree</div>";
        }

        return $tree;
    }

    public static function getParentAndGrandparentIds($catId, $allCats) {
        $parentIds = [];
        foreach ($allCats as $cat) {
            if ($cat['id'] == $catId && $cat['parent_id'] != null) {
                $parentIds[] = $cat['parent_id'];
                $parentIds = array_merge($parentIds, self::getParentAndGrandparentIds($cat['parent_id'], $allCats));
            }
        }
        return $parentIds;
    }
}
