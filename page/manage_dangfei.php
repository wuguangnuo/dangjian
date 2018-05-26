<?php
	include("head.php");
	include("manageNav.php");
?>

<script>
$("#manage_dangfei").addClass("active");

$(function(){
	$("#myModal_dangfei,#myModal_detail,#myModal_jiaona,#Modal_jiaona_detail").on("show.bs.modal",function(){
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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;管理中心 -> 党费管理
	</div>
	<div class="panel-body">
<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal_dangfei">添加党费</button>
</div>
<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal_jiaona">添加缴纳</button>
</div>
<hr />
	
<!-- Modal -->
<div class="modal fade" id="myModal_dangfei" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="manage_dangfei_form" class="form-horizontal" method="post" action="?action=manage&do=add_dangfei" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加党费</h3>
	</div>
	<div class="modal-body">
	
		<div class="form-group">
			<label class="col-sm-2 control-label" for="name">党费名称</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="name" placeholder="请输入党费名称" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mark">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" name="mark" rows="4"></textarea>
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

<!-- Modal -->
<div class="modal fade" id="myModal_jiaona" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="manage_dangfei_form1" class="form-horizontal" method="post" action="?action=manage&do=add_jiaona" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加缴纳</h3>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="user_id">用户信息</label>
			<div class="col-sm-8">
				<select class="form-control" name="user_id" id="userSelect">
				<?php
				foreach($list_user as &$row){
					echo "<option value = \"{$row['user_id']}\">{$row['name']}&nbsp;&nbsp;/&nbsp;&nbsp;{$row['username']}</option>";
				}
				?>
				</select>
			</div>
		</div>
		<script>
		$(function() {
			//$("#manage_dangfei_form1 input[name='price']").val($("#userSelect label").text());
			$("#userSelect").click(function(){
				//发送($("#userSelect").val());
				//接收$("#manage_dangfei_form1 input[name='price']").val();
				$.ajax({
					url:"?action=manage&do=getUserPrice",
					data: {
						user_id:$("#userSelect").val()
						},
					type: "POST",
					dataType: "TEXT",	
					success: function(data){
						$("#manage_dangfei_form1 input[name='price']").val(data);
					},
					error: function(){
						//失败，请稍后重试
						swal("错误", "请求失败，请稍后重试！","error");
					}
				});
			});
		});
		</script>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="dangfeiid">党费</label>
			<div class="col-sm-8">
				<select class="form-control" name="dangfeiid">
				<?php
				foreach($list_dangfei as &$row){
					echo "<option value = \"{$row['id']}\">{$row['name']}</option>";
				}
				?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="price">应缴金额</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="price" placeholder="请先选择用户" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="real_price">实缴金额</label>
			<div class="col-sm-8">
				<input type="number" class="form-control" name="real_price" placeholder="请输入实缴金额" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="date">缴纳时间</label>
			<div class="col-sm-8">
				<input type="text" class="form-control selectData" name="date" value="<?php echo date("Y-m-d"); ?>" />
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

<form class="form-inline" action="?action=manage&do=manage_dangfei" method="post" role="form">
	<div class="form-group">
		<label for="key">筛选党费</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入党费名称" />&nbsp;&nbsp;&nbsp;
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
<!--时间区间 全留空 则默认筛选近一年-->
<hr />

	<p class="ttitle">党费缴纳情况</p>
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
					<a onclick=\"modalShow(this)\" data-toggle=\"modal\">".cut_str($row['name'], 25)."</a></th>";
				}
				?>
			</tr>
			</thead>
			
			<tbody>
			<?php
			if(empty($list_u))echo "<h4 style='color:red'>列表为空!</h4>";
			else{
				foreach($list_u as &$row){
				echo "<tr>";
				echo "<td>" . $row['username'] ."</td>";
				echo "<td>" . $row['name'] ."</td>";
				for($j = 1;$j<=$total_d;$j++){
					echo "<td>";
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT * FROM dj_jiaona WHERE user_id = '{$row['user_id']}' AND dangfeiid = '{$list_d[$j-1]['id']}' ORDER BY id DESC LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "<a title='党费缴纳编号：".$db->getValue("id")."'
							data-container='body' data-toggle='popover' data-placement='right' data-trigger='hover' data-html='true'
							data-content='应缴纳金额：￥".$db->getValue("price")."<br />
										  实缴纳金额：￥".$db->getValue("real_price")."<br />
										  缴纳时间：".substr($db->getValue("date"),0,10)."'>
						已缴纳</a>";
					else
						echo "未缴纳";
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
				<li><a href="lib/excelDL.class.php?type=dangfeiXls<?php echo "&username=" . $_SESSION['username'] . "&sql_d=" . $sql_d . "&sql_u=" . $sqlExcel_u; ?>">生成xls格式文件</a></li>
				<li><a href="lib/excelDL.class.php?type=dangfeiCsv<?php echo "&username=" . $_SESSION['username'] . "&sql_d=" . $sql_d . "&sql_u=" . $sqlExcel_u; ?>">生成csv格式文件</a></li>
			</ul>
		</div>
		
<script>
function modalShow(obj){
	var tds= $(obj).parent().find("lable");

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
//删除党费
function del(obj){
	swal({ 
		title: "确定删除吗？", 
		text: "确定要删除党费 " + $("#name").val() + " 吗？\n此操作不可逆！", 
		type: "warning",
		showCancelButton: true, 
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确定删除", 
		closeOnConfirm: false
	},
	function(){
		var id = $("#id").val();
		$.ajax({
			url:"?action=manage&do=del_dangfei",
			data:{
				id:id
				},
			type:"POST",
			dataType: "TEXT",
			success: function(data){
					swal("删除！", "党费 " + $("#name").val()  + " 删除成功！", "success"); 
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