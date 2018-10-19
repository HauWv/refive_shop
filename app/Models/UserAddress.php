<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    //规定last_used_at是一个日期对象Carbon
    protected $dates = ['last_used_at'];

    ////由于外键的存在，构建此方法后，可以通过 $useraddress()->user方法调用User，取出关联值；belongsTo()表示只有唯一对应值
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //创建一个访问器，用来获取完整的地址
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
