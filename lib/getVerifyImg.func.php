<?php
function getRandString($type = 3,$length=4){
	switch ($type) {
		case 1:
			$chars = implode('',range(0,9));
			break;
		case 2:
			$chars = implode('',array_merge(range('A','Z'),range('a', 'z')));
			break;
		case 3:
			$chars =implode('',array_merge(range(1,9),range('A','Z'),range('a', 'z')));
			break;
		default:
			exit('输入无效');
			break;
	}
	if (strlen($chars)<$length) {
		exit("长度不够");
	}
	$chars = str_shuffle($chars);
	return substr($chars, 0,$length);
}

function getVerifyImg($type=3,$length=4){
	$image = imagecreatetruecolor(100, 30);
	$white = imagecolorallocate($image,255, 255,255);
	imagefilledrectangle($image, 0,0,100,30, $white);
	$chars = getRandString(3,4);
	session_start();
	$_SESSION['verifyCode'] = $chars;
	$fontfiles=array('../fonts/AGENCYR.TTF','../fonts/BuxtonSketch.ttf','../fonts/calibrii.ttf','../fonts/CALIST.TTF','../fonts/CHILLER.TTF','../fonts/comic.ttf','../fonts/FREESCPT.TTF');
	for ($i=0; $i <$length ; $i++) { 
		$randcolor = imagecolorallocate($image, rand(0,150), rand(0,150), rand(0,150));
		$randsize = rand(22,26);
		$randangle = rand(-25,15);
		imagettftext($image, $randsize, $randangle, 25*$i+rand(0,3), rand(24,28), $randcolor, $fontfiles[rand(0,count($fontfiles)-1)], substr($chars,$i,1));
	}
	$randcolor_other = imagecolorallocate($image, rand(150,255), rand(150,255),rand(150,255));
	for ($i=0; $i <30 ; $i++) { 
		imagesetpixel($image, rand(0,100), rand(0,30), $randcolor_other);
	}
	for ($i=0; $i <3 ; $i++) { 
		imageline($image, rand(0,100), rand(0,30), rand(0,100), rand(0,30), $randcolor_other);
	}
	// header("Content-type: image/png");
	header("content-type:image/png");
	imagepng($image);
	imagedestroy($image);
}
getVerifyImg();