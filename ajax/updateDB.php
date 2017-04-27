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
	default:
		break;
}