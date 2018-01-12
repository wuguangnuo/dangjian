<?php
if(!defined("CORE"))exit("error!");//判断根目录是否存在

//首页
if($do==""){
	If_rabc($action,$do);//检测权限
	
	include("page/index.php");
	exit;
}

else
	include("404.php");//所有判定结束，未匹配则报404

?>
