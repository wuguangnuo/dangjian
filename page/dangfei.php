<?php
	include("head.php");
?>

<script>
$("#navbar_dangfei").addClass("active");

$(function(){
	$("#myModal_dangfei,#myModal_jiaona,#myModal_detail").on("show.bs.modal",function(){
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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;党费管理
	</div>
	<div class="panel-body">

(开发计划：将所有 form表单 改为 AJAX 异步传输改善刷新)<br />
(开发计划：批量添加缴纳；删除党费；删除缴纳；)<br />
(细节优化：后端实现，jiaona 表冲突提示)<br />
操作按钮:
<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal_dangfei">添加党费</button>
</div>
<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal_jiaona">添加缴纳</button>
</div>
<hr />
	
<!-- Modal -->
<div class="modal fade" id="myModal_dangfei" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog role="document">
<div class="modal-content">
<form class="form-horizontal" method="post" action="?action=dangfei&do=add_dangfei" role="form">
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
			<label class="col-sm-2 control-label" for="price">金额</label>
			<div class="col-sm-8">
				<input type="number" step="0.01" class="form-control" name="price" placeholder="请输入应缴金额" />
			</div>
		</div>
		<!--div class="form-group" style="display:none;">
			<label class="col-sm-2 control-label" for="">发布时间(暂限制为不可更改)</label>
			<div class="col-sm-8">
				<input type="datetime-local" class="form-control" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>" disabled />
			</div>
		</div-->
		<!--div class="form-group">
			<label class="col-sm-2 control-label" for="">截止时间(该功能未确认，数据库目前无此字段)</label>
			<div class="col-sm-8">
				<input type="date" class="form-control" name="" disabled />
			</div>
		</div-->
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
<div class="modal-dialog role="document">
<div class="modal-content">
<form class="form-horizontal" method="post" action="?action=dangfei&do=add_jiaona" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加缴纳</h3>
	</div>
	<div class="modal-body">
<script>
//select 适配Android浏览器
$(function () {
	var nua = navigator.userAgent
	var isAndroid = (nua.indexOf("Mozilla/5.0") > -1 && nua.indexOf("Android ") > -1 && nua.indexOf("AppleWebKit") > -1 && nua.indexOf("Chrome") === -1)
	if (isAndroid) {
		$("select.form-control").removeClass("form-control").css("width", "100%")
	}
})
</script>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="user_id">用户</label>
			<div class="col-sm-8">
				<select class="form-control" name="user_id">
				<?php
				foreach($list_user as &$row){
					echo "<option value = \"{$row['user_id']}\">{$row['name']}&nbsp;&nbsp;/&nbsp;&nbsp;{$row['username']}</option>";
				}
				?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="dangfeiid">党费</label>
			<div class="col-sm-8">
				<select class="form-control" name="dangfeiid">
				<?php
				foreach($list_dangfei as &$row){
					echo "<option value = \"{$row['id']}\">{$row['name']}&nbsp;&nbsp;/&nbsp;&nbsp;￥{$row['price']}</option>";
				}
				?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-2 control-label" for="date">缴纳时间</label>
			<div class="col-sm-8">
				<input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d"); ?>" />
			</div>
		</div>
		<!--div class="form-group">
			<label class="col-sm-2 control-label" for="">处理时间(功能未确认，数据库无字段)</label>
			<div class="col-sm-8">
				<input type="date" class="form-control" name="" disabled />
			</div>
		</div-->
		<!--div class="form-group">
			<label class="col-sm-2 control-label" for="mark">备注(功能未确认，数据库无字段)</label>
			<div class="col-sm-8">
				<textarea rows="3" cols="20" name="" disabled></textarea>
			</div>
		</div-->
	</div>
	<div class="modal-footer">
		<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">返&nbsp;回</button>
		<button type="submit" class="btn btn-sm btn-primary">提&nbsp;交</button>
	</div>
</form>
</div>
</div>
</div>

<form class="form-inline" action="?action=dangfei" method="post" role="form">
	<div class="form-group">
		<label for="key">筛选党费</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入党费名称" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<label for="date1">时间区间</label>
		<input type="date" name="date1" class="form-control input-sm" value="<?php
			$temp = empty($_GET['date1']) ? $_POST['date1'] : $_GET['date1'];
			echo ($temp == "1000-01-01") ? "" : $temp;
		?>" />
	</div>
	<div class="form-group">
		<label for="date2">至</label>
		<input type="date" name="date2" class="form-control input-sm" value="<?php
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
时间区间 全留空 则默认筛选近一年
		<?php echo "<p class=\"sqlinfo\">THEAD SQL：{$sql_d}<br />TBODY SQL：{$sql_u}</p>"; ?>


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
					echo "<th><div style=\"display:none\">
					<lable>{$row['id']}</lable><lable>{$row['name']}</lable><lable>{$row['price']}</lable><lable>{$row['date']}</lable><lable>{$row['mark']}</lable>
					</div><a onclick=\"modalShow(this)\" data-toggle=\"modal\">".$row['name']."&nbsp;/&nbsp;".substr($row['date'],0,10)."</a></th>";
				}
				?>
			</tr>
			</thead>
			
			<tbody>
			<?php
			if(empty($list_u))echo "列表为空!";
			else{
				foreach($list_u as &$row){
				echo "<tr>";
				echo "<td>" . $row['username'] ."</td>";
				echo "<td>" . $row['name'] ."</td>";
				for($j = 1;$j<=$total_d;$j++){
					echo "<td>";
				//	echo "横".($row['username'])."，纵".$list_d[$j-1]['name'];//定位
					$sql_j="SELECT id,date FROM dj_jiaona WHERE user_id = '{$row['user_id']}' AND dangfeiid = '{$list_d[$j-1]['id']}' LIMIT 1";
					$db->query($sql_j);
					$db->fetchRow();
					if($db->getValue("id"))
						echo "缴纳号:".$db->getValue("id").",时间:".$db->getValue("date");
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

		
<script>
function modalShow(obj){
	var tds= $(obj).parent().find("lable");
//	console.log(tds.eq(0).text());
//	console.log(tds.eq(1).text());
//	console.log(tds.eq(2).text());
//	console.log(tds.eq(3).text());
//	console.log(tds.eq(4).text());
	
	$("#id").val(tds.eq(0).text());
	$("#name").val(tds.eq(1).text());
	$("#price").val(tds.eq(2).text());
	$("#date").val(tds.eq(3).text());
	$("#mark").val(tds.eq(4).text());
	
	$("#myModal_detail").modal("show");
}
</script>

<!-- Modal -->
<div class="modal fade" id="myModal_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog role="document">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">党费详情</h3>
	</div>
	<div class="modal-body">
	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="id">党费编号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="id" name="id" placeholder="" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="name">党费名称</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="name" name="name" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="price">金额</label>
			<div class="col-sm-8">
				<input type="number" step="0.01" class="form-control" id="price" name="price" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="date">提交时间</label>
			<div class="col-sm-8">
				<input type="datetime" class="form-control" id="date" name="date" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="mark">备注</label>
			<div class="col-sm-8">
				<textarea class="form-control" id="mark" name="mark" rows="4" readonly="readonly" ></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="name">缴纳统计</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="name" name="name" readonly="readonly" value="已缴纳&nbsp;/&nbsp;总人数：此功能完善中..." />
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
	console.log("DEL with: name=" + $("#id").val());
	if(confirm("确定要删除党费 " + $("#name").val() + " 吗？\n此操作不可逆！")){
		var id = $("#id").val();
		$.ajax({
			url:"?action=dangfei&do=del_dangfei",
			data:{
				id:id,
				},
			type:"POST",
			dataType:"TEXT",
			success: function(data){
					alert("删除党费成功！\n课程 id = " + id + "\n");
					window.location.reload();
				}
		});
	return true;
	}else{
		return false;
	}
}
</script>

</div>
</div>
</div>
</div>
<?php
	include("foot.php");
?>