<script>
$("#navbar_user").addClass("active");
</script>

<ul class="nav nav-tabs">
	<li id="home"><a href="?action=user&do=home&user_id=<?php echo $_SESSION['user_id']; ?>">个人资料</a></li>
	<li id="edit_profile"><a href="?action=user&do=edit_profile&user_id=<?php echo $_SESSION['user_id']; ?>">资料修改</a></li>
	<li id="detail_dangfei"><a href="?action=user&do=detail_dangfei&user_id=<?php echo $_SESSION['user_id']; ?>">党费情况</a></li>
	<li id="modify_pwd"><a href="?action=user&do=modify_pwd&user_id=<?php echo $_SESSION['user_id']; ?>">密码修改</a></li>
</ul>	
