<?php

use Illuminate\Http\Request;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| 其他（后台等）api请求
| prefix=api
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function (Request $request) {
    return 'test';
});

Route::group(['namespace' => 'Api'], function (Router $router) {
    $router->get('/aaa', 'MainController@index');

});