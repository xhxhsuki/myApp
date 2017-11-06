<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carmodel extends Model
{
    protected $table = 'car_models';

    public function car_brand()
    {
        return $this->belongsTo('App\Models\Carbrand','brand_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Userscar','id','car_model_id');
    }
}
