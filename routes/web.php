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

//主页面
// Route::get('/','PagesController@root')->name('root');
Route::redirect('/','/products')->name('root');
Route::get('products','ProductsController@index')->name('products.index');
Route::get('products/{product}','ProductsController@show')->name('products.show');


//这个路由包含了Login/Register/Resetpassword/Forgotpassword控制器
Auth::routes();


//登陆才可访问的页面；这个中件间也可以在控制器的__construct()中设置（用$this->middleware('中件间名',['except/only'=>[]]))
Route::group(['middleware'=>'auth'],function(){
	//请验证邮箱的静态页
	Route::get('/email_verify_notice','PagesController@emailVerifyNotice')->name('email_verify_notice');

	//邮箱验证逻辑
	Route::get('/email_verification/verify','EmailVerificationController@verify')->name('email_verification.verify'); 
	Route::get('/email_verification/send','EmailVerificationController@send')->name('email_verification.send');

	//再嵌套一层中间件，指登录并且完成邮箱激活才能进入的页面
	Route::group(['middleware'=>'email_verified'],function(){
		Route::get('user_addresses','UserAddressesController@index')->name('user_addresses.index');
		Route::get('user_addresses/create','UserAddressesController@create')->name('user_addresses.create');
		Route::post('user_addresses','UserAddressesController@store')->name('user_addresses.store');
		Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
		Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
		Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
	});
});
