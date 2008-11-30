<?php
include_once('../config.php');

/*
 * blogController
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class blogController {

	/*
	 * define $THEME folder
	 */
	public static $THEME = THEME_DEFAULT;
	
	/*
	 * indexAction
	 */
	public function indexAction(){
		$ret = array();
		return TemplateHelper::redirect("/blog/posts/latest/");
	}

	/*
	 * latestBlogPostsAction
	 */
	public function latestBlogPostsAction($cat="latest"){
		$ret = array();
		$ret["tagcloud"] 	= BlogpostProxy::tags();
		$ret["blogposts"] 	= BlogpostProxy::latestByCreated();
		$ret["infos"] 		= BlogsettingsProxy::getAll();
		return TemplateHelper::renderToResponse(self::$THEME,"html/posts.phtml",$ret);
	}
	
	/*
	 * thankyouAction
	 */
	public function thankyouAction(){
		$ret = array();
		$ret["tagcloud"] 	= BlogpostProxy::tags();
		$ret["infos"] 		= BlogsettingsProxy::getAll();
		return TemplateHelper::renderToResponse(self::$THEME,"html/thankyou.phtml",$ret);
	}
	
	/*
	 * postAction
	 */
	public function postAction(){
		
		$ret = array();

		if(TemplateHelper::isPost()){
			$ret["author"] = strip_tags($_POST["author"]);
			if(strlen($ret["author"])<3 || strlen($ret["author"])>100){
				$ret["error"]["author"] = "author_invalid";
			}
			$ret["title"] = strip_tags($_POST["title"]);
			if(strlen($ret["title"])<3 || strlen($ret["title"])>150){
				$ret["error"]["title"] = "title_invalid";
			}
	        $ret["body"] = strip_tags($_POST["body"]);
	        if(strlen($ret["body"])<10 || strlen($ret["body"])>2500){
	                $ret["error"]["body"] = "body_invalid";
	        }
			$ret["tags_plain"] = strip_tags($_POST["tags"]);
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
			$nr1 = (int)$_POST["nr1"];
			$nr2 = (int)$_POST["nr2"];
			$total = (int)$_POST["total"];
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
				TemplateHelper::redirect('/blog/post/thankyou/');
			}
	    }
		$ret["tagcloud"] 	= BlogpostProxy::tags();
		$ret["blogposts"] 	= BlogpostProxy::latestByCreated();
		$ret["infos"] 		= BlogsettingsProxy::getAll();
		$ret["nr1"] = rand(0,9);
		$ret["nr2"] = rand(0,9);
		return TemplateHelper::renderToResponse(self::$THEME,"html/post.phtml",$ret);
	}
	
	/*
	 * tagAction
	 */
	public function tagAction(){
		$_POST["s"] = addslashes(strip_tags((string)$_GET["s"]));
		self::searchAction();
	}

	/*
	 * searchAction
	 */
	public function searchAction(){
		if(!isset($_POST['s'])){
			TemplateHelper::redirect('/blog/posts/latest/');
		}
		$raw = $_POST['s'];
		$raw = str_replace(","," ",$raw);
		$raw = str_replace("\""," ",$raw);
		$splitted = split(" ",$raw);
		$splitted2 = array();
		foreach($splitted as $isemptycheck){
			if($isemptycheck!=""){
				$splitted2[] = $isemptycheck;
			}
		}
		$ret = array();
		$_sqlfilter = ' ';
		if(count($splitted2)<=0){
			$_sqlfilter.= '1=1';
		}
		for( $i=0; $i<count($splitted2); $i++ ){
			$splitted2[$i] = DBConnectionHelper::getInstance()->escape($splitted2[$i]);
			if(strlen($splitted2[$i])>0){
				$ret["s"]   = isset($ret["s"]) ? $ret["s"].=" ".$splitted2[$i] : $ret["s"]=$splitted2[$i];
				$_sqlfilter.= sprintf('( title like "%%%s%%" ',$splitted2[$i]);
				$_sqlfilter.= sprintf('OR body like "%%%s%%" ',$splitted2[$i]);
				$_sqlfilter.= sprintf('OR tags like "%%%s%%" )',$splitted2[$i]);
			}
			if(count($splitted2)>$i+1){
				$_sqlfilter.= 'AND ';
			}
		}
		$ret["tagcloud"]	= BlogpostProxy::tags();
		$ret["blogposts"] 	= BlogpostProxy::filter($_sqlfilter." ORDER BY created DESC LIMIT 0,30");
		$ret["infos"] 		= BlogsettingsProxy::getAll();
		return TemplateHelper::renderToResponse(self::$THEME,"/html/posts.phtml",$ret);
	}
	
	/*
	 * feedAction
	 */
	public function feedAction(){
		$ret = array();
		$ret["blogposts"] = BlogpostProxy::filter("1=1 ORDER BY created DESC LIMIT 0,20");
		return TemplateHelper::renderToResponse(self::$THEME,"/xml/rss-092.pxml",$ret);
	}
	
}
