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

//注册账号
elseif($do=="registerok"){
	$username	=	_RunMagicQuotes($_POST['username']);
	$name		=	_RunMagicQuotes($_POST['name']);
	$email		=	_RunMagicQuotes($_POST['email']);
	$password	=	_RunMagicQuotes(md5($_POST['password']));
	$user_id	=	md5($username);
	$created_at	=	date("Y-m-d H-i-s");
	
	$sql = "SELECT * FROM dj_users WHERE username = '{$username}';";//用户查重
	$db->query($sql);
	if($db->recordCount()){
		exit($lang_cn['rabc_is_repeat']);
	}
	$sql = "INSERT INTO dj_users (user_id ,username, password, name ,email, created_at)
	VALUES ('{$user_id}', '{$username}', '{$password}', '{$name}', '{$email}', '{$created_at}');";
	if($db->query($sql)){echo success("注册成功！","?action=user&do=login");}else{echo error($msg);}
	exit;
}

//注销
elseif($do=="logout"){
	$_SESSION = array();
	session_destroy();
	exit($lang_cn['rabc_logout']);
}

//忘记密码
elseif($do=="forget"){
	$username	=	_RunMagicQuotes($_POST['username']);
	$email		=	_RunMagicQuotes($_POST['email']);
	
	$sql = "SELECT * FROM dj_users WHERE username = '{$username}' AND email = '{$email}' LIMIT 1;";
	$db->query($sql);
	
	if ($record = $db->fetchRow()){
		//重置密码并发邮件
		$newPwd = rand(100000,999999);//随机新密码

		$sql_update = "UPDATE dj_users SET password = '".md5($newPwd)."' WHERE username = '{$username}';";
		$db->query($sql_update);//重置密码
	
		$smtpemailto = $email;//发送给谁
		$mailtitle = "党建系统 - 重置密码";//邮件主题
		$mailcontent = "账号：".$username."。<br />您的新密码为：<strong style='color:red;font-size:20px;'>".$newPwd."</strong>。<br />请及时修改。<br /><br /><a href='{$cfg["website"]}'>点此立即登录</a>";//邮件内容
		$mailtype = "HTML";//邮件格式

		$smtp = new Smtp($cfg["smtpserver"],$cfg["smtpserverport"],true,$cfg["smtpuser"],$cfg["smtppass"]);//true表示使用身份验证
		$smtp->debug = false;//是否显示发送的调试信息
		$state = $smtp->sendmail($smtpemailto, $cfg["smtpusermail"], $mailtitle, $mailcontent, $mailtype);
	
		if($state==""){
			echo error("对不起，邮件发送失败！","?action=user&do=login");
			exit;
		}
		else{
			echo success("新密码已发送到您的邮箱\\n请及时修改","?action=user&do=login");
			exit;
		}
	}
	else{
		//输入有误
		echo error("学号与邮箱不匹配！\\n请重新输入","?action=user&do=login");
	}
}

//个人中心 - 个人资料 || 个人中心 — 修改资料	
elseif($do=="user_profile" || $do=="user_edit"){
	If_rabc($action,$do);//检测权限
	
	$sql = "SELECT * FROM dj_users WHERE user_id = '{$_SESSION['user_id']}';";
	$db->query($sql);
	$db->fetchRow();//取出一条记录
	
	if($do == "user_profile"){
		include("page/user_profile.php");
	}else{
		include("page/user_edit.php");
	}
	exit;
}

