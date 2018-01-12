<?php
	include('head.php');
	include('nav.php');
?>

<script>
$("#detail_dangfei").addClass("active");
</script>

<div class="row">
	<div class="col-md-12 column">
	<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-book" aria-hidden="true"></i>&nbsp;党费情况
	</div>
	<div class="panel-body">

<form class="form-inline" action="?action=user&do=detail_dangfei" method="post" role="form">
	<div class="form-group">
		<label for="key">查询</label>
		<input type="text" name="key" class="form-control input-sm" value="<?php
			echo empty($_GET['key']) ? $_POST['key'] : $_GET['key']; 
		?>" placeholder="请输入党费名称" />&nbsp;&nbsp;&nbsp;
	</div>
	<div class="form-group">
		<label for="date1">时间区间</label>
		<input type="date" name="date1" class="form-control input-sm" value="<?php
			$temp = empty($_GET['date1']) ? $_POST['date1'] : $_GET['date1'];
			echo ($temp == "1000-01-01") ? "" : $temp;//默认值不显示
		?>" />
	</div>
	<div class="form-group">
		<label for="date2">至</label>
		<input type="date" name="date2" class="form-control input-sm" value="<?php
			$temp = empty($_GET['date2']) ? $_POST['date2'] : $_GET['date2'];
			echo ($temp == "9999-12-31") ? "" : $temp;//默认值不显示
		?>" />
	</div>
	<div class="form-group">
		<select class="form-control input-sm" name="check">
			<option value="all" <?php
				echo $_POST['check'] == "all" ? "selected" : ($_GET['check'] == "all" ? "selected" : "");
			?>>显示全部</option>
			<option value="yes" <?php
				echo $_POST['check'] == "yes" ? "selected" : ($_GET['check'] == "yes" ? "selected" : "");
			?>>查询已缴</option>
			<option value="not" <?php
				echo $_POST['check'] == "not" ? "selected" : ($_GET['check'] == "not" ? "selected" : "");
			?>>查询未缴</option>
		</select>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-sm btn-success" id="search">查询</button>
	</div>
</form>

<?php echo "<p class='sqlinfo'>SQL：{$sql}</p>"; ?>
<hr />
	<p class="ttitle">党费情况</p>

	<div class="table-responsive">
		<table class="table table-striped table-condensed table-hover">
			<thead>
				<tr>
					<th>ID(隐藏此列)</th>
					<th>名称</th>
					<th>金额￥</th>
					<th>时间</th>
					<th>详情</th>
					<th>缴纳情况</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
			if(empty($list))echo "<p>列表为空!</p>";
			else{
				foreach($list as &$row){
				echo "<tr>";
				echo "<td>" . $row['id'] ."</td>";
				echo "<td>" . $row['name'] ."</td>";
				echo "<td>" . $row['price'] ."</td>";
				echo "<td>" . $row['date'] ."</td>";
				echo "<td>" . $row['mark'] ."</td>";
				echo "<td>";
				if($row['judge'] == 0)
					echo "未缴纳";
				else
					echo "已缴纳!!!";
				echo "</td>";
				echo "</tr>\n";
				}
			}
			?>
			</tbody>
		</table>
	</div>
		<div class="showPage">
		<?php
		if($total > $showrow){//总记录数大于每页显示数，显示分页
			$page = new page($total, $showrow, $curpage, $url, 2);
			echo $page->myde_write();
		}
		?>
		</div>

</div>
</div>
</div>
</div>


<?php
	include('foot.php');
?>