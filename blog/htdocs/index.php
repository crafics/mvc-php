<?php
include("../config.php");

/*
 * Front controller
 */
foreach($urls as $pattern => $_request){
	$pattern = '/'.str_replace('/','\\/',substr($pattern,0,strlen($pattern))).'/';
	$params = array();
	if(preg_match($pattern, $_SERVER['REQUEST_URI'],$params_match)){
		new RequestHelper($_request,$params_match);
		if( $GLOBALS['rights'] & RequestHelper::getInstance()->right ) { 
			call_user_func_array(
				array($_request['controller'],$_request['action']),
				RequestHelper::getInstance()->params
				);
			exit();
		}
		/* call 404 page */
		echo "index.php -> create a default page!";
		exit();
	}
}

header('Location: /');