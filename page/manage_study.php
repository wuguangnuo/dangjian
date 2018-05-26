<?php
	include("head.php");
	include("manageNav.php");
?>

<script>
$("#manage_study").addClass("active");

$(function(){
	$("#myModal,#myModal_lesson").on("show.bs.modal",function(){
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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;管理中心 -> 课程管理
	</div>
	<div class="panel-body">
<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal_lesson">添加课程</button>
</div>
<hr />
	
<!-- Modal -->
<div class="modal fade" id="myModal_lesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="manage_study_form" class="form-horizontal" method="post" action="?action=manage&do=add_lesson" role="form" enctype="multipart/form-data">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加课程</h3>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">课程名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="name" id="name" placeholder="请输入课程名称">
			</div>
		</div>
		<div class="form-group">
			<label for="extension" class="col-sm-2 control-label">课程类型</label>
			<div class="col-sm-8">
				<select class="form-control" name="extension" id="extension">
					<option value="专题课程">专题课程</option>
					<option value="红色影院">红色影院</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="score" class="col-sm-2 control-label">课程学分</label>
			<div class="col-sm-8">
				<input type="number" class="form-control" name="score" id="score" placeholder="请输入课程学分">
			</div>
		</div>
		<div class="form-group">
			<label for="detail" class="col-sm-2 control-label">详情</label>
			<div class="col-sm-8">
				<textarea class="form-control" name="detail" id="detail" rows="4"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">课程文件</label>
			<div class="col-sm-8">
				<input id="new_name" type="text" style="display:none" name="link" />
				<button id="fcup"></button>
				<script>
				$.fcup({
					updom: '#fcup',//上传控件的位置dom
					//upid: 'upid',//上传的文件表单id，有默认
					shardsize : '2',//切片大小,(单次上传最大值)单位M，默认2M
					upstr: '上传文件',//按钮文字
					uploading: '上传中...',//上传中的提示文字
					upfinished: '上传完成',//上传完成后的提示文字
					upurl: 'lib/upload.class.php',//文件上传接口
					uptype: 'jpg,png,gif,jpeg,txt,pdf,doc,docx,ppt,pptx,mp4,avi,rmvb',//上传类型检测,用,号分割
					errtype: '不支持此类型文件',//不支持类型的提示文字
					//接口返回结果回调
					upcallback : function(result){
						 $("#new_name").val(result);
					}
				});
				</script>
			</div>
		</div>
		<div class="form-group">
			<label for="mark" class="col-sm-2 control-label">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" name="mark" id="mark" rows="4"></textarea>
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

<form class="form-inline" action="?action=manage&do=manage_study" method="post" role="form">
	<div class="form-group">
		<label for="key">筛选课程</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入课程名称" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<label for="date1">时间区间</label>
		<input type="text" name="date1" class="form-control input-sm selectData" value="<?php
			$temp = empty($_GET['date1']) ? $_POST['date1'] : $_GET['date1'];
			echo ($temp == "1000-01-01") ? "" : $temp;
		?>" />
	</div>
	<div class="form-group">
		<label for="date2">至</label>
		<input type="text" name="date2" class="form-control input-sm selectData" value="<?php
			$temp = empty($_GET['date2']) ? $_POST['date2'] : $_GET['date2'];
			echo ($temp == "9999-12-31") ? "" : $temp;//默认值不显示
		?>" />&nbsp;&nbsp;&nbsp;
	</div>
	
	<div class="form-group">
		<label for="user">筛选用户</label>
		<input type="text" name="user" class="form-control input-sm" value="<?php echo empty($_GET['user']) ? $_POST['user'] : $_GET['user']; ?>" placeholder="请输入学号或姓名" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-success" id="search">查询</button>
		<button type="reset" class="btn btn-sm btn-warning" id="search">清空条件</button>
	</div>
</form>
<!--时间区间 全留空 则默认筛选近一月-->
<hr />

	<p class="ttitle">学生上课情况</p>
	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover">
			<thead>
			<tr>
				<th>登录名</th>
				<th>用户名</th>
				<?php
				//foreach(array_reverse($list_d) as $row){//反向输出(注:此处不能用&$)
				foreach($list_d as &$row){
					echo "<th><lable style=\"display:none\">{$row['id']}</lable>
					<a onclick=\"modalShow(this)\" data-toggle=\"modal\">".cut_str($row['name'], 10)."</a></th>";
				}
				?>
			</tr>
			</thead>
			
			<tbody>
			<?php
			if(empty($list_u))echo "<h4 style='color:red'>列表为空</h4>";
			else{
				foreach($list_u as &$row){
				echo "<tr>";
				echo "<td>" . $row['username'] ."</td>";
				echo "<td>" . $row['name'] ."</td>";
				for($j = 1;$j<=$total_d;$j++){
					echo "<td>";
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT id,date FROM dj_study WHERE user_id = '{$row['user_id']}' AND lessonid = '{$list_d[$j-1]['id']}' LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "<a title='课程记录编号：".$db->getValue("id")."'
								data-container='body' data-toggle='popover' data-placement='right' data-trigger='hover'
								data-content='完成时间:：".$db->getValue("date")."'>
							已完成</a>";
					else
						echo "未完成";
					echo "</td>";
				}
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
				<li><a href="lib/excelDL.class.php?type=managestudyXls<?php echo "&username=" . $_SESSION['username'] . "&sql_d=" . $sql_d . "&sql_u=" . $sqlExcel_u; ?>">生成xls格式文件</a></li>
				<li><a href="lib/excelDL.class.php?type=managestudyCsv<?php echo "&username=" . $_SESSION['username'] . "&sql_d=" . $sql_d . "&sql_u=" . $sqlExcel_u; ?>">生成csv格式文件</a></li>
			</ul>
		</div>
		
<script>
function modalShow(obj){
	var tds= $(obj).parent().find("lable");
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
			$("#detail_created_at").val(data.created_at);
			$("#detail_mark").val(data.mark);
		},
		error: function(){
			//失败，请稍后重试
			swal("错误", "请求失败，请稍后重试！","error");
		}
	});
	
	$("#myModal_detail").modal("show");
}
</script>

<!-- Modal -->
<div class="modal fade" id="myModal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	</form>
	</div>
	<div class="modal-footer">
		<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">返&nbsp;回</button>
		<button onclick="del(this)" class="btn btn-sm btn-danger">删&nbsp;除</button>
	</div>
</div>
</div>
</div>
<script>
//删除课程
function del(obj){
	
	swal({ 
		title: "确定删除吗？", 
		text: "确定要删除课程 " + $("#detail_name").val() + " 吗？\n此操作不可逆！", 
		type: "warning",
		showCancelButton: true, 
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确定删除", 
		closeOnConfirm: false
	},
	function(){
		var lessonid = $("#detail_id").val();
		$.ajax({
			url:"?action=manage&do=del_lesson",
			data:{
				lessonid:lessonid
				},
			type:"POST",
			dataType: "TEXT",
			success: function(data){
					swal("删除！", "课程 " + $("#detail_name").val()  + " 删除成功！", "success"); 
					setTimeout(function(){
						window.history.back();
					},1500);
				}
		});
	});
}
</script>

</div>
</div>
</div>
</div>
<?php
	include("foot.php");
?>
