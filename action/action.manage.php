<?php
if(!defined("CORE"))exit("error!");

//用户管理
if($do=="manage_user"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search .= " AND (username LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%')";

	//分页设定
	$showrow = 4;//一页显示的行数
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=manage&do=manage_user&page={page}&key={$key}";//分页地址，检索key

	$sql = "SELECT * FROM dj_users WHERE 1=1 {$search} ORDER BY id ASC";
	$sqlExcel = $sql;//表格下载专用
	$db->query($sql);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql);
	$list = $db->fetchAll();

	include("page/manage_user.php");
	exit;
}

//获取用户信息
elseif($do=="getUserProfile"){
	If_rabc($action,$do);//检测权限	
	
	$id = $_POST['id'];
	
	$sql = "SELECT * FROM dj_users WHERE id='{$id}' LIMIT 1;";
	$db->query($sql);
	$db->fetchRow();
	
	$json_arr = array(
		"id"			=>	$db->getValue("id"),
		"user_id"		=>	$db->getValue("user_id"),
		"username"		=>	$db->getValue("username"),
		"password"		=>	$db->getValue("password"),
		"name"			=>	$db->getValue("name"),
		"sex"			=>	$db->getValue("sex"),
		"birthday"		=>	$db->getValue("birthday"),
		"idcard"		=>	$db->getValue("idcard"),
		"education"		=>	$db->getValue("education"),
		"volk"			=>	$db->getValue("volk"),
		"category"		=>	$db->getValue("category"),
		"organization"	=>	$db->getValue("organization"),
		"joinDate"		=>	$db->getValue("joinDate"),
		"regularDate"	=>	$db->getValue("regularDate"),
		"price"			=>	$db->getValue("price"),
		"phone"			=>	$db->getValue("phone"),
		"email"			=>	$db->getValue("email"),
		"address"		=>	$db->getValue("address"),
		"roleid"		=>	$db->getValue("roleid"),
		"created_at"	=>	$db->getValue("created_at"),
		"updated_at"	=>	$db->getValue("updated_at")
	);
	$json_obj = json_encode($json_arr);
	echo $json_obj;
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
	$sql = "SELECT * FROM dj_users WHERE username ='{$username}';";//用户查重
	$db->query($sql);
	if($db->recordCount()){
		exit($lang_cn['rabc_is_repeat']);
	}
	$sql = "INSERT INTO dj_users (user_id, username, password, name, email, roleid, created_at)
	VALUES ('{$user_id}', '{$username}', '{$password}', '{$name}', '{$email}', '{$roleid}', '{$created_at}');";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_user");}else{echo error($msg);}
	exit;
}

//删除用户
elseif($do=="del_user"){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);
	
	$user_id = $_POST['user_id'];
	$sql = "DELETE FROM dj_users WHERE user_id='{$user_id}' LIMIT 1;";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_user");}else{echo error($msg);}
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
	$birthday	=	$_POST['birthday']==""?"NULL":("'".$_POST['birthday']."'");
	$idcard		=	_RunMagicQuotes($_POST['idcard']);
	$education	=	_RunMagicQuotes($_POST['education']);
	$volk		=	_RunMagicQuotes($_POST['volk']);
	$category	=	_RunMagicQuotes($_POST['category']);
	$organization=	_RunMagicQuotes($_POST['organization']);
	$joinDate	=	$_POST['joinDate']==""?"NULL":("'".$_POST['joinDate']."'");
	$regularDate=	$_POST['regularDate']==""?"NULL":("'".$_POST['regularDate']."'");
	$price		=	$_POST['price']==""?"NULL":$_POST['price'];
	$phone		=	$_POST['phone']==""?"NULL":$_POST['phone'];
	$email		=	_RunMagicQuotes($_POST['email']);
	$address	=	_RunMagicQuotes($_POST['address']);
	$roleid		=	_RunMagicQuotes($_POST['roleid']);
//	$created_at	=	_RunMagicQuotes($_POST['created_at']);
	$updated_at	=	date("Y-m-d H-i-s");
	$user_id	=	md5($_POST['username']);
	
	$sql = "UPDATE dj_users SET name = '{$name}',
		sex			=	'{$sex}',
		birthday	=	{$birthday},
		idcard		=	'{$idcard}',
		education	=	'{$education}',
		volk		=	'{$volk}',
		category	=	'{$category}',
		organization=	'{$organization}',
		joinDate	=	{$joinDate},
		regularDate	=	{$regularDate},
		price		=	{$price},
		phone		=	{$phone},
		email		=	'{$email}',
		address		=	'{$address}',
		roleid		=	'{$roleid}',
		updated_at	=	'{$updated_at}'";
	$sql .= empty($_POST['password']) ? "" : " ,password = '{$password}'";//是否更改用户密码
	$sql .= " WHERE user_id ='{$user_id}' LIMIT 1;";
		
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_user");}else{echo error($msg);}
	exit;
}

