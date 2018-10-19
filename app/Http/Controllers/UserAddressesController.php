<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;

class UserAddressesController extends Controller
{
//----------------------显示收货地址-------------------------------
    public function index(Request $request)
    {
        //调用User的关联表查询方法addresses，以数组形式返回给视图
        //request里包含user()信息，因此可以查到addresses信息；
    	return view('user_addresses.index',['addresses'=>$request->user()->addresses,]);
    }

//----------------------创建收货地址--------------------------------
    //显示创建页面，并且实例化UserAddress给视图文件（约定大于配置，这会自动创建当前id的收货地址模型对象）
    public function create()
    {
    	return view('user_addresses.create_and_edit',['address'=>new UserAddress()]);
    }

    //采用UserAddressRequest代替Request，集成了验证规则，不用再调用$this->validate()方法
    public function store(UserAddressRequest $request)
    {
        //$request->user()指获得当前用户；
        //user()->addresses()指获得当前用户与地址的关联关系；
        //$request->only([''])指设立白名单，从用户提交的数据中获取需要的字段
    	$request->user()->addresses()->create($request->only([
    		'province',
    		'city',
    		'district',
    		'address',
    		'zip',
    		'contact_name',
    		'contact_phone',
    	]));
    	return redirect()->route('user_addresses.index');
    }

//---------------------修改与删除收货地址----------------------------
    public function edit(UserAddress $user_address)
    {
        $this->authorize('own',$user_address);
        return view('user_addresses.create_and_edit', ['address' => $user_address]);
    }

    public function update(UserAddress $user_address, UserAddressRequest $request)
    {
        $this->authorize('own',$user_address);       
        $user_address->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }

    public function destroy(UserAddress $user_address)
    {
        $this->authorize('own',$user_address);
        $user_address->delete();
        //这里是ajax请求，如果返回view,则会报错；
        return [];
    }

}
