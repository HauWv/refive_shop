<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Http\Request;

class InvalidRequestException extends Exception
{
    //固定写法，规定错误的长度
    public function _construct(string $message = '',int $code = 400){
    	parent::_construct($message,$code);
    }
    
    //异常触发时的处理过程：
    public function render(Request $request){
    	//1、如果是ajax请求，则返回json
    	if($request->expectsJson()){
    		return respose()->json(['msg'=>$this->message],$this->code);
    	}
    	//2、其他请求，则返回错误页
    	return view('pages.error',['msg'=>$this->message]);
    }
}
