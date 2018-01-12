<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>注册 - <?php echo $cfg["webtitle"]; ?></title>
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
				<a href="?action=user&do=login" class="">已经有账号<i class="fa fa-question" aria-hidden="true"></i>立刻登录</a>
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
	
	//验证正确性
	var usernameTest = false, nameTest = false, emailTest = false, passwordTest = false, password2Test = false;
	
	//单独检查
	$("#username").change(function(){
		if(reUsername.test(this.value)){
			checkFeedback(0,"success");
			usernameTest = true;
		}else{
			checkFeedback(0,"error");
			usernameTest = false;
		}
	});
	$("#name").change(function(){
		if(reName.test(this.value)){
			checkFeedback(1,"success");
			nameTest = true;
		}else{
			checkFeedback(1,"error");
			nameTest = false;
		}
	});
	$("#email").change(function(){
		if(reEmail.test(this.value)){
			checkFeedback(2,"success");
			emailTest = true;
		}else{
			checkFeedback(2,"error");
			emailTest = false;
		}
	});
	$("#password").change(function(){
		checkFeedback(4,"error");
		if(rePassword.test(this.value)){
			checkFeedback(3,"success");
			passwordTest = true;
		}else{
			checkFeedback(3,"error");
			passwordTest = false;
		}
	});
	$("#password2").change(function(){
		if(rePassword.test(this.value) && $("#password2").val() == $("#password").val()){
			checkFeedback(4,"success");
			password2Test = true;
		}else{
			checkFeedback(4,"error");
			password2Test = false;
		}
	});
	
	//表单验证
	$("#register").click(function(){
		//总体检查
		if(usernameTest)checkFeedback(0,"success");else checkFeedback(0,"error");
		if(nameTest)checkFeedback(1,"success");else checkFeedback(1,"error");
		if(emailTest)checkFeedback(2,"success");else checkFeedback(2,"error");
		if(passwordTest)checkFeedback(3,"success");else checkFeedback(3,"error");
		if(password2Test)checkFeedback(4,"success");else checkFeedback(4,"error");
		
		if(usernameTest && nameTest && emailTest && passwordTest && password2Test)
			alert("暂时禁止注册");//此处AJAX提交表单
		else
			alert("请检查您的输入");//若需单独提示，则判断每个值的布尔类型
	});
	
	//验证反馈
	function checkFeedback(obj,val){//定位符;success:成功,warning:警告,error:错误
		$("#check .form-group:eq("+obj+")").removeClass("has-success has-warning has-error has-feedback");//清除反馈框
		$("#check span:eq("+obj+")").removeClass("glyphicon-ok glyphicon-warning-sign glyphicon-remove");//清除反馈提示
		if(val == "success"){//验证成功	
			$("#check .form-group:eq("+obj+")").addClass("has-success has-feedback");
			$("#check span:eq("+obj+")").addClass("glyphicon-ok");
		}
		if(val == "warning"){//验证警告
			$("#check .form-group:eq("+obj+")").addClass("has-warning has-feedback");
			$("#check span:eq("+obj+")").addClass("glyphicon-warning-sign");
		}
		if(val == "error"){//验证错误
			$("#check .form-group:eq("+obj+")").addClass("has-error has-feedback");
			$("#check span:eq("+obj+")").addClass("glyphicon-remove");
		}
	}
});
</script>
<div class="account-container" id="check">
	<h2>注册账号</h2>
	<p>创建您的帐户:</p>
	<!--div class="form-group" style="display:none">
		<input type="text" id="roleid" name="roleid" class="form-control" placeholder="请输入编号" />
	</div-->
	<div class="form-group">
		<input type="text" id="username" class="form-control" placeholder="请输入学号" maxlength="32" data-toggle="tooltip" data-placement="top" title="3~32位字母或数字" />
		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input type="text" id="name" class="form-control" placeholder="请输入姓名" maxlength="32" data-toggle="tooltip" data-placement="top" title="2~32位字母数字或汉字" />
		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input type="email" id="email" class="form-control" placeholder="请输入邮箱" data-toggle="tooltip" data-placement="top" title="请输入您的邮箱地址" />
		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input type="password" id="password" class="form-control" placeholder="请输入密码" maxlength="32" data-toggle="tooltip" data-placement="top" title="6~32位符号字母或数字" />
		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group">
		<input type="password" id="password2" class="form-control" placeholder="请重复密码" maxlength="32" data-toggle="tooltip" data-placement="top" title="6~32位符号字母或数字" />
		<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
	</div>
	<div class="form-group pull-right">
		<button id="register" class="btn btn-success">注册</button>
	</div>
</div>
<div class="login-extra">
	已经有账号?&nbsp;<a href="?action=user&do=login">立即登录</a>
</div>
</body>
</html>
