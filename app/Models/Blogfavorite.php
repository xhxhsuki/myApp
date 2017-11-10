<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogfavorite extends Model
{
    protected $table = 'blog_favorites';

    protected $fillable = ['user_id', 'blog_id' ,'is_favorite'];

    public function blog()
    {
        return $this->belongsTo('App\Models\Blog','blog_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
