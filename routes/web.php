<?php

Route::get('aa', function () {
    return view('welcome');
});
// Route::get('/login', function () {
//     return view('login');
// });
//UserController控制器
//@分隔符
//show方法
Route::any('login', 'UserController@login');
Route::any('user', 'UserController@index');
Route::any('shop', 'ShopController@shopping');
Route::any('demo', 'ShopController@demo');
Route::any('floor', 'ShopController@floor');
Route::any('floorshow', 'ShopController@floorshow');
Route::any('welcome', 'PostController@welcome');


Route::group(['middleware' => App\Http\Middleware\CheckToken::class,], function () {
Route::any('show', 'UserController@show');
Route::any('user/loginout', 'UserController@loginout');
Route::any('showaction', 'UserController@showaction');
Route::any('add', 'UserController@add');
Route::any('delete', 'UserController@delete');
Route::any('update', 'UserController@update');
Route::any('updateadd', 'UserController@updateadd');
});