<?php
//====================================================
//		FileName: func.class.php
//		Summary:  系统函数配置
//====================================================

if(!defined('CORE'))exit("error!");
//当前时区
date_default_timezone_set('asia/shanghai');

//初始化数据库连接
$db	=new mysql($cfg["dbhost"],$cfg["dbuser"],$cfg["dbpass"],$cfg["dbname"]);

//提示信息
$lang_cn = array(
	"rabc_error"		=>"<script>alert('权限不足,非法操作!');window.location='index.php';</script>",
	"rabc_is_repeat"	=>"<script language=javascript>alert('对不起,该用户已存在！');history.back();</script>",
	"rabc_error_oldPwd"	=>"<script language=javascript>alert('原始密码错误！');history.back();</script>",
	"rabc_error_Pwd2"	=>"<script language=javascript>alert('两次密码不一致！');history.back();</script>",
	"rabc_is_login"		=>"<script>window.location='index.php?action=user&do=login';</script>",
	"rabc_login_ok"		=>"<script>window.location='index.php';</script>",
	"rabc_login_error"	=>"<script>alert('用户密码错误!');window.location='index.php?action=user&do=login';</script>",
	"rabc_logout"		=>"<script>alert('安全退出!');window.location='index.php?action=user&do=login';</script>",
	"validate"			=>"<script>alert('内容不能为空,请填全内容!');history.back(-1);</script>"
);

//权限页面
$action_cn=array(
	"info"=>"信息列表",
	"infonew"=>"新建信息",
	
);

//安全验证
function _RunMagicQuotes(&$svar){
	if(!get_magic_quotes_gpc())	{
		if( is_array($svar) ){
			foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
		}else{
			$svar = addslashes($svar);//转义,防注入
		}
	}
	return $svar;
}

//SMARTY模版配置
function smarty_cfg($self){
	global $cfg;
	global $user_list;
	global $css;
	$self->template_dir='./tpl';
	$self->cache_dir='./tmp/cache';
	$self->compile_dir	='./tmp/compile';
	$self->assign('cfg',$cfg);
	$self->assign('user_list',$user_list);
	$self->assign('css',$css);
}

//安全过滤
foreach(Array('_GET','_POST','_COOKIE') as $_request){
	foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
}

//dwz_ajax_succee
function success($msg,$url){
	$msg = $msg ? $msg : "操作成功!";
	$val = "<script>alert('".$msg."');window.location='".$url."';</script>";
	return $val;
}

//dwz_ajax_error
function error($msg,$url){
	$msg = $msg ? $msg : "操作错误!";
	$val = "<script>alert('".$msg."');javascript:history.back();</script>";
	return $val;
}

/*打印友好的数组形式*/
function dump($array){
	echo "<pre>";
	print_r($array);
	echo "<pre>";
}

//中文截取
function cnString($text, $length){
	if(strlen($text) <= $length){
		return $text;
	}
	$str = substr($text, 0, $length) . chr(0) ; 
	return $str;
}

//数组转化为select
function select($arr,$name,$self="",$cn_name="选择",$class="combox"){
	$slt .= "<select name=\"".$name."\" class=\"input ".$class."\" title=\"此项目必填\" validate=\"required:true\">";
	$slt .= "<option value=\"\" selected=\"selected\">".$cn_name."</option>";
	foreach($arr as $key=>$val){
		if($key==$self){
		$slt .= "    <option value=\"".$key."\" selected=\"selected\">".$val."</option>";
		}else{
		$slt .= "    <option value=\"".$key."\">".$val."</option>";
		}
	}
	$slt .= "</select>";
	return $slt;
}

//读取目录所有的文件名
function myreaddir($dir) {
	$handle=opendir($dir);
	$i=0;
	while($file=readdir($handle)){
		if ($file!="." && $file!=".." && !is_dir($file)){
		$list[$i]=$file;
		$i=$i+1;
		}
	}
	closedir($handle);
	rsort($list);
	return $list;
}

//验证内容
function Ifvalidate($arr){
	global $lang_cn;
	foreach($arr as $val){
		if(!$val){exit($lang_cn['validate']);}
	}
}

//arr=>json
function my_json_encode($phparr){
	if(function_exists("json_encode")){
		return json_encode($phparr);
	}else{
		require_once './include/json.php';
		$json = new Services_JSON;
		return $json->encode($phparr);
	}
}

//json=>arr
function json_to_array($web){
	$arr=array();
	foreach($web as $k=>$w){
	if(is_object($w)) $arr[$k]=json_to_array($w);  //判断类型是不是object
	else $arr[$k]=$w;
	}
	return $arr;
}

//数组转化为type循环th名称
function type_th($arr){
	foreach($arr as $key=>$val){
		$slt .= "<th>".$val."</th>\n";
	}
	return $slt;
}

//检查空值
function checkEmpty($checkempty){
	if (empty($checkempty))
		return "未填写";
	else
		return $checkempty;
}

//名字过长截断
function cut_str($str, $len){
	if(mb_strlen($str, 'utf-8') > $len){
		$str = mb_substr($str, 0, $len, 'utf-8')."...";
	}
	return $str;
}

?>