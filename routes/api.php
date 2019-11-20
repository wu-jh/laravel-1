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
//新增
Route::post('/product/create','GoodsController@add');
//修改
Route::post('/product/update','GoodsController@update');
//删除
Route::post('/product/del','GoodsController@del');
//查询
Route::get('/product/details','GoodsController@show');
