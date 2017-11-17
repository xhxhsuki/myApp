<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('/update', 'UpdateController@index');
    $router->get('/updatemodel', 'UpdateController@modelUpdate');
    $router->resource('article', ArticleController::class);
    $router->resource('slider', SliderController::class);
    $router->resource('bread', BreadController::class);
    $router->resource('store', StoreController::class);
    $router->resource('product', ProductController::class);
    $router->resource('storecategory', StorecategoryController::class);
    $router->resource('active', ActiveController::class);

    $router->get('/api/start', 'UpdateController@start');
    $router->get('/api/progress', 'UpdateController@progress');
});
