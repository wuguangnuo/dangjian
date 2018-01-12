<?php
	include('head.php');
?>
<h3>数据库测试页面</h3>

<?php
//===============================
//个人中心--党费查询--sql语句优化
$user_id = "21232f297a57a5a743894a0e4a801fc3";
$sql = "
SELECT  T1.*,SUM(IF(T1.id = T2.dangfeiid,1,0)) AS judge
FROM dj_dangfei T1 ,
	(
	SELECT DISTINCT user_id,dangfeiid FROM dj_jiaona WHERE user_id = '{$user_id}' 
	) T2
WHERE 1 = 1
	AND
		NOT		-- 加 not 未学习，不加 not 已学习
		EXISTS
		(SELECT DISTINCT T3.user_id, T3.dangfeiid FROM dj_jiaona T3
			WHERE T1.id = T3.dangfeiid
			AND T3.user_id = '{$user_id}' 
		)-- 是否进行学习情况筛选
	
AND (T1.id LIKE '%%' OR T1.name LIKE '%%')
AND (T1.date BETWEEN '1000-01-01 00:00:00' AND '9999-12-31 23:59:59')
GROUP BY T1.id
ORDER BY T1.id DESC
-- LIMIT 0,4
;";//筛选 user 已缴纳党费

$db->query($sql);
$list = $db->fetchAll();
echo "<pre style=\"color:#f00\">{$sql}</pre>";
foreach($list as &$row){
	echo "<p>{$row['id']}，{$row['name']}，{$row['price']}，{$row['date']}，{$row['mark']}
	，{$row['judge']}</p>";
}

//=============================================
//在线学习--SQL语句优化
$user_id = "ad0234829205b9033196ba818f7a872b";

$sql = "SELECT T1.*, SUM(IF(T1.id = T2.lessonid,1,0)) AS judge
		FROM dj_lesson T1,
		(
		SELECT DISTINCT user_id,lessonid FROM dj_study WHERE user_id = '{$user_id}' 
		) T2
		WHERE 1=1
	/*	AND
	--	NOT		-- 加 not 未学习，不加 not 已学习
		EXISTS
		(SELECT DISTINCT T3.user_id, T3.lessonid FROM dj_study T3
			WHERE T1.id = T3.lessonid
			AND T3.user_id = '{$user_id}'
		)-- 是否进行学习情况筛选
	*/	AND (T1.id LIKE '%%' OR T1.name LIKE '%%' OR T1.detail LIKE '%%')
		AND (T1.created_at BETWEEN '1000-01-01 00:00:00' AND '9999-12-31 23:59:59')
		GROUP BY T1.id
		ORDER BY T1.id DESC
	--	LIMIT 0,4;

";

echo "<pre style=\"color:#f00\">{$sql}</pre>";
$db->query($sql);
$list = $db->fetchAll();
foreach($list as &$row){
	echo "<p>{$row['id']}，{$row['name']}，{$row['detail']}，{$row['created_at']}，{$row['mark']}
	，{$row['judge']}</p>";
}
//======================================
//党费管理--SQL语句优化--得不偿失
$sql1 ="SELECT * 
          FROM dj_dangfei 
         WHERE 1=1 
      --   AND (id LIKE '%%' OR name LIKE '%%' OR price LIKE '%%' OR mark LIKE '%%') 
           AND (date BETWEEN '2006-12-31 00:00:00' AND '2017-12-31 23:59:59') 
         ORDER BY id ASC 
";//限定列数
echo "<pre style=\"color:#f00\">{$sql1}</pre>";
$db->query($sql1);
$list1 = $db->fetchAll();

$sql2 ="SELECT T1.username\n,T1.name\n";
$i = 0;
foreach($list1 as &$row){
	echo "<p>{$row['name']}，{$row['date']}</p>";
	$i++;
//	$sql2 .= " ,'{$row['name']}' AS thead{$i}";
//	$sql2 .= ",SUM(if({$row['id']} = T3.dangfeiid, 1 ,0)) AS thead{$i}";
	$sql2 .= ",SUM(if(({$row['id']} = T3.dangfeiid)&(T1.user_id = T3.user_id), 1 ,0)) AS thead{$i}\n";
	
}



$sql2 .=" FROM dj_users T1, 
            -- dj_dangfei T2, 
               (SELECT DISTINCT * FROM dj_jiaona) T3 
         WHERE 1=1 
           AND (T1.username LIKE '%%' OR T1.name LIKE '%%')
         GROUP BY T1.id 
         ORDER BY T1.id ASC 
";
echo "<pre style=\"color:#f00\">{$sql2}</pre>";
$db->query($sql2);
$list2 = $db->fetchAll();
foreach($list2 as &$row){
	echo "<p>{$row['username']}，{$row['name']}";
	for($j = 1;$j <= $i;$j++){
		echo "，".$row["thead{$j}"];
	}
	echo "</p>\n";
}
//临时测试
//======================================
$sql = "SELECT T1.*, SUM(IF((T1.id = T2.lessonid)&(user_id = 'ad0234829205b9033196ba818f7a872b'), 1, 0)) AS judge
 FROM dj_lesson T1,
 (SELECT DISTINCT user_id, lessonid
		FROM dj_study )T2
	--	WHERE user_id = '21232f297a57a5a743894a0e4a801fc3') T2 
		-- ad0234829205b9033196ba818f7a872b
 WHERE 1 = 1
 AND (T1.id LIKE '%%' OR T1.name LIKE '%%' OR T1.detail LIKE '%%') 
 AND (created_at BETWEEN '1000-01-01 00:00:00' AND '9999-12-31 23:59:59')
 GROUP BY T1.id 
 ORDER BY T1.id DESC 
 LIMIT 0,4;";

echo "<pre style=\"color:#f00\">{$sql}</pre>";
$db->query($sql);
$list = $db->fetchAll();
foreach($list as &$row){
	echo "<p>{$row['id']}，{$row['judge']}";
	echo "</p>\n";
}

?>
<?php
	include('foot.php');
?>