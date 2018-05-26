<?php
	//引入类库及公共方法
	@define("CORE",dirname(__FILE__)."/");	//根目录
	require_once("cfg.class.php");			//配置类
	require_once("mysql.class.php");		//数据类
	require_once("func.class.php");			//核心类
	
	$type = $_GET['type'];//获取表类型
	//类型判断
	if($type == "studyXls" || $type == "user_studyXls"){
		$fileName = "学习记录表_" . date("YmdHis") . ".xls";
	}
	elseif($type == "studyCsv" || $type == "user_studyCsv"){
		$fileName = "学习记录表_" . date("YmdHis") . ".csv";
	}
	elseif($type == "dangwu_judgeXls"){
		$fileName = "互评统计_" . date("YmdHis") . ".xls";
	}
	elseif($type == "dangwu_judgeCsv"){
		$fileName = "互评统计_" . date("YmdHis") . ".csv";
	}	
	elseif($type == "dangwu_electionXls"){
		$fileName = "评议统计_" . date("YmdHis") . ".xls";
	}
	elseif($type == "dangwu_electionCsv"){
		$fileName = "评议统计_" . date("YmdHis") . ".csv";
	}
	elseif($type == "manageXls"){
		$fileName = "用户列表_" . date("YmdHis") . ".xls";
	}
	elseif($type == "manageCsv"){
		$fileName = "用户列表_" . date("YmdHis") . ".csv";
	}
	elseif($type == "dangfeiXls"){
		$fileName = "缴纳情况表_" . date("YmdHis") . ".xls";
	}
	elseif($type == "dangfeiCsv"){
		$fileName = "缴纳情况表_" . date("YmdHis") . ".csv";
	}
	elseif($type == "managestudyXls"){
		$fileName = "课程情况表_" . date("YmdHis") . ".xls";
	}
	elseif($type == "managestudyCsv"){
		$fileName = "课程情况表_" . date("YmdHis") . ".csv";
	}
	elseif($type == "detail_dangfeiXls"){
		$fileName = "党费缴纳表_" . date("YmdHis") . ".xls";
	}
	elseif($type == "detail_dangfeiCsv"){
		$fileName = "党费缴纳表_" . date("YmdHis") . ".csv";
	}
	elseif($type == "user_dangfeiXls"){
		$fileName = "党费情况表_" . date("YmdHis") . ".xls";
	}
	elseif($type == "user_dangfeiCsv"){
		$fileName = "党费情况表_" . date("YmdHis") . ".csv";
	}
	else
		$fileName = "error.txt";
	
	Header("Content-Disposition:attachment;filename={$fileName}");
	Header("Accept-Ranges:bytes");
	Header("Content-type:application/octet-stream");
	
	if($type == "studyXls" || $type == "studyCsv" || $type == "user_studyXls" || $type == "user_studyCsv"){//导出学习记录表
		//表格数据查询
		$username = $_GET['username'];
		$sql = $_GET['sql'];
		$db->query($sql);
		$total = $db->recordCount();
		$list = $db->fetchAll();
		
		if($type == "studyXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>学习记录表</h3></caption>";
			echo "\n<thead><tr><th colspan='7'>表格作者：{$username}</th></tr>\n<tr><th>课程编号</th><th>课程名称</th><th>课程类型</th><th>课程学分</th><th>创建时间</th><th>备注</th><th>听课情况</th></tr></thead><tbody>";

			foreach($list as &$row){
				echo "\n<tr>";
				echo "<td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['extension']}</td><td>{$row['score']}</td><td>{$row['created_at']}</td><td>{$row['mark']}</td>";
				if($row['judge'] == "0")
					echo "<td>未完成</td>";
				else
					echo "<td>已完成!!!</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='7'>共{$total}条记录</td></tr><tr><td colspan='7'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "studyCsv"){//导出为csv格式
			echo "学习记录表\n表格作者：{$username}\n课程编号,课程名称,课程类型,课程学分,创建时间,备注,听课情况";

			foreach($list as &$row){
				echo "\n";
				echo $row['id'] . "," . $row['name'] . "," . $row['extension'] . "," . $row['score'] . "," . $row['created_at'] . "," . $row['mark'];
				if($row['judge'] == "0")
					echo ",未完成";
				else
					echo ",已完成!!!";
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
		if($type == "user_studyXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>学习记录表</h3></caption>";
			echo "\n<thead><tr><th colspan='6'>表格作者：{$username}</th></tr>\n<tr><th>课程编号</th><th>课程名称</th><th>课程类型</th><th>课程学分</th><th>创建时间</th><th>听课情况</th></tr></thead><tbody>";

			foreach($list as &$row){
				echo "\n<tr>";
				echo "<td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['extension']}</td><td>{$row['score']}</td><td>{$row['created_at']}</td>";
				if($row['judge'] == "0")
					echo "<td>未完成</td>";
				else
					echo "<td>已完成!!!</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='6'>共{$total}条记录</td></tr><tr><td colspan='6'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "user_studyCsv"){//导出为csv格式
			echo "学习记录表\n表格作者：{$username}\n课程编号,课程名称,课程类型,课程学分,创建时间,听课情况";

			foreach($list as &$row){
				echo "\n";
				echo $row['id'] . "," . $row['name'] . "," . $row['extension'] . "," . $row['score'] . "," . $row['created_at'];
				if($row['judge'] == "0")
					echo ",未完成";
				else
					echo ",已完成!!!";
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "dangwu_judgeXls" || $type == "dangwu_judgeCsv"){//导出互评统计
		//表格数据查询
		$username = $_GET['username'];
		$sql = $_GET['sql'];//统计查询
		$db->query($sql);
		$total = $db->recordCount();
		$list_statis = $db->fetchAll();
		
		if($type == "dangwu_judgeXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>互评统计表</h3></caption>";
			echo "\n<thead><tr><th colspan='4'>表格作者：{$username}</th></tr>\n<tr><th>姓名</th><th>优秀数</th><th>合格数</th><th>参与人数</th></tr></thead><tbody>";
		
			foreach($list_statis as &$row){
				echo "\n<tr>";
				echo "<td>{$row['target']}</td><td>{$row['level1']}</td><td>{$row['level2']}</td><td>".($row['level1']+$row['level2'])."</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='4'>共{$total}条记录</td></tr><tr><td colspan='4'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "dangwu_judgeCsv"){//导出为csv格式
			echo "互评统计表\n表格作者：{$username}\n姓名,优秀数,合格数,参与人数";
			
			foreach($list_statis as &$row){
				echo "\n";
				echo $row['target'] . "," . $row['level1'] . "," . $row['level2'] . "," . ($row['level1']+$row['level2']);
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "dangwu_electionXls" || $type == "dangwu_electionCsv"){//导出评议统计
		//表格数据查询
		$username = $_GET['username'];
		$sql_c = $_GET['sql_c'];//查询参与总人数
		$db->query($sql_c);
		$count = $db->recordCount();
		
		$sql = $_GET['sql'];//统计查询
		$db->query($sql);
		$total = $db->recordCount();
		$list_statis = $db->fetchAll();

		if($type == "dangwu_electionXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>评议统计表</h3></caption>";
			echo "\n<thead><tr><th colspan='3'>表格作者：{$username}</th></tr>\n<tr><th>姓名</th><th>推举人数</th><th>参与人数</th></tr></thead><tbody>";
		
			foreach($list_statis as &$row){
				echo "\n<tr>";
				echo "<td>{$row['target']}</td><td>{$row['num']}</td><td>{$count}</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='3'>共{$total}条记录</td></tr><tr><td colspan='3'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "dangwu_electionCsv"){//导出为csv格式
			echo "评议统计表\n表格作者：{$username}\n姓名,推举人数,参与人数";
			
			foreach($list_statis as &$row){
				echo "\n";
				echo $row['target'] . "," . $row['num'] . "," . $count;
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "manageXls" || $type == "manageCsv"){//导出用户列表
		//表格数据查询
		$username = $_GET['username'];
		$sql = $_GET['sql'];
		$db->query($sql);
		$total = $db->recordCount();
		$list = $db->fetchAll();
		
		if($type == "manageXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>用户列表</h3></caption>";
			echo "\n<thead><tr><th colspan='5'>表格作者：{$username}</th></tr>\n<tr><th>用户编号</th><th>登录名</th><th>姓名</th><th>电子邮件</th><th>创建时间</th></tr></thead><tbody>";

			foreach($list as &$row){
				echo "\n<tr>";
				echo "<td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['name']}</td><td>{$row['email']}</td><td>{$row['created_at']}</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='5'>共{$total}条记录</td></tr><tr><td colspan='5'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "manageCsv"){//导出为csv格式
			echo "用户列表\n表格作者：{$username}\n用户编号,登录名,姓名,电子邮件,创建时间";

			foreach($list as &$row){
				echo "\n";
				echo $row['id'] . "," . $row['username'] . "," . $row['name'] . "," . $row['email'] . "," . $row['created_at'];
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "dangfeiXls" || $type == "dangfeiCsv"){//导出缴纳情况表
		//表格数据查询
		$username = $_GET['username'];
		$sql_d = $_GET['sql_d'];
		$db->query($sql_d);
		$total_d = $db->recordCount();
		$list_d = $db->fetchAll();
		$total = $total_d + 2;//总列数
	
		$sql_u = $_GET['sql_u'];
		$db->query($sql_u);
		$total_u = $db->recordCount();
		$list_u = $db->fetchAll();

		if($type == "dangfeiXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>党费缴纳情况表</h3></caption>";
			echo "\n<thead><tr><th colspan='{$total}'>表格作者：{$username}</th></tr>\n<tr><th>登录名</th><th>用户名</th>";
			foreach($list_d as &$row){
				echo "<th>{$row['name']}，" . substr($row['date'],0,10) . "</th>";
			}
			echo "</tr></thead><tbody>";

			foreach($list_u as &$row){
				echo "\n<tr>";
				echo "<td>{$row['username']}</td><td>{$row['name']}</td>";
				for($j = 1;$j<=$total_d;$j++){
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT * FROM dj_jiaona WHERE user_id = '{$row['user_id']}' AND dangfeiid = '{$list_d[$j-1]['id']}' ORDER BY date DESC LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "<td>缴纳号:" . $db->getValue("id") . "，" . substr($db->getValue("date"),0,10) . "，实缴" . $db->getValue("real_price") . "</td>";
					else
						echo "<td>未缴纳</td>";
				}
				echo "</tr>";
			}
			echo "\n<tr><td colspan='{$total}'>共{$total_u}条记录</td></tr><tr><td colspan='{$total}'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "dangfeiCsv"){//导出为csv格式
			echo "党费缴纳情况表\n表格作者：{$username}\n登录名,用户名";
			foreach($list_d as &$row){
				echo "," . $row['name'] . "/" . substr($row['date'],0,10);
			}

			foreach($list_u as &$row){
				echo "\n";
				echo $row['username'] . "," . $row['name'];
				for($j = 1;$j<=$total_d;$j++){
					echo ",";
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT * FROM dj_jiaona WHERE user_id = '{$row['user_id']}' AND dangfeiid = '{$list_d[$j-1]['id']}' ORDER BY date DESC LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "缴纳号:".$db->getValue("id")."，".substr($db->getValue("date"),0,10)."，实缴".$db->getValue("real_price");
					else
						echo "未缴纳";
				}
			}
			echo "\n共{$total_u}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "managestudyXls" || $type == "managestudyCsv"){//导出课程情况表
		//表格数据查询
		$username = $_GET['username'];
		$sql_d = $_GET['sql_d'];
		$db->query($sql_d);
		$total_d = $db->recordCount();
		$list_d = $db->fetchAll();
		$total = $total_d + 2;//总列数
	
		$sql_u = $_GET['sql_u'];
		$db->query($sql_u);
		$total_u = $db->recordCount();
		$list_u = $db->fetchAll();

		if($type == "managestudyXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>党员上课情况表</h3></caption>";
			echo "\n<thead><tr><th colspan='{$total}'>表格作者：{$username}</th></tr>\n<tr><th>登录名</th><th>用户名</th>";
			foreach($list_d as &$row){
				echo "<th>{$row['name']}，" . substr($row['created_at'],0,10) . "</th>";
			}
			echo "</tr></thead><tbody>";

			foreach($list_u as &$row){
				echo "\n<tr>";
				echo "<td>{$row['username']}</td><td>{$row['name']}</td>";
				for($j = 1;$j<=$total_d;$j++){
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT id,date FROM dj_study WHERE user_id = '{$row['user_id']}' AND lessonid = '{$list_d[$j-1]['id']}' LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "<td>上课号:" . $db->getValue("id") . "，时间:" . $db->getValue("date") . "</td>";
					else
						echo "<td>未完成</td>";
				}
				echo "</tr>";
			}
			echo "\n<tr><td colspan='{$total}'>共{$total_u}条记录</td></tr><tr><td colspan='{$total}'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "managestudyCsv"){//导出为csv格式
			echo "党员上课情况表\n表格作者：{$username}\n登录名,用户名";
			foreach($list_d as &$row){
				echo "," . $row['name'] . "/" . substr($row['created_at'],0,10);
			}

			foreach($list_u as &$row){
				echo "\n";
				echo $row['username'] . "," . $row['name'];
				for($j = 1;$j<=$total_d;$j++){
					echo ",";
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT id,date FROM dj_study WHERE user_id = '{$row['user_id']}' AND lessonid = '{$list_d[$j-1]['id']}' LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "上课号:".$db->getValue("id")."，时间:".$db->getValue("date");
					else
						echo "未完成";
				}
			}
			echo "\n共{$total_u}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "detail_dangfeiXls" || $type == "detail_dangfeiCsv"){//导出党费缴纳表
		//表格数据查询
		$username = $_GET['username'];
		$sql = $_GET['sql'];
		$db->query($sql);
		$total = $db->recordCount();
		$list = $db->fetchAll();
		
		if($type == "detail_dangfeiXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>党费缴纳表</h3></caption>";
			echo "\n<thead><tr><th colspan='6'>表格作者：{$username}</th></tr>\n<tr><th>党费编号</th><th>党费名称</th><th>缴纳金额</th><th>缴纳日期</th><th>详情</th><th>缴纳情况</th></tr></thead><tbody>";

			foreach($list as &$row){
				echo "\n<tr>";
				echo "<td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['price']}</td><td>{$row['date']}</td><td>{$row['mark']}";
				if($row['judge'] == 0)
					echo "<td>未缴纳</td>";
				else
					echo "<td>已缴纳!!!</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='6'>共{$total}条记录</td></tr><tr><td colspan='6'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "detail_dangfeiCsv"){//导出为csv格式
			echo "党费缴纳表\n表格作者：{$username}\n党费编号,党费名称,缴纳金额,缴纳日期,详情,缴纳情况";

			foreach($list as &$row){
				echo "\n";
				echo $row['id'] . "," . $row['name'] . "," . $row['price'] . "," . $row['date'] . "," . $row['mark'];
				if($row['judge'] == 0)
					echo ",未缴纳";
				else
					echo ",已缴纳!!!";
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	elseif($type == "user_dangfeiXls" || $type == "user_dangfeiCsv"){//导出党费缴纳表
		//表格数据查询
		$username = $_GET['username'];
		$sql = $_GET['sql'];
		$db->query($sql);
		$total = $db->recordCount();
		$list = $db->fetchAll();
		
		if($type == "user_dangfeiXls"){//导出为xls格式
			echo "<html><head><meta charset='utf-8' /></head><body><table border='1'>\n<caption><h3>党费情况表</h3></caption>";
			echo "\n<thead><tr><th colspan='6'>表格作者：{$username}</th></tr>\n<tr><th>党费编号</th><th>党费名称</th><th>应缴金额</th><th>缴纳日期</th><th>详情</th><th>缴纳情况</th></tr></thead><tbody>";

			foreach($list as &$row){
				echo "\n<tr>";
				echo "<td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['price']}</td><td>{$row['date']}</td><td>{$row['mark']}";
				if($row['judge'] == 0)
					echo "<td>未缴纳</td>";
				else
					echo "<td>已缴纳!!!</td>";
				echo "</tr>";
			}
			echo "\n<tr><td colspan='6'>共{$total}条记录</td></tr><tr><td colspan='6'>导出时间：[" . date("Y-m-d H:i:s") ."]</td></tr></tbody></table></body></html>";
		}
		if($type == "user_dangfeiCsv"){//导出为csv格式
			echo "党费情况表\n表格作者：{$username}\n党费编号,党费名称,应缴金额,缴纳日期,详情,缴纳情况";

			foreach($list as &$row){
				echo "\n";
				echo $row['id'] . "," . $row['name'] . "," . $row['price'] . "," . $row['date'] . "," . $row['mark'];
				if($row['judge'] == 0)
					echo ",未缴纳";
				else
					echo ",已缴纳!!!";
			}
			echo "\n共{$total}条记录\n导出时间：[" . date("Y-m-d H:i:s") ."]";
		}
	}
	
	else
		echo "表格导出错误！\n导出时间：[" . date("Y-m-d H:i:s") ."]";
	
?>