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
    $router->get('/aaaa', 'MainController@update');
    $router->get('/aaa', 'MainController@index');
    $router->get('/articlelist', 'MainController@articlelist');
    $router->get('/activelist', 'MainController@activelist');
    $router->get('/articledetail', 'MainController@articledetail');
    $router->get('/storecategory', 'MainController@storecategory');
    $router->get('/storelist', 'MainController@storelist');
    $router->get('/store', 'MainController@store');
    $router->get('/product', 'MainController@product');
    $router->get('/slider', 'MainController@sliders');

});