<?php
switch ($_GET['flag']) {
	case 'set':
		setcookie("{$_GET['name']}","{$_GET['value']}",$_GET['expire']);
		break;
	case 'delete':
		$name = $_GET['name'];
		setcookie("{$_GET['name']}",'',time()-1);
		break;
	
}
