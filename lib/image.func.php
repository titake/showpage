<?php
	require_once 'string.func.php';
	function buildVerifyImage($type=3,$length=4)
	{
		$width = 100;
		$height = 28;
		$image = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($image, 255,255,255);
		imagefilledrectangle($image, 0,0, $width, $height, $white);
		$chars = buildRandString($type,$length);
		$verifyCode = 'verifyCode';
		session_start();
		$_SESSION[$verifyCode] = $chars;
		for ($i=0; $i <$length ; $i++) { 
			$randColor = imagecolorallocate($image, rand(0,200), rand(0,200),rand(0,200));
			$randlineColor = imagecolorallocate($image,rand(150,255), rand(150,255), rand(150,255));
			$fontfiles = array('AGENCYR.TTF','BuxtonSketch.ttf','calibrii.ttf','CALIST.TTF','CHILLER.TTF','comic.ttf','FREESCPT.TTF');
			echo '<br/>'.dirname(__FILE__);
			$randFont = '../fonts/'.$fontfiles[rand(0,count($fontfiles)-1)];
			echo '<br/>'.$randFont;
			$randsize = rand(20,24);
			$randangle = rand(-15,15);
			$text = substr($chars, $i,1);
			//imagettftext($image, $randsize, $randangle, 25*$i+rand(0,4), rand(20,25), $randColor, $randFont, $text);
		}
		for ($i=0; $i <40; $i++) { 
			imagesetpixel($image, mt_rand(0,$width), mt_rand(0,$height), $randColor);
		}
		for ($i=0; $i < 3; $i++) { 
			imageline($image,rand(0,$width) , rand(0,$height), rand(0,$width), rand(0,$height),$randlineColor);
		}
		header("content-type:image/gif");
		imagegif($image);
		imagedestroy($image);
	}
buildVerifyImage();