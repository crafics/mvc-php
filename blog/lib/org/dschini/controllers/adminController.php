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
		return RequestHelper::redirect("/blog/settings/");
	}
	
	/*
	 * settingsAction
	 */
	public function settingsAction(){
		$ret = array();
		if(RequestHelper::isPost()){
			$ret['settings'] = is_array($_POST['settings']) 
				? InputFilterHelper::getArray($_POST['settings'])
				: array();
			foreach($ret['settings'] as $name=>$value){
				if(strlen(InputFilterHelper::getString($value))<3 
				|| strlen(InputFilterHelper::getString($value))>255){
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
	
	/*
	 * postAction
	 */
	public function postAction(){
		
		$ret = array();

		if(RequestHelper::isPost()){
			$ret["author"] = InputFilterHelper::getString($_POST["author"]);
			if(strlen($ret["author"])<3 || strlen($ret["author"])>100){
				$ret["error"]["author"] = "author_invalid";
			}
			$ret["title"] = InputFilterHelper::getString($_POST["title"]);
			if(strlen($ret["title"])<3 || strlen($ret["title"])>150){
				$ret["error"]["title"] = "title_invalid";
			}
	        $ret["body"] = InputFilterHelper::getString($_POST["body"]);
	        if(strlen($ret["body"])<10 || strlen($ret["body"])>2500){
	                $ret["error"]["body"] = "body_invalid";
	        }
			$ret["tags_plain"] = InputFilterHelper::getString($_POST["tags"]);
	        if($ret["tags_plain"]){
				$ret["tags"]="";
				$words = preg_split( '/,/',  $ret["tags_plain"], -1, PREG_SPLIT_NO_EMPTY );
				for($i=0; $i<count($words); $i++ ) {
	                $ret["tags"] .= trim( $words[$i] ) . ($i+1>=count($words)?'':', ');
	        	}
				if(strlen($ret["tags_plain"])<3 || strlen($ret["tags_plain"])>150){
	                $ret["error"]["tags"] = "tags_invalid";
		        }
			}

			/* security check */
			$nr1 = InputFilterHelper::getInt($_POST["nr1"]);
			$nr2 = InputFilterHelper::getInt($_POST["nr2"]);
			$total = InputFilterHelper::getInt($_POST["total"]);
			if($nr1+$nr2!=$total){
				$ret["error"]["total"] = "total_invalid";
			}
			/* success */
			if(!isset($ret['error'])){
				$blogpostProxy = new BlogpostProxy();
				$blogpostProxy->author = $ret["author"];
				$blogpostProxy->title = $ret["title"];
				$blogpostProxy->body = $ret["body"];
				$blogpostProxy->tags = $ret["tags"];
				$blogpostProxy->save();
				RequestHelper::redirect('/blog/admin/post/thankyou/');
			}
	    }
		$ret["tagcloud"] 	= BlogpostProxy::tags();
		$ret["blogposts"] 	= BlogpostProxy::latestByCreated();
		$ret["settings"] 	= BlogsettingsProxy::getAll();
		$ret["nr1"] = rand(0,9);
		$ret["nr2"] = rand(0,9);
		return TemplateHelper::renderToResponse(self::$THEME,"html/post.phtml",$ret);
	}

	/*
	 * loginAction
	 */
	public function loginAction(){
		
		$ret = array();
		
		if(RequestHelper::isPost()){
			$ret["email"] = InputFilterHelper::getString($_POST["email"]);
			if(strlen($ret["email"])>100){
            	$ret["error"]["email"] = "email_toolong";
            }
			if(!preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $ret["email"])){
		        $ret["error"]["email"] = "email_invalid";
	        }
			$password = InputFilterHelper::getString($_POST["password"]);
			if(strlen($password)<4 || strlen($password)>8){
				$ret["error"]["password"] = "password_invalid";
			}
			if($ret["email"]!='test@test.com' || $password!='test'){
				$ret["error"]["login"] = "login_invalid";
			}

			/* success */
			if(!isset($ret['error'])){
				$_SESSION['userRight'] = $_SESSION['userRight'] | pow(2,RIGHT_ADMIN);
				$next = InputFilterHelper::getString($_GET['next']);
				RequestHelper::redirect($next?$next:'/blog/');
			}
	    }
		$ret["tagcloud"] 	= BlogpostProxy::tags();
		$ret["blogposts"] 	= BlogpostProxy::latestByCreated();
		$ret["settings"] 	= BlogsettingsProxy::getAll();
		return TemplateHelper::renderToResponse(self::$THEME,"html/login.phtml",$ret);
	}

	/*
	 * thankyouAction
	 */
	public function thankyouAction(){
		$ret = array();
		$ret["tagcloud"] 	= BlogpostProxy::tags();
		$ret["settings"] 	= BlogsettingsProxy::getAll();
		return TemplateHelper::renderToResponse(self::$THEME,"html/thankyou.phtml",$ret);
	}
}
