<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg["webtitle"]; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<!--script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->

<script src="cdn/jquery.min.js"></script>
<link href="cdn/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="cdn/bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="cdn/bootstrap-3.3.7/dist/js/bootstrap.min.js"></script>

<link href="css/style.css<?php echo "?v=".date(His); ?>" rel="stylesheet">
<script src="js/functions.js<?php echo "?v=".date(His); ?>"></script>

<script>
	function check(){
		if(document.getElementById('username').value == ''){
			alert('必须输入用户名！');
			document.getElementById('username').focus();
			return false;
		}
		if(document.getElementById('name').value == ''){
			alert('必须输入真实姓名！');
			document.getElementById('name').focus();
			return false;
		}
		if(document.getElementById('email').value == ''){
			alert('必须输入邮箱！');
			document.getElementById('email').focus();
			return false;
		}
		if(document.getElementById('password').value == ''){
			alert('密码不能为空！');
			document.getElementById('password').focus();
			return false;
		}
		if(document.getElementById('password').value != document.getElementById('password2').value){
			alert('两次输入的密码不一致！');
			document.getElementById('password').focus();
			return false;
	}
}
</script>
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
				<a href="?action=user&do=home&user_id=<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $_SESSION['username']; ?></a>
			</li>
			<li class="dropdown dropdown-split-right hidden-xs">
				<a href="" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog" aria-hidden="true"></i>&nbsp;操&nbsp;作&nbsp;
					<i class="fa fa-caret-down" aria-hidden="true"></i>
				</a>
				<ul class="dropdown-menu pull-right">
					<li><a href="?action=user&do=logout"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;注&nbsp;销&nbsp;</a></li>
					<li><a href="http://soooo.club/index.php" target="_blank"><i class="fa fa-question" aria-hidden="true"></i>&nbsp;帮&nbsp;助&nbsp;</a></li>
				</ul>
			</li>
			<li class="hidden-lg hidden-md hidden-sm"><a href="?action=user&do=logout"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;注&nbsp;销&nbsp;</a></li>
			<li class="hidden-lg hidden-md hidden-sm"><a href="http://soooo.club/index.php" target="_blank"><i class="fa fa-question" aria-hidden="true"></i>&nbsp;帮&nbsp;助&nbsp;</a></li>
		</ul>
	</div>
	</div>
</div>

<div class="subnavbar">
	<div class="subnavbar-inner">
		<div class="container">
		<ul class="mainnav">
			<li class="" id="navbar_index"><a href="<?php echo $cfg["website"]; ?>"><i class="fa fa-home" aria-hidden="true"></i><span>首页</span></a></li>
			<li class="" id="navbar_study"><a href="?action=study"><i class="fa fa-book" aria-hidden="true"></i><span>在线学习</span></a></li>
			<?php if ($_SESSION['roleid'] == "1"): ?>
			<li class="" id="navbar_manage"><a href="?action=manage"><i class="fa fa-users" aria-hidden="true"></i><span>用户管理</span></a></li>
			<li class="" id="navbar_dangfei"><a href="?action=dangfei"><i class="fa fa-jpy" aria-hidden="true"></i><span>党费管理</span></a></li>
			<?php endif; ?>	
			<li class="" id="navbar_user"><a href="?action=user&do=home&user_id=<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-user" aria-hidden="true"></i><span>个人中心</span></a></li>
		</ul>
		</div>
	</div>
</div>

<div class="main">
<div class="container">
