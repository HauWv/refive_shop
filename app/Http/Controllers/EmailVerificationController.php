<?php
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
    	//1.用户点击链接，从请求中获取email与token的值
    	$email = $request->input('email');
    	$token = $request->input('token');

        //2.对获取的信息进行验证
         //2.1 如果有一个值不存在，则：
    	if(!$email | !$token){
    		throw new InvalidRequestException('验证链接不正确');
    	}
         //3.从缓存中读取数据
    	if($token != Cache::get('email_verification_'.$email)){
    		throw new InvalidRequestException('验证链接不正确或已经过期');
    	}
            //如果用户不存在时（即$user为空）
    	if(!$user = User::where('email',$email)->first()){
    		throw new InvalidRequestException('用户不存在');
    	}
    	//4.将指定的key从缓存中删除
    	Cache::forget('email_verified_'.$email);
    	//5.把邮箱验证修改为true
    	$user->update(['email_verified'=>true]);

    	//6.告知用户验证成功
    	return view('pages.success',['msg'=>'邮箱验证成功']);
    }


    //用于用户主动请求发送验证邮件
    public function send(Request $request){
    	$user = $request->user();
    	//判断用户是否已经激活
    	if($user->email_verified){
    		throw new InvalidRequestException('您已经验证过邮箱了');
    	}
    	//调用内置的notify(new 通知对象())方法用来发送我们定义好的通知类
    	$user->notify(new EmailVerificationNote());
    	return view('pages.success',['msg'=>'邮件发送成功']);
    }
}
