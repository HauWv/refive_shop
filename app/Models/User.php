<?php
//这个文件是系统自带的模型，与migration里的users表对应
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserAddress;

class User extends Authenticatable
{
    use Notifiable;

    //表示可以赋值的字段
    protected $fillable = [
        'name', 'email', 'password','email_verified'
    ];
    //表示不可以赋值的字段
    protected $guarded = [];


    //表示该字段在写入表之前，要转换成特定的格式（加一层保障，防止值类型出错）
    protected $casts = [
        'email_verified'=>'boolean',
    ];


    //表示隐藏的字段，使其不出现在实例中
    protected $hidden = [
        'password', 'remember_token',
    ];


    //表示给字段赋予默认的值
    protected $attributes = [];


    //由于外键的存在，构建此方法后，可以通过 $user()->addresses方法调用UserAddress，取出关联值；hasMany表示可以取出多个；
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }
}
