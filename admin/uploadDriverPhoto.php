<?php
$destination_folder = "../uploadImg/";
if(!file_exists($destination_folder)){
	mkdir($destination_folder);
}
session_start();
$url_search = $_SESSION["url_search"];
$urls = explode("&",$url_search);
$file = explode(".",$_FILES["photo_driver"]["name"]);
$filename = md5(uniqid($file[0],true)).".".$file[1];
if(move_uploaded_file($_FILES["photo_driver"]["tmp_name"],$destination_folder.$filename)){
	print_r($urls);
	$url_upload = "&upload={$filename}";
	$url = "<script language='javascript'>window.location='../scripts/logup_Step2_driver.html".$urls[0].$url_upload;
	if (count($urls,0)==3) {
		$url = $url."&".$urls[2];
	}
	$url.="';</script>";
	echo $url;
}else{
	$url_upload = "&upload=failed";
	$url = "<script language='javascript'>window.location='../scripts/logup_Step2_driver.html".$urls[0].$url_upload;
	if (count($urls,0)==3) {
		$url = $url."&".$urls[2];
	}
	$url.="';</script>";
	echo $url;
}


//留着，回来加个cookie，通过cookie判断usertype
//