<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $casts = [
        'store_sliders' => 'array',
    ];
    public function product()
    {
        return $this->hasMany('App\Models\Product','store_id','id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Storecategory','category_id','id');
    }
}
