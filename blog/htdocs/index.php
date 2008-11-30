<?php
include("../config.php");
/*
 * Front controller
 */
foreach($url_mappings as $pattern => $view){
	$pattern = '/'.str_replace('/','\\/',substr($pattern,0,strlen($pattern))).'/';
	if(preg_match($pattern, $_SERVER['REQUEST_URI'],$result)){
	    $arr = explode('::',$view);
	    $result[1] = isset($result[1]) ? $result[1] : array();
	    $result[2] = isset($result[2]) ? $result[2] : array();
		call_user_func($arr,$result[1],$result[2]);
		exit();
	}
}

echo "something wrong!";