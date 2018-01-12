<?php

//检测用户页面权限
function If_rabc($action,$do){
	global $lang_cn;
	global $db;
	//检测用户登录
	if(!isLogin()){exit($lang_cn['rabc_is_login']);}
	//组合内容
	$c_action=$action.$do;
}

//检测用户页面权限
function is_admin($action,$do){
	global $lang_cn;
	global $db;
	//检测用户登录
	if(!isLogin()){exit($lang_cn['rabc_is_login']);}
	//组合内容
	$c_action=$action.$do;
	//获取当前用户
	$uid=$_SESSION['uid'];
	$roleid=$_SESSION['roleid'];
	//echo $roleid;
	
	//判断当前页面是否有权限
	if($roleid!=1){
		exit($lang_cn['rabc_error']);
	}
}

//检测用户是否登录
function isLogin(){
	if(!empty($_SESSION['isLogin']))
		return 1;	
	else
		return 0;  
}

?>