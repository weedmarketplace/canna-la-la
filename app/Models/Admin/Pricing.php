<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
	// use SoftDeletes;
    protected $table = 'pricing';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'weight_custom_num',
        'weight_custom_unit',
        'product_id',
        'price',
        'cost',
        'qty',
        'fixed',
        'weight_id',
    ];
}
