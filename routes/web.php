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
	echo "123";
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
		Route::get("/login",'Admin\LoginController@login');
		Route::get("/actionWxLogin",'Admin\LoginController@actionWxLogin');
		Route::get("/goods",'Admin\LoginController@goods');
		Route::get("/detail",'Admin\LoginController@detail');
		Route::get("/cart",'Admin\LoginController@cart');
		Route::get("/carts",'Admin\LoginController@carts');
	});


