<?php

//这个文件是系统默认操作user表的模型，用于对表进行各种操作
//可以用User::find(id)->字段来查找值
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    //表示可以赋值的字段
    protected $fillable = [
        'name', 'email', 'password','email_verified'
    ];
    //表示不可以赋值的字段
    protected $guarded = [];


    //表示该字段在写入表之前，要转换成特定的格式
    protected $casts = [
        'email_verified'=>'boolean',
    ];


    //表示隐藏的字段，使其不出现在数组Auth::user()里
    protected $hidden = [
        'password', 'remember_token',
    ];


    //表示给字段赋予默认的值
    protected $attributes = [];
}
