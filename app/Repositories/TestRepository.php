<?php
/**
 * Created by PhpStorm.
 * User: xhxhs
 * Date: 2017/10/30
 * Time: 8:44
 */

namespace App\Repositories;


use App\Models\User;

class TestRepository
{
    public function data()
    {
        return "ab";
    }

    public function add($data)
    {
        return User::create($data);
    }

}