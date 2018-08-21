<?php
//这个文件是系统默认操作user表的模型，用于对表进行各种操作
//可以用User::find(id)->字段来查找值
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
      protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];
    protected $dates = ['last_used_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
