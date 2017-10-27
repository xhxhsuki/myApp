<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userscar extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function car()
    {
        return $this->hasOne('App\Models\Carmodel','id','car_model_id');
    }
}
