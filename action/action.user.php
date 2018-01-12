<?php
if(!defined("CORE"))exit("error!");

//验证登录
if($do=="loginok"){
	// 进行参数安全过滤
	$name = _RunMagicQuotes($_POST['username']);
	$pwd = _RunMagicQuotes(md5($_POST[password]));

	$validate_arr=array($name,$pwd);
	Ifvalidate($validate_arr);
	
	$sql = "SELECT * FROM dj_users WHERE username = '{$name}' AND password = '{$pwd}' LIMIT 1;";
	$db->query($sql);
	
	if ($record = $db->fetchRow()){//登录成功
		$_SESSION['isLogin']	=	true;
		$_SESSION['userid']		=	$record['id'];
		$_SESSION['user_id']	=	$record['user_id'];
		$_SESSION['username']	=	$record['username'];
		$_SESSION['roleid']		=	$record['roleid'];
		exit($lang_cn['rabc_login_ok']);
	}
	else
		exit($lang_cn['rabc_login_error']);

	exit;
}

//登录
elseif($do=="login"){
	include("page/login.php");
	exit;
}

//注册
elseif($do=="register"){
	include("page/register.php");
	exit;
}

//注销
elseif($do=="logout"){
	$_SESSION = array();
	session_destroy();
	exit($lang_cn['rabc_logout']);
}

//个人中心-个人资料 || 个人中心—修改资料	
elseif($do=="home" || $do=="edit_profile"){
	If_rabc($action,$do);//检测权限
	
	$sql = "SELECT * FROM dj_users WHERE user_id = '{$_SESSION['user_id']}';";
	$db->query($sql);
	$db->fetchRow();//取出一条记录
	
	if($do == "home"){
		include("page/home.php");
	}else{
		include("page/edit_profile.php");
	}
	exit;
}

//个人中心——修改个人资料提交
elseif($do=="update"){
	If_rabc($action,$do);//检测权限
	
	$user_id	=	$_SESSION['user_id'];
	//参数安全过滤
	//$username	=	_RunMagicQuotes($_POST['username']);//登陆名禁止修改
	//$userid	=	md5($username);
	$name		=	_RunMagicQuotes($_POST['name']);
	$sex		=	_RunMagicQuotes($_POST['sex']);
	$birthday	=	_RunMagicQuotes($_POST['birthday']);
	$idcard		=	_RunMagicQuotes($_POST['idcard']);
	$college	=	_RunMagicQuotes($_POST['college']);
	$volk		=	_RunMagicQuotes($_POST['volk']);
	$phone		=	_RunMagicQuotes($_POST['phone']);
	$email		=	_RunMagicQuotes($_POST['email']);
	$address	=	_RunMagicQuotes($_POST['address']);
	$updated_at	=	date("Y-m-d H-i-s");

	$sql = "UPDATE dj_users SET name = '{$name}',
		sex			=	'{$sex}',
		birthday	=	'{$birthday}',
		idcard		=	'{$idcard}',
		college		=	'{$college}',
		volk		=	'{$volk}',
		phone		=	'{$phone}',
		email		=	'{$email}',
		address		=	'{$address}',
		updated_at	=	'{$updated_at}' WHERE user_id ='{$user_id}' LIMIT 1;";
	
	if($db->query($sql)){echo success($msg,"?action=user&do=home");}else{echo error($msg);}
	exit;
}

//个人中心——党费情况	
elseif($do == "detail_dangfei"){
	If_rabc($action,$do);//检测权限
	$user_id = $_SESSION['user_id'];
	
	//筛选缴纳情况
	$check = empty($_POST['check']) ? (empty($_GET['check']) ? "all" : $_GET['check']) : $_POST['check'];//优先使用_POST
	if($check == "yes")
		$search .= " AND EXISTS (SELECT DISTINCT T3.user_id, T3.dangfeiid FROM dj_jiaona T3 
			WHERE T3.user_id = '{$user_id}' 
			AND T1.id = T3.dangfeiid)";//只筛选已缴纳
	elseif($check == "not")
		$search .= " AND NOT EXISTS (SELECT DISTINCT T3.user_id, T3.dangfeiid FROM dj_jiaona T3 
			WHERE T3.user_id = '{$user_id}' 
			AND T1.id = T3.dangfeiid)";//只筛选未缴纳
	else
		$search .= "";//查询全部
	
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search .= " AND (T1.id LIKE '%".strip_tags($key)."%' OR T1.name LIKE '%".strip_tags($key)."%')";

	//接收日期数据，首次使用_POST，以后使用_GET
	$date1 = empty($_GET['date1']) ? (empty($_POST['date1']) ? "1000-01-01" : _RunMagicQuotes($_POST['date1'])) : _RunMagicQuotes($_GET['date1']);
	$date2 = empty($_GET['date2']) ? (empty($_POST['date2']) ? "9999-12-31" : _RunMagicQuotes($_POST['date2'])) : _RunMagicQuotes($_GET['date2']);
	if($date1 > $date2){$date1 = $date1 ^ $date2; $date2 = $date1 ^ $date2; $date1 = $date1 ^ $date2;}//位运算交换数值
	$search .= " AND (T1.date BETWEEN '".strip_tags($date1)." 00:00:00' AND '".strip_tags($date2)." 23:59:59')";

	//分页设定
	$showrow = 4;//一页显示的行数
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=user&do=detail_dangfei&user_id={$user_id}&page={page}&key={$key}&date1={$date1}&date2={$date2}&check={$check}";//分页地址,检索key、date1、date2、check
	
	$sql = "SELECT T1.*, SUM(IF(T1.id = T2.dangfeiid, 1, 0)) AS judge
			  FROM dj_dangfei T1,
				   (SELECT DISTINCT user_id, dangfeiid
					  FROM dj_jiaona
					 WHERE user_id = '{$user_id}') T2
			 WHERE 1 = 1 {$search} 
			 GROUP BY T1.id 
			 ORDER BY T1.id DESC";
	$db->query($sql);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql);
	$list = $db->fetchAll();

	include("page/detail_dangfei.php");
	exit;
}

//个人中心修改密码
elseif($do=="modify_pwd"){
	If_rabc($action,$do);//检测权限
	
	include("page/modify_pwd.php");
	exit;
}
	
//个人中心更新密码提交
elseif($do=="update_pwd"){
	If_rabc($action,$do);//检测权限
	
	//参数安全过滤
	$user_id	=	$_SESSION['user_id'];
	$old_pwd	=	_RunMagicQuotes(md5($_POST['old_password']));
	$password	=	_RunMagicQuotes(md5($_POST['password']));
	$updated_at	=	date("Y-m-d H-i-s");
	if($_POST['password'] != $_POST['password2'])//先判断两次输入密码一致性
		exit($lang_cn['rabc_error_Pwd2']);
	else{
		$sql = "SELECT * FROM dj_users WHERE user_id = '{$user_id}' AND password = '{$old_pwd}' LIMIT 1;";
		$db->query($sql);
		if($db->fetchRow()){//原密码正确
			$sql2 = "UPDATE dj_users SET password='{$password}', updated_at = '{$updated_at}' WHERE user_id ='{$user_id}' LIMIT 1";	
			if($db->query($sql2)){echo success($msg,"index.php");}else{echo error($msg);}
			exit;
		}else{
			exit($lang_cn['rabc_error_oldPwd']);//原密码错误
		}
	}
}

else
	include("404.php");//所有判定结束，未匹配则报404

?>