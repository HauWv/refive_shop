<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Str;
use Cache;

//这里的implements ShouldQueue，是指异步发送
class EmailVerificationNote extends Notification implements ShouldQueue
{
    use Queueable;
    public function via($notifiable)
    {
        return ['mail'];
    }

    //定义通知的内容
    //这里传入的参数实际App\Models\User对象（这个类统一都用形参$notifiable表示)
    public function toMail($notifiable)
    {
        //1.生成16位随机字符串作为$token
        $token = Str::random(16);
        //2.向缓存（用于储存可控失效时间的信息）写入这个随机字符串
        Cache::set('email_verification_'.$notifiable->email,$token,30); //字段名为“email_verification_用户邮箱名”，有效时间为30分钟
        //3.生成验证链接
        //链接附带两个参数email和token
        $url = route('email_verification.verify',['email'=> $notifiable->email,'token'=>$token]);

        return (new MailMessage)
                    ->greeting($notifiable->name.'您好：')
                    ->subject('您已注册成功，请验证邮箱')
                    ->line('点击下方的链接验证邮箱：')
                    ->action('点击验证', url($url))
                    ->line('感谢您的注册与使用');
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
