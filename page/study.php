<?php
	include('head.php');
?>

<script>
$("#navbar_study").addClass("active");

$(function(){
	$("#myModal").on("show.bs.modal",function(){
		var $this = $(this);
		var $modal_dialog = $this.find(".modal-dialog");
		$this.css("display","block");
		$modal_dialog.css({"margin-top":Math.max(0,($(window).height()-$modal_dialog.height())/2)});
	});
});

</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;在线学习
	</div>
	<div class="panel-body">

<?php if($_SESSION['roleid'] == "1"): ?>

<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">添加课程</button>
</div>
<hr />
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog role="document">
<div class="modal-content">
<form class="form-horizontal" method="post" action="?action=study&do=add_lesson" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加课程</h3>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">课程名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="name" placeholder="请输入课程名称">
			</div>
		</div>
		<div class="form-group">
			<label for="detail" class="col-sm-2 control-label">详情</label>
			<div class="col-sm-8">
				<textarea class="form-control" name="detail" rows="4"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="mark" class="col-sm-2 control-label">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" name="mark" rows="4"></textarea>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">关闭</button>
		<button type="submit" class="btn btn-sm btn-primary">提交</button>
	</div>
</form>
</div>
</div>
</div>

<?php endif; ?>

<form class="form-inline" action="?action=study" method="post" role="form">
	<div class="form-group">
		<label for="key">查询</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入课程ID或课程名" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<label for="date1">时间区间</label>
		<input type="date" name="date1" class="form-control input-sm" value="<?php
			$temp = empty($_GET['date1']) ? $_POST['date1'] : $_GET['date1'];
			echo ($temp == "1000-01-01") ? "" : $temp;//默认值不显示
		?>" />
	</div>
	<div class="form-group">
		<label for="date2">至</label>
		<input type="date" name="date2" class="form-control input-sm" value="<?php
			$temp = empty($_GET['date2']) ? $_POST['date2'] : $_GET['date2'];
			echo ($temp == "9999-12-31") ? "" : $temp;//默认值不显示
		?>" />
	</div>
	<div class="form-group">
		<select class="form-control input-sm" name="check">
			<option value="all" <?php
				echo $_POST['check'] == "all" ? "selected" : ($_GET['check'] == "all" ? "selected" : "");
			?>>显示全部</option>
			<option value="yes" <?php
				echo $_POST['check'] == "yes" ? "selected" : ($_GET['check'] == "yes" ? "selected" : "");
			?>>查询已学</option>
			<option value="not" <?php
				echo $_POST['check'] == "not" ? "selected" : ($_GET['check'] == "not" ? "selected" : "");
			?>>查询未学</option>
		</select>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-success" id="search">查询</button>
		<button type="reset" class="btn btn-sm btn-warning" id="cls">清空条件</button>
	</div>
</form>

<?php echo "<p class='sqlinfo'>SQL：{$sql}</p>"; ?>
<hr />
	<p class="ttitle">课程情况</p>

	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>课程编号</th>
					<th>课程名称</th>
					<!--th>详情</th-->
					<th>创建时间</th>
					<?php if($_SESSION['roleid'] == "1"): ?>
					<th>备注</th>
					<?php endif; ?>
					<th>听课情况</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php
			if(empty($list))echo "列表为空!";
			else{
				foreach($list as &$row){
				echo "<tr>";
				echo "<td>" . $row['id'] ."</td>";
				echo "<td>" . $row['name'] ."</td>";
				echo "<!--td>" . checkEmpty($row['detail']) ."</td-->";
				echo "<td>" . $row['created_at'] ."</td>";
				if($_SESSION['roleid'] == "1")
					echo "<td>" . checkEmpty($row['mark']) ."</td>";
				echo "<td>";
				if($row['judge'] == "0")
					echo "未完成</td><td><button onclick=\"add_study(this)\" class=\"btn btn-xs btn-primary\">进入课程</button>";
				else
					echo "已完成!!!</td><td><button onclick=\"again_study(this)\" class=\"btn btn-xs btn-primary\">再次学习</button>";
				if($_SESSION['roleid'] == "1")
					echo "&nbsp;<button onclick=\"del_lesson(this)\" class=\"btn btn-xs btn-danger\">删除课程</button>";
				echo "</td></tr>\n";
				}
			}
			?>
			</tbody>
		</table>
	</div>
		<div class="showPage">
		<?php
		if($total > $showrow){//总记录数大于每页显示数，显示分页
			$page = new page($total, $showrow, $curpage, $url, 2);
			echo $page->myde_write();
		}
		?>
		</div>

</div>
</div>
</div>
</div>
<script>
//进入课程
function add_study(obj){
	var tds = $(obj).parent().parent().find("td");
	console.log("ADD with: lessonid=" + tds.eq(0).text());
	var lessonid = tds.eq(0).text();
	var user_id = "<?php echo $_SESSION['user_id']; ?>";
	$.ajax({
		url:"?action=study&do=add_study",
		data:{
			lessonid:lessonid,
			user_id:user_id
			},
		type:"POST",
		dataType:"TEXT",
		success: function(data){
				alert("开始学习课程\nlessonid = " + lessonid + "\nuser_id = " + user_id);
				window.location.reload();
			}
	});
}

//再次学习
function again_study(obj){
	var tds = $(obj).parent().parent().find("td");
	console.log("AGAIN with: lessonid=" + tds.eq(0).text());
	var lessonid = tds.eq(0).text();
	alert("再次学习课程\nlessonid = " + lessonid + "\nuser_id = <?php echo $_SESSION['user_id']; ?>");
}

//删除课程
function del_lesson(obj){
	var tds = $(obj).parent().parent().find("td");
	console.log("DEL with: lessonid=" + tds.eq(0).text());
	if(confirm("确定要删除课程 " + tds.eq(1).text() + " 吗？\n此操作不可逆！")){
		window.location.href="?action=study&do=del_lesson&lessonid=" + tds.eq(0).text();
		return true;
	}else{
		return false;
	}
}
</script>

<?php
	include('foot.php');
?>