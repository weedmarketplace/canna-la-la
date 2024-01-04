<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    protected $table = 'log';

    // public $timestamps  = false;

    protected $fillable = [
        'owner_id',
        'type',
        'data',
        'owner_type',
        'created_at'
    ];
}