//个人中心 — 修改个人资料提交
elseif($do=="update"){
	If_rabc($action,$do);//检测权限
	
	$user_id	=	$_SESSION['user_id'];
	//参数安全过滤
	//$username	=	_RunMagicQuotes($_POST['username']);//登陆名禁止修改
	//$userid	=	md5($username);
	$name		=	_RunMagicQuotes($_POST['name']);
	$sex		=	_RunMagicQuotes($_POST['sex']);
	$birthday	=	$_POST['birthday']==""?"NULL":("'".$_POST['birthday']."'");
	$idcard		=	_RunMagicQuotes($_POST['idcard']);
	$education	=	_RunMagicQuotes($_POST['education']);
	$volk		=	_RunMagicQuotes($_POST['volk']);
	$organization=	_RunMagicQuotes($_POST['organization']);
	$joinDate	=	$_POST['joinDate']==""?"NULL":("'".$_POST['joinDate']."'");
	$regularDate=	$_POST['regularDate']==""?"NULL":("'".$_POST['regularDate']."'");
	$phone		=	$_POST['phone']==""?"NULL":$_POST['phone'];
	$email		=	_RunMagicQuotes($_POST['email']);
	$address	=	_RunMagicQuotes($_POST['address']);
	$updated_at	=	date("Y-m-d H-i-s");

	$sql = "UPDATE dj_users SET name = '{$name}',
		sex			=	'{$sex}',
		birthday	=	{$birthday},
		idcard		=	'{$idcard}',
		education	=	'{$education}',
		volk		=	'{$volk}',
		organization=	'{$organization}',
		joinDate	=	{$joinDate},
		regularDate	=	{$regularDate},
		phone		=	{$phone},
		email		=	'{$email}',
		address		=	'{$address}',
		updated_at	=	'{$updated_at}' WHERE user_id ='{$user_id}' LIMIT 1;";
	
	if($db->query($sql)){echo success($msg,"?action=user&do=user_profile");}else{echo error($msg);}
	exit;
}

//个人中心 - 党费情况	
elseif($do == "user_dangfei"){
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
	$url = "?action=user&do=user_dangfei&user_id={$user_id}&page={page}&key={$key}&date1={$date1}&date2={$date2}&check={$check}";//分页地址,检索key、date1、date2、check
	
	$sql = "SELECT T1.*, SUM(IF(T1.id = T2.dangfeiid, 1, 0)) AS judge
			  FROM dj_dangfei T1,
				   (SELECT DISTINCT user_id, dangfeiid
					  FROM dj_jiaona
					 WHERE user_id = '{$user_id}') T2
			 WHERE 1 = 1 {$search} 
			 GROUP BY T1.id 
			 ORDER BY T1.id DESC";
	$sqlExcel = "SELECT T1.*, SUM(IF(T1.id = T2.dangfeiid, 1, 0)) AS judge FROM dj_dangfei T1,(SELECT DISTINCT user_id, dangfeiid FROM dj_jiaona WHERE user_id = '{$user_id}') T2 WHERE 1 = 1 {$search} GROUP BY T1.id ORDER BY T1.id DESC";//表格下载专用
	$db->query($sql);
	$total = $db->recordCount();
	$listAll = $db->fetchAll();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql);
	$list = $db->fetchAll();

	include("page/user_dangfei.php");
	exit;
}

//个人中心 - 党费情况 - 详情
elseif($do=="user_dangfei_detail"){
	If_rabc($action,$do);//检测权限
	
	$user_id = $_SESSION['user_id'];
	$dangfeiid = $_POST['dangfeiid'];
	
	$sql_price = "select price from dj_users where user_id = '{$user_id}' limit 1;";
	$db->query($sql_price);
	$db->fetchRow();
	$userPrice = $db->getValue("price");
	
	$sql = "SELECT price,real_price FROM dj_jiaona WHERE user_id = '{$user_id}' AND dangfeiid = '{$dangfeiid}' ORDER BY id DESC LIMIT 1";
	$db->query($sql);
	$db->fetchRow();
	$price = $db->getValue("price")?$db->getValue("price"):checkEmpty($userPrice);
	$real_price = $db->getValue("real_price")?$db->getValue("real_price"):"未缴纳";
	$json_arr = array("price"=>$price, "real_price"=>$real_price);
	$json_obj = json_encode($json_arr);
	echo $json_obj;
}

