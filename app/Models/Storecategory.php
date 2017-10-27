<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storecategory extends Model
{
    public function store()
    {
        return $this->hasMany('App\Models\Store','category_id','id');
    }
}
