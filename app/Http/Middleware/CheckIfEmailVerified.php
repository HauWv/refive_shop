<?php

//用于检查用户是否验证了邮箱
namespace App\Http\Middleware;

use Closure;

class CheckIfEmailVerified
{
   /** 
    * 当中间件被执行时会调用handle方法.
    * 这个方法有两个参数，$request表示当前请求对象;Closure $next是个闭包函数，它将实际的$request传入下一个中间件
    */
    public function handle($request, Closure $next)
    {
        //$request->user()用于获取当前登陆用户的各个字段值
        if(!$request->user()->email_verified){
            //如果是ajax请求，则返回json
            if($request->expectsJson()){
                return response()->json(['msg'=>'请先验证邮箱'], 400);  
            //如果是普通请求，则返回验证提示页       
            }return redirect(route('email_verify_notice'));
        }
        return $next($request);
    }
}
