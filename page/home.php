<?php
	include("head.php");
	include("nav.php");
?>

<script>
$("#home").addClass("active");
</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;个人档案
	</div>
	<div class="panel-body">

	<strong>注：目前为测试版全信息展示，正式版中有些信息会被隐藏<br /></strong>
	
	<?php echo "<p class='sqlinfo'>SQL：{$sql}</p>"; ?>

	<form class="form-horizontal" role="form">
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="id">编号</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="id" value="<?php echo checkEmpty($db->getValue("id")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="username">登陆名(学号)</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="username" value="<?php echo checkEmpty($db->getValue("username")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="user_id">登录名MD5</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="user_id" value="<?php echo checkEmpty($db->getValue("user_id")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="name">姓名(没什么用)</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="name" value="<?php echo checkEmpty($db->getValue("name")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="password">密码MD5</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="password" value="<?php echo checkEmpty($db->getValue("password")); ?>" readonly="readonly" />
			</div>
		</div> 
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
				<input type="date" class="form-control" id="birthday" value="<?php echo checkEmpty($db->getValue("birthday")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="idcard">身份证号</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="idcard" value="<?php echo checkEmpty($db->getValue("idcard")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="college">院校</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="college" value="<?php echo checkEmpty($db->getValue("college")); ?>" readonly="readonly" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="volk">民族</label>
			<div class="col-md-4 col-sm-6">
				<input type="text" class="form-control" id="volk" value="<?php echo checkEmpty($db->getValue("volk")); ?>" readonly="readonly" />
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
			<label class="col-md-2 col-sm-2 control-label">状态</label>
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
		<div class="form-group">
			<label class="col-md-2 col-sm-2 control-label" for="updated_at">更新时间</label>
			<div class="col-md-4 col-sm-6">
				<input type="datetime" class="form-control" id="updated_at" value="<?php echo checkEmpty($db->getValue("updated_at")); ?>" readonly="readonly" />
			</div>
		</div>
	</form>
	
	<hr />
	<strong>注：SESSION:传递信息。&nbsp;&nbsp;&nbsp;&nbsp;编号：自增字段、主键，用以区分，实际操作中作用不大。<br />
	登陆名(user_id)，username是user_id的md5值，主要在传递链接时使用以避免明文传递信息(并不是敏感或隐私信息故使用 $_GTE 传递)<br />
	姓名：您的大名。<br />
	密码：MD5 加密保存。验证时MD5值比较。忘记密码时，不能找回密码，只能重置密码。<br />
	性别、生日、身份证、院校、民族 属于个人信息。能否为空以及默认值详见数据库.sql<br />
	手机、邮箱、住址 属于联系方式，需要注意的是邮箱比填，后续会添加邮件通知功能。(催缴党费、个人/群邮件通知、重大新闻)<br />
	状态：你能看到这个界面就表示你的账号状态正常。<br />
	注册时间：datetime类型(区别于生日的date类型)，数值由PHP系统自动生成，Y-m-d H-i-s格式。<br />
	更新时间：个人信息/密码最后一次修改时间，类型同上。<br />
	2017年12月7日数据库更新：roleid 类型bit(1) -> int(1) 兼容在线数据库读取，防止出现乱码。(虽然多使用了几个bit)
	</strong>
</div>
</div>
</div>
</div>

<?php
	include("foot.php");
?>
