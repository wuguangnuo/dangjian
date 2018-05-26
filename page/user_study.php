<?php
	include('head.php');
	include('userNav.php');
?>

<script>
$("#user_study").addClass("active");

$(function(){
	$("#myModal,#Modal_detail").on("show.bs.modal",function(){
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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;个人中心 -> 学习情况
	</div>
	<div class="panel-body">

<form class="form-inline" action="?action=user&do=user_study" method="post" role="form">
	<div class="form-group">
		<label for="key">查询</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入课程ID或课程名" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<label for="date1">时间区间</label>
		<input type="text" name="date1" class="form-control input-sm selectData" value="<?php
			$temp = empty($_GET['date1']) ? $_POST['date1'] : $_GET['date1'];
			echo ($temp == "1000-01-01") ? "" : $temp;//默认值不显示
		?>" />
	</div>
	<div class="form-group">
		<label for="date2">至</label>
		<input type="text" name="date2" class="form-control input-sm selectData" value="<?php
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

<hr />
	<p class="ttitle">课程情况</p>

	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>课程名称</th>
					<th>课程类型</th>
					<th>课程学分</th>
					<th>创建时间</th>
					<th>听课情况</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			<?php
			if(empty($list))echo "<h4 style='color:red'>列表为空!</h4>";
			else{
				foreach($list as &$row){
				echo "<tr>";
				echo "<td style=\"display:none;\">" . $row['id'] ."</td>";
				echo "<td>" . cut_str($row['name'], 20) ."</td>";
				echo "<td>" . checkEmpty($row['extension']) ."</td>";
				echo "<td>" . checkEmpty($row['score']) ."</td>";
				echo "<td>" . $row['created_at'] ."</td>";
				echo "<td>";
				if($row['judge'] == "0"){
					echo "未完成</td><td><button onclick=\"modalShow(this);\" role=\"button\" class=\"btn btn-xs btn-info\" data-toggle=\"modal\">查看详情</button>";
				}
				else{
					echo "已完成!!!</td><td><button onclick=\"modalShow(this);\" role=\"button\" class=\"btn btn-xs btn-info\" data-toggle=\"modal\">查看详情</button>";
				}
				echo "</td></tr>\n";
				}
				echo "<caption>总学分：" . $scoreA . "，已修学分：" . $scoreB . "</caption>";
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
		
		<div class="btn-group">
			<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">导出此表<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="lib/excelDL.class.php?type=user_studyXls<?php echo "&username=" . $_SESSION['username'] . "&sql=" . $sqlExcel; ?>">生成xls格式文件</a></li>
				<li><a href="lib/excelDL.class.php?type=user_studyCsv<?php echo "&username=" . $_SESSION['username'] . "&sql=" . $sqlExcel; ?>">生成csv格式文件</a></li>
			</ul>
		</div>
		
</div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="Modal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">课程详情</h3>
	</div>
	<div class="modal-body">
	<form class="form-horizontal" role="form">
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_id">课程编号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_id" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_name">课程名称</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_name" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_extension">课程类型</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_extension" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_score">课程学分</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_score" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_detail">课程详情</label>
			<div class="col-sm-8">
				<textarea class="form-control" id="detail_detail" rows="4" readonly="readonly" ></textarea>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_created_at">提交时间</label>
			<div class="col-sm-8">
				<input type="datetime" class="form-control" id="detail_created_at" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_mark">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" id="detail_mark" rows="4" readonly="readonly" ></textarea>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_done">听课情况</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_done" readonly="readonly" />
			</div>
		</div>
	</form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">返&nbsp;回</button>
	</div>
</div>
</div>
</div>

<script>

//查看详情
function modalShow(obj){
	var tds = $(obj).parent().parent().find("td");
	
	//根据 id 获取课程信息
	$.ajax({
		url: "?action=study&do=getLessonProfile",
		data: {
			id:tds.eq(0).text()
			},
		type: "POST",
		dataType: "JSON",
		beforeSend: function(){//AJAX发送前
			swal({
				title: "获取数据中...", 
				//text: "获取数据中...",
				imageUrl: "img/ajax-wait.gif"
			});
		},
		complete: function(){//请求完成，失败或成功
			swal.close();
		},
		success: function(data){
			$("#detail_id").val(data.id);
			$("#detail_name").val(data.name);
			$("#detail_extension").val(data.extension);
			$("#detail_score").val(data.score);
			$("#detail_detail").val(data.detail);
			$("#detail_link").val(data.link);
			$("#detail_created_at").val(data.created_at);
			$("#detail_mark").val(data.mark);
			$("#detail_done").val(tds.eq(5).text());
		},
		error: function(){
			//失败，请稍后重试
			swal("错误", "请求失败，请稍后重试！","error");
		}
	});
	
	$("#Modal_detail").modal("show");
}

</script>

<?php
	include('foot.php');
?>