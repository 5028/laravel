<?php

Route::get('aa', function () {
   echo $a=Hash::make('aa');
});
// Route::get('/login', function () {
//     return view('login');
// });
//UserController控制器
//@分隔符
//show方法
Route::any('login', 'UserController@login');
Route::any('user', 'UserController@index');
Route::any('welcome', 'PostController@welcome');
Route::any('boot', 'LoginController@boot');

//Route::any('shop', 'ShopController@shopping');
//Route::any('demo', 'ShopController@demo');
//Route::any('floor', 'ShopController@floor');
//Route::any('floorshow', 'ShopController@floorshow');
//Route::any('goods', 'ShopController@goods');
//Route::any('price', 'ShopController@price');
//Route::any('user1', 'ShopController@user1');
//Route::any('usershow', 'ShopController@usershow');
//Route::any('alogin', 'AuthController@login');

Route::group(['middleware' => App\Http\Middleware\CheckToken::class,], function () {
Route::any('show', 'UserController@show');
Route::any('user/loginout', 'UserController@loginout');
Route::any('showaction', 'UserController@showaction');
Route::any('add', 'UserController@add');
Route::any('delete', 'UserController@delete');
Route::any('update', 'UserController@update');
Route::any('updateadd', 'UserController@updateadd');
});