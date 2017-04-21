<?php
require_once '../lib/mysql.func.php';
$email = $_POST['email'];
$password = $_POST['password'];
$mysqli = connectDb("tb_users");
$sql = "SELECT password FROM tb_users WHERE email='{$email}';";
$result = fetchRes($mysqli,$sql);
if ($result->num_rows<=0) {
	echo "dologup";
}else{
	if (password_verify($password,$result->fetch_all(MYSQLI_ASSOC)[0]["password"])) {
		if (isset($_COOKIE["user_email"])) {
			echo "error";
			setcookie("user_email","",time()-1);
		}
		else{
			echo "pass";
			setcookie("user_email",$email,time()+3*30*24*3600);
		}
	}else{
		echo "error";
	}
}
$result->free();
$mysqli->close();