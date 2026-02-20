<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'category_id',
        'start_time',
    ];
}
