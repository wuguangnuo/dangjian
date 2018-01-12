<?php
	include("head.php");
?>

<script>
$("#navbar_manage").addClass("active");

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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;用户管理
	</div>
	<div class="panel-body">

<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">新建用户</button>
</div>
<hr />

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog role="document">
<div class="modal-content">
<form class="form-horizontal" method="post" action="?action=manage&do=add_user" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">添加用户</h3>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label class="col-sm-2 control-label" for="username">登录名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="username" placeholder="请输入学号" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="radio">权限</label>
			<div class="col-sm-8">
				<div class="radio-inline">
					<input type="radio" name="roleid" value="0" checked>普通用户
				</div>
				<div class="radio-inline">
				<input type="radio" name="roleid" value="1">管理员
				</div>
				<!--select class="form-control" name="roleid">
					<option value="0">普通用户</option>
					<option value="1">管理员</option>
				</select-->
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="lastname">姓名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="name" placeholder="请输入姓名" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="email">邮箱</label>
			<div class="col-sm-8">
				<input type="mail" class="form-control" name="email" placeholder="请输入邮箱" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password1">密码</label>
			<div class="col-sm-8">
				<input type="password" class="form-control" name="password" placeholder="默认密码123456" />
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

<form class="form-inline" action="?action=manage" method="post" role="form">
	<div class="form-group">
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入学号或姓名" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-success" id="search">查询</button>
	</div>
</form>

<?php echo "<p class='sqlinfo'>SQL：{$sql}</p>"; ?>