//个人中心 - 学习情况
elseif($do=="user_study"){
	If_rabc($action,$do);//检测权限
	$user_id = $_SESSION['user_id'];
	
	//筛选听课情况
	$check = empty($_POST['check']) ? (empty($_GET['check']) ? "all" : $_GET['check']) : $_POST['check'];//优先使用_POST
	if($check == "yes")
		$search .= " AND EXISTS (SELECT DISTINCT T3.user_id, T3.lessonid FROM dj_study T3 
			WHERE T3.user_id = '{$user_id}' 
			AND T1.id = T3.lessonid)";//只筛选已缴纳
	elseif($check == "not")
		$search .= " AND NOT EXISTS (SELECT DISTINCT T3.user_id, T3.lessonid FROM dj_study T3 
			WHERE T3.user_id = '{$user_id}' 
			AND T1.id = T3.lessonid)";//只筛选未缴纳
	else
		$search .= "";//查询全部
	
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search .= " AND (T1.id LIKE '%".strip_tags($key)."%' OR T1.name LIKE '%".strip_tags($key)."%' OR T1.detail LIKE '%".strip_tags($key)."%')";//防注入

	//接收日期数据，首次使用_POST，以后使用_GET
	$date1 = empty($_GET['date1']) ? (empty($_POST['date1']) ? "1000-01-01" : _RunMagicQuotes($_POST['date1'])) : _RunMagicQuotes($_GET['date1']);
	$date2 = empty($_GET['date2']) ? (empty($_POST['date2']) ? "9999-12-31" : _RunMagicQuotes($_POST['date2'])) : _RunMagicQuotes($_GET['date2']);
	if($date1 > $date2){$date1 = $date1 ^ $date2; $date2 = $date1 ^ $date2; $date1 = $date1 ^ $date2;}//位运算交换数值
	$search .= " AND (created_at BETWEEN '".strip_tags($date1)." 00:00:00' AND '".strip_tags($date2)." 23:59:59')";

	//分页设定
	$showrow = 4;//一页显示的行数
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=user&do=user_study&page={page}&key={$key}&date1={$date1}&date2={$date2}&check={$check}";//分页地址，检索key、date1、date2、check
		
	//计算学分
	$sqlScore = "SELECT T1.*, SUM(IF((T1.id = T2.lessonid) & (user_id = '{$user_id}'), 1, 0)) AS judge FROM dj_lesson T1, (SELECT DISTINCT user_id, lessonid FROM dj_study) T2 GROUP BY T1.id";
	$scoreA = 0;//总分
	$scoreB = 0;//已修分
	$db->query($sqlScore);
	$listScore = $db->fetchAll();
	foreach($listScore as &$row){
		$scoreA += $row['score'];
		if($row['judge'] != "0")
			$scoreB += $row['score'];
	}
	
	$sql = "SELECT T1.*, SUM(IF((T1.id = T2.lessonid) & (user_id = '{$user_id}'), 1, 0)) AS judge 
			  FROM dj_lesson T1, 
				   (SELECT DISTINCT user_id, lessonid 
					  FROM dj_study) T2 
			 WHERE 1 = 1 {$search} 
			 GROUP BY T1.id 
			 ORDER BY T1.id DESC";
	$sqlExcel = "SELECT T1.*, SUM(IF((T1.id = T2.lessonid) %26 (user_id = '{$user_id}'), 1, 0)) AS judge FROM dj_lesson T1,(SELECT DISTINCT user_id, lessonid FROM dj_study) T2 WHERE 1 = 1 {$search} GROUP BY T1.id ORDER BY T1.id DESC";//表格下载专用
	
	$db->query($sql);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql);
	$list = $db->fetchAll();
	
	include("page/user_study.php");
	exit;
}

//个人中心 - 修改密码
elseif($do=="user_pwd"){
	If_rabc($action,$do);//检测权限
	
	include("page/user_pwd.php");
	exit;
}
	
//个人中心 - 更新密码提交
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