<?php
$name = $_GET["name"];
if (isset($_COOKIE["{$name}"])) {
	echo '{"success":true,"value":"'.$_COOKIE["{$name}"].'"}';
}else{
	echo '{"success":false}';
}