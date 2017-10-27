<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogcomment extends Model
{
    public function blog()
    {
        return $this->belongsTo('App\Models\Blog','blog_id','id');
    }
}
