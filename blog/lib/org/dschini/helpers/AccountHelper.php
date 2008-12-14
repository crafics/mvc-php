<?php
class AccountHelper
{
	public static $FLAGS = 0;
	
	public static function makeSessionIfCookieExists(){
		if(
			(!isset($_SESSION["account"]->uid) || !isset($_SESSION["account"]->secret))
			&& isset($_COOKIE["account"]) ){
			$account = unserialize(base64_decode($_COOKIE["account"]));
			if(isset($account->uid)&&isset($account->secret)){
				$accountProxy = AccountsProxy::getByUIDAndSecret($account->uid,$account->secret);
				if($accountProxy){
					//self::login($accountProxy);
					$_SESSION["account"] = $account;
				}
			}
		}
	}
	
	public static function logout( ){
		if(isset($_SESSION["account"]->uid) && isset($_SESSION["account"]->secret)){
			setcookie("account", 
				base64_encode(serialize($_SESSION["account"])), 
				time()-3600,
				"/"
			);
			$_SESSION["account"] = null;
			unset($_SESSION["account"]);
		}
		$_COOKIE = null;
	}
	
	public static function getAccount(){
		return AccountsProxy::getByUID($_SESSION["account"]->uid);
	}
	
	public static function getAccountRights(){
		return AccountsProxy::getRightsByUID($_SESSION["account"]->uid);
	}
	
	public static function isLoggedIn(){
		if(isset($_SESSION["account"])){
			return true;
		}
		return false;
	}
	
	public static function login($accountProxy){
		$account = new stdClass();
		$account->uid = $accountProxy->uid;
		$account->secret = $accountProxy->secret;
		$_SESSION["account"] = $account;
		setcookie("account", 
			base64_encode(serialize($account)), 
			time()+3600*24*30*3,
			"/"
		);
	}

}