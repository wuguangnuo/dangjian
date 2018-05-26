<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录 - <?php echo $cfg["webtitle"]; ?></title>
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
				<a href="?action=user&do=register" class="">还没有账号<i class="fa fa-question" aria-hidden="true"></i>立即注册</a>
			</li>
			<li class="">
				<a href="index.php" class=""><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;返回主页</a>
			</li>
		</ul>
	</div>
	</div>
</div>

<div class="account-container">
	<form id="login_form" action="?action=user&do=loginok" method="post" role="form">
		<h2>用户登录</h2>
		<p>请填写您的登录信息</p>
		<div class="form-group">
			<input type="text" name="username" class="form-control" placeholder="请输入学号" maxlength="32" />
		</div>
		<div class="form-group">
			<input type="password" name="password" class="form-control" placeholder="请输入密码" maxlength="32" />
		</div>
		<div class="pull-left">
			<button type="submit" class="btn btn-success">登录</button>
		</div>
		<div class="pull-right">
			<a id="forget" class="" style="cursor:pointer;">忘记密码？</a>
		</div>
	</form>
	
<script>

$(function(){
	$("#Modal_forget").on("show.bs.modal",function(){
		var $this = $(this);
		var $modal_dialog = $this.find(".modal-dialog");
		$this.css("display","block");
		$modal_dialog.css({"margin-top":Math.max(0,($(window).height()-$modal_dialog.height())/2)});
	});

	//打开对话框
	$("#forget").click(function(){
		$("#Modal_forget").modal("show");
	});
});
</script>

<!-- Modal -->
<div class="modal fade" id="Modal_forget" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document" style="width:400px;">
<div class="modal-content">
<form id="forget_form" class="form-horizontal" method="post" action="?action=user&do=forget" role="form" enctype="multipart/form-data">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel" class="ttitle">找回密码</h3>
	</div>
	<div class="modal-body">
		<div class="form-group">
			<label for="username" class="col-sm-2 control-label">学号</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="username" id="username" placeholder="请输入学号">
			</div>
		</div>
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">邮箱</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="email" id="email" placeholder="请输入邮箱">
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-sm btn-primary">提交</button>
	</div>
</form>
</div>
</div>
</div>

</div>
<div class="login-extra">
	还没有账号?&nbsp;<a href="?action=user&do=register">立即注册</a><br />
</div>
</body>
</html>
