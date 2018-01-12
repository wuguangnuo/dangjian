<?php
	include('head.php');
	include('nav.php');
?>

<script>
$("#modify_pwd").addClass("active");
</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;修改密码
	</div>
	<div class="panel-body">

	<strong>先验证密码一致性，再验证原始密码。考虑添加验证码防机器人注册(同是应用于注册界面)</strong>

	<form class="form-horizontal" method="post" action="?action=user&do=update_pwd" role="form">
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="username">登录名</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="username" value="<?php echo $_SESSION['username']; ?>" disabled />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="old_password">原始密码</label>
			<div class="col-md-4 col-sm-6">
				<input type="password" class="form-control" id="old_password" name="old_password" placeholder="请输入原密码" />
			</div>
		</div> 
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="password">新密码</label>
			<div class="col-md-4 col-sm-6">
				<input type="password" class="form-control" id="password" name="password" placeholder="请输入新密码" />
			</div>
		</div> 
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="password2">确认密码</label>
			<div class="col-md-4 col-sm-6">
				<input type="password" class="form-control" id="password2" name="password2" placeholder="请重复密码" />
			</div>
		</div> 
		<div class="form-actions">
			<div class="col-md-2 col-sm-2"></div>
			<button class="btn btn-sm btn-primary" type="submit">提交</button>
			<a href="?action=user&do=home" type="button" class="btn btn-sm btn-default">返回</a>
			<button class="btn btn-sm btn-default" type="reset">清空</button>
		</div>
	</form>
</div>
</div>
</div> 
</div> 

<?php
	include('foot.php');
?>