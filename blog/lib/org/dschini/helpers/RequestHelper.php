<?php
/*
 * RequestHelper
 */
class RequestHelper
{
	public $right;
	public $controller;
	public $action;
	public $params;
	
	public function __construct($_request,$params){
		$this->right = pow(2,$_request['right']);
		$this->controller = $_request['controller'];
		$this->action = $_request['action'];
		$this->params = $this->numKeysOnly($params);
		$GLOBALS['helpers']['request'] = $this;
	}
	
	public function isController( $name ){
		if($GLOBALS['helpers']['request']->controller == $name){
			return true;
		}
		return false;
	}

	public function isAction( $name ){
		if($GLOBALS['helpers']['request']->action == $name){
			return true;
		}
		return false;
	}
	
	private static function numKeysOnly($params){
		$ret = array();
		for($i=1; $i<count($params); $i++){
			if(isset($params[$i])){
				$ret[] = $params[$i];
			}
		}
	    return $ret;
	}
	
	public static function getInstance(){
		if(!isset($GLOBALS['helpers']['request'])){
			echo "RequestHelper is null";
			exit();
		}
		return $GLOBALS['helpers']['request'];
	}
}