<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carbrand extends Model
{
    protected $table = 'car_brands';

    protected $fillable = ['car_brand_id', 'car_brand_name'];

    public function car_model()
    {
        return $this->hasMany('App\Models\Carmodel','brand_id','car_brand_id');
    }
}
