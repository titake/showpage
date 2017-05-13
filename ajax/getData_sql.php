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
	case 'transComps_person':
		$tbName = "tb_transcomp";
		$infoNames = "name,registe_address";
		$where = 'scope like "%person%"';
		$info = getInfos($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transComps_good':
		$tbName = "tb_transcomp";
		$infoNames = "name,registe_address";
		$where = 'scope like "%good%"';
		$info = getInfos($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transComps_teach':
		$tbName = "tb_transcomp";
		$infoNames = "name,registe_address";
		$where = 'scope like "%teach%"';
		$info = getInfos($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transComp_one_edit':
		$tbName = "tb_transcomp";
		$infoNames = 'registe_money,registe_address,registe_date,registe_valid_date,corporation,corporation_phone,charge_person,charge_phone,qualification,scope,star';
		$where = 'name="'.$_GET["compName"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'mainComps':
		$tbName = "tb_maincomp";
		$infoNames = "name,registe_address";
		$where = '';
		$info = getInfos($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'mainComp_one_edit':
		$tbName = "tb_maincomp";
		$infoNames = 'registe_money,registe_address,registe_date,registe_valid_date,staff_num,corporation,corporation_phone,charge_person,charge_phone,qualification,scope,main_classify,star';
		$where = 'name="'.$_GET["compName"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transports':
		$tbName = "tb_transport";
		$infoNames = "name,location";
		$where = '';
		$info = getInfos($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'transport_one_edit':
		$tbName = "tb_transport";
		$infoNames = 'location,registe_date,registe_valid_date,charge_person,charge_phone,star';
		$where = 'name="'.$_GET["compName"].'"';
		$info = getInfo($tbName,$infoNames,$where);
		echo $info;
		break;
	case 'dosql':
		$info = doSQL($_GET["sql"]);
		echo $info;
		break;
	case 'dosql_one':
		$info = doSQL_one($_GET["sql"]);
		echo $info;
		break;
	case 'cars':
		$info = getCars($_GET["sql"]);
		echo $info;
		break;
	case 'car_one_show':
		$info = getCar_one_show($_GET["sql"]);
		echo $info;
		break;
	case 'sessionName_driver':
		getDriver_one();
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
	if (mb_strlen($where)==0) {
		$sql = "select $infoNames from $tbName";
	}else  $sql = "select $infoNames from $tbName where $where";
	$result = $mysqli->query($sql);
	if ($result!=false) {
		if ($result->num_rows>0) {
			$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
		}else{
			return '{"length":0,"reason":"not find"}';
		}
		$info = '{"length":'.count($results,0);
		for ($i=0; $i <count($results,0) ; $i++) { 
			$info = $info.',"list'.$i.'":{';
			foreach ($results[$i] as $key => $value) {
				$info = $info.'"'.$key.'":"'.$value.'",';
			}
			$info = mb_substr($info, 0,-1);
			$info .= "}";
		}
		$info.="}";
		return $info;
	}else{
		return '{"length":-2,"reson":"'.$mysqli->errno.$mysqli->error.'"}';
	}
}

//得多条结果
function doSQL($sql){
	$mysqli = connectDb();
	$result = $mysqli->query($sql);
	if ($result!=false) {
		if ($result->num_rows>0) {
			$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
		}else{
			return '{"length":0,"reason":"not find"}';
		}
		$info = '{"length":'.count($results,0);
		for ($i=0; $i <count($results,0) ; $i++) { 
			$info = $info.',"list'.$i.'":{';
			foreach ($results[$i] as $key => $value) {
				$info = $info.'"'.$key.'":"'.$value.'",';
			}
			$info = mb_substr($info, 0,-1);
			$info .= "}";
		}
		$info.="}";
		return $info;
	}else{
		return '{"length":-2,"reson":"'.$mysqli->errno.$mysqli->error.'"}';
	}
}
//得一条结果
function doSQL_one($sql){
	$mysqli = connectDb();
	$result = $mysqli->query($sql);
	if ($result!=false) {
		$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
		$info = "{";
		foreach ($results[0] as $key => $value) {
			$info = $info.'"'.$key.'":"'.$value.'",';
		}
		$info = $info.'"failed":false}';
		return $info;
	}else{
		return '{"failed":true,"reason":"}'.$mysqli->errno.'is '.$mysqli->error.'"}';
	}
}
function getCar_one_show($sql){
	$mysqli = connectDb();
	$result = $mysqli->query($sql);
	if ($result!=false) {
		$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
		$info = "{";
		foreach ($results[0] as $key => $value) {
			if (strpos($key,"driver")!==false) {
				if (mb_strlen($value)>0) {
					$value1 = substr($value, 0,3);
					$value2 = substr($value, -3);
					$info = $info.'"'.$key.'":"'.$value1.'************'.$value2.'",';
				}else{
					$info = $info.'"'.$key.'":"empty",';
				}
			}else{
				$info = $info.'"'.$key.'":"'.$value.'",';
			}
		}
		$info=$info.'"failed":false}';
		return $info;
	}else{
		return '{"failed":true,"reason":"}'.$mysqli->errno.'is '.$mysqli->error.'"}';
	}
}
function getCars($sql){
	$mysqli = connectDb();
	$result = $mysqli->query($sql);
	if ($result!=false) {
		if ($result->num_rows>0) {
			$results = $result->fetch_all(MYSQLI_ASSOC);  //列名+值
		}else{
			return '{"length":0,"reason":"not find"}';
		}
		$info = '{"length":'.count($results,0);
		for ($i=0; $i <count($results,0) ; $i++) { 
			$info = $info.',"list'.$i.'":{';
			foreach ($results[$i] as $key => $value) {
				if (strpos($key,"driver")!==false) {
					if (mb_strlen($value)>0) {
						$value1 = substr($value, 0,3);
						$value2 = substr($value, -3);
						$info = $info.'"'.$key.'":"'.$value1.'************'.$value2.'",';
					}else{
						$info = $info.'"'.$key.'":"empty",';
					}
					
				}else{
					$info = $info.'"'.$key.'":"'.$value.'",';
				}
			}
			$info = mb_substr($info, 0,-1);
			$info .= "}";
		}
		$info.="}";
		return $info;
	}else{
		return '{"length":-2,"reson":"'.$mysqli->errno.$mysqli->error.'"}';
	}
}
function getDriver_one(){
	session_start();
	$mysqli = connectDb();
	$sql = "select * from tb_driver where idcard_num='"
}
