<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carmodel extends Model
{
    protected $table = 'car_models';

    protected $fillable = ['car_model_id', 'car_model_name' ,'brand_id'];

    public function car_brand()
    {
        return $this->belongsTo('App\Models\Carbrand','brand_id','car_brand_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Userscar','car_model_id','car_model_id');
    }
}
