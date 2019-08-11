<?php  
	header('content-type:text/html;charset=utf-8');
	header('Access-Control-Allow-Origin:*');
	//定义常量：值不能改变
	define('HOSTNAME','localhost');
	define('USERNAME','root');
	define('PASSWORD','');
	$conn=@mysql_connect(HOSTNAME,USERNAME,PASSWORD);
	if(!$conn){
		die('数据库链接失败:'.mysql_error());
	}

	mysql_select_db('glog');
	mysql_query('SET NAMES UTF8');

?>