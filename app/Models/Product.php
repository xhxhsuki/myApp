<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'product_pics' => 'array',
    ];

    public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id','id');
    }
}
