<?php
require_once("../lib/mysql.func.php");
switch ($_GET["flag"]) {
	case 'mainComp_one':
		$tbName = "tb_maincomp";
		$infoNames = 'registe_address,charge_person,charge_phone,scope,main_classify,star';
		$where = 'name="'.$_GET["compName"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transComp_one':
		$tbName = "tb_transcomp";
		$infoNames = 'registe_address,charge_person,charge_phone,scope,star';
		$where = 'name="'.$_GET["compName"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transport_one':
		$tbName = "tb_transport";
		$infoNames = 'location,charge_person,charge_phone,star';
		$where = 'name="'.$_GET["compName"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'userType':
		$tbName = "tb_users";
		$infoNames = "userType";
		$where = 'email="'.$_GET["user_email"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
}
//查询仅得一条结果
function getInfo($tbName,$infoNames,$where){
	$mysqli = connectDb();
	$sql = "select $infoNames from $tbName where $where";
	$result = $mysqli->query($sql);
	if ($result!=false) {
		$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
		$info = "{";
		foreach ($results[0] as $key => $value) {
			$info = $info.'"'.$key.'":"'.$value.'",';
		}
		$info = mb_substr($info, 0,-1);
		$info .= "}";
		return $info;
	}else{
		return '{"failed":true,"reason":"}'.$mysqli->errno.'is '.$mysqli->error.'"}';
	}
	
}

//在指定数据库中指定位置的指定数据,$result中有多条数据
function getInfos($tbName,$infoNames,$where){
	$mysqli = connectDb();
	$sql = "select $infoNames from $tbName where $where";
	$result = $mysqli->query($sql);
	$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
	$info = "";
	for ($i=0; $i <count($results,0) ; $i++) { 
		$info = $info."(";
		foreach ($results[$i] as $key => $value) {
			$info = $info.$key.":".$value.",";
		}
		$info = mb_substr($info, 0,-1);
		$info .= ")";
	}
	return $info;
}