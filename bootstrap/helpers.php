<?php 
function test_helper(){
	return 'ok';
}

function route_class(){
	// 返回当前路由请求名称
	return str_replace('.','-',Route::currentRouteName());
}
 ?>