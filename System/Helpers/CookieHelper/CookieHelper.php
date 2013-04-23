<?php
class CookieHelper{
	public static function CreateCookie($name, $value, $time = 1, $path = "/"){
		setcookie($name,$value, time() + 60 * $time, $path);
	}
	
	public static function CheckCookie($name){
		return isset($_COOKIE[$name]);
	}
	
	public static function DeleteCookie($name){
		setcookie($name, "", time() - 3600, "/");
	}
	
	public static function SelectCookie($name){
		return $_COOKIE[$name];
	}
}