//================ Nav * Nav * Nav * Nav * Nav * Nav ================//

//党费管理
elseif($do=="manage_dangfei"){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);

	//下拉选择用户
	$sql_user = "SELECT user_id,username,name,price FROM dj_users ORDER BY id ASC;";
	$db->query($sql_user);
	$list_user = $db->fetchAll();

	//下拉选择党费
	$sql_dangfei = "SELECT id,name FROM dj_dangfei ORDER BY id DESC;";
	$db->query($sql_dangfei);
	$list_dangfei = $db->fetchAll();

	//查询 thead 数据
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search1 .= " AND (id LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%' OR mark LIKE '%".strip_tags($key)."%')";
	
	//接收日期数据，首次使用_POST，以后使用_GET
	$date1 = empty($_GET['date1']) ? (empty($_POST['date1']) ? "1000-01-01" : _RunMagicQuotes($_POST['date1'])) : _RunMagicQuotes($_GET['date1']);
	$date2 = empty($_GET['date2']) ? (empty($_POST['date2']) ? "9999-12-31" : _RunMagicQuotes($_POST['date2'])) : _RunMagicQuotes($_GET['date2']);
	if(empty($_POST['date1']) && empty($_POST['date2']) && empty($_GET['date1']) && empty($_GET['date2'])){//不填写则默认获取近一年数据
		$date1 = date("Y-m-d",strtotime("-1 year"));
		$date2 = date("Y-m-d");
	}
	if($date1 > $date2){$date1 = $date1 ^ $date2; $date2 = $date1 ^ $date2; $date1 = $date1 ^ $date2;}//位运算交换数值
	$search1 .= " AND (date BETWEEN '".strip_tags($date1)." 00:00:00' AND '".strip_tags($date2)." 23:59:59')";
	$sql_d = "SELECT * FROM dj_dangfei WHERE 1=1 {$search1} ORDER BY id ASC;";
	$db->query($sql_d);
	$total_d = $db->recordCount();
	$list_d = $db->fetchAll();
	
	//查询 tbody 数据
	//筛选用户
	$user = empty($_POST['user']) ? (empty($_GET['user']) ? "" : _RunMagicQuotes($_GET['user'])) : _RunMagicQuotes($_POST['user']);
	$search2 .= " AND (username LIKE '%".strip_tags($user)."%' OR name LIKE '%".strip_tags($user)."%')";
	
	//分页设定
	$showrow = 4;//一页显示的行数
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=manage&do=manage_dangfei&page={page}&key={$key}&date1={$date1}&date2={$date2}&user={$user}";//分页地址，检索key、date1、date2、user
	$sql_u = "SELECT user_id,username,name FROM dj_users WHERE 1=1 {$search2} ORDER BY id ASC";
	$sqlExcel_u = $sql_u;//表格下载专用
	$db->query($sql_u);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql_u .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql_u);
	$total_u = $db->recordCount();
	$list_u = $db->fetchAll();
	
	include("page/manage_dangfei.php");
	exit;
}

//获取党费信息
elseif($do=="getDangfeiProfile"){
	If_rabc($action,$do);//检测权限	
	
	$id = $_POST['id'];
	
	$sql = "SELECT * FROM dj_dangfei WHERE id='{$id}' LIMIT 1;";
	$db->query($sql);
	$db->fetchRow();
	
	$json_arr = array(
		"id"	=>	$db->getValue("id"),
		"name"	=>	$db->getValue("name"),
		"date"	=>	$db->getValue("date"),
		"mark"	=>	$db->getValue("mark"),
		);
	$json_obj = json_encode($json_arr);
	echo $json_obj;
}

//添加党费
elseif($do=="add_dangfei"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$name	=	_RunMagicQuotes($_POST['name']);
	$date	=	date("Y-m-d H-i-s");
	$mark	=	_RunMagicQuotes($_POST['mark']);
//	$created_at = date("Y-m-d H-i-s");
	
	$sql = "INSERT INTO dj_dangfei (name, date, mark)
	VALUES ('{$name}', '{$date}', '{$mark}')";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_dangfei");}else{echo error($msg);}
	exit;
}

//删除党费
elseif($do=="del_dangfei"){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);
	
	$id = $_POST['id'];
	$sql = "DELETE FROM dj_dangfei WHERE id='{$id}' LIMIT 1";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_dangfei");}else{echo error($msg);}
	exit;
}

