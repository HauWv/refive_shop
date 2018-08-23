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

//auth是系统自带，用于检测用户是否登陆，即以下页面都要登陆后才能显示（否则返回登陆页面）
Route::group(['middleware'=>'auth'],function(){
	Route::get('/email_verify_notice','PagesController@emailVerifyNotice')->name('email_verify_notice');//命名规则：路径.方法
	Route::get('/email_verification/verify','EmailVerificationController@verify')->name('email_verification.verify'); 
	Route::get('/email_verification/send','EmailVerificationController@send')->name('email_verification.send');
	
	/**
	 * 登陆并且完成邮箱激活才能进入的页面
	 */
	Route::group(['middleware'=>'email_verified'],function(){
		Route::get('user_addresses','UserAddressesController@index')->name('user_addresses.index');
		Route::get('user_addresses/create','UserAddressesController@create')->name('user_addresses.create');
		Route::post('user_addresses','UserAddressesController@store')->name('user_addresses.store');
	});
});
