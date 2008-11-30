<?php
/*
 * BlogpostProxy
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class BlogpostProxy {
	
	public $id;
	public $created;
	public $author;
	public $title;
	public $body;
	public $tags;

	public function __construct(){
	}
	
	/*
	 * save
	 */
	public function save(){
		if(!isset($this->id)){
			$sql = sprintf("INSERT INTO `posts` (`created`,`author`,`title`,`body`,`tags`) VALUES (now(),'%s','%s','%s','%s');"
				,$this->author,$this->title,$this->body,$this->tags);
			DBConnectionHelper::getInstance()->execute($sql);
			$this->id = DBConnectionHelper::getInstance()->insert_id();
		} else {
			$sql = sprintf("UPDATE `posts` SET `author`='%s', `title`='%s', `body`='%s', `tags`='%s' WHERE id=%d"
				,$this->author,$this->title,$this->body,$this->tags,$this->id);
			DBConnectionHelper::getInstance()->execute($sql);
		}
	}

	/*
	 * get
	 */
	public static function get( $id ){
		$sql = sprintf("SELECT * from posts WHERE `id`=%d",$id);
		$row = DBConnectionHelper::getInstance()->query($sql);
		if(sizeof($row)>0){
			$obj = new BlogpostProxy();
			foreach($row[0] as $key => $value){
				$obj->{$key} = $value;
			}
			return $obj;
		}
		return null;
	}
	
	/*
	 * tags
	 */
	public static function tags(){
    	$sql = sprintf("SELECT tags FROM posts ORDER BY created DESC LIMIT 0,50");
        $rows = DBConnectionHelper::getInstance()->query($sql);
        $keywords = array();
		$keywords['size'] = 0;
		$keywords['high'] = 0;
		foreach($rows as $row){
			$row["tags"] = trim($row["tags"]);
			if(!empty($row["tags"])){
				$_clean_1 = str_replace(" ","",$row["tags"]);
				$_clean_2 = explode(",",$_clean_1);
				foreach($_clean_2 as $keyword){
					if(!isset($keywords['cloud'][$keyword])){
						$keywords['cloud'][$keyword] = 0;
					}
					$keywords['cloud'][$keyword]++;
					$keywords['high'] = $keywords['cloud'][$keyword]>$keywords['high']?$keywords['cloud'][$keyword]:$keywords['high'];
				}
				$keywords['size']++;
			}
		}
		return $keywords;
	}

	/*
	 * latestByCreated
	 */
	public static function latestByCreated(){
		$sql = sprintf("SELECT * FROM posts ORDER BY created DESC LIMIT 0,30");
        $rows = DBConnectionHelper::getInstance()->query($sql);
        $arr = array();
        foreach($rows AS $row){
			$obj = new BlogpostProxy();
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
		$sql = sprintf("SELECT * FROM posts WHERE %s", $filter);
		$rows = DBConnectionHelper::getInstance()->query($sql);
		$arr = array();
		foreach($rows AS $row){
			$obj = new BlogpostProxy();
			foreach($row as $key => $value){
				$obj->{$key} = $value;
			}
			$arr[] = $obj;
		}
		return $arr;
	}	
}
