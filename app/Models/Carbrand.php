<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carbrand extends Model
{
    protected $table = 'car_brands';

    public function car_model()
    {
        return $this->hasMany('App\Models\Carmodel','brand_id','id');
    }
}
