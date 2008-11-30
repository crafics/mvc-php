<?php
/*
 * TemplateHelper
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class TemplateHelper {
	
	/*
	 * renderToResponse
	 */
	public static function renderToResponse( $theme, $page, $data=array() ){
		foreach($data AS $var => $value){
			$$var = $value;
		}
		if(!@include_once( $theme.$page ) ) {
			echo "Error: [".$theme.$page."] -> TemplateHelper does not exist";
			return;
		}
	}
	
	/*
	 * redirect
	 */
	public static function redirect( $target ){
		header("Location: ".$target);
		exit();
	}
	
	/*
	 * isPost
	 */
	public static function isPost() {
		if(isset($_POST)&&sizeof($_POST)>0){
			return true;
		}
		return false;
	}
	
}