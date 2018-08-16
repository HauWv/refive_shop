<?php

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

//name是用于前台页面跳转，可以用{{route('name')}}，代替链接
Route::get('/','PagesController@root')->name('root');

//这个路由包含了Login/Register/Resetpassword/Forgotpassword控制器
Auth::routes();
