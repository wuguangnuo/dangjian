<?php
	include("head.php");
	include("manageNav.php");
?>

<script>
$("#manage_user").addClass("active");

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
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;管理中心 -> 用户管理
	</div>
	<div class="panel-body">

<div class="btn-group">
	<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">新建用户</button>
</div>
<hr />

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="manage_user_form" class="form-horizontal" method="post" action="?action=manage&do=add_user" role="form">
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
				<input type="text" class="form-control" name="email" placeholder="请输入邮箱" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="password">密码</label>
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

<form class="form-inline" action="?action=manage&do=manage_user" method="post" role="form">
	<div class="form-group">
		<input type="text" name="key" class="form-control input-sm" value="<?php echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; ?>" placeholder="请输入学号或姓名" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-success" id="search">查询</button>
	</div>
</form>

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
					if(empty($list))echo "<h4 style='color:red'>列表为空!</h4>";
					else{
						foreach($list as &$row){
						echo "<tr>";
						echo "<td>" . $row['id'] ."</td>";
						echo "<td style=\"display:none;\">" . $row['user_id'] ."</td>";
						echo "<td>" . $row['username'] ."</td>";
						echo "<td>" . $row['name'] ."</td>";
						echo "<td>" . $row['email'] ."</td>";
						echo "<td>" . $row['created_at'] ."</td>";
					//	echo "<td>" . substr($row['created_at'],0,10) ."</td>";//截取日期字符
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
	swal({ 
		title: "确定删除吗？", 
		text: "确定要删除账户 " + tds.eq(2).text() + " 吗？\n此操作不可逆！", 
		type: "warning",
		showCancelButton: true, 
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "确定删除", 
		closeOnConfirm: false
	},
	function(){
		var user_id = tds.eq(1).text();
		$.ajax({
			url:"?action=manage&do=del_user",
			data:{
				user_id:user_id
				},
			type:"POST",
			dataType: "TEXT",
			success: function(data){
					swal("删除！", "账户 " + tds.eq(2).text()  + " 删除成功！", "success"); 
					setTimeout(function(){
						window.history.back();
					},1500);
				}
		});
	});
}

//显示用户详情
function modalShow(obj){
	var tds = $(obj).parent().parent().find("td");

	//根据 id 获取用户信息
	$.ajax({
		url: "?action=manage&do=getUserProfile",
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
			$("#id").val(data.id);
			$("#user_id").val(data.user_id);
			$("#username").val(data.username);
		//	$("#password").val(data.password);
			$("#name").val(data.name);
			if(data.sex == "男"){
				$("#man").prop("checked",true);
				$("#woman").prop("checked",false);
			}else if(data.sex == "女"){
				$("#man").prop("checked",false);
				$("#woman").prop("checked",true);
			}else{
				$("#man").prop("checked",false);
				$("#woman").prop("checked",false);
			}
			$("#birthday").val(data.birthday);
			$("#idcard").val(data.idcard);
			$("#education").val(data.education);
			$("#volk").val(data.volk);
			if(data.category == "1"){
				$("#category1").prop("checked",true);
				$("#category0").prop("checked",false);
			}else{
				$("#category1").prop("checked",false);
				$("#category0").prop("checked",true);
			}
			$("#organization").val(data.organization);
			$("#joinDate").val(data.joinDate);
			$("#regularDate").val(data.regularDate);
			$("#price").val(data.price);
			$("#phone").val(data.phone);
			$("#email").val(data.email);
			$("#address").val(data.address);
			if(data.roleid == "1"){
				$("#role0").prop("checked",false);
				$("#role1").prop("checked",true);
			}else{
				$("#role0").prop("checked",true);
				$("#role1").prop("checked",false);
			}
			$("#created_at").val(data.created_at);
			$("#updated_at").val(data.updated_at);
		},
		error: function(){
			//失败，请稍后重试
			swal("错误", "请求失败，请稍后重试！","error");
		}
	});
	
	$("#modal2").modal("show");
}
</script>

<!-- Modal -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<form id="manage_user_form2" class="form-horizontal" method="post" action="?action=manage&do=update_user" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">个人档案</h3>
	</div>
	<div class="modal-body">  

		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="id">ID编号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="id" name="id" readonly="readonly" />
			</div>
		</div>
		<!--div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="user_id">MD5(username)</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="user_id" name="user_id" readonly="readonly" />
			</div>
		</div-->
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="username">登陆名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="username" name="username" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="password">密码</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="password" name="password"  placeholder="留空不修改" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="name">姓名</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="name" name="name" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label">权限</label>
			<div class="col-sm-8">
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
			<label class="col-sm-2 control-label">性别</label>
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
			<label class="col-sm-2 control-label" for="birthday">生日</label>
			<div class="col-sm-8">
				<input type="text" class="form-control selectData" id="birthday" name="birthday" placeholder="请输入生日" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="idcard">身份证号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="idcard" name="idcard" placeholder="请输入身份证号" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="education">学历</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="education" name="education" placeholder="请输入学历" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="volk">民族</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="volk" name="volk" placeholder="请输入民族" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label">人员类别</label>
			<div class="col-sm-8">
				<div class="radio-inline">
					<input type="radio" id="category1" name="category" value="1">正式党员
				</div>
				<div class="radio-inline">
					<input type="radio" id="category0" name="category" value="0">预备党员
				</div>
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="organization">所在党支部</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="organization" name="organization" placeholder="请输入所在党支部" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="joinDate">入党日期</label>
			<div class="col-sm-8">
				<input type="text" class="form-control selectData" id="joinDate" name="joinDate" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="regularDate">转正日期</label>
			<div class="col-sm-8">
				<input type="text" class="form-control selectData" id="regularDate" name="regularDate" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="price">党费应缴</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="price" name="price" />
			</div>
		</div>
		<hr />
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="phone">手机</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="phone" name="phone" placeholder="请输入手机号" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="email">邮箱</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="email" name="email" placeholder="请输入邮箱" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="address">住址：</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="address" name="address" placeholder="请输入住址" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="created_at">创建时间</label>
			<div class="col-sm-8">
				<input type="datetime" class="form-control" id="created_at" name="created_at" readonly="readonly" />
			</div>
		</div>
		<div class="form-group form-group-sm">
			<label class="col-sm-2 control-label" for="updated_at">最后修改时间</label>
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
		
		<div class="btn-group">
			<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">导出此表<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="lib/excelDL.class.php?type=manageXls<?php echo "&username=" . $_SESSION['username'] . "&sql=" . $sqlExcel; ?>">生成xls格式文件</a></li>
				<li><a href="lib/excelDL.class.php?type=manageCsv<?php echo "&username=" . $_SESSION['username'] . "&sql=" . $sqlExcel; ?>">生成csv格式文件</a></li>
			</ul>
		</div>
		
</div>
</div>
</div>
</div>
<?php
	include("foot.php");
?>
