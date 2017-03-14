<?php
$user_emailPhone = $_POST['user_emailPhone'];
$password = $_POST['password'];
$verifyCode = $_POST['verifyCode'];
session_start();
if (strtolower($verifyCode)==strtolower($_SESSION['verifyCode'])) {
	echo "true";	
}else{
	echo "flase";
}