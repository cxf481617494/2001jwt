<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	echo "123456";
    // return view('welcome');
});
//登录路由分组管理 prefix 前缀  group 分组

	//展示登录
	Route::match(["post","get"],'/login','Admin\LoginController@create');
	//执行登录
	Route::match(["post","get"],'store','Admin\LoginController@store');
	//展示注册
	Route::match(["post","get"],'reg','Admin\LoginController@show');
	//执行注册
	Route::match(["post","get"],'edit','Admin\LoginController@edit');
	//跳转展示
	Route::match(["post","get"],"login/index",'Admin\LoginController@index');


	//小程序接口测试
	Route::prefix("/api")->group(function(){
		Route::get("/userinfo",'Admin\LoginController@userinfo');
		Route::get("/login",'Admin\LoginController@login')->middleware("checkLogin");
		Route::get("/actionWxLogin",'Admin\LoginController@actionWxLogin')->middleware("checkLogin");
		Route::get("/goods",'Admin\LoginController@goods')->middleware("checkLogin");
		Route::get("/detail",'Admin\LoginController@detail')->middleware("checkLogin")->middleware("checkLogin");
		Route::get("/cart",'Admin\LoginController@cart')->middleware("checkLogin");
		Route::get("/carts",'Admin\LoginController@carts');
		Route::get("/coll",'Admin\LoginController@coll')->middleware("checkLogin");
		Route::get("/ee",'Admin\LoginController@ee');
		Route::get("/order",'Admin\LoginController@order')->middleware("checkLogin");
		Route::get("/zongshu",'Admin\LoginController@zongshu')->middleware("checkLogin");
		Route::get("/dels",'Admin\LoginController@dels');
	});
	// vue接口测试
	Route::prefix("/apiv")->group(function(){
		Route::get("vue_g_list","Admin\LoginController@vue_g_list");
	});


