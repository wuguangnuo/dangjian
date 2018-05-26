<?php
if(!defined("CORE"))exit("error!");//判断根目录是否存在

//党员评价
if($do=="dangwu_judge"){
	If_rabc($action,$do);//检测权限	
	
	//查询人数
	$sql_u = "SELECT username FROM dj_users;";
	$db->query($sql_u);
	$count_u = $db->recordCount();

	//查询互评
	$sql_judge = "SELECT * FROM dj_judge ORDER BY id DESC;";
	$db->query($sql_judge);
	$list_judge = $db->fetchAll();

	include("page/dangwu_judge.php");
	exit;
}

//党员评价_detail
elseif($do=="dangwu_judge_detail"){
	If_rabc($action,$do);//检测权限
	
	$judge_id	=	$_POST['judge_id'];
	$username	=	$_POST['username'];
	$count_u	=	$_POST['count_u'];
	
	//评价详情
	$sql = "SELECT * FROM dj_judge WHERE id = {$judge_id} LIMIT 1;";
	$db->query($sql);
	$db->fetchRow();
	$judge_detail = "<form class='form-horizontal' role='form'>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>互评号</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("id")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>互评名称</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("name")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>创建时间</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("create_at")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>开始时间</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("start_date")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>结束时间</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("end_date")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>备注</label>
			<div class='col-md-4 col-sm-6'>
				<textarea class='form-control' readonly='readonly'>".checkEmpty($db->getValue("mark"))."</textarea>
			</div>
		</div>
	</form>";
	if($_SESSION['roleid'] == 1)
		$judge_detail .= "<div class='text-center'><button onclick='del_judge({$judge_id})' class='btn btn-sm btn-danger'>删除本次互评</button></div>";
	
	//评价情况
	$sql_j = "SELECT start_date,end_date FROM dj_judge WHERE id = {$judge_id} LIMIT 1;";//查询互评
	$db->query($sql_j);
	$db->fetchRow();
	$start_date = $db->getValue("start_date");
	$end_date = $db->getValue("end_date");
	$sql = "SELECT DISTINCT T3.username AS target, T2.content, T2.date 
			  FROM (SELECT T1.* 
					  FROM dj_pingjia T1 
					 WHERE T1.judge_id = '{$judge_id}' 
					   AND T1.username = '{$username}') T2 
		RIGHT JOIN (SELECT username FROM dj_users) T3 
				ON T2.target = T3.username;";//查询评价
	$db->query($sql);
	$list_content = $db->fetchAll();
	$judge_content = "";
	foreach($list_content as &$row){
		$judge_content .= "<tr id='line_{$count_u}'>";
		$judge_content .= "<td name='judge_id' style='display:none'>{$judge_id}</td><td name='username'>{$_SESSION['username']}</td><td name='target'>{$row['target']}</td>";
		$judge_content .= "<td><select class='form-control input-sm' name='content' ".((date("Y-m-d H-i-s")>$start_date&&date("Y-m-d H-i-s")<$end_date)?"":"disabled").">
			<option value = ''>未评价</option>
			<option value = '优秀' ".($row['content']=="优秀"?"selected":"").">优秀</option>
			<option value = '合格' ".($row['content']=="合格"?"selected":"").">合格</option>
			</select></td><td>{$row['date']}</td>";
		$judge_content .= "</tr>";
		$count_u--;
	}
	
	//是否可提交
	$sql_j = "SELECT start_date,end_date FROM dj_judge WHERE id = {$judge_id} LIMIT 1;";//查询到期
	$db->query($sql_j);
	$db->fetchRow();
	$start_date = $db->getValue("start_date");
	$end_date = $db->getValue("end_date");
	$sql_pingjia_ok = "SELECT id FROM dj_pingjia WHERE judge_id = '{$judge_id}' AND username = '{$username}';";//查询是否已进行
	$db->query($sql_pingjia_ok);
	$pingjia_ok = $db->recordCount();
	if(date("Y-m-d H-i-s")>$start_date && date("Y-m-d H-i-s")<$end_date){
		if($pingjia_ok == 0){
			$judge_ok = "btn btn-sm btn-primary pull-right";//可以提交
		}
		else $judge_ok = "btn btn-sm btn-primary pull-right disabled";//已经提交过
	}
	else
		$judge_ok = "btn btn-sm btn-primary pull-right disabled";//时间过期
	
	//信息统计
	$sql = "SELECT T1.target, SUM(IF ((T1.content = '优秀'), 1, 0)) AS level1, SUM(IF ((T1.content = '合格'), 1, 0)) AS level2 
			  FROM dj_pingjia T1 
			 WHERE T1.judge_id = {$judge_id} 
		  GROUP BY T1.target;";//查询统计
	$db->query($sql);
	$count = $db->recordCount();
	$list_statis = $db->fetchAll();
	$judge_statis = "";
	if($count == 0){
		$judge_statis .= "<h4 style='color:red'>列表为空!</h4>";
	}
	foreach($list_statis as &$row){
		$judge_statis .= "<tr><td>{$row['target']}</td><td>{$row['level1']}</td><td>{$row['level2']}</td><td>".($row['level1']+$row['level2'])."</td></tr>";
	}
	
	//表格下载
	$sqlExcel = "SELECT T1.target, SUM(IF ((T1.content = '优秀'), 1, 0)) AS level1, SUM(IF ((T1.content = '合格'), 1, 0)) AS level2 FROM dj_pingjia T1 WHERE T1.judge_id = {$judge_id} GROUP BY T1.target;";
	$excelDLXls = "lib/excelDL.class.php?type=dangwu_judgeXls&username={$_SESSION['username']}&sql={$sqlExcel}";
	$excelDLCsv = "lib/excelDL.class.php?type=dangwu_judgeCsv&username={$_SESSION['username']}&sql={$sqlExcel}";
	
	$json_arr = array(
		"judge_detail"	=>	$judge_detail,	//评议详情
		"judge_content"	=>	$judge_content,	//评议情况
		"judge_ok"		=>	$judge_ok,		//是否可提交
		"judge_statis"	=>	$judge_statis,	//信息统计
		"excelDLXls"	=>	$excelDLXls,	//表格下载
		"excelDLCsv"	=>	$excelDLCsv		//表格下载
	);
	$json_obj = json_encode($json_arr);
	echo $json_obj;
	
}

