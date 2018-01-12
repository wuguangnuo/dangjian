<?php
if(!defined("CORE"))exit("error!");

//用户管理
elseif($do==""){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search .= " AND (username LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%')";

	//分页设定
	$showrow = 4;//一页显示的行数
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=manage&page={page}&key={$key}";//分页地址，检索key

	$sql = "SELECT * FROM dj_users WHERE 1=1 {$search} ORDER BY id ASC";
	$db->query($sql);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql);
	$list = $db->fetchAll();

	include("page/manage.php");
	exit;
}

//新建用户
elseif($do=="add_user"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$username	=	_RunMagicQuotes($_POST['username']);
	$roleid		=	_RunMagicQuotes($_POST['roleid']);
	$name		=	_RunMagicQuotes($_POST['name']);
	$email		=	_RunMagicQuotes($_POST['email']);
	$password	=	empty($_POST['password']) ? md5(123456) : md5($_POST['password']);//默认密码123456
	$user_id	=	_RunMagicQuotes(md5($_POST['username']));
	$created_at	=	date("Y-m-d H-i-s");
	
	//用户查重
	$sql = "SELECT * FROM dj_users WHERE username ='{$username}' LIMIT 1;";//用户查重
	$db->query($sql);
	if($db->fetchRow()){
		exit($lang_cn['rabc_is_repeat']);
	}
	$sql = "INSERT INTO dj_users (user_id, username, password, name, email, roleid, created_at)
	VALUES ('{$user_id}', '{$username}', '{$password}', '{$name}', '{$email}', '{$roleid}', '{$created_at}');";
	if($db->query($sql)){echo success($msg,"?action=manage");}else{echo error($msg);}
	exit;
}

//删除用户
elseif($do=="del_user"){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);
	
	$user_id = $_POST['user_id'];
	$sql = "DELETE FROM dj_users WHERE user_id='{$user_id}' LIMIT 1;";
	if($db->query($sql)){echo success($msg,"?action=manage");}else{echo error($msg);}
	exit;
}

//管理-更新用户信息
elseif($do=="update_user"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
//	$id			=	_RunMagicQuotes($_POST['id']);
	$username	=	_RunMagicQuotes($_POST['username']);
	$password	=	md5($_POST['password']);
	$name		=	_RunMagicQuotes($_POST['name']);
	$sex		=	_RunMagicQuotes($_POST['sex']);
	$birthday	=	_RunMagicQuotes($_POST['birthday']);
	$idcard		=	_RunMagicQuotes($_POST['idcard']);
	$college	=	_RunMagicQuotes($_POST['college']);
	$volk		=	_RunMagicQuotes($_POST['volk']);
	$phone		=	_RunMagicQuotes($_POST['phone']);
	$email		=	_RunMagicQuotes($_POST['email']);
	$address	=	_RunMagicQuotes($_POST['address']);
	$roleid		=	_RunMagicQuotes($_POST['roleid']);
//	$created_at	=	_RunMagicQuotes($_POST['created_at']);
	$updated_at	=	date("Y-m-d H-i-s");
	$user_id	=	md5($_POST['username']);
	
	$sql = "UPDATE dj_users SET name = '{$name}',
		sex			=	'{$sex}',
		birthday	=	'{$birthday}',
		idcard		=	'{$idcard}',
		college		=	'{$college}',
		volk		=	'{$volk}',
		phone		=	'{$phone}',
		email		=	'{$email}',
		address		=	'{$address}',
		roleid		=	'{$roleid}',
		updated_at	=	'{$updated_at}'";
	$sql .= empty($_POST['password']) ? "" : " ,password = '{$password}'";//是否更改用户密码
	$sql .= " WHERE user_id ='{$user_id}' LIMIT 1;";
		
	if($db->query($sql)){echo success($msg,"?action=manage");}else{echo error($msg);}
	exit;
}

else
	include("404.php");//所有判定结束，未匹配则报404

?>