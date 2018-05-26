<?php
	include("head.php");
	include('dangwuNav.php');
?>

<script>
$("#dangwu_election").addClass("active");

$(function(){
	$("#myModal_election").on("show.bs.modal",function(){
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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;党务工作 -> 民主评议
	</div>
	<div class="panel-body">

<?php if($_SESSION['roleid'] == "1"): ?>

<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal_election">开启新一期评议</button>
</div>
	
<!-- Modal -->
<div class="modal fade" id="myModal_election" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="dangwu_election_form" class="form-horizontal" method="post" action="?action=dangwu&do=add_election" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加民主评议</h3>
	</div>
	<div class="modal-body">
	
		<div class="form-group">
			<label class="col-sm-2 control-label" for="name">评议名称</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="name" name="name" placeholder="请输入互评名称" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="start_date">开始时间</label>
			<div class="col-sm-8">
				<input type="text" class="form-control selectData" id="start_date" name="start_date" value="<?php echo date("Y-m-d"); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="end_date">截止时间</label>
			<div class="col-sm-8">
				<input type="text" class="form-control selectData" id="end_date" name="end_date" value="<?php echo date("Y-m-d"); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="vote_num">每人票数</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="vote_num" name="vote_num" value="3" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mark">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" id="mark" name="mark" rows="4"></textarea>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">返&nbsp;回</button>
		<button type="submit" class="btn btn-sm btn-primary">提&nbsp;交</button>
	</div>
</form>
</div>
</div>
</div>

<hr />

<?php endif; ?>

<p class="ttitle">往期评议：</p>
	<?php
		echo "<ul class='nav nav-pills'>";
		foreach($list_election as &$row){
			echo "<li><a onclick=\"modalElection({$row['id']})\" id=\"election_{$row['id']}\" type=\"button\" class=\"btn btn-default\" title=\"".substr($row['start_date'],0,10)."至".substr($row['end_date'],0,10)."\">".$row['name']."</a></li>";
		}
		echo "</ul>";
	?>

<script>
var vote_limit = 3;//默认每人票数3

function modalElection(electionid){

	$("a[id^='election_']").attr("class","btn btn-default");//所有按钮样式重置
	$("#election_" + electionid).attr("class","btn btn-primary active");//样式改变

	var username = "<?php echo $_SESSION['username']; ?>";

	//评议详情
	$.ajax({
		url: "?action=dangwu&do=dangwu_election_detail",
		data: {
			election_id:electionid,
			username:username,
			count_u:<?php echo $count_u; ?>
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
			$("#election_detail").html(data.election_detail);	//评议详情
			$("#election_content").html(data.election_content);	//评议情况
			$("#submitAll").attr("class",data.election_ok);		//是否可提交
			<?php if ($_SESSION['roleid'] == "1"): ?>
			$("#election_statis").html(data.election_statis);	//信息统计
			<?php endif; ?>
			vote_limit = data.election_limit;	//每人票数
			$("#election_excelDL li:eq(0) a").attr("href", data.excelDLXls);//表格导出
			$("#election_excelDL li:eq(1) a").attr("href", data.excelDLCsv);//表格导出
		},
		error: function(){
			//失败，请稍后重试
			swal("错误", "请求失败，请稍后重试！","error");
		}
	});
}

</script>
<hr />
<p class="ttitle">评议详情：</p><div id="election_detail"></div>
<?php if ($_SESSION['roleid'] == "1"): ?>
<hr />
<p class="ttitle">评议统计：</p>
	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>姓名</th>
				<th>推举人数</th>
				<th>参与人数</th>
			</tr>
			</thead>
			
			<tbody id="election_statis">
			
			</tbody>
		</table>
	</div>
	<div class="btn-group">
		<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">导出此表<span class="caret"></span></button>
		<ul id="election_excelDL" class="dropdown-menu" role="menu">
			<li><a href="">生成xls格式文件</a></li>
			<li><a href="">生成csv格式文件</a></li>
		</ul>
	</div>
<?php endif; ?>
<hr />
<script>
function del_election(election_id){
	swal({ 
		title: "确定删除吗？", 
		text: "确定要删除评议 id=" + election_id + " 吗？\n此操作不可逆！", 
		type: "warning",
		showCancelButton: true, 
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确定删除", 
		closeOnConfirm: false
	},
	function(){
		$.ajax({
			url: "?action=dangwu&do=del_election",
			data: {
				election_id:election_id
				},
			type: "POST",
			dataType: "TEXT",
			success: function(data){
					swal("删除！", "评议 " + election_id + " 删除成功！", "success"); 
					setTimeout(function(){
						window.history.back();
					},1500);
				}
		});
	});
}
</script>
	<p class="ttitle">评价情况</p>
	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>评议人</th>
				<th>被评人</th>
				<th>投票</th>
				<th>投票时间</th>
			</tr>
			</thead>
			
			<tbody id="election_content">
			
			</tbody>
		</table>
	</div>
	
<div id="submitBtn">
	<a id="submitAll" type="button" class="btn btn-sm btn-primary pull-right disabled">提交评价</a>
</div>

<script>
$("#submitAll").click(function(){
	var count_u = <?php echo $count_u; ?>;
	var limit = vote_limit;
	
	for(var i=count_u;i>0;i--){
		//不是票数则禁止提交
		if($("#line_"+i+" input[type = 'checkbox']").is(":checked"))
			limit--;
	}
	if(limit == 0){
		for(;count_u>0;count_u--){
			if($("#line_"+count_u+" input[type = 'checkbox']").is(":checked")){
				$.ajax({
					url: "?action=dangwu&do=add_vote",
					data: {
						election_id:$("#line_"+count_u+" td[name = 'election_id']").html(),
						username:$("#line_"+count_u+" td[name = 'username']").html(),
						target:$("#line_"+count_u+" td[name = 'target']").html()
						},
					type: "POST",
					dataType: "TEXT",
					success: function(){}
				});
			}
		}
		swal('操作成功！','民主评议提交成功！','success');
	}
	else
		swal('提示！','每人只能投 ' + vote_limit + ' 票！','info');
});
</script>

</div>
</div>
</div>
</div>
<?php
	include("foot.php");
?>