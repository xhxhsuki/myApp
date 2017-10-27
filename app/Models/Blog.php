<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Models\Blogcomment','blog_id','id');
    }

    public function attitudes()
    {
        return $this->hasMany('App\Models\Blogattitude','blog_id','id');
    }

    public function favorites()
    {
        return $this->hasMany('App\Models\Blogfavorite','blog_id','id');
    }
}
