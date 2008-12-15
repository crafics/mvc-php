<?php
/*
 * BlogcommentProxy
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class BlogcommentProxy {
	
	public $id;
	public $created;
	public $post_id;
	public $author;
	public $title;
	public $body;

	public function __construct(){
	}
	
	/*
	 * save
	 */
	public function save(){
		if(!isset($this->id)){
			$sql = sprintf("INSERT INTO `comments` (`created`,`post_id`,`author`,`body`) VALUES (now(),%d,'%s','%s');"
				,DBConnectionHelper::escape($this->post_id)
				,DBConnectionHelper::escape($this->author)
				,DBConnectionHelper::escape($this->body)
				);
			DBConnectionHelper::getInstance()->execute($sql);
			$this->id = DBConnectionHelper::getInstance()->insert_id();
		} else {
			$sql = sprintf("UPDATE `comments` SET `post_id`=%d, `author`='%s', `body`='%s' WHERE id=%d"
				,DBConnectionHelper::escape($this->post_id)
				,DBConnectionHelper::escape($this->author)
				,DBConnectionHelper::escape($this->body)
				,DBConnectionHelper::escape($this->id)
				);
			DBConnectionHelper::getInstance()->execute($sql);
		}
	}

	/*
	 * get
	 */
	public static function get( $id ){
		$sql = sprintf("SELECT * from comments WHERE `id`=%d",$id);
		$row = DBConnectionHelper::getInstance()->query($sql);
		if(sizeof($row)>0){
			$obj = new BlogcommentProxy();
			foreach($row[0] as $key => $value){
				$obj->{$key} = $value;
			}
			return $obj;
		}
		return null;
	}

	/*
	 * getByPostId
	 */
	public static function getByPostId( $postId ){
		$sql = sprintf("SELECT * from comments WHERE `post_id`=%d",$postId);
		$rows = DBConnectionHelper::getInstance()->query($sql);
        $arr = array();
        foreach($rows AS $row){
			$obj = new BlogcommentProxy();
        	foreach($row as $key => $value){
            	$obj->{$key} = $value;
			}
            $arr[] = $obj;
		}
		return $arr;
	}
	
	/*
	 * latestByCreated
	 */
	public static function latestByCreated(){
		$sql = sprintf("SELECT * FROM comments ORDER BY created DESC LIMIT 0,30");
        $rows = DBConnectionHelper::getInstance()->query($sql);
        $arr = array();
        foreach($rows AS $row){
			$obj = new BlogcommentProxy();
        	foreach($row as $key => $value){
            	$obj->{$key} = $value;
			}
            $arr[] = $obj;
		}
		return $arr;
	}
		
	/*
	 * filter
	 */
	public static function filter( $filter ){
		$sql = sprintf("SELECT * FROM comments WHERE %s", $filter);
		$rows = DBConnectionHelper::getInstance()->query($sql);
		$arr = array();
		foreach($rows AS $row){
			$obj = new BlogcommentProxy();
			foreach($row as $key => $value){
				$obj->{$key} = $value;
			}
			$arr[] = $obj;
		}
		return $arr;
	}	
}
