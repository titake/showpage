<?php
$destination_folder = "../uploadImg/";
if(!file_exists($destination_folder)){
	mkdir($destination_folder);
}
$file = explode(".",$_FILES["photo_driver"]["name"]);
$filename = md5(uniqid($file[0],true)).".".$file[1];
if(move_uploaded_file($_FILES["photo_driver"]["tmp_name"],$destination_folder.$filename)){
	echo "<script language='javascript'>window.location='../scripts/logup_Step2_staff.html?usertype=&upload={$filename}';</script>";
}else{
	echo '<script language="javascript">window.location="../scripts/logup_Step2_staff.html?usertype=&upload=failed";</script>';
}
//留着，回来加个cookie，通过cookie判断usertype