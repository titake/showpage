<?php
require_once '../lib/mysql.func.php';
switch ($_POST["step"]) {
	case 'step1':
		logupStep1();
		break;
	case 'step2':
	//logup_step2_```
		break;
	case 'step3':
	//logup_step3_```
		break;
}
function logupStep1(){
	$userType = $_POST['user-type'];
	//对password加密
	$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    //对身份证号加密
	$methods = openssl_get_cipher_methods();
	//定义key和iv(iv最好是16byte)
	$key = 'titake_password';
	$iv = 'titake_iv_codeiv';
	$idnum_encrypt = openssl_encrypt($_POST['idnum'], $methods[0], $key,0,$iv);
	session_set_cookie_params(12*3600);
	session_start();
	$_SESSION['userType'] = $userType;
	$_SESSION['password'] = $password;
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['nickname'] = $_POST['nickname'];
	$_SESSION['idnum'] = $idnum_encrypt;
	switch ($userType) {
		case '驾驶员/教练员':
		echo 'logup_Step2_driver.html?userty=driver&upload=';
			break;
		case '维修工人':
		echo "logup_Step2_maintainer.html?usertype=maintainer&upload=";
			break;
		case '客运站员工':
		echo 'logup_Step2_staff.html?usertype=staff&upload=';
			break;
		case '运输公司/驾校管理人员':
		case '维护公司管理人员':
		case '客运站管理人员':
		echo "logup_Step2_comp.html";
			break;
		case "超级管理员":
		echo "logup_Step2_super.html";
			break;
		case '乘客/学员':
			$mysqli = connectDb();
			$sql = "insert tb_users values('{$_SESSION["email"]}','{$_SESSION["password"]}','{$_SESSION["userType"]}');";
			$result = $mysqli->query($sql);
			if ($result ==false) {
				echo '{"success":false,"reason":"insert tb_users '.$mysqli->errno." is ".$mysqli->error.'"}';
			}else{
				$sql = "insert tb_passengers values('{$_POST["nickname"]}','{$_SESSION["email"]}');";
				$result = $mysqli->query($sql);
				if ($result==false) {
					echo '{"success":false,"reason":"insert tb_passengers(staff)'.$mysqli->errno." is ".$mysqli->error.'"}';
				}else{
					echo 'logup_Step2_passenger.html';
					if (!isset($_COOKIE["user_email"])) {
						setcookie("user_email",$_SESSION["email"],strtotime('+3 months'));
					}else{
						setcookie("user_email","",time()-1);
					}
				}
			}
			$mysqli->close();
			break;
	}
}
