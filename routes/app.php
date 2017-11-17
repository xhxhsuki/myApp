<?php

/*
|--------------------------------------------------------------------------
| APP Routes
|--------------------------------------------------------------------------
|
| APP相关请求处理
| 移动端（APP等）请求写在这里，已添加跨域中间件cors
| prefix = app
|
*/

use Illuminate\Http\Request;

/**
 * /app/test
 */
Route::get('/test',function () {
    return "app请求测试";
});

Route::post('/request/token/{guard?}', 'AuthController@getToken');

Route::post('/refresh/token/{guard?}', 'AuthController@refreshToken');

Route::post('/register', 'AuthController@register');
/**
 * 发送短信验证码
 */
Route::post('/send/sms', function (Request $request) {
    return (new \App\Addon\AliyunMns\UserSms())->sendVerifyCode($request->get('phone'));
});
Route::get('/otherscoterie','CoterieController@othersCoterie');

Route::get('/blogs', 'BlogController@index');

Route::get('/carmodels', 'UserController@carModel');
Route::get('/blog/search', 'BlogController@search');
/**
 * 需要登陆请求
 * 请求头请带有如下信息
 *
 * $accessToken
 *
 * 'headers' => [
 *      'Accept' => 'application/json',
 *      'Authorization' => 'Bearer '.$accessToken,
 *  ],
 */
Route::group(['middleware'=> ['auth:app']], function() {

    /**
     * 用户信息
     */
    Route::get('/user', function(Request $request) {

        //控制器中快速获取登陆用户信息
        $aaa = $request->user();

        //获取登陆用户对象信息
        return $aaa;
    });
    Route::get('/userscar', 'UserController@usersCar');

    Route::post('/userpics', 'UserController@uploadPic');
    Route::post('/carverify', 'UserController@carVerify');
    Route::post('/saveuserinfo', 'UserController@saveUserInfo');

    Route::get('/coteries', 'CoterieController@index');
    Route::post('/coterie/publish', 'CoterieController@publish');
    Route::post('/coterie/delete', 'CoterieController@delete');
    Route::post('/coterie/comment', 'CoterieController@comment');
    Route::post('/coterie/like', 'CoterieController@like');

    Route::post('/blog/publish', 'BlogController@publish');
    Route::post('/blog/delete', 'BlogController@delete');
    Route::post('/blog/comment', 'BlogController@comment');
    Route::post('/blog/like', 'BlogController@like');
    Route::post('/blog/favorite', 'BlogController@favorite');
    Route::get('/blog/mycomments', 'BlogController@myComments');
    Route::get('/blog/myfavorites', 'BlogController@myFavorites');

    Route::get('/userlist','UserController@userList');
    Route::post('/storecomment', 'UserController@storeComment');
    Route::get('/blog/detail', 'BlogController@detail');
});

Route::post('/socialite/token', 'AuthController@socialiteToken');

Route::post('/bind/phone', 'AuthController@bindPhone');