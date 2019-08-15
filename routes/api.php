<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('users/{user}', function (App\User $user) {
    dd($user);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');//login登陆页面
    Route::post('logout', 'AuthController@logout');//退出
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');//user表 --member_user页面
    Route::post('add', 'CartController@add');//详情页-添加到购物车 --product页面
    Route::post('buycar_show', 'CartController@buycar_show');//购物车页面展示-第1页--buycar页面
    //buycar-数量加减
    Route::post('Up', 'CartController@Update');
    Route::post('check', 'CartController@check');
    //个人中心-收货地址
    Route::post('province', 'CartController@province');
    Route::post('area_show', 'CartController@area_show');
    Route::post('addarea', 'CartController@addarea');
    Route::post('address_show', 'CartController@address_show');
    Route::post('buycar_two', 'CartController@buycar_two');
    Route::post('buycar_two1', 'CartController@buycar_two1');
    Route::post('addorder', 'CartController@addorder');
    //支付页面

});
Route::get('index', 'PayController@index');
Route::get('return', 'PayController@return');
//index页面 商品展示
Route::post('shop', 'ShopController@shop');
Route::post('floor', 'ShopController@floor');
Route::post('floorshow', 'ShopController@floorshow');
//product页面
Route::get('goods', 'ShopController@goods');
Route::get('price', 'ShopController@price');
//支付页面
Route::get('notify', 'PayController@notify');

