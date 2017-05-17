<?php
require_once("../lib/mysql.func.php");
header("Content-Type:charset=utf-8;");
switch ($_POST['flag']) {
	case 'update':
		$mysqli = connectDb();
		$sql = $_POST['sql'];
		$result = $mysqli->query($sql);
		if ($result==true) {
			echo "更新成功";
		}else{
			echo "更新失败：".$mysqli->errno.$mysqli->error;
		}
		break;
	case 'update_two':
		$mysqli = connectDb();
		$sql = $_POST["sql1"];
		$result= $mysqli->query($sql);
		if ($result==true) {
			$sql = $_POST["sql2"];
			$result=$mysqli->query($sql);
			if ($result==true) {
				echo "更新成功";
			}else{
				echo "更新失败 sql2".$mysqli->errno.$mysqli->error;
			}
		}else{
			echo "更新失败 sql1".$mysqli->errno.$mysqli->error;
		}
		break;
	case 'update_session':
		session_set_cookie_params(6*3600);
		session_start();
		$where = $_SESSION["{$_POST['sessionName']}"];
		$sql =$_POST["sql"]."'{$where}';";
		$mysqli = connectDb();
		$result = $mysqli->query($sql);
		if ($result==true) {
			echo "更新成功";
		}else{
			echo "更新失败：".$mysqli->errno.$mysqli->error;
		}
		break;
	default:
		break;
}
$mysqli->close();