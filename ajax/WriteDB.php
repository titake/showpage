<?php
require_once("../lib/mysql.func.php");
header("Content-Type:charset=utf-8;");
switch ($_POST["flag"]) {
	case 'add_transport':
		addTransport();
		break;
	case 'add_transComp':
		addTranscomp();
		break;
	case 'add_maintComp':
		addMaincomp();
		break;
	case 'add_administer':
		addAdminister();
		break;
	case 'add_driver':
		addDriver();
		break;
	case 'add_driver_super':
		addDriver_super();
		break;
	case 'add_maintainer':
		addMaintainer();
		break;
	case 'add_staff':
		addStaff();
		break;
	case 'add_super':
		addSuper();
		break;
	case 'delete_transComp':
		deleteTansComp();
		break;
	case 'delete_transport':
		deleteTransport();
		break;
	case 'delete_mainComp':
		deleteMaincomp();
		break;
	case 'delete_driver':
		session_start();
		$sessionName = $_POST["sessionName"];
		$sql = "select email from tb_driver where idcard_num='{$_SESSION[$sessionName]}'";
		$mysqli = connectDb();
		$result = $mysqli->query($sql);
		if ($result==false) {
			$mysqli->close();
			echo '{"success":false,"reason:"select email from tb_driver error '.$mysqli->errno.$mysqli->error.'"}';
		}else{
			if ($result->num_rows<=0) {
				$mysqli->close();
				echo '{"success":false,"reason:"not find email from tb_driver"}';
			}else{
				$email = $result->fetch_all(MYSQLI_ASSOC)[0]["email"];
				$sql = "delete from tb_users where email='".$email."';";
				$result=$mysqli->query($sql);
				if ($result==false) {
					$mysqli->close();
					echo '{"success":false,"reason:"delete from tb_users error '.$mysqli->errno.$mysqli->error.'"}';
				}else{
					$sql = "delete from tb_driver where idcard_num='{$_SESSION[$sessionName]}'";
					$result = $mysqli->query($sql);
					if ($result ==false) {
						echo '{"success":false,"reason":"delete from tb_driver'.$mysqli->errno." is ".$mysqli->error.'"}';
					}else{
						echo '{"success":true}';
					}
					$mysqli->close();
				}
			}
		}
		break;
	case 'add_car':
		addCar();
		break;
	case 'dosql':
		doSQL($_POST["sql"]);
		break;
}
function addTransport(){
	$mysqli = connectDb();
	$sql = "insert tb_transport values('{$_POST["compName"]}','{$_POST["location"]}','{$_POST["registe_date"]}','{$_POST["registe_valid_date"]}','{$_POST["charge_person"]}','{$_POST["charge_phone"]}',{$_POST['star']});";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"'.$mysqli->errno." is ".$mysqli->error.'<end>"}';
	}else{
		echo '{"success":true}';
	}
	$mysqli->close();
}
function addTranscomp(){
	$mysqli = connectDb();
	$sql = "insert tb_transcomp values('{$_POST["compName"]}',{$_POST['registe_money']},'{$_POST["registe_address"]}','{$_POST["registe_date"]}','{$_POST["registe_valid_date"]}','{$_POST["corporation"]}','{$_POST["corporation_phone"]}','{$_POST["charge_person"]}','{$_POST["charge_phone"]}','{$_POST["qualification"]}','{$_POST["scope"]}',{$_POST['star']});";
	$result = $mysqli->query($sql);
	if ($result == false) {
		echo '{"success":false,"reason":"'.$mysqli->errno." is ".$mysqli->error.'<end>"}';
	}else{
		echo '{"success":true}';
	}
	$mysqli->close();
}
function addMaincomp(){
	$mysqli = connectDb();
	$sql = "insert tb_maincomp values('{$_POST["compName"]}',{$_POST['registe_money']},'{$_POST["registe_address"]}','{$_POST["registe_date"]}','{$_POST["registe_valid_date"]}',{$_POST['staff_num']},'{$_POST["corporation"]}','{$_POST["corporation_phone"]}','{$_POST["charge_person"]}','{$_POST["charge_phone"]}','{$_POST["scope"]}','{$_POST["qualification"]}','{$_POST["main_classify"]}',{$_POST['star']});";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"'.$mysqli->errno." is ".$mysqli->error.'<end>"}';
	}else{
		echo '{"success":true}';
	}
	$mysqli->close();
}
function addAdminister(){
	$mysqli = connectDb();
	$tbName = "";
	session_start();
	switch ($_SESSION["userType"]) {
		case '运输公司/驾校管理人员':
			$tbName = "tb_administer_compTrans";
			break;
		case '维护公司管理人员':
			$tbName = "tb_administer_compMaint";
			break;
		case '客运站管理人员':
			$tbName = "tb_administer_transport";
			break;
		case "超级管理员":
			$tbName = "tb_administer_gover";
			break;
	}
	$sql = "insert tb_users values('{$_SESSION["email"]}','{$_SESSION["password"]}','{$_SESSION["userType"]}');";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$sql = "insert {$tbName} values('{$_SESSION["idnum"]}','{$_POST['username']}','{$_POST["phonenum"]}','{$_SESSION["email"]}','{$_POST["institution"]}');";
		$result = $mysqli->query($sql);
		if ($result==false) {
			echo '{"success":false,"reason":"insert administer'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
			if (!isset($_COOKIE["user_email"])) {
				setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
			}
		}
	}
	$mysqli->close();
}
function addDriver(){
	$mysqli = connectDb();
	$tbName = "";
	session_start();
	$sql = "insert tb_users values('{$_SESSION["email"]}','{$_SESSION["password"]}','{$_SESSION["userType"]}');";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$sql = "insert tb_driver values('{$_SESSION["idnum"]}','{$_POST['username']}','{$_POST["sex"]}','{$_POST["driveLicence_id"]}','{$_POST["driverLicence_num"]}','{$_POST["date_getLice"]}','{$_POST["cars_permi"]}','{$_POST["job_permi_id"]}','{$_POST["job_permi_classify"]}','{$_POST["job_permi_date"]}','{$_SESSION["email"]}','{$_POST["phonenum"]}','{$_POST["address"]}','{$_POST["picture"]}',{$_POST["ifblock"]},{$_POST["star_polite"]},{$_POST["star_safe"]},{$_POST["star_law"]},{$_POST["star_honest"]},{$_POST["star_server"]});";
		$result = $mysqli->query($sql);
		if ($result==false) {
			echo '{"success":false,"reason":"insert administer'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
			if (!isset($_COOKIE["user_email"])) {
				setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
			}
		}
	}
	$mysqli->close();
}
function addDriver_super(){
	$mysqli = connectDb();
	$idcard_num = $_POST["idcard_num"];
	$methods = openssl_get_cipher_methods();  
	$key1 = 'titake_password';
	$iv = 'titake_iv_codeiv';
	$idnum_encrypt = openssl_encrypt($idcard_num, $methods[0], $key1,0,$iv);
	$password = password_hash("123456",PASSWORD_DEFAULT);
	$sql = "insert tb_users values('{$_POST["email"]}','{$password}','驾驶员/教练员');";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$sql = "insert tb_driver values('{$idnum_encrypt}','{$_POST['username']}','{$_POST["sex"]}','{$_POST["driveLicence_id"]}','{$_POST["driverLicence_num"]}','{$_POST["date_getLice"]}','{$_POST["cars_permi"]}','{$_POST["job_permi_id"]}','{$_POST["job_permi_classify"]}','{$_POST["job_permi_date"]}','{$_POST["email"]}','{$_POST["phonenum"]}','{$_POST["address"]}','{$_POST["picture"]}',{$_POST["ifblock"]},{$_POST["star_polite"]},{$_POST["star_safe"]},{$_POST["star_law"]},{$_POST["star_honest"]},{$_POST["star_server"]});";
		$result = $mysqli->query($sql);
		if ($result==false) {
			echo '{"success":false,"reason":"insert administer'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
			if (!isset($_COOKIE["user_email"])) {
				setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
			}
		}
	}
	$mysqli->close();
}
function addMaintainer(){
	$mysqli = connectDb();
	$tbName = "";
	session_start();
	$sql = "insert tb_users values('{$_SESSION["email"]}','{$_SESSION["password"]}','{$_SESSION["userType"]}');";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$sql = "insert tb_maintainers values('{$_POST["name"]}','{$_SESSION["idnum"]}','{$_POST["sex"]}','{$_SESSION["email"]}','{$_POST["phonenum"]}','{$_POST["picture"]}','{$_POST["companyName"]}',{$_POST["star"]});";
		$result = $mysqli->query($sql);
		if ($result==false) {
			echo '{"success":false,"reason":"insert tb_maintainer'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
			if (!isset($_COOKIE["user_email"])) {
				setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
			}
		}
	}
	$mysqli->close();
}
function addStaff(){
	$mysqli = connectDb();
	$tbName = "";
	session_start();
	$sql = "insert tb_users values('{$_SESSION["email"]}','{$_SESSION["password"]}','{$_SESSION["userType"]}');";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$sql = "insert tb_others values('{$_POST["name"]}','{$_SESSION["idnum"]}','{$_POST["sex"]}','{$_SESSION["email"]}','{$_POST["phonenum"]}','{$_POST["picture"]}','{$_POST["companyName"]}',{$_POST["star"]});";
		$result = $mysqli->query($sql);
		if ($result==false) {
			echo '{"success":false,"reason":"insert tb_others(staff)'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
			if (!isset($_COOKIE["user_email"])) {
				setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
			}
		}
	}
	$mysqli->close();
}
function addSuper(){
	$mysqli = connectDb();
	$tbName = "";
	session_start();
	$sql = "insert tb_users values('{$_SESSION["email"]}','{$_SESSION["password"]}','{$_SESSION["userType"]}');";
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$sql = "insert tb_administer_gover values('{$_SESSION["idnum"]}','{$_POST["username"]}','{$_POST["phonenum"]}','{$_SESSION["email"]}','{$_POST["institution"]}');";
		$result = $mysqli->query($sql);
		if ($result==false) {
			echo '{"success":false,"reason":"insert tb_administer_gover(super)'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
			if (!isset($_COOKIE["user_email"])) {
				setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
			}
		}
	}
	$mysqli->close();
}
function deleteTansComp(){
	$mysqli = connectDb();
	$sql = "delete from tb_transcomp where name='{$_POST["name"]}'";
	$result = $mysqli->query($sql);
	if ($result==true) {
		echo "删除成功";
	}else{
		echo "删除失败".$mysqli->errno.$mysqli->error;
	}
	$mysqli->close();
}
function deleteTransport(){
	$mysqli = connectDb();
	$sql = "delete from tb_transport where name='{$_POST["name"]}'";
	$result = $mysqli->query($sql);
	if ($result==true) {
		echo "删除成功";
	}else{
		echo "删除失败".$mysqli->errno.$mysqli->error;
	}
	$mysqli->close();
}
function deleteMaincomp(){
	$mysqli = connectDb();
	$sql = "delete from tb_maincomp where name='{$_POST["name"]}'";
	$result = $mysqli->query($sql);
	if ($result==true) {
		echo "删除成功";
	}else{
		echo "删除失败".$mysqli->errno.$mysqli->error;
	}
	$mysqli->close();
}
function addCar(){
	$mysqli = connectDb();
	$result = $mysqli->query($_POST["sqlCar"]);
	if ($result ==false) {
		echo '{"success":false,"reason":"insert tb_car '.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		$result = $mysqli->query($_POST["sqlInsur"]);
		if ($result==false) {
			echo '{"success":false,"reason":"insert tb_insur'.$mysqli->errno." is ".$mysqli->error.'"}';
		}else{
			echo '{"success":true}';
		}
	}
	$mysqli->close();
}
function doSQL($sql){
	$mysqli = connectDb();
	$result = $mysqli->query($sql);
	if ($result ==false) {
		echo '{"success":false,"reason":"'.$mysqli->errno." is ".$mysqli->error.'"}';
	}else{
		echo '{"success":true}';
	}
	$mysqli->close();
}