<hr />

	<p class="ttitle">用户列表</p>

		<div class="table-responsive">
			<table class="table table-striped table-condensed table-hover">
				<thead>
					<tr>
					<th>编号</th>
					<th>登录名</th>
					<th>姓名</th>
					<th>邮箱</th>
					<th>创建时间</th>
					<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if(empty($list))echo "<p>列表为空!</p>";
					else{
						foreach($list as &$row){
						echo "<tr>";
						echo "<td>" . $row['id'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['user_id'] ."</td>";
						echo "<td>" . $row['username'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['password'] ."</td>";
						echo "<td>" . $row['name'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['sex'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['birthday'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['idcard'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['college'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['volk'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['phone'] ."</td>";
						echo "<td>" . $row['email'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['address'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['roleid'] ."</td>";
						echo "<td>" . $row['created_at'] ."</td>";
					//	echo "<td>" . substr($row['created_at'],0,10) ."</td>";//截取日期字符
						echo "<td style=\"display:none;\">" .$row['updated_at'] ."</td>";
						echo "<td>";
					?>
						<button onclick="modalShow(this);" role="button" class="btn btn-xs btn-info" data-toggle="modal">编&nbsp;辑</button>
						<button onclick="del(this)" class="btn btn-xs btn-danger">删&nbsp;除</button>
					<?php
						echo "</td>";
						echo "</tr>\n";
						}
					}
					?>
				</tbody>
			</table>
		</div>
				
<script>
//删除用户
function del(obj){
	var tds = $(obj).parent().parent().find("td");
	console.log("DEL with: name=" + tds.eq(2).text());
	if(confirm("确定要删除账户 " + tds.eq(2).text() + " 吗？\n此操作不可逆！")){
		var user_id = tds.eq(1).text();
		$.ajax({
			url:"?action=manage&do=del_user",
			data:{
				user_id:user_id,
				},
			type:"POST",
			dataType:"TEXT",
			success: function(data){
					alert("删除账户成功！\n user_id = " + user_id + "，name = " + tds.eq(2).text());
					window.location.reload();
				}
		});
		return true;
	}else{
		return false;
	}
}

//显示用户详情
function modalShow(obj){
	var tds = $(obj).parent().parent().find("td");
	console.log("SET with: name=" + tds.eq(2).text());
	$("#id").val(tds.eq(0).text());
	$("#user_id").val(tds.eq(1).text());
	$("#username").val(tds.eq(2).text());
//	$("#password").val(tds.eq(3).text());//hide()
	$("#name").val(tds.eq(4).text());
	if(tds.eq(5).text() == "男"){
		$("#man").prop("checked",true);
		$("#woman").prop("checked",false);
	}else if(tds.eq(5).text() == "女"){
		$("#man").prop("checked",false);
		$("#woman").prop("checked",true);
	}
	$("#birthday").val(tds.eq(6).text());
	$("#idcard").val(tds.eq(7).text());
	$("#college").val(tds.eq(8).text());
	$("#volk").val(tds.eq(9).text());
	$("#phone").val(tds.eq(10).text());
	$("#email").val(tds.eq(11).text());
	$("#address").val(tds.eq(12).text());
	$("#roleid").val(tds.eq(13).text());
	if(tds.eq(13).text() == "1"){
		$("#role0").prop("checked",false);
		$("#role1").prop("checked",true);
	}else{
		$("#role0").prop("checked",true);
		$("#role1").prop("checked",false);
	}
	$("#created_at").val(tds.eq(14).text());
	$("#updated_at").val(tds.eq(15).text());
	$("#modal2").modal("show");
}
</script>

<!-- Modal -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog role="document">
<div class="modal-content">
<form class="form-horizontal" method="post" action="?action=manage&do=update_user" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">个人档案</h3>
	</div>
	<div class="modal-body">  

		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">ID编号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="id" name="id" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">MD5(username)</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="user_id" name="user_id" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">用户名(登陆名)</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="username" name="username" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">密码</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="password" name="password"  placeholder="留空不修改" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">姓名(没什么用)</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="name" name="name" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">权限</label>
			<div class="col-sm-8">
				<!--label class="radio inline">
					<input type="radio" id="role1" name="roleid" value="1" />管理员
				</label>
				<label class="radio inline">
					<input type="radio" id="role0" name="roleid" value="0" />用户
				</label-->
				<div class="radio-inline">
					<input type="radio" id="role0" name="roleid" value="0">普通用户
				</div>
				<div class="radio-inline">
					<input type="radio" id="role1" name="roleid" value="1">管理员
				</div>
			</div>
		</div>
		<hr />
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">性别</label>
			<div class="col-sm-8">
			<div class="radio-inline">
				<label class="radio inline">
					<input type="radio" id="man" name="sex" value="男" />男
				</label>
			</div>
			<div class="radio-inline">
				<label class="radio inline">
					<input type="radio" id="woman" name="sex" value="女" />女
				</label>
			</div>
		</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">生日</label>
			<div class="col-sm-8">
				<input type="date" class="form-control" id="birthday" name="birthday" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">身份证号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="idcard" name="idcard" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">院校</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="college" name="college" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">民族</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="volk" name="volk" />
			</div>
		</div>
		<hr />
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">手机</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="phone" name="phone" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">邮箱</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="email" name="email" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">住址：</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="address" name="address" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">创建时间</label>
			<div class="col-sm-8">
				<input type="datetime" class="form-control" id="created_at" name="created_at" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="">最后修改时间</label>
			<div class="col-sm-8">
				<input type="datetime" class="form-control" id="updated_at" name="updated_at" readonly="readonly" />
			</div>
		</div>

	</div>
	<div class="modal-footer">
		<button class="btn btn-sm btn-default" data-dismiss="modal" aria-hidden="true">返&nbsp;回</button>
		<button type="submit" class="btn btn-sm btn-primary">修改</button>
	</div>
</form>
</div>
</div>
</div>

		<div class="showPage">
		<?php
		if($total > $showrow) {//总记录数大于每页显示数，显示分页
			$page = new page($total, $showrow, $curpage, $url, 2);
			echo $page->myde_write();
		}
		?>
		</div>

</div>
</div>
</div>
</div>
<?php
	include("foot.php");
?>