//添加互评
elseif($do=="add_judge"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$name		=	_RunMagicQuotes($_POST['name']);
	$create_at	=	date("Y-m-d H-i-s");
	$start_date	=	_RunMagicQuotes($_POST['start_date']);
	$end_date	=	_RunMagicQuotes($_POST['end_date']) . " 23:59:59";
	$mark		=	_RunMagicQuotes($_POST['mark']);
	
	$sql = "INSERT INTO dj_judge (name, create_at, start_date, end_date, mark)
	VALUES ('{$name}', '{$create_at}', '{$start_date}', '{$end_date}', '{$mark}')";
	if($db->query($sql)){echo success($msg,"?action=dangwu&do=dangwu_judge");}else{echo error($msg);}
	exit;
}
	
//删除互评
elseif($do=="del_judge"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$judge_id = _RunMagicQuotes($_POST['judge_id']);
	
	$sql = "DELETE FROM dj_judge WHERE id='{$judge_id}' LIMIT 1";
	$db->query($sql);
}

//添加评价
elseif($do=="add_pingjia"){
	If_rabc($action,$do);//检测权限
	
	//参数安全过滤
	$judge_id	=	_RunMagicQuotes($_POST['judge_id']);
	$username	=	_RunMagicQuotes($_POST['username']);
	$target		=	_RunMagicQuotes($_POST['target']);
	$content	=	_RunMagicQuotes($_POST['content']);
	$date		=	date("Y-m-d H-i-s");

	$sql = "INSERT INTO dj_pingjia (judge_id, username, target, content, date)
	VALUES ('{$judge_id}', '{$username}', '{$target}', '{$content}', '{$date}')";
	$db->query($sql);
}

