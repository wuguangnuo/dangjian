<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $cfg["webtitle"]; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
				<a href="?action=user&do=user_profile&user_id=<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;<?php echo $_SESSION['username']?$_SESSION['username']:"未登录"; ?></a>
			</li>
			<li class="dropdown dropdown-split-right hidden-xs">
				<a href="" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-cog" aria-hidden="true"></i>&nbsp;操&nbsp;作&nbsp;
					<i class="fa fa-caret-down" aria-hidden="true"></i>
				</a>
				<ul class="dropdown-menu pull-right">
					<li><a href="<?php echo $_SESSION['username']?"?action=user&do=logout":""; ?>"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;注&nbsp;销&nbsp;</a></li>
					<li><a href="http://wuguangnuo.cn/index.php" target="_blank"><i class="fa fa-question" aria-hidden="true"></i>&nbsp;帮&nbsp;助&nbsp;</a></li>
				</ul>
			</li>
			<li class="hidden-lg hidden-md hidden-sm"><a href="<?php echo $_SESSION['username']?"?action=user&do=logout":""; ?>"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;注&nbsp;销&nbsp;</a></li>
			<li class="hidden-lg hidden-md hidden-sm"><a href="http://wuguangnuo.cn/index.php" target="_blank"><i class="fa fa-question" aria-hidden="true"></i>&nbsp;帮&nbsp;助&nbsp;</a></li>
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
			<li class="" id="navbar_dangwu"><a href="?action=dangwu&do=dangwu_judge"><i class="fa" aria-hidden="true"><img src="img/danghui.png" width="19" height="19"></i><span>党务工作</span></a></li>
			<?php if ($_SESSION['roleid'] == "1"): ?>
			<li class="" id="navbar_manage"><a href="?action=manage&do=manage_user"><i class="fa fa-users" aria-hidden="true"></i><span>管理中心</span></a></li>
			<?php endif; ?>	
			<li class="" id="navbar_user"><a href="?action=user&do=user_profile&user_id=<?php echo $_SESSION['user_id']; ?>"><i class="fa fa-user" aria-hidden="true"></i><span>个人中心</span></a></li>
		</ul>
		</div>
	</div>
</div>

<script>
$("#navbar_index").addClass("active");
</script>

<style>
pre {
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
<iframe src="zzb.html" width="100%" height="600px"></iframe>
<?php
	include('foot.php');
?>
</body>