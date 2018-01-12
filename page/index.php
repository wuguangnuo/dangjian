<?php
	include('head.php');
?>

<script>
$("#navbar_index").addClass("active");
</script>

<style>
pre {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
<link rel="stylesheet" href="https://cdn.bootcss.com/highlight.js/9.12.0/styles/monokai-sublime.min.css">
<script src="https://cdn.bootcss.com/highlight.js/9.12.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-home" aria-hidden="true"></i>&nbsp;主&nbsp;页
		</div>
		<div class="panel-body">
			<b>简·介</b>
			<p>这是主界面</p>
			<p>在这里添加一些欢迎内容与图片。添加一些有关新闻，消息等</p>
			<hr />
			<b>消息</b>
			<p>计划添加功能：系统首页通知，以及相关的admin管理界面（可能会用到富文本编辑器）</p>
			<hr />
			<h1>党员管理系统首页...党员管理系统首页...党员管理系统首页...</h1>
			<h3>2017年12月10日1:15更新V1.3。</h3>
			<p>SQL语句面向对象，完善分页类,添加查询类，在线学习界面架子，部分逻辑、功能、界面优化</p>
			<p>用户界面美化，添加弹出模态框</p>
			<p>新添加方类/法：</p>
<pre><code>
//安全验证，转义防注入
function _RunMagicQuotes(&$svar)

//首页
private function myde_home()

//上一页
private function myde_prev()

//下一页
private function myde_next()

//尾页
private function myde_last()

//输出分页
public function myde_write($id = 'page')
		
//查询类
$key = empty($_POST['key']) ? "" : _RunMagicQuotes($_POST['key']);
$search .= " WHERE username LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%'";

//分页设定
$showrow = 4;//一页显示的行数
$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
$url = "?action=user&page={page}";//分页地址，如果有检索条件 ="?page={page}&q=".$_GET['q']

//分页 Pagination
if($total > $showrow) {//总记录数大于每页显示数，显示分页
	$page = new page($total, $showrow, $curpage, $url, 2);
	echo $page->myde_write();
}

</code></pre>
<hr />
			<h3>2017年12月23日18:55更新V1.4。</h3>
			<p>添加、完善多个功能，全局界面升级完成，所有需求基本实现。</p>
			<p>action.dangfei.php 系统action层代码片段：<p>
<pre><code>
if($do==""){
	if(!isLogin()){exit($lang_cn['rabc_is_login']);}//判断是否登录
	If_rabc($action,$do);//检测权限	
	is_admin($action,$do);

	//查询 thead 数据
	//查询类
	$key = empty($_POST['key']) ? (empty($_GET['key']) ? "" : _RunMagicQuotes($_GET['key'])) : _RunMagicQuotes($_POST['key']);
	$search .= " AND (id LIKE '%".strip_tags($key)."%' OR name LIKE '%".strip_tags($key)."%' OR price LIKE '%".strip_tags($key)."%' OR mark LIKE '%".strip_tags($key)."%')";

	//接收日期数据，首次使用_POST，以后使用_GET
	$date1 = empty($_GET['date1']) ? (empty($_POST['date1']) ? "1000-01-01" : _RunMagicQuotes($_POST['date1'])) : _RunMagicQuotes($_GET['date1']);
	$date2 = empty($_GET['date2']) ? (empty($_POST['date2']) ? "9999-12-31" : _RunMagicQuotes($_POST['date2'])) : _RunMagicQuotes($_GET['date2']);

	if(empty($_POST['date1']) && empty($_POST['date2']) && empty($_GET['date1']) && empty($_GET['date2'])){//不填写则默认获取近一年数据
		$date1 = date("Y-m-d",strtotime("-1 year"));
		$date2 = date("Y-m-d");
	}
	if($date1 > $date2){$date1=$date1^$date2;$date2=$date1^$date2;$date1=$date1^$date2;}//位运算交换数值
	$search .= " AND date BETWEEN '".strip_tags($date1)." 00:00:00' AND '".strip_tags($date2)." 23:59:59'";
	$sql_d = "SELECT * FROM dj_dangfei WHERE 1=1 {$search} ORDER BY id ASC";
	$db->query($sql_d);
	$total_d = $db->recordCount();
	$list_d = $db->fetchAll();

	//查询 tbody 数据
	//筛选用户
	$user = empty($_POST['user']) ? (empty($_GET['user']) ? "" : _RunMagicQuotes($_GET['user'])) : _RunMagicQuotes($_POST['user']);
	$shaixuan .= " AND (username LIKE '%".strip_tags($user)."%' OR name LIKE '%".strip_tags($user)."%')";

	//分页设定
	$showrow = 4;//一页显示的行数 (如需开放用户调整权限则更改此处)
	$curpage = empty($_GET['page']) ? 1 : $_GET['page'];//当前的页,还应该处理非数字的情况
	$url = "?action=dangfei&page={page}&key={$key}&date1={$date1}&date2={$date2}&user={$user}";//分页地址，检索key、date1、date2、user
	$sql_u = "SELECT user_id,username,name FROM dj_users WHERE 1=1 {$shaixuan} ORDER BY id ASC";
	$db->query($sql_u);
	$total = $db->recordCount();
	if(!empty($_GET['page']) && $total != 0 && $curpage > ceil($total / $showrow))$curpage = ceil($total_rows / $showrow);//当前页数大于最后页数，取最后一页
	$sql_u .= " LIMIT ".($curpage - 1) * $showrow .",{$showrow};";//添加限制
	$db->query($sql_u);
	$total_u = $db->recordCount();
	$list_u = $db->fetchAll();

	include('page/dangfei.php');
	exit;
}
</code></pre>
<p>下一步任务：处理部分新需求，强化交互部分限制以及相关提示，整理、合并代码，增加管理员集合统计/筛选功能，表格下载功能，邮件通知功能，日志记录log表</p>
<h3>2018年1月1日 V1.5 低调发布</h3>
<p>重要更新：所有SQL查询语句<strong>重大升级！</strong></p>
<p>新增删除确认框，改为使用 ajax post 提交</p>
<p>action层统一格式，美化代码，部分代码逻辑优化，变量规范命名</p>
<p>2018-1-6 13:04 FTP提交，线上版本V1.5已更新至SVN版本8</p>
<p>2018-1-9 10:40 FTP提交，线上版本V1.5已更新至SVN版本14。锁定版本库直到2018-1-19</p>
<pre><code>-- 示例：在线学习查询SQL语句
SELECT T1.id, T1.name, T1.created_at, T1.mark, SUM(IF(T1.id = T2.lessonid, 1, 0)) AS judge
  FROM dj_lesson T1,
       (SELECT DISTINCT user_id, lessonid
          FROM dj_study
         WHERE user_id = '21232f297a57a5a743894a0e4a801fc3') T2
 WHERE 1 = 1
   AND EXISTS
       (SELECT DISTINCT T3.user_id, T3.lessonid
          FROM dj_study T3
         WHERE T3.user_id = '21232f297a57a5a743894a0e4a801fc3'
           AND T1.id = T3.lessonid)
   AND (T1.id LIKE '%te%' OR T1.name LIKE '%te%' OR T1.detail LIKE '%te%')
   AND (created_at BETWEEN '2017-12-12 00:00:00' AND '2018-01-01 23:59:59')
 GROUP BY T1.id
 ORDER BY T1.id DESC
 LIMIT 0, 4;</code></pre>
		</div>
	</div>
	</div>
</div>

<?php
	include('foot.php');
?>