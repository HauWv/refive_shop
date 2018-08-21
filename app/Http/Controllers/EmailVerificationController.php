<?php

//用于完成激活链接的认证过程
//逻辑：生成一个随机字符串+邮箱作为key，然后将其缓存。
//然后把key作为提交数据放入激活链接，通过对比提交数据与缓存信息，来完成激活操作
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\EmailVerificationNote;
use Mail;
use Exception;
use App\Models\User;
use Cache;
use App\Exceptions\InvalidRequestException;

class EmailVerificationController extends Controller
{
    //验证过程：
    public function verify(Request $request){
    	//用户点击链接，从请求中获取email与token的值（input提交）
    	$email = $request->input('email');
    	$token = $request->input('token');

        //对获取的信息进行验证
         //如果有一个值不存在，则：
    	if(!$email | !$token){
    		throw new InvalidRequestException('验证链接不正确');
    	}
         //从缓存中读取数据
    	if($token != Cache::get('email_verification_'.$email)){
    		throw new InvalidRequestException('验证链接不正确或已经过期');
    	}
    	if(!$user = User::where('email',$email)->first()){
    		throw new InvalidRequestException('用户不存在');
    	}
    	//将指定的key从缓存中删除
    	Cache::forget('email_verified_'.$email);
    	//把邮箱验证修改为ture
    	$user->update(['email_verified'=>true]);

    	//告知用户验证成功
    	return view('pages.success',['msg'=>'邮箱验证成功']);
    }


    //用于用户主动请求发送验证邮件
    public function send(Request $request){
    	$user = $request->user();
    	//判断用户是否已经激活
    	if($user->email_verified){
    		throw new InvalidRequestException('您已经验证过邮箱了');
    	}
    	//调用notify()方法用来发送我们定义好的通知类
    	$user->notify(new EmailVerificationNote());
    	return view('pages.success',['msg'=>'邮件发送成功']);
    }
}