//================ Nav * Nav * Nav * Nav * Nav * Nav ================//

//民主评议
elseif($do=="dangwu_election"){
	If_rabc($action,$do);//检测权限	
	
	//查询人数
	$sql_u = "SELECT username FROM dj_users;";
	$db->query($sql_u);
	$count_u = $db->recordCount();

	//查询互评
	$sql_election = "SELECT * FROM dj_election ORDER BY id DESC;";
	$db->query($sql_election);
	$list_election = $db->fetchAll();

	include("page/dangwu_election.php");
	exit;
}

//党员评议_detail
elseif($do=="dangwu_election_detail"){
	If_rabc($action,$do);//检测权限
	
	$election_id=	$_POST['election_id'];
	$username	=	$_POST['username'];
	$count_u	=	$_POST['count_u'];
	
	//评议详情
	$sql = "SELECT * FROM dj_election WHERE id = {$election_id} LIMIT 1;";
	$db->query($sql);
	$db->fetchRow();
	
	$election_limit = $db->getValue("vote_num");//每人票数
	$election_detail = "<form class='form-horizontal' role='form'>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>评议号</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("id")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>评议名称</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("name")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>创建时间</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("create_at")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>开始时间</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("start_date")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>结束时间</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("end_date")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>每人票数</label>
			<div class='col-md-4 col-sm-6'>
				<input type='text' class='form-control' value='{$db->getValue("vote_num")}' readonly='readonly' />
			</div>
		</div>
		<div class='form-group'>
			<label class='col-md-2 col-sm-2 control-label'>备注</label>
			<div class='col-md-4 col-sm-6'>
				<textarea class='form-control' readonly='readonly'>".checkEmpty($db->getValue("mark"))."</textarea>
			</div>
		</div>
	</form>";
	if($_SESSION['roleid'] == 1)
		$election_detail .= "<div class='text-center'><button onclick='del_election({$election_id})' class='btn btn-sm btn-danger'>删除本次评议</button></div>";
	
	//评议情况
	$sql = "SELECT DISTINCT T3.username AS target, T2.date 
			  FROM (SELECT T1.* 
					  FROM dj_vote T1 
					 WHERE T1.election_id = '{$election_id}' 
					   AND T1.username = '{$username}') T2 
		RIGHT JOIN (SELECT username FROM dj_users) T3 
				ON T2.target = T3.username;";
	$db->query($sql);
	$list_content = $db->fetchAll();
	$election_content = "";
	foreach($list_content as &$row){
		$election_content .= "<tr id='line_{$count_u}'>";
		$election_content .= "<td name='election_id' style='display:none'>{$election_id}</td><td name='username'>{$_SESSION['username']}</td><td name='target'>{$row['target']}</td>";
		$election_content .= "<td><input type='checkbox' ".(empty($row['date'])?"":"checked")."></td><td>{$row['date']}</td>";
		$election_content .= "</tr>";
		$count_u--;
	}
	
	//是否可提交
	$sql_e = "SELECT start_date,end_date FROM dj_election WHERE id = {$election_id} LIMIT 1;";//查询日期限制
	$db->query($sql_e);
	$db->fetchRow();
	$start_date = $db->getValue("start_date");
	$end_date = $db->getValue("end_date");
	$sql_vote_ok = "SELECT id FROM dj_vote WHERE election_id = '{$election_id}' AND username = '{$username}';";//查询是否已进行
	$db->query($sql_vote_ok);
	$vote_ok = $db->recordCount();
	if(date("Y-m-d H-i-s")>$start_date && date("Y-m-d H-i-s")<$end_date){
		if($vote_ok == 0){
			$election_ok = "btn btn-sm btn-primary pull-right";//可以提交
		}
		else $election_ok = "btn btn-sm btn-primary pull-right disabled";//已经提交过
	}
	else
		$election_ok = "btn btn-sm btn-primary pull-right disabled";//时间过期
	
	//信息统计
	$sql = "SELECT T1.target, COUNT(T1.id) AS num 
			  FROM dj_vote T1 
			 WHERE T1.election_id = {$election_id} 
		  GROUP BY T1.target 
		  ORDER BY num DESC;";//查询统计
	$db->query($sql);
	$list_statis = $db->fetchAll();
	$sql_count = "SELECT username FROM dj_vote WHERE election_id = {$election_id} GROUP BY username;";//查询参与总人数
	$db->query($sql_count);
	$count = $db->recordCount();
	$election_statis = "";
	if($count == 0){
		$election_statis .= "<h4 style='color:red'>列表为空!</h4>";
	}
	foreach($list_statis as &$row){
		$election_statis .= "<tr><td>{$row['target']}</td><td>{$row['num']}</td><td>{$count}</td></tr>";
	}
	
	//表格下载
	$sqlExcel = "SELECT T1.target, COUNT(T1.id) AS num FROM dj_vote T1 WHERE T1.election_id = {$election_id} GROUP BY T1.target ORDER BY num DESC;";
	$excelDLXls = "lib/excelDL.class.php?type=dangwu_electionXls&username={$_SESSION['username']}&sql={$sqlExcel}&sql_c={$sql_count}";
	$excelDLCsv = "lib/excelDL.class.php?type=dangwu_electionCsv&username={$_SESSION['username']}&sql={$sqlExcel}&sql_c={$sql_count}";
	
	$json_arr = array(
		"election_detail"	=>	$election_detail,	//评议详情
		"election_content"	=>	$election_content,	//评议情况
		"election_ok"		=>	$election_ok,		//是否可提交
		"election_statis"	=>	$election_statis,	//信息统计
		"election_limit"	=>	$election_limit,	//每人票数
		"excelDLXls"		=>	$excelDLXls,		//表格下载
		"excelDLCsv"		=>	$excelDLCsv			//表格下载
	);
	$json_obj = json_encode($json_arr);
	echo $json_obj;
	
}

