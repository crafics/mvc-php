<?php
/* The Front controller
*
* @author	Manfred Weber
* @date		20/11/08
* @see		http://manfred.dschini.org/
*/

include("../config.php");


/* Some more information regarding this front controller can be found here:
 * http://www.reiersol.com/blog/1_php_in_action/archive/172_the_one-line_web_framework.html
 * 
 * This is developed to my best knowledge! You are warned ;)
 */

include("../urls.php");

/*
 * Loop through the urls!
 */
foreach($urls as $pattern => $definition){
	
	/* Replace backslashes with slashes */
	$pattern = '/'.str_replace('/','\\/',substr($pattern,0,strlen($pattern))).'/';
	$params = array();
	
	/* Find the matching regex */
	if(preg_match($pattern, $_SERVER['REQUEST_URI'],$params_match)){
		
		/* Before Request Execution !!!
		 * 
		 * Put stuff here that you want to get done BEFORE calling the
		 * matching controller action! 
		 */
		RequestHelper::getInstance()->setController($definition['controller']);
		RequestHelper::getInstance()->setAction($definition['action']);
		RequestHelper::getInstance()->setRequiredRight($definition['right']);
		RequestHelper::getInstance()->setParams($params_match);
		
		/* check user rights */
		if( RequestHelper::getInstance()->userHasRequiredRight() ) { 
			
			/* Execution the matching controller action.
			 */
			$ok = call_user_func_array(
				array(
					RequestHelper::getInstance()->controller,
					RequestHelper::getInstance()->action
				),
				RequestHelper::getInstance()->params
			);
			
			if(!$ok){
				
				/* Before Request Execution !!!
				 * 
				 * Put stuff here that you want to get done BEFORE calling the
				 * matching controller action! 
				 */
				
				// do something
			}
			exit();
		}

		/* Execution failed function.
		 * 
		 * Put stuff here that you want to get done AFTER calling the
		 * matching controller action! 
		 */
		RequestHelper::redirect('/blog/admin/login/?next='.$_SERVER['REQUEST_URI']);
	}
}
/* No controller or action found */
RequestHelper::redirect('/');

