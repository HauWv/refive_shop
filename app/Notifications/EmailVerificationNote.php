<?php

//用于生成通知的内容
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;
use Cache;

//这里加入了implements ShouldQueue，实现异步发送
class EmailVerificationNote extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * 创建新的通知实例
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    //用于定义通过哪种方式发送通知
    public function via($notifiable)
    {
        return ['mail'];
    }

    //定义具体的通知样式，这里传入的参数就是App\Models\User对象
    public function toMail($notifiable)
    {
        //1.生成16位随机字符串作为$token
        $token = Str::random(16);
        //2.往缓存写入这个随机字符串，字段名为“email_verification_用户邮箱名”，有效时间为30分钟
        Cache::set('email_verification_'.$notifiable->email,$token,30);
        //3.生成验证链接
        //这个链接是将两个参数email和token通过input给email_verification.verify
        $url = route('email_verification.verify',['email'=> $notifiable->email,'token'=>$token]);

        return (new MailMessage)
                    ->greeting($notifiable->name.'hello')
                    ->subject('registered succefully, please verify your email')
                    ->line('click the link below to verify your email')
                    ->action('verification', url($url))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
