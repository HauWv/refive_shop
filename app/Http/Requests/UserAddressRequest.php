<?php

namespace App\Http\Requests;


class UserAddressRequest extends Request
{

    //定义验证规则
    public function rules()
    {
        return [
            'province'  =>  'required',
            'city'      =>  'required',
            'district'      =>  'required',
            'address'      =>  'required',
            'zip'      =>  'required',
            'contact_name'      =>  'required',
            'contact_phone'      =>  'required',
        ];
    }

    //传递给$error时，字段实际显示的名称
    public function attributes()
    {
        return [
            'province'  =>  '省',
            'city'      =>  '城市',
            'district'      =>  '地区',
            'address'      =>  '详细地址',
            'zip'      =>  '邮编',
            'contact_name'      =>  '姓名',
            'contact_phone'      =>  '电话',
        ];
    }
}
