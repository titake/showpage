<?php
	function buildRandString($type=3,$length=4){
		if ($type==1) {
			//range(start,end)得到一个从start到end顺序排列的的数组
			//implode是将一个以为数组的值连接为一个字符串，第一个参数是指定的字符串的分隔符
			$chars = implode("",range(0, 9)); 
		}elseif ($type==2) {
			//array_merge 融合多个数组为一个数组
			$chars = implode("",array_merge(range('A','Z'),range('a', 'z')));
		}elseif ($type == 3) {
			$chars =  implode("", array_merge(range(0, 9),range('a','z'),range('A','Z')));
		}
		if ($length>strlen($chars)) {
			exit("长度不足");
		}
		$chars = str_shuffle($chars);
		return substr($chars, 0,$length);
	}