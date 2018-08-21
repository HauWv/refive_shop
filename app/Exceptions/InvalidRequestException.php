<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Http\Request;

class InvalidRequestException extends Exception
{
    public function _construct(string $message = '',int $code = 400){
    	parent::_construct($message,$code);
    }
    
    public function render(Request $request){
    	if($request->expectsJson()){
    		return respose()->json(['msg'=>$this->message],$this->code);
    	}
    	return view('pages.error',['msg'=>$this->message]);
    }
}