//添加缴纳
elseif($do=="add_jiaona"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$user_id	=	_RunMagicQuotes($_POST['user_id']);
	$dangfeiid	=	_RunMagicQuotes($_POST['dangfeiid']);
	$price	=	_RunMagicQuotes($_POST['price']);
	$real_price	=	_RunMagicQuotes($_POST['real_price']);
	$date		=	_RunMagicQuotes($_POST['date']);
	
	$sql = "INSERT INTO dj_jiaona (user_id, dangfeiid, price, real_price, date)
	VALUES ('{$user_id}', '{$dangfeiid}', '{$price}', '{$real_price}', '{$date}')";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_dangfei");}else{echo error($msg);}
	exit;
}

//获取金额
elseif($do=="getUserPrice"){
	$user_id	=	_RunMagicQuotes($_POST['user_id']);
	
	$sql = "SELECT price FROM dj_users WHERE user_id = '{$user_id}' LIMIT 1;";
	$db->query($sql);
	$sql = $db->fetchRow();
	echo ($db->getValue("price"))?($db->getValue("price")):"请先填写用户应缴金额";
}

//================ Nav * Nav * Nav * Nav * Nav * Nav ================//

//课程管理
elseif($do=="manage_study"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//查询 thead 数据
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search1 .= " AND (id LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%' OR extension LIKE '%".strip_tags($key)."%' OR detail LIKE '%".strip_tags($key)."%' OR mark LIKE '%".strip_tags($key)."%')";
	
	//接收日期数据，首次使用_POST，以后使用_GET
	$date1 = empty($_GET['date1']) ? (empty($_POST['date1']) ? "1000-01-01" : _RunMagicQuotes($_POST['date1'])) : _RunMagicQuotes($_GET['date1']);
	$date2 = empty($_GET['date2']) ? (empty($_POST['date2']) ? "9999-12-31" : _RunMagicQuotes($_POST['date2'])) : _RunMagicQuotes($_GET['date2']);
	if(empty($_POST['date1']) && empty($_POST['date2']) && empty($_GET['date1']) && empty($_GET['date2'])){//不填写则默认获取近六月数据
		$date1 = date("Y-m-d",strtotime("-6 month"));
		$date2 = date("Y-m-d");
	}
	if($date1 > $date2){$date1 = $date1 ^ $date2; $date2 = $date1 ^ $date2; $date1 = $date1 ^ $date2;}//位运算交换数值
	$search1 .= " AND (created_at BETWEEN '".strip_tags($date1)." 00:00:00' AND '".strip_tags($date2)." 23:59:59')";
	$sql_d = "SELECT * FROM dj_lesson WHERE 1=1 {$search1} ORDER BY id ASC;";
	$db->query($sql_d);
	$total_d = $db->recordCount();
	$list_d = $db->fetchAll();
	
	//查询 tbody 数据
	//筛选用户
	$user = empty($_POST['user']) ? (empty($_GET['user']) ? "" : _RunMagicQuotes($_GET['user'])) : _RunMagicQuotes($_POST['user']);
	$search2 .= " AND (username LIKE '%".strip_tags($user)."%' OR name LIKE '%".strip_tags($user)."%')";
	
	//分页设定
	$showrow = 4;//一页显示的行数
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=manage&do=manage_study&page={page}&key={$key}&date1={$date1}&date2={$date2}&user={$user}";//分页地址，检索key、date1、date2、user
	$sql_u = "SELECT user_id,username,name FROM dj_users WHERE 1=1 {$search2} ORDER BY id ASC";
	$sqlExcel_u = $sql_u;//表格下载专用
	$db->query($sql_u);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql_u .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql_u);
	$total_u = $db->recordCount();
	$list_u = $db->fetchAll();
	
	include("page/manage_study.php");
	exit;
}

//添加课程
elseif($do=="add_lesson"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);

	//参数安全过滤
	$name		=	_RunMagicQuotes($_POST['name']);
	$extension	=	_RunMagicQuotes($_POST['extension']);
	$score		=	_RunMagicQuotes($_POST['score']);
	$detail		=	_RunMagicQuotes($_POST['detail']);
	$link		=	_RunMagicQuotes($_POST['link']);
	$created_at	=	date("Y-m-d H-i-s");
	$mark		=	_RunMagicQuotes($_POST['mark']);

	$link = $cfg["website"] . "upload/" . $link;
	$sql = "INSERT INTO dj_lesson (name ,extension, score, detail ,link ,created_at ,mark)
	VALUES ('{$name}', '{$extension}', '{$score}', '{$detail}', '{$link}', '{$created_at}', '{$mark}');";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_study");}else{echo error($msg);}
	exit;
}

//删除课程
elseif($do=="del_lesson"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$lessonid	=	_RunMagicQuotes($_GET['lessonid']);
	
	$sql = "DELETE FROM dj_lesson WHERE id='{$lessonid}' LIMIT 1;";
	if($db->query($sql)){echo success($msg,"?action=manage&do=manage_study");}else{echo error($msg);}
	exit;
}

else
	include("404.php");//所有判定结束，未匹配则报404

?>