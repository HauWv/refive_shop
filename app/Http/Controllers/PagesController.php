<?php

//这个控制器仅用于页面的跳转作用
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function root(){
    	return view('pages.root');
    }

    public function emailVerifyNotice(Request $request){
    	return view('pages.email_verify_notice');
    }
}
