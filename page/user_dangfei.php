<?php
	include('head.php');
	include('userNav.php');
?>

<script>
$("#user_dangfei").addClass("active");

$(function(){
	//模态框位置设置
	$("#Modal_detail").on("show.bs.modal",function(){
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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;个人中心 -> 党费情况
	</div>
	<div class="panel-body">

<form class="form-inline" action="?action=user&do=user_dangfei" method="post" role="form">
	<div class="form-group">
		<label for="key">查询</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php
			echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; 
		?>" placeholder="请输入党费名称" />&nbsp;&nbsp;&nbsp;
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
			?>>查询已缴</option>
			<option value="not" <?php
				echo $_POST['check'] == "not" ? "selected" : ($_GET['check'] == "not" ? "selected" : "");
			?>>查询未缴</option>
		</select>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-success" id="search">查询</button>
	</div>
</form>

	<hr />

	<p class="ttitle">党费情况</p>

	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover" id="table2">
			<thead>
				<tr>
					<th style="display:none">ID(隐藏此列)</th>
					<th>名称</th>
					<th>时间</th>
					<th>详情</th>
					<th>缴纳情况</th>
					<th>操作</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
			if(empty($list))echo "<h4 style='color:red'>列表为空!</h4>";
			else{
				foreach($list as &$row){
				echo "<tr>";
				echo "<td style='display:none'>" . $row['id'] ."</td>";
				echo "<td>" . $row['name'] ."</td>";
				echo "<td>" . $row['date'] ."</td>";
				echo "<td>" . cut_str($row['mark'], 20) ."</td>";
				echo "<td>";
				if($row['judge'] == 0)
					echo "未缴纳";
				else
					echo "已缴纳!!!";
				echo "</td><td><button onclick=\"modalShow(this);\" role=\"button\" class=\"btn btn-xs btn-info\" data-toggle=\"modal\">查看详情</button></td>";
				echo "</tr>\n";
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

	<div class="btn-group">
		<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">导出此表<span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu">
			<li><a href="lib/excelDL.class.php?type=user_dangfeiXls<?php echo "&username=" . $_SESSION['username'] . "&sql=" . $sqlExcel; ?>">生成xls格式文件</a></li>
			<li><a href="lib/excelDL.class.php?type=user_dangfeiCsv<?php echo "&username=" . $_SESSION['username'] . "&sql=" . $sqlExcel; ?>">生成csv格式文件</a></li>
		</ul>
	</div>
		
</div>
</div>
</div>
</div>

<script>
//查看详情
function modalShow(obj){
	var tds = $(obj).parent().parent().find("td");
	
	//根据 id 获取党费信息
	$.ajax({
		url: "?action=manage&do=getDangfeiProfile",
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
			$("#detail_date").val(data.date);
			$("#detail_mark").val(data.mark);
			$("#detail_done").val(tds.eq(4).text());
		},
		error: function(){
			//失败，请稍后重试
			swal("错误", "请求失败，请稍后重试！","error");
		}
	});

	//实际缴纳金额
	$.ajax({
		url:"?action=user&do=user_dangfei_detail",
		data:{
			dangfeiid:tds.eq(0).text()
			},
		type:"POST",
		dataType: "JSON",
		success: function(data){
			$("#detail_price").val(data.price);
			$("#detail_real_price").val(data.real_price);
		}
	});
	
	$("#Modal_detail").modal("show");
}
</script>

<!-- Modal -->
<div class="modal fade" id="Modal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">党费详情</h3>
	</div>
	<div class="modal-body">
	<form class="form-horizontal" role="form">
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_id">党费编号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_id" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_name">党费名称</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_name" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_price">应缴金额</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_price" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_real_price">实缴金额</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="detail_real_price" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_date">提交时间</label>
			<div class="col-sm-8">
				<input type="datetime" class="form-control" id="detail_date" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_mark">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" id="detail_mark" rows="4" readonly="readonly" ></textarea>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="detail_done">缴纳情况</label>
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

<?php
	include('foot.php');
?>