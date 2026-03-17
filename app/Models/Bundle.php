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
        'value',
        'start_time',
    ];
    public function user (){
        return $this->belongsTo(User::class);
    }
    public function bundle (){
        return $this->belongsTo(Bundle::class);
    }
}
