<?php
	include('head.php');
	include('userNav.php');
?>

<script>
$("#user_edit").addClass("active");
</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;个人中心 -> 资料修改
	</div>
	<div class="panel-body">

	<form id="user_edit_form" class="form-horizontal" method="post" action="?action=user&do=update" role="form">
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="username">登陆名(学号)</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="username" name="username" value="<?php echo $db->getValue("username"); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="name">姓名</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="name" name="name" value="<?php echo $db->getValue("name"); ?>" placeholder="请输入姓名" />
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label">性别</label>
			<div class="col-md-4 col-sm-6">
				<label class="radio-inline">
					<input type="radio" name="sex" value="男" <?php if ($db->getValue("sex") == "男"): ?>checked<?php endif; ?> />男
				</label>
				<label class="radio-inline">
					<input type="radio" name="sex" value="女" <?php if ($db->getValue("sex") == "女"): ?>checked<?php endif; ?> />女
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="birthday">生日</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control selectData" id="birthday" name="birthday" value="<?php echo $db->getValue("birthday"); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="idcard">身份证号</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="idcard" name="idcard" value="<?php echo $db->getValue("idcard"); ?>" placeholder="请输入身份证号" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="education">学历</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="education" name="education" value="<?php echo $db->getValue("education"); ?>" placeholder="请输入学历" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="volk">民族</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="volk" name="volk" value="<?php echo $db->getValue("volk"); ?>" placeholder="请输入民族" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="organization">所在党支部</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="organization" name="organization" value="<?php echo $db->getValue("organization"); ?>" placeholder="请输入所在党支部" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="joinDate">入党日期</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control selectData" id="joinDate" name="joinDate" value="<?php echo $db->getValue("joinDate"); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="regularDate">转正日期</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control selectData" id="regularDate" name="regularDate" value="<?php echo $db->getValue("regularDate"); ?>" />
			</div>
		</div>
		<hr />
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="phone">手机</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $db->getValue("phone"); ?>" placeholder="请输入手机号" />
			</div>
		</div> 
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="email">邮箱</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="email" name="email" value="<?php echo $db->getValue("email"); ?>" placeholder="请输入邮箱" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="address">住址</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="address" name="address" value="<?php echo $db->getValue("address"); ?>" placeholder="请输入住址" />
			</div>
		</div>
		<div class="form-actions">
		<div class="col-md-2 col-sm-2"></div>
			<button type="submit" class="btn btn-sm btn-primary">提交</button>
			<a href="?action=user&do=user_profile" type="button" class="btn btn-sm btn-default">返回</a>
		</div>
	</form>
</div>
</div>
</div>
</div>

<?php
	include('foot.php');
?>