//添加评议
elseif($do=="add_election"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$name		=	_RunMagicQuotes($_POST['name']);
	$create_at	=	date("Y-m-d H-i-s");
	$start_date	=	_RunMagicQuotes($_POST['start_date']);
	$end_date	=	_RunMagicQuotes($_POST['end_date']) . " 23:59:59";
	$vote_num	=	_RunMagicQuotes($_POST['vote_num']);
	$mark		=	_RunMagicQuotes($_POST['mark']);
	
	$sql = "INSERT INTO dj_election (name, create_at, start_date, end_date, vote_num, mark)
	VALUES ('{$name}', '{$create_at}', '{$start_date}', '{$end_date}', '{$vote_num}', '{$mark}')";
	if($db->query($sql)){echo success($msg,"?action=dangwu&do=dangwu_election");}else{echo error($msg);}
	exit;
}

//删除评议
elseif($do=="del_election"){
	If_rabc($action,$do);//检测权限
	is_admin($action,$do);
	
	//参数安全过滤
	$election_id = _RunMagicQuotes($_POST['election_id']);
	
	$sql = "DELETE FROM dj_election WHERE id='{$election_id}' LIMIT 1";
	$db->query($sql);
}

//添加投票
elseif($do=="add_vote"){
	If_rabc($action,$do);//检测权限
	
	//参数安全过滤
	$election_id	=	_RunMagicQuotes($_POST['election_id']);
	$username		=	_RunMagicQuotes($_POST['username']);
	$target			=	_RunMagicQuotes($_POST['target']);
	$date			=	date("Y-m-d H-i-s");

	$sql = "INSERT INTO dj_vote (election_id, username, target, date)
	VALUES ('{$election_id}', '{$username}', '{$target}', '{$date}')";
	$db->query($sql);
}

else
	include("404.php");//所有判定结束，未匹配则报404

?>
