<?php
	include("head.php");
	include("userNav.php");
?>

<script>
$("#user_profile").addClass("active");
</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;个人中心 -> 个人资料
	</div>
	<div class="panel-body">
	
	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="id">编号</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="id" value="<?php echo checkEmpty($db->getValue("id")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="username">登陆名</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="username" value="<?php echo checkEmpty($db->getValue("username")); ?>" readonly="readonly" />
			</div>
		</div>
		<!--div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="user_id">登录名MD5</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="user_id" value="<?php echo checkEmpty($db->getValue("user_id")); ?>" readonly="readonly" />
			</div>
		</div-->
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="name">姓名</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="name" value="<?php echo checkEmpty($db->getValue("name")); ?>" readonly="readonly" />
			</div>
		</div>
		<!--div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="password">密码MD5</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="password" value="<?php echo checkEmpty($db->getValue("password")); ?>" readonly="readonly" />
			</div>
		</div--> 
		<hr />
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label">性别</label>
			<div class="col-md-4 col-sm-6">
				<label class="radio-inline">
					<input type="radio" name="sex" onclick="return false;" <?php if ($db->getValue("sex") == "男"): ?>checked<?php endif; ?> />男
				</label>
				<label class="radio-inline">
					<input type="radio" name="sex" onclick="return false;" <?php if ($db->getValue("sex") == "女"): ?>checked<?php endif; ?> />女
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="birthday">生日</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="birthday" value="<?php echo checkEmpty($db->getValue("birthday")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="idcard">身份证号</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="idcard" value="<?php echo checkEmpty($db->getValue("idcard")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="education">学历</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="education" value="<?php echo checkEmpty($db->getValue("education")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="volk">民族</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="volk" value="<?php echo checkEmpty($db->getValue("volk")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label">人员类别</label>
			<div class="col-md-4 col-sm-6">
				<label class="radio-inline">
					<input type="radio" name="category" onclick="return false;" <?php if ($db->getValue("category") == 1): ?>checked<?php endif; ?> />正式党员
				</label>
				<label class="radio-inline">
					<input type="radio" name="category" onclick="return false;" <?php if ($db->getValue("category") != 1): ?>checked<?php endif; ?> />预备党员
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="organization">所在党支部</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="organization" value="<?php echo checkEmpty($db->getValue("organization")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="joinDate">入党日期</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="joinDate" value="<?php echo checkEmpty($db->getValue("joinDate")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="regularDate">转正日期</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="regularDate" value="<?php echo checkEmpty($db->getValue("regularDate")); ?>" readonly="readonly" />
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="phone">手机</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="phone" value="<?php echo checkEmpty($db->getValue("phone")); ?>" readonly="readonly" />
			</div>
		</div> 
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="email">邮箱</label>
			<div class="col-md-4 col-sm-6">
				<input type="email" class="form-control" id="email" value="<?php echo checkEmpty($db->getValue("email")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="address">住址</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="address" value="<?php echo checkEmpty($db->getValue("address")); ?>" readonly="readonly" />
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label">账号状态</label>
			<div class="col-md-4 col-sm-6">
				<label class="checkbox-inline">
					<input type="checkbox" onclick="return false;" checked />正常
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label">权限</label>
			<div class="col-md-4 col-sm-6">
				<label class="radio-inline">
					<input type="radio" name="roleid" onclick="return false;" <?php if ($db->getValue("roleid") == 1): ?>checked<?php endif; ?> />管理员
				</label>
				<label class="radio-inline">
					<input type="radio" name="roleid" onclick="return false;" <?php if ($db->getValue("roleid") != 1): ?>checked<?php endif; ?> />用户
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="created_at">注册时间</label>
			<div class="col-md-4 col-sm-6">
				<input type="datetime" class="form-control" id="created_at" value="<?php echo checkEmpty($db->getValue("created_at")); ?>" readonly="readonly" />
			</div>
		</div>
		<!--div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="updated_at">更新时间</label>
			<div class="col-md-4 col-sm-6">
				<input type="datetime" class="form-control" id="updated_at" value="<?php echo checkEmpty($db->getValue("updated_at")); ?>" readonly="readonly" />
			</div>
		</div-->
	</form>
	
</div>
</div>
</div>
</div>

<?php
	include("foot.php");
?>
