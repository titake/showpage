<?php
//连接指定数据库
function connectDb($dbName)
{
	$mysqli = new mysqli("localhost","root","123456",$dbName);
	if ($mysqli->connect_errno) {
		die("数据库连接失败，原因：".$mysqli->connect_error);
	}
}

//向指定数据库中插入记录，$values是个数组
function insertItem($tbName,$values){
	$value = implode("','", $valuse);
	$value = "'".$value."'";
	$sql = "INSERT $tbName VALUES($value);";
}