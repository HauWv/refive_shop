<?php

//用于监听用户注册，如果出现，会自动触发handle的内容
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Registered;
use App\Notifications\EmailVerificationNote;

class RegisteredListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    //_contruct()用于实例化时，给对象赋初始值
    public function __construct()
    {
        //
    }

    //当事件触发时，就会执行handle()方法
    public function handle(Registered $event)
    {
        //获取刚注册的用户
        $user = $event->user;
        //调用notify发送通知
        $user->notify(new EmailVerificationNote());
    }
}
