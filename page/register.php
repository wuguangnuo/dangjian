<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册账号 - <?php echo $cfg["webtitle"]; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">

<script src="cdn/jquery.min.js"></script>
<link href="cdn/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="cdn/bootstrap-3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="cdn/bootstrap-datepicker-1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<link href="cdn/highlight.js-9.12.0/styles/monokai-sublime.css" rel="stylesheet">
<link href="cdn/sweetalert-1.1.3/sweetalert.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<script src="cdn/bootstrap-3.3.7/js/bootstrap.min.js"></script>
<script src="cdn/bootstrap-datepicker-1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="cdn/bootstrap-datepicker-1.7.1/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script src="cdn/jquery-validation-1.17.0/jquery.validate.min.js"></script>
<script src="cdn/jquery-validation-1.17.0/localization/messages_zh.js"></script>
<script src="cdn/highlight.js-9.12.0/highlight.min.js"></script>
<script src="cdn/sweetalert-1.1.3/sweetalert.min.js"></script>
<script src="js/jquery.fcup.js"></script>
<script src="js/functions.js"></script>

</head>

<body>
<div class="navbar navbar-inverse navbar-static-top hidden-print">
	<div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<i class="fa fa-bars fa-lg" aria-hidden="true" title="切换导航"></i>
			<span class="sr-only">切换导航</span>
		</button>
		<a class="navbar-brand" href="index.php"><?php echo $cfg["webtitle"]; ?></a>
	</div>
	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav pull-right">
			<li class="">
				<a href="?action=user&do=login" class="">已经有账号<i class="fa fa-question" aria-hidden="true"></i>立刻登录</a>
			</li>
			<li class="">
				<a href="index.php" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;返回主页</a>
			</li>
		</ul>
	</div>
	</div>
</div>

<div class="account-container">
	<form id="register_form" action="?action=user&do=registerok" method="post" role="form">
		<h2>注册账号</h2>
		<p>创建您的帐户:</p>
		<div class="form-group">
			<input type="text" name="username" class="form-control" placeholder="请输入学号" maxlength="32" />
		</div>
		<div class="form-group">
			<input type="text" name="name" class="form-control" placeholder="请输入姓名" maxlength="32" />
		</div>
		<div class="form-group">
			<input type="text" name="email" class="form-control" placeholder="请输入邮箱" />
		</div>
		<div class="form-group">
			<input id="password" type="password" name="password" class="form-control" placeholder="请输入密码" maxlength="32" />
		</div>
		<div class="form-group">
			<input type="password" name="password2" class="form-control" placeholder="请重复密码" maxlength="32" />
		</div>
		<div class="form-group pull-right">
			<button type="submit" class="btn btn-success">注册</button>
		</div>
	</form>
</div>
<div class="login-extra">
	已经有账号?&nbsp;<a href="?action=user&do=login">立刻登录</a>
</div>
</body>
</html>
