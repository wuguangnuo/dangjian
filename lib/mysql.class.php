<?php
//====================================================
//		FileName: mysql.class.php
//		Summary:  mysql数据库类
//====================================================

//make sure all sytax error are reported.
class mysql
{
	var $host		= "";			//mysql主机名
	var $user		= "";			//mysql用户名
	var $pwd		= "";			//mysql密码
	var $dbName		= "";			//mysql数据库名称
	var $linkID		= 0;			//用来保存连接ID
	var $queryID	= 0;			//用来保存查询ID
	var $fetchMode	= MYSQL_ASSOC;	//取记录时的模式
	var $queryTimes	= 0;			//保存查询的次数
	var $errno		= 0;			//mysql出错代号
	var $error		= "";			//mysql出错信息
	var $record		= array();		//一条记录数组

	//======================================
	// 函数: mysql()
	// 功能: 构造函数
	// 参数: 参数类的变量定义
	// 说明: 构造函数将自动连接数据库
	//      如果想手动连接去掉连接函数
	//======================================
	function mysql($host,$user,$pwd,$dbName)
	{	if(empty($host) || empty($user) || empty($dbName))
			$this->halt("数据库主机地址,用户名或数据库名称不完全,请检查!");
		$this->host    = $host;
		$this->user    = $user;
		$this->pwd     = $pwd;
		$this->dbName  = $dbName;
		$this->connect();//设置为自动连接
	}
	//======================================
	// 函数: connect($host,$user,$pwd,$dbName)
	// 功能: 连接数据库
	// 参数: $host 主机名, $user 用户名
	// 参数: $pwd 密码, $dbName 数据库名称
	// 返回: 0:失败
	// 说明: 默认使用类中变量的初始值
	//======================================
	function connect($host = "", $user = "", $pwd = "", $dbName = "")
	{
		if ("" == $host)
			$host = $this->host;
		if ("" == $user)
			$user = $this->user;
		if ("" == $pwd)
			$pwd = $this->pwd;
		if ("" == $dbName)
			$dbName = $this->dbName;
		//now connect to the database
		$this->linkID = mysql_connect($host, $user, $pwd);
		if (!$this->linkID)
		{
			$this->halt();
			return 0;
		}
		if (!mysql_select_db($dbName, $this->linkID))
		{
			$this->halt();
			return 0;
		}
		mysql_query("set names utf8");
		return $this->linkID;
	}
	//======================================
	// 函数: query($sql)
	// 功能: 数据查询
	// 参数: $sql 要查询的SQL语句
	// 返回: 0:失败
	//======================================
	function query($sql)
	{
		$this->queryTimes++;
		$this->queryID = mysql_query($sql, $this->linkID);
		if (!$this->queryID)
		{	
			$this->halt();
			return 0;
		}
		return $this->queryID;
	}
	//======================================
	// 函数: setFetchMode($mode)
	// 功能: 设置取得记录的模式
	// 参数: $mode 模式 MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH
	// 返回: 0:失败
	//======================================
	function setFetchMode($mode)
	{
		if ($mode == MYSQL_ASSOC || $mode == MYSQL_NUM || $mode == MYSQL_BOTH) 
		{
			$this->fetchMode = $mode;
			return 1;
		}
		else
		{
			$this->halt("错误的模式.");
			return 0;
		}
		
	}
	//======================================
	// 函数: fetchRow()
	// 功能: 从记录集中取出一条记录
	// 返回: 0: 出错 record: 一条记录
	//======================================
	function fetchRow()
	{
		$this->record = mysql_fetch_array($this->queryID,$this->fetchMode);
		return $this->record;
	}
	//======================================
	// 函数: fetchAll()
	// 功能: 从记录集中取出所有记录
	// 返回: 记录集数组
	//======================================
	function fetchAll()
	{
		$arr = array();
		while($this->record = mysql_fetch_array($this->queryID,$this->fetchMode))
		{
			$arr[] = $this->record;
		}
		mysql_free_result($this->queryID);
		return $arr;
	}
	//======================================
	// 函数: getValue()
	// 功能: 返回记录中指定字段的数据
	// 参数: $field 字段名或字段索引
	// 返回: 指定字段的值
	//======================================
	function getValue($field)
	{
		return $this->record[$field];
	}
	//======================================
	// 函数: affectedRows()
	// 功能: 返回影响的记录数
	//======================================
	function affectedRows()
	{
		return mysql_affected_rows($this->linkID);
	}
	//======================================
	// 函数: recordCount()
	// 功能: 返回查询记录的总数
	// 参数: 无
	// 返回: 记录总数
	//======================================
	function recordCount()
	{
		return mysql_num_rows($this->queryID);
	}
	//======================================
	// 函数: getQueryTimes()
	// 功能: 返回查询的次数
	// 参数: 无
	// 返回: 查询的次数
	//======================================
	function getQueryTimes()
	{
		return $this->queryTimes;
	}
	//======================================
	// 函数: getVersion()
	// 功能: 返回mysql的版本
	// 参数: 无
	//======================================
	function getVersion() 
	{
		$this->query("select version() as ver");
		$this->fetchRow();
		return $this->getValue("ver");
	}
	//======================================
	// 函数: getDBSize($dbName, $tblPrefix=null)
	// 功能: 返回数据库占用空间大小
	// 参数: $dbName 数据库名
	// 参数: $tblPrefix 表的前缀,可选
	//======================================
	function getDBSize($dbName, $tblPrefix=null) 
	{
		$sql = "SHOW TABLE STATUS FROM " . $dbName;
		if($tblPrefix != null) {
			$sql .= " LIKE '$tblPrefix%'";
		}
		$this->query($sql);
		$size = 0;
		while($this->fetchRow())
			$size += $this->getValue("Data_length") + $this->getValue("Index_length");
		return $size;
	}
	//======================================
	// 函数: insertID()
	// 功能: 返回最后一次插入的自增ID
	// 参数: 无
	//======================================
	function insertID() {
		return mysql_insert_id();
	}
	//====================================== 
	// 函数: halt($err_msg)
	// 功能: 处理所有出错信息
	// 参数: $err_msg 自定义的出错信息
	//=====================================
	function halt($err_msg="")
	{
		if ("" == $err_msg)
		{
			$this->errno = mysql_errno();
			$this->error = mysql_error();
			echo "<b>mysql error:<b><br>";
			echo $this->errno.":".$this->error."<br>";
			exit;
		}
		else
		{
			echo "<b>mysql error:<b><br>";
			echo $err_msg."<br>";
			exit;
		}
	}
}
?>