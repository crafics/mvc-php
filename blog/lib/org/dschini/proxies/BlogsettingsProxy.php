<?php
/*
 * BlogsettingsProxy
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class BlogsettingsProxy
{
	public $id;
	public $created;
	public $name;
	public $value;
	
	public function __construct(){
	}
	
	/*
	 * save a Blogsetting
	 */
	public function save(){
		if(!isset($this->id)){
			$sql = sprintf("INSERT INTO `settings` (`created`,`name`,`value`) VALUES (now(),'%s','%s');"
				,$this->name,$this->value);
			DBConnectionHelper::getInstance()->execute($sql);
			$this->id = DBConnectionHelper::getInstance()->insert_id();
		} else {
			$sql = sprintf("UPDATE `settings` SET `name`='%s', `value`='%s' WHERE id=%d"
				,$this->name,$this->value,$this->id);
			DBConnectionHelper::getInstance()->execute($sql);
		}
	}
	
	/*
	 * getByName
	 */
	public static function getByName( $name ){
		$sql = sprintf("SELECT * from settings WHERE `name`='%s'",$name);
		$row = DBConnectionHelper::getInstance()->query($sql);
		if(sizeof($row)>0){
			$obj = new BlogsettingsProxy();
			foreach($row[0] as $key => $value){
				$obj->{$key} = $value;
			}
			return $obj;
		}
		return null;
	}

	/*
	 * get all Blogsettings
	 */
	public static function getAll(){
		$sql = sprintf("SELECT * from settings;");
		$rows = DBConnectionHelper::getInstance()->query($sql);
		$ret = array();
		if(sizeof($rows)>0){
			foreach($rows as $row){
				$ret[$row['name']] = $row['value'];
			}
			return $ret;
		}
		return null;
	}
}
