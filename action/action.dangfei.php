<?php
if(!defined("CORE"))exit("error!");//判断根目录是否存在

//党费管理
if($do==""){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);

	//下拉选择用户
	$sql_user = "SELECT user_id,username,name FROM dj_users ORDER BY id ASC;";
	$db->query($sql_user);
	$list_user = $db->fetchAll();

	//下拉选择党费
	$sql_dangfei = "SELECT id,name,price FROM dj_dangfei ORDER BY id DESC;";
	$db->query($sql_dangfei);
	$list_dangfei = $db->fetchAll();

	//查询 thead 数据
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search1 .= " AND (id LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%' OR price LIKE '%".strip_tags($key)."%' OR mark LIKE '%".strip_tags($key)."%')";
	
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
	$url = "?action=dangfei&page={page}&key={$key}&date1={$date1}&date2={$date2}&user={$user}";//分页地址，检索key、date1、date2、user
	$sql_u = "SELECT user_id,username,name FROM dj_users WHERE 1=1 {$search2} ORDER BY id ASC";
	$db->query($sql_u);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql_u .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql_u);
	$total_u = $db->recordCount();
	$list_u = $db->fetchAll();
	
	include("page/dangfei.php");
	exit;
}

//添加党费
elseif($do=="add_dangfei"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$name	=	_RunMagicQuotes($_POST['name']);
	$price	=	_RunMagicQuotes($_POST['price']);
	$date	=	date("Y-m-d H-i-s");
	$mark	=	_RunMagicQuotes($_POST['mark']);
//	$created_at = date("Y-m-d H-i-s");
	
	$sql = "INSERT INTO dj_dangfei (name, price, date, mark)
	VALUES ('{$name}', '{$price}', '{$date}', '{$mark}')";
	if($db->query($sql)){echo success($msg,"?action=dangfei");}else{echo error($msg);}
	exit;
}

//删除党费
elseif($do=="del_dangfei"){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);
	
	$id = $_POST['id'];
	$sql = "DELETE FROM dj_dangfei WHERE id='{$id}' LIMIT 1";
	if($db->query($sql)){echo success($msg,"?action=dangfei");}else{echo error($msg);}
	exit;
}

//添加缴纳
elseif($do=="add_jiaona"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$user_id	=	_RunMagicQuotes($_POST['user_id']);
	$dangfeiid	=	_RunMagicQuotes($_POST['dangfeiid']);
	$date		=	_RunMagicQuotes($_POST['date']);
	
	$sql = "INSERT INTO dj_jiaona (user_id, dangfeiid, date)
	VALUES ('{$user_id}', '{$dangfeiid}', '{$date}')";
	if($db->query($sql)){echo success($msg,"?action=dangfei");}else{echo error($msg);}
	exit;
}


//数据库表格测试页面
elseif($do=="6666"){
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);
	
	include("page/dbtable.php");
	exit;
}


else
	include("404.php");//所有判定结束，未匹配则报404

?>
