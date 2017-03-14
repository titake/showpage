<?php
//session_start();
//require_once'lib/image.func.php';
//require 'lib/string.func.php';
//__FILE__是魔术常量，为当前php的目录+文件名
//dirname()获取目录
define("ROOT", dirname(__FILE__));
set_include_path('.'.PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT."/core".PATH_SEPARATOR.get_include_path());
echo get_include_path();
require_once 'image.func.php';
require_once 'string.func.php';
//buildVerifyImage();