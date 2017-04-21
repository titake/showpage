<?php 
$verifyCode = $_GET["verifyCode"];
session_start();
if (strtolower($verifyCode)==strtolower($_SESSION['verifyCode'])) {
	echo "pass";
}else{
	echo "notPass";
}