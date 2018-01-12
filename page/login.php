<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录 - <?php echo $cfg["webtitle"]; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="css/style.css" rel="stylesheet">
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
				<a href="?action=user&do=register" class="">还没有账号<i class="fa fa-question" aria-hidden="true"></i></a>
			</li>
			<li class="">
				<a href="index.php" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;返回主页</a>
			</li>
		</ul>
	</div>
	</div>
</div>
<script>
$(function(){
	//提示工具
	$("[data-toggle='tooltip']").tooltip();
	
	//正则表达式
	var reUsername	=	/^[A-Za-z0-9]{3,32}$/;//3-32位大小写字母或数字
	var reName		=	/^[A-Za-z0-9\u4e00-\u9fa5]{2,32}$/;//2-32位大小写字母或数字或汉字
	var reEmail		=	/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;//邮箱匹配
	var rePassword	=	/^.{6,32}$/;//长度6-32位
	var rePhone		=	/^((1[3-9]{1})+\d{9})$/;//已适配199/198等新号段，故放宽限制
	var reIdcard	=	/^[1-9]\d{5}(18|19|20)\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;//没有闰月限制，大小写Xx均可
});
</script>
<div class="account-container">
	<form action="?action=user&do=loginok" method="post" role="form">
		<h2>用户登录</h2>
		<p>请填写您的登录信息</p>
		<div class="form-group">
			<input type="text" name="username" class="form-control" placeholder="请输入学号" maxlength="32" data-toggle="tooltip" data-placement="top" title="3~32位字母或数字" />
		</div>
		<div class="form-group">
			<input type="password" name="password" class="form-control" placeholder="请输入密码" maxlength="32" data-toggle="tooltip" data-placement="top" title="6~32位符号字母或数字" />
		</div>
		<div class="form-group pull-right">
			<button type="submit" class="btn btn-success">登录</button>
		</div>
	</form>
</div>
<div class="login-extra">
	还没有账号?&nbsp;<a href="?action=user&do=register">立即注册</a>
</div>
</body>
</html>
