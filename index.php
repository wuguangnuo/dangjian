<?php
//====================================================
//		FileName: index.php
//		Summary:  程序入口文件
//====================================================
header("Content-type:text/html;charset=utf-8");
session_start();
error_reporting(0);

//引入类库及公共方法
@define("CORE",dirname(__FILE__)."/");		//根目录
require_once("lib/cfg.class.php");			//配置类
require_once("lib/mysql.class.php");		//数据类
require_once("lib/json.class.php");			//JSON类
require_once("lib/func.class.php");			//核心类
require_once("lib/rabc.class.php");			//查询类
require_once("lib/image.class.php");		//图片类
require_once("lib/page.class.php");			//分页类

//操作值
$action = empty($_GET['action']) ? "" : trim($_GET['action']);			//get action值
$do = empty($_GET['do']) ? "" : trim($_GET['do']);						//get do值
/* 此处集中控制，供action调用
$id = empty($_GET['id']) ? "" : intval($_GET['id']);					//get id值
$cuserid = empty($_GET['userid']) ? "" : intval($_GET['userid']);		//get userid值
*/

//读取用户数组
$sql_user = "SELECT id,username FROM dj_users;";
$db->query($sql_user);
$user_arr = $db->fetchAll();
foreach($user_arr as $key=>$val){
	$user_list[$user_arr[$key]['id']] = $user_arr[$key]['username'];	//用户数组
}

//执行页面
switch($action){
	case "":
		include("action/action.index.php");		//首页`
		break;
		
	case "study":
		include("action/action.study.php");		//在线学习
		break;
		
	case "manage":
		include("action/action.manage.php");	//用户管理
		break;
		
	case "dangfei":
		include("action/action.dangfei.php");	//党费管理
		break;
		
	case "user":
		include("action/action.user.php");		//个人中心
		break;
		
	default:
		include("404.php");						//404错误页
		break;
}
?>
