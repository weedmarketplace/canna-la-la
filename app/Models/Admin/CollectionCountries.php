<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionCountries extends Model
{
    protected $table = 'collection_countries';
    public $timestamps = false;
    use HasFactory;
}

