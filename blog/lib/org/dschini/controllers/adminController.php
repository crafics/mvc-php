<?php
include_once('../config.php');

/*
 * adminController
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class adminController {

	/*
	 * define $THEME folder
	 */
	public static $THEME = THEME_DEFAULT;
	
	/*
	 * indexAction
	 */
	public function indexAction(){
		$ret = array();
		return TemplateHelper::redirect("/blog/settings/");
	}
	
	/*
	 * settingsAction
	 */
	public function settingsAction(){
		$ret = array();
		if(TemplateHelper::isPost()){

			$ret['settings'] = is_array($_POST['settings']) ? $_POST['settings'] : array();
			foreach($ret['settings'] as $name=>$value){
				if(strlen($value)<3 || strlen(strip_tags($value))>255){
					$ret["error"][$name] = $name."_invalid";
				}
			}

			/* success */
			if(!isset($ret['error'])){
				foreach($ret["settings"] as $name=>$value){
					$blogsetting = BlogsettingsProxy::getByName($name);
					$blogsetting->value = $value;
					$blogsetting->save();
				}
			}
		}
		$ret["tagcloud"]		= BlogpostProxy::tags();
		$ret["settings"] 		= BlogsettingsProxy::getAll();
		return TemplateHelper::renderToResponse(self::$THEME,"/html/settings.phtml",$ret);
	}
	
}
