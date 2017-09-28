<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function findForPassport($username) {
        return $this->where('phone', $username)->first();
    }

    /**
     * 第三方登录信息（微信/微博/QQ等）
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauths()
    {
        return $this->hasMany(Oauth::class);
    }
}
