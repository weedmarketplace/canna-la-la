<?php

namespace App\Models;

use http\Encoding\Stream\Deflate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
	use HasFactory;
    protected $table = 'collections';
    public $timestamps = false;
}
