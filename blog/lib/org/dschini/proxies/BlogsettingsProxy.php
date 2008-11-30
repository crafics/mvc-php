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
			$sql = sprintf("UPDATE `infos` SET `name`='%s', `value`='%s' WHERE id=%d"
				,$this->name,$this->value,$this->id);
			DBConnectionHelper::getInstance()->execute($sql);
		}
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
