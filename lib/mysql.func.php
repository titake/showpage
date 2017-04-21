<?php
//连接指定数据库
function connectDb($dbName="titake")
{
	$mysqli = new mysqli("localhost","root","123456","titake");
	if ($mysqli->connect_errno) {
		die("$dbName 数据库连接失败，原因：".$mysqli->connect_error);
	}
	return $mysqli;
}

//插入记录，$values是个一维数组
function insertItem($mysqli,$tbName,$values){
	$value = implode("','", $valuse);
	$value = "'".$value."'";
	$sql = "INSERT $tbName VALUES($value);";
	$res = $mysqli->query($sql);
	if ($res) {
		
	}else{
		echo "ERROR:".$mysqli->errno.":".$mysqli->error;
	}
}

//删除记录
function deleteItem($mysqli,$tbName,$whereCondition){
	$sql = "DELETE FROM $tbName WHERE $whereCondition;";
	$mysqli->query($sql);
}

//更改记录
//$updates为一维数组
function updateItem_char($mysqli,$tbName,$updates){
	$update = "";
	foreach ($updates as $key => $value) {
		if ($update==null) {
			$sep = "";
		}else{
			$sep = ",";
		}
		$update = $update.$sep.$key."='".$value."'";
	}
	$sql = "UPDATE {$tbName} SET {$update} ;";
	$mysqli->query($sql);
}

//查数据库
//这个判断暂时调试用，免得sql语句写错，回来改！
function fetchRes($mysqli,$sql){
	$result = $mysqli->query($sql);
	if ($result==false){
		die("sql语句写错啦！");
	}else{
		return $result;
	}
	// }elseif ($result->num_rows<=0) {
	// 	die("无匹配结果");
	// }else{
	// 	//列名+值
	// 	return $result->fetch_all(MYSQLI_ASSOC);
	// }
}