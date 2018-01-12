<?php
if(!defined("CORE"))exit("error!");//判断根目录是否存在

//首页
if($do==""){
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
	$url = "?action=study&page={page}&key={$key}&date1={$date1}&date2={$date2}&check={$check}";//分页地址，检索key、date1、date2、check
		
	$sql = "SELECT T1.*, SUM(IF((T1.id = T2.lessonid) & (user_id = '{$user_id}'), 1, 0)) AS judge 
			  FROM dj_lesson T1, 
				   (SELECT DISTINCT user_id, lessonid 
					  FROM dj_study) T2 
			 WHERE 1 = 1 {$search} 
			 GROUP BY T1.id 
			 ORDER BY T1.id DESC";
	$db->query($sql);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页，向上取整
	$sql .= " LIMIT ".($curpage - 1) * $showrow.",{$showrow};";//添加限制
	$db->query($sql);
	$list = $db->fetchAll();
	
	include("page/study.php");
	exit;
}

//添加课程
elseif($do=="add_lesson"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);

	//参数安全过滤
	$name		=	_RunMagicQuotes($_POST['name']);
	$detail		=	_RunMagicQuotes($_POST['detail']);
	$created_at	=	date("Y-m-d H-i-s");
	$mark		=	_RunMagicQuotes($_POST['mark']);
	
	$sql = "INSERT INTO dj_lesson (name ,detail ,created_at ,mark)
	VALUES ('{$name}', '{$detail}', '{$created_at}', '{$mark}');";
	if($db->query($sql)){echo success($msg,"?action=study");}else{echo error($msg);}
	exit;
}

//进入课程
elseif($do=="add_study"){
	If_rabc($action,$do);//检测权限
	
	//参数安全过滤
	$user_id	=	_RunMagicQuotes($_POST['user_id']);
	$lessonid	=	_RunMagicQuotes($_POST['lessonid']);
	$date 		= 	date("Y-m-d H-i-s");

	$sql = "INSERT INTO dj_study (user_id ,lessonid ,date)
	VALUES ('{$user_id}', '{$lessonid}', '{$date}');";
	if($db->query($sql)){echo success($msg,"?action=study");}else{echo error($msg);}
	exit;
}

//删除课程
elseif($do=="del_lesson"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$lessonid	=	_RunMagicQuotes($_GET['lessonid']);
	
	$sql = "DELETE FROM dj_lesson WHERE id='{$lessonid}' LIMIT 1;";
	if($db->query($sql)){echo success($msg,"?action=study");}else{echo error($msg);}
	exit;
}

else
	include("404.php");//错误页

?>
