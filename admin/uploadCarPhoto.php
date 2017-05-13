<?php
$destination_folder = "../uploadImg/";
if(!file_exists($destination_folder)){
	mkdir($destination_folder);
}
$file = explode(".",$_FILES["photo_driver"]["name"]);
$filename = md5(uniqid($file[0],true)).".".$file[1];
session_start();
if(move_uploaded_file($_FILES["photo_driver"]["tmp_name"],$destination_folder.$filename)){
	echo "<script language='javascript'>window.location='../scripts/add_car.html?cartype=".$_SESSION["cartype"]."&upload={$filename}&edit=".$_SESSION["edit"]."&plate_num=".$_SESSION["plate_num"]."';</script>";
}else{
	echo "<script language='javascript'>window.location='../scripts/add_car.html?cartype=".$_SESSION["cartype"]."&upload=failed&edit=".$_SESSION["edit"]."&plate_num=".$_SESSION["plate_num"]."';</script>";
}
