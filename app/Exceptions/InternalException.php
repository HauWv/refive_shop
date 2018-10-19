<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InternalException extends Exception
{
    //1、创建变量，用来储存给用户看的信息
    protected $msgForUser;

    //2、定义错误格式，并将默认的msgForUser替换为'系统内部错误'
    public function _construct(string $message, string $msgForUser='系统内部错误',int $code=500){
    	parent::_construct($message,$code);
    	$this->msgForUser=$msgForUser;
    }
    
    //3、定义错误触发时（系统内部错误）的操作
    public function render(Request $request){
    	if($request->expectsJson()){
    		return response()->json(['msg'=>$this->msgForUser],$this->code);
    	}

    	return view('pages.error',['msg'=>$this->msgForUser]);
    }
}
