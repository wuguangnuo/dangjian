<?php
	include('head.php');
	include('nav.php');
?>

<script>
$("#edit_profile").addClass("active");
</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;修改个人资料
	</div>
	<div class="panel-body">

	<strong>
		计划任务：前端使用正则表达式约束提交信息，后端使用_RunMagicQuotes()方法二次过滤防注入<br />
		var checkphone = /^((1[3-9]{1})+\d{9})$/;已适配199/198等新号段，故放宽限制<br />
		var checkidnum = /^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;没有闰月限制，大小写Xx均可，数据库varchar(18)
	</strong>
	<?php echo "<p class='sqlinfo'>SQL：{$sql}</p>"; ?>

	<form class="form-horizontal" method="post" action="?action=user&do=update" role="form">
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="username">登陆名(学号)</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="username" name="username" value="<?php echo $db->getValue("username"); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="name">姓名(没什么用)</label>
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
				<input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $db->getValue("birthday"); ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="idcard">身份证号</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="idcard" name="idcard" value="<?php echo $db->getValue("idcard"); ?>" placeholder="请输入身份证号" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="college">院校</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="college" name="college" value="<?php echo $db->getValue("college"); ?>" placeholder="请输入院校" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="volk">民族</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="volk" name="volk" value="<?php echo $db->getValue("volk"); ?>" placeholder="请输入民族" />
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
				<input type="email" class="form-control" id="email" name="email" value="<?php echo $db->getValue("email"); ?>" placeholder="请输入邮箱" />
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
			<a href="?action=user&do=home" type="button" class="btn btn-sm btn-default">返回</a>
		</div> 
	</form>
</div>
</div>
</div>
</div>

<?php
	include('foot.php');
?>