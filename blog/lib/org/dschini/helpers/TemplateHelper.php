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
	
	
}