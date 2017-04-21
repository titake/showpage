<?php
require_once '../lib/mysql.func.php';
header("Content-Type:application/json;charset=utf-8");
session_start();
if ($_GET["flag"]=="nickname") {
	//对用户名判重
	$mysqli = connectDb("tb_passengers");
	$sql = "SELECT email FROM `tb_passengers` WHERE username= '{$_GET["nickname"]}'";
	$results = fetchRes($mysqli,$sql);
	if ($results->num_rows<=0) {
		echo '{"value":"中文、数字、英文或字符，最长20位","color":"#898989","warning":false}';
	}else{
		echo '{"value":"该用户名已经被注册！","color":"#ff0000","warning":true}';
	}
}elseif ($_GET["flag"]=="email") {
	//通过email判断该用户是否已经注册
	$mysqli = connectDb("tb_users");
	$sql = "SELECT userType FROM tb_users WHERE email= '{$_GET["email"]}'";
	$results = fetchRes($mysqli,$sql);
	if ($results->num_rows<=0) {
		echo '{"exist":false}';
	}else{
		echo '{"exist":true}';
	}
}elseif ($_GET["flag"]=="idnumber") {
	//通过身份证号判断是否已经注册过
	switch ($_GET["userType"]) {
		case '驾驶员/教练员':
			$tableName = "tb_driver";
			break;
		case '维修工人':
			$tableName = "tb_maintainers";
			break;
		case '客运站员工':
			$tableName = "tb_others";
			break;
		case '运输公司/驾校管理人员':
			$tableName = "tb_administer_compTrans";
			break;
		case '维护公司管理人员':
			$tableName = "tb_administer_compMaint";
			break;
		case '客运站管理人员':
			$tableName = "tb_administer_transport";
			break;
		case '超级管理员':
			$tableName = "tb_administer_gover";
			break;
	}
	$methods = openssl_get_cipher_methods();
	$key = 'titake_password';
	$iv = 'titake_iv_codeiv';
	$idnum_encrypt = openssl_encrypt( $_GET["idnum"], $methods[0], $key,0,$iv);
	$mysqli = connectDb();
	$sql = "SELECT idcard_num FROM {$tableName} WHERE idcard_num = '{$idnum_encrypt}'";
	$results = $mysqli->query($sql);
	if ($results==false) {
		echo '{"exist":false,"reason":"'.$mysqli->errno." is ".$mysqli->error.'<end>"}';
	}else if ($results->num_rows<=0) {
		echo '{"exist":false}';
	}else{
		echo '{"exist":true}';
	}
}elseif ($_GET["flag"]=="compName") { //搜索公司是否已经注册,这里之后登录的时候加一个cookie，不然过一段时间后，服务器会忘掉session
	switch ($_SESSION["userType"]) {
		case '运输公司/驾校管理人员':
			$tableName = "tb_transcomp";
			break;
		case '维护公司管理人员':
		case '维修工人':
			$tableName = "tb_maincomp";
			break;
		case '客运站管理人员':
		case '客运站员工':
			$tableName = "tb_transport";
			break;
		case '超级管理员':
			$tableName = $_GET["compType"];
			break;
	}
	$mysqli = connectDb($tableName);
	$sql = "SELECT name FROM {$tableName} WHERE name like '%{$_GET["compName"]}%'";
	$results = fetchRes($mysqli,$sql);
	if ($results->num_rows<=0) {
		echo '{"length":0}';
	}else{
		$names = $results->fetch_all(MYSQLI_NUM);  //索引+值 
		$name = '{"length":'.$results->num_rows.',"0":"'.$names[0][0].'"';
		for ($i=1; $i <count($names,0) ; $i++) { 
			$name = $name.',"'.$i.'":"'.$names[$i][0].'"';
		}
		$name.='}';
		echo $name;
	}
}
$results->free();
$mysqli->close();
