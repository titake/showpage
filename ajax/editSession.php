<?php
session_start();
switch ($_GET["flag"]) {
	case 'set':
		$key = $_GET['name'];
		$_SESSION["{$key}"]=$_GET["{$key}"];
		break;
	case 'set_car':
		$_SESSION["cartype"]=$_GET["cartype"];
		$_SESSION["edit"]=$_GET["edit"];
		$_SESSION["plate_num"]=$_GET["plate_num"];
		break